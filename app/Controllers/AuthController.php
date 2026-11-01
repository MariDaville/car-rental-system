<?php

namespace App\Controllers;

use App\Middleware\AuthMiddleware;
use App\Core\Controller;
use App\Services\AuthenticationService;
use App\Models\User;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class AuthController extends Controller
{
    /**
     * Display the registration page.
     */
    public function showRegister(): void
    {
        AuthMiddleware::requireGuest();

        $this->render('auth/register', [
            'title' => 'Create Your Account'
        ]);
    }

    /**
     * Process customer registration.
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/register');
        }

        // Verify CSRF token
        if (
            !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
            !hash_equals(
                $_SESSION['csrf_token'],
                $_POST['csrf_token']
            )
        ) {
            http_response_code(419);
            exit('Invalid or expired form token.');
        }

        try {

            $auth = new AuthenticationService();

            $userId = $auth->register(
                $_POST['email'] ?? '',
                $_POST['password'] ?? '',
                $_POST['first_name'] ?? '',
                $_POST['last_name'] ?? '',
                $_POST['phone'] ?? ''
            );

            $_SESSION['flash_success'] =
                'Your account has been created successfully. Please log in.';

            // Prevent reuse of the registration token
            unset($_SESSION['csrf_token']);

            $this->redirect('/login');

        } catch (InvalidArgumentException | RuntimeException $e) {

            $this->render('auth/register', [
                'title' => 'Create Your Account',
                'error' => $e->getMessage()
            ]);

        } catch (Throwable $e) {

            error_log('Registration error: ' . $e->getMessage());

            $this->render('auth/register', [
                'title' => 'Create Your Account',
                'error' => 'Registration could not be completed. Please try again.'
            ]);
        }
    }

    /**
     * Display the login page.
     */
    public function showLogin(): void
    {
        AuthMiddleware::requireGuest();
        $this->render('auth/login', [
            'title' => 'Customer Login'
        ]);
    }

    /**
     * Process customer login.
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/login');
        }

        if (
            !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
            !hash_equals(
                $_SESSION['csrf_token'],
                $_POST['csrf_token']
            )
        ) {
            http_response_code(419);
            exit('Invalid or expired form token.');
        }

        try {

            $email = strtolower(trim($_POST['email'] ?? ''));
            $password = $_POST['password'] ?? '';

            $userModel = new User();

            $user = $userModel->findByEmail($email);

            if (
                !$user ||
                !password_verify($password, $user['password_hash'])
            ) {
                throw new RuntimeException(
                    'Invalid email address or password.'
                );
            }

            if (!$user['is_active']) {
                throw new RuntimeException(
                    'Your account is currently inactive.'
                );
            }

            // Retrieve assigned roles
            $roles = $userModel->getRoles((int) $user['user_id']);

            // Regenerate session ID after authentication
            session_regenerate_id(true);

            $_SESSION['user_id'] = (int) $user['user_id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['roles'] = array_column($roles, 'role_name');

            $userModel->updateLastLogin(
                (int) $user['user_id']
            );

            // Generate a new CSRF token
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

            $this->redirect('/');

        } catch (RuntimeException $e) {

            $this->render('auth/login', [
                'title' => 'Customer Login',
                'error' => $e->getMessage()
            ]);

        } catch (Throwable $e) {

            error_log('Login error: ' . $e->getMessage());

            $this->render('auth/login', [
                'title' => 'Customer Login',
                'error' => 'Unable to process your login. Please try again.'
            ]);
        }
    }

    /**
     * Log out the authenticated user.
     */
    public function logout(): void
    {
        if (
    !isset($_POST['csrf_token'], $_SESSION['csrf_token']) ||
    !hash_equals(
        $_SESSION['csrf_token'],
        $_POST['csrf_token']
    )
) {
    http_response_code(419);
    exit('Invalid or expired form token.');
}
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                [
                    'expires' => time() - 42000,
                    'path' => $params['path'],
                    'domain' => $params['domain'],
                    'secure' => $params['secure'],
                    'httponly' => $params['httponly'],
                    'samesite' => 'Lax'
                ]
            );
        }

        session_destroy();

        $this->redirect('/login');
    }
}

<?php
// Start secure application session
if (session_status() === PHP_SESSION_NONE) {

    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => !empty($_SERVER['HTTPS'])
            && $_SERVER['HTTPS'] !== 'off',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

// Generate CSRF token if one does not exist
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Define application root
define('BASE_PATH', dirname(__DIR__));

// Load Composer autoloader
require BASE_PATH . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Load application configuration
$appConfig = require BASE_PATH . '/config/app.php';

// Set timezone
date_default_timezone_set($appConfig['timezone']);

// Configure error reporting
error_reporting(E_ALL);

ini_set(
    'display_errors',
    $appConfig['debug'] ? '1' : '0'
);

// Load application routes
require BASE_PATH . '/routes/web.php';
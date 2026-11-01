<?php

namespace App\Services;

use App\Core\Database;
use PDO;
use Throwable;
use InvalidArgumentException;
use RuntimeException;

class AuthenticationService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Register a new customer.
     */
    public function register(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $phone
    ): int {

        // Validate email
        $email = strtolower(trim($email));

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(
                'Please provide a valid email address.'
            );
        }

        // Validate password
        if (strlen($password) < 8) {
            throw new InvalidArgumentException(
                'Password must contain at least 8 characters.'
            );
        }

        // Validate customer information
        $firstName = trim($firstName);
        $lastName = trim($lastName);
        $phone = trim($phone);

        if ($firstName === '' || $lastName === '' || $phone === '') {
            throw new InvalidArgumentException(
                'All customer details are required.'
            );
        }

        try {

            $this->db->beginTransaction();

            // Check whether email already exists
            $statement = $this->db->prepare(
                "SELECT user_id
                 FROM users
                 WHERE email = :email
                 LIMIT 1"
            );

            $statement->execute([
                'email' => $email
            ]);

            if ($statement->fetch()) {
                throw new RuntimeException(
                    'An account with this email already exists.'
                );
            }

            // Hash password
            $passwordHash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            if ($passwordHash === false) {
                throw new RuntimeException(
                    'Unable to secure the password.'
                );
            }

            // Create user account
            $statement = $this->db->prepare(
                "INSERT INTO users (
                    email,
                    password_hash
                ) VALUES (
                    :email,
                    :password_hash
                )"
            );

            $statement->execute([
                'email' => $email,
                'password_hash' => $passwordHash
            ]);

            $userId = (int) $this->db->lastInsertId();

            // Retrieve Customer role
            $statement = $this->db->prepare(
                "SELECT role_id
                 FROM roles
                 WHERE role_name = :role_name
                 LIMIT 1"
            );

            $statement->execute([
                'role_name' => 'Customer'
            ]);

            $role = $statement->fetch();

            if (!$role) {
                throw new RuntimeException(
                    'Customer role has not been configured.'
                );
            }

            // Assign Customer role
            $statement = $this->db->prepare(
                "INSERT INTO user_roles (
                    user_id,
                    role_id
                ) VALUES (
                    :user_id,
                    :role_id
                )"
            );

            $statement->execute([
                'user_id' => $userId,
                'role_id' => $role['role_id']
            ]);

            // Create customer profile
            $statement = $this->db->prepare(
                "INSERT INTO customers (
                    user_id,
                    first_name,
                    last_name,
                    phone
                ) VALUES (
                    :user_id,
                    :first_name,
                    :last_name,
                    :phone
                )"
            );

            $statement->execute([
                'user_id' => $userId,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'phone' => $phone
            ]);

            // Commit all three operations
            $this->db->commit();

            return $userId;

        } catch (Throwable $e) {

            // Roll back if any operation fails
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }
}

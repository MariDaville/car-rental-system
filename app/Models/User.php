<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    /**
     * Find a user using their email address.
     */
    public function findByEmail(string $email): ?array
    {
        return $this->find(
            "SELECT *
             FROM users
             WHERE email = :email
             LIMIT 1",
            ['email' => $email]
        );
    }

    /**
     * Find a user using their ID.
     */
    public function findById(int $userId): ?array
    {
        return $this->find(
            "SELECT user_id, email, is_active, created_at
             FROM users
             WHERE user_id = :user_id
             LIMIT 1",
            ['user_id' => $userId]
        );
    }

    /**
     * Create a new user account.
     *
     * Accepts a password hash, never a plaintext password.
     */
    public function create(
        string $email,
        string $passwordHash
    ): int {

        $statement = $this->db->prepare(
            "INSERT INTO users (email, password_hash)
             VALUES (:email, :password_hash)"
        );

        $statement->execute([
            'email' => $email,
            'password_hash' => $passwordHash
        ]);

        return (int) $this->db->lastInsertId();
    }

    /**
     * Retrieve all roles assigned to a user.
     */
    public function getRoles(int $userId): array
    {
        return $this->findAll(
            "SELECT r.role_id, r.role_name
             FROM roles r
             INNER JOIN user_roles ur
                 ON r.role_id = ur.role_id
             WHERE ur.user_id = :user_id",
            ['user_id' => $userId]
        );
    }

    /**
     * Update the user's last login timestamp.
     */
    public function updateLastLogin(int $userId): int
    {
        return $this->execute(
            "UPDATE users
             SET last_login_at = NOW()
             WHERE user_id = :user_id",
            ['user_id' => $userId]
        );
    }
}
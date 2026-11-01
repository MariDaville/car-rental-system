<?php

namespace App\Models;

use App\Core\Model;

class Customer extends Model
{
    /**
     * Find a customer using their customer ID.
     */
    public function findById(int $customerId): ?array
    {
        return $this->find(
            "SELECT *
             FROM customers
             WHERE customer_id = :customer_id",
            ['customer_id' => $customerId]
        );
    }

    /**
     * Find a customer using their user account ID.
     */
    public function findByUserId(int $userId): ?array
    {
        return $this->find(
            "SELECT *
             FROM customers
             WHERE user_id = :user_id",
            ['user_id' => $userId]
        );
    }

    /**
     * Create a customer profile.
     */
    public function createProfile(
        int $userId,
        string $firstName,
        string $lastName,
        string $phone
    ): int {

        $statement = $this->db->prepare(
            "INSERT INTO customers (
                user_id,
                first_name,
                last_name,
                phone
            )
            VALUES (
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

        return (int) $this->db->lastInsertId();
    }

    /**
     * Retrieve all customers.
     */
    public function getAll(): array
    {
        return $this->findAll(
            "SELECT
                c.customer_id,
                c.first_name,
                c.last_name,
                c.phone,
                u.email,
                u.is_active
             FROM customers c
             INNER JOIN users u
                 ON c.user_id = u.user_id
             ORDER BY c.created_at DESC"
        );
    }
}
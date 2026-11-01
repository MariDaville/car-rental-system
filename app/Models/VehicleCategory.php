<?php

// we gonna uses the existing Model.php database methods, so we don't need another database connection.

namespace App\Models;

use App\Core\Model;

class VehicleCategory extends Model
{
    /**
     * This will retrieve all active vehicle categories.
     */
    public function getActiveAll(): array
    {
        return $this->findAll(
            "SELECT
                category_id,
                category_name,
                description
             FROM vehicle_categories
             WHERE is_active = 1
             ORDER BY category_name ASC"
        );
    }

    /**
     * This will find a category using its ID.
     */
    public function findById(int $categoryId): ?array
    {
        return $this->find(
            "SELECT *
             FROM vehicle_categories
             WHERE category_id = :category_id
             AND is_active = 1
             LIMIT 1",
            [
                'category_id' => $categoryId
            ]
        );
    }
}

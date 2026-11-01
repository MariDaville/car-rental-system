<?php

// This model will retrieve Main Rental Location and any additional locations we set up and introduce later on in the project.
namespace App\Models;

use App\Core\Model;

class Location extends Model
{
    /**
     * Retrieve all active rental locations.
     */
    public function getActiveAll(): array
    {
        return $this->findAll(
            "SELECT
                location_id,
                location_name,
                address,
                city,
                parish,
                country
             FROM locations
             WHERE is_active = 1
             ORDER BY location_name ASC"
        );
    }

    /**
     * Find an active location by ID.
     */
    public function findById(int $locationId): ?array
    {
        return $this->find(
            "SELECT *
             FROM locations
             WHERE location_id = :location_id
             AND is_active = 1
             LIMIT 1",
            [
                'location_id' => $locationId
            ]
        );
    }
}

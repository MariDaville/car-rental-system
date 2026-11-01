<?php

namespace App\Models;

use App\Core\Model;

class VehicleImage extends Model
{
    /**
     * Save an image record for a vehicle.
     */
    public function create(
        int $vehicleId,
        string $imagePath,
        bool $isPrimary = false,
        int $displayOrder = 0
    ): int {
        return $this->execute(
            "INSERT INTO vehicle_images (
                vehicle_id,
                image_path,
                is_primary,
                display_order
            ) VALUES (
                :vehicle_id,
                :image_path,
                :is_primary,
                :display_order
            )",
            [
                'vehicle_id' => $vehicleId,
                'image_path' => $imagePath,
                'is_primary' => $isPrimary ? 1 : 0,
                'display_order' => $displayOrder
            ]
        );
    }

    /**
     * Retrieve all images belonging to a vehicle.
     */
    public function getByVehicleId(int $vehicleId): array
    {
        return $this->findAll(
            "SELECT *
             FROM vehicle_images
             WHERE vehicle_id = :vehicle_id
             ORDER BY is_primary DESC, display_order ASC",
            [
                'vehicle_id' => $vehicleId
            ]
        );
    }

    /**
     * Set an image as the primary vehicle image.
     */
    public function setPrimary(
        int $imageId,
        int $vehicleId
    ): int {
        $this->db->beginTransaction();

        try {
            $this->execute(
                "UPDATE vehicle_images
                 SET is_primary = 0
                 WHERE vehicle_id = :vehicle_id",
                ['vehicle_id' => $vehicleId]
            );

            $updated = $this->execute(
                "UPDATE vehicle_images
                 SET is_primary = 1
                 WHERE image_id = :image_id
                 AND vehicle_id = :vehicle_id",
                [
                    'image_id' => $imageId,
                    'vehicle_id' => $vehicleId
                ]
            );

            if ($updated !== 1) {
                throw new \RuntimeException(
                    'Vehicle image was not found.'
                );
            }

            $this->db->commit();

            return $updated;

        } catch (\Throwable $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            throw $e;
        }
    }
}

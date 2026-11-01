<?php

// This is the main model responsible for registering vehicles, retrieving vehicle records, updating vehicle information and managing vehicle status.
// so basically, this model is the main model for the vehicle management system. And we also handle CRUD operations here.
// also ensure that registration numbers and VINs are checked for duplicates before insertion.
namespace App\Models;

use App\Core\Model;

class Vehicle extends Model
{
    /**
     * Retrieve all vehicles with category and location.
     */
    public function getAll(): array
    {
        return $this->findAll(
            "SELECT
                v.*,
                vc.category_name,
                l.location_name
             FROM vehicles v
             INNER JOIN vehicle_categories vc
                ON v.category_id = vc.category_id
             INNER JOIN locations l
                ON v.home_location_id = l.location_id
             ORDER BY v.created_at DESC"
        );
    }

    /**
     * Retrieve vehicles available for public browsing.
     */
    public function getActiveAll(): array
    {
        return $this->findAll(
            "SELECT
                v.*,
                vc.category_name,
                l.location_name,
                (
                    SELECT vi.image_path
                    FROM vehicle_images vi
                    WHERE vi.vehicle_id = v.vehicle_id
                    ORDER BY vi.is_primary DESC,
                             vi.display_order ASC
                    LIMIT 1
                ) AS primary_image
             FROM vehicles v
             INNER JOIN vehicle_categories vc
                ON v.category_id = vc.category_id
             INNER JOIN locations l
                ON v.home_location_id = l.location_id
             WHERE v.vehicle_status = 'active'
             AND vc.is_active = 1
             AND l.is_active = 1
             ORDER BY v.created_at DESC"
        );
    }

    /**
     * Find a vehicle by its ID.
     */
    public function findById(int $vehicleId): ?array
    {
        return $this->find(
            "SELECT
                v.*,
                vc.category_name,
                l.location_name
             FROM vehicles v
             INNER JOIN vehicle_categories vc
                ON v.category_id = vc.category_id
             INNER JOIN locations l
                ON v.home_location_id = l.location_id
             WHERE v.vehicle_id = :vehicle_id
             LIMIT 1",
            [
                'vehicle_id' => $vehicleId
            ]
        );
    }

    /**
     * Check whether a registration number already exists.
     */
    public function registrationExists(
        string $registrationNumber,
        ?int $excludeVehicleId = null
    ): bool {

        $sql = "SELECT vehicle_id
                FROM vehicles
                WHERE registration_number = :registration_number";

        $params = [
            'registration_number' => $registrationNumber
        ];

        if ($excludeVehicleId !== null) {
            $sql .= " AND vehicle_id != :vehicle_id";
            $params['vehicle_id'] = $excludeVehicleId;
        }

        $sql .= " LIMIT 1";

        return $this->find($sql, $params) !== null;
    }

    /**
     * Check whether a VIN already exists.
     */
    public function vinExists(
        string $vin,
        ?int $excludeVehicleId = null
    ): bool {

        $sql = "SELECT vehicle_id
                FROM vehicles
                WHERE vin = :vin";

        $params = [
            'vin' => $vin
        ];

        if ($excludeVehicleId !== null) {
            $sql .= " AND vehicle_id != :vehicle_id";
            $params['vehicle_id'] = $excludeVehicleId;
        }

        $sql .= " LIMIT 1";

        return $this->find($sql, $params) !== null;
    }

    /**
     * Register a new vehicle.
     *
     * Returns the newly created vehicle ID.
     */
    public function create(array $data): int
    {
        $statement = $this->query(
            "INSERT INTO vehicles (
                category_id,
                home_location_id,
                registration_number,
                vin,
                make,
                model,
                manufacturing_year,
                color,
                transmission,
                fuel_type,
                seating_capacity,
                daily_rate,
                security_deposit,
                current_odometer,
                vehicle_status,
                description
            ) VALUES (
                :category_id,
                :home_location_id,
                :registration_number,
                :vin,
                :make,
                :model,
                :manufacturing_year,
                :color,
                :transmission,
                :fuel_type,
                :seating_capacity,
                :daily_rate,
                :security_deposit,
                :current_odometer,
                :vehicle_status,
                :description
            )",
            [
                'category_id' => $data['category_id'],
                'home_location_id' => $data['home_location_id'],
                'registration_number' => $data['registration_number'],
                'vin' => $data['vin'] ?: null,
                'make' => $data['make'],
                'model' => $data['model'],
                'manufacturing_year' => $data['manufacturing_year'],
                'color' => $data['color'] ?: null,
                'transmission' => $data['transmission'],
                'fuel_type' => $data['fuel_type'],
                'seating_capacity' => $data['seating_capacity'],
                'daily_rate' => $data['daily_rate'],
                'security_deposit' => $data['security_deposit'],
                'current_odometer' => $data['current_odometer'],
                'vehicle_status' => $data['vehicle_status'],
                'description' => $data['description'] ?: null
            ]
        );

        return (int) $this->db->lastInsertId();
    }

    /**
     * Update an existing vehicle.
     */
    public function update(
        int $vehicleId,
        array $data
    ): int {

        return $this->execute(
            "UPDATE vehicles SET
                category_id = :category_id,
                home_location_id = :home_location_id,
                registration_number = :registration_number,
                vin = :vin,
                make = :make,
                model = :model,
                manufacturing_year = :manufacturing_year,
                color = :color,
                transmission = :transmission,
                fuel_type = :fuel_type,
                seating_capacity = :seating_capacity,
                daily_rate = :daily_rate,
                security_deposit = :security_deposit,
                current_odometer = :current_odometer,
                vehicle_status = :vehicle_status,
                description = :description
             WHERE vehicle_id = :vehicle_id",
            [
                'category_id' => $data['category_id'],
                'home_location_id' => $data['home_location_id'],
                'registration_number' => $data['registration_number'],
                'vin' => $data['vin'] ?: null,
                'make' => $data['make'],
                'model' => $data['model'],
                'manufacturing_year' => $data['manufacturing_year'],
                'color' => $data['color'] ?: null,
                'transmission' => $data['transmission'],
                'fuel_type' => $data['fuel_type'],
                'seating_capacity' => $data['seating_capacity'],
                'daily_rate' => $data['daily_rate'],
                'security_deposit' => $data['security_deposit'],
                'current_odometer' => $data['current_odometer'],
                'vehicle_status' => $data['vehicle_status'],
                'description' => $data['description'] ?: null,
                'vehicle_id' => $vehicleId
            ]
        );
    }

    /**
     * Update vehicle operational status.
     */
    public function updateStatus(
        int $vehicleId,
        string $status
    ): int {

        return $this->execute(
            "UPDATE vehicles
             SET vehicle_status = :status
             WHERE vehicle_id = :vehicle_id",
            [
                'status' => $status,
                'vehicle_id' => $vehicleId
            ]
        );
    }
}

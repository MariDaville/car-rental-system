<?php
//Now this is the page that displays all vehicles registered in the rental fleet.
// This view will display a list of all registered vehicles in the system, along with their details and status.
// It will also provide options for administrators to manage the vehicle inventory, such as adding new vehicles, editing existing records, and viewing vehicle information.

//ob_start(); This was causing the navbar to render twice.

$vehicles = $vehicles ?? [];

?>

<div class="container py-5">

    <!-- Page Heading -->
    <div class="d-flex flex-wrap justify-content-between
                align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-car-front-fill text-primary me-2"></i>
                Vehicle Management
            </h2>

            <p class="text-muted mb-0">
                Manage your rental fleet and vehicle information.
            </p>
        </div>

        <a href="/admin/vehicles/create"
           class="btn btn-primary">

            <i class="bi bi-plus-circle me-1"></i>
            Register New Vehicle

        </a>

    </div>


    <!-- Summary Cards -->
    <?php

    $totalVehicles = count($vehicles);

    $activeVehicles = count(array_filter(
        $vehicles,
        fn($v) => $v['vehicle_status'] === 'active'
    ));

    $maintenanceVehicles = count(array_filter(
        $vehicles,
        fn($v) => $v['vehicle_status'] === 'maintenance'
    ));

    $inactiveVehicles = count(array_filter(
        $vehicles,
        fn($v) => $v['vehicle_status'] === 'inactive'
            || $v['vehicle_status'] === 'retired'
    ));

    ?>

    <div class="row g-3 mb-4">

        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Total Vehicles
                    </div>

                    <h3 class="fw-bold mb-0">
                        <?= $totalVehicles ?>
                    </h3>

                    <i class="bi bi-car-front text-primary fs-3"></i>

                </div>
            </div>

        </div>


        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Active Vehicles
                    </div>

                    <h3 class="fw-bold text-success mb-0">
                        <?= $activeVehicles ?>
                    </h3>

                    <i class="bi bi-check-circle text-success fs-3"></i>

                </div>
            </div>

        </div>


        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Under Maintenance
                    </div>

                    <h3 class="fw-bold text-warning mb-0">
                        <?= $maintenanceVehicles ?>
                    </h3>

                    <i class="bi bi-tools text-warning fs-3"></i>

                </div>
            </div>

        </div>


        <div class="col-md-3">

            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Inactive / Retired
                    </div>

                    <h3 class="fw-bold text-secondary mb-0">
                        <?= $inactiveVehicles ?>
                    </h3>

                    <i class="bi bi-slash-circle text-secondary fs-3"></i>

                </div>
            </div>

        </div>

    </div>


    <!-- Vehicle Inventory Table -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex justify-content-between
                        align-items-center flex-wrap gap-2">

                <h5 class="fw-bold mb-0">
                    Registered Vehicles
                </h5>

                <span class="badge bg-primary">
                    <?= $totalVehicles ?> Vehicles
                </span>

            </div>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>
                            <th>Registration</th>
                            <th>Vehicle</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Transmission</th>
                            <th>Daily Rate</th>
                            <th>Status</th>
                        </tr>

                    </thead>


                    <tbody>

                    <?php if (empty($vehicles)): ?>

                        <tr>

                            <td colspan="7" class="text-center py-5">

                                <i class="bi bi-car-front text-muted fs-1"></i>

                                <h5 class="mt-3">
                                    No Vehicles Registered
                                </h5>

                                <p class="text-muted">
                                    Your rental fleet is currently empty.
                                </p>

                                <a href="/admin/vehicles/create"
                                   class="btn btn-primary btn-sm">

                                    Register Your First Vehicle

                                </a>

                            </td>

                        </tr>

                    <?php else: ?>

                        <?php foreach ($vehicles as $vehicle): ?>

                            <?php

                            $status = $vehicle['vehicle_status'];

                            $statusClasses = [
                                'active' => 'success',
                                'maintenance' => 'warning',
                                'inactive' => 'secondary',
                                'retired' => 'dark'
                            ];

                            $statusClass = $statusClasses[$status] ?? 'secondary';

                            ?>

                            <tr>

                                <!-- Registration -->
                                <td class="fw-semibold">

                                    <?= htmlspecialchars(
                                        $vehicle['registration_number']
                                    ) ?>

                                </td>


                                <!-- Vehicle -->
                                <td>

                                    <div class="fw-semibold">

                                        <?= htmlspecialchars(
                                            $vehicle['manufacturing_year'] . ' '
                                            . $vehicle['make'] . ' '
                                            . $vehicle['model']
                                        ) ?>

                                    </div>

                                    <small class="text-muted">

                                        <?= htmlspecialchars(
                                            $vehicle['color'] ?? 'N/A'
                                        ) ?>

                                    </small>

                                </td>


                                <!-- Category -->
                                <td>

                                    <?= htmlspecialchars(
                                        $vehicle['category_name']
                                    ) ?>

                                </td>


                                <!-- Location -->
                                <td>

                                    <?= htmlspecialchars(
                                        $vehicle['location_name']
                                    ) ?>

                                </td>


                                <!-- Transmission -->
                                <td>

                                    <?= ucfirst(htmlspecialchars(
                                        $vehicle['transmission']
                                    )) ?>

                                </td>


                                <!-- Daily Rate -->
                                <td class="fw-semibold">

                                    JMD $
                                    <?= number_format(
                                        (float) $vehicle['daily_rate'],
                                        2
                                    ) ?>

                                </td>


                                <!-- Status -->
                                <td>

                                    <span class="badge bg-<?= $statusClass ?>">

                                        <?= ucfirst(htmlspecialchars($status)) ?>

                                    </span>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>
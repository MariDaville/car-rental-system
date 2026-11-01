
<?php

// The form uses Bootstrap cards to separate the different information sections. It also preserves submitted values when validation fails.


// Capture the page content for the main layout.
//ob_start(); Again, this is causing the navbar to render twice. This was fixed by removing ob_start() here and adding it in the Controller.php render() method.

// Safely escape form values.
$value = static function (
    string $key,
    string $default = ''
) use ($old): string {
    return htmlspecialchars(
        (string) ($old[$key] ?? $default),
        ENT_QUOTES,
        'UTF-8'
    );
};

// Check whether a field has an error.
$hasError = static function (string $field) use ($errors): bool {
    return isset($errors[$field]);
};

?>

<div class="container py-5">

    <!-- Page Heading -->
    <div class="d-flex flex-wrap justify-content-between
                align-items-center mb-4">

        <div>
            <h2 class="fw-bold mb-1">
                <i class="bi bi-car-front-fill text-primary me-2"></i>
                Register New Vehicle
            </h2>

            <p class="text-muted mb-0">
                Add a vehicle to your rental fleet.
            </p>
        </div>

        <a href="/admin/vehicles"
           class="btn btn-outline-secondary">

            <i class="bi bi-arrow-left me-1"></i>
            Back to Vehicles

        </a>

    </div>


    <!-- General Error -->
    <?php if (!empty($errors['general'])): ?>

        <div class="alert alert-danger">
            <?= htmlspecialchars($errors['general']) ?>
        </div>

    <?php endif; ?>


    <!-- Registration Form -->
    <form method="POST"
          action="/admin/vehicles"
          id="vehicleForm"
          enctype="multipart/form-data">

        <!-- CSRF Protection -->
        <input type="hidden"
               name="csrf_token"
               value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">


        <!-- SECTION 1: VEHICLE IDENTIFICATION -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-card-text text-primary me-2"></i>
                    Vehicle Identification
                </h5>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <!-- Registration Number -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Registration Number *
                        </label>

                        <input type="text"
                               name="registration_number"
                               class="form-control <?= $hasError('registration_number') ? 'is-invalid' : '' ?>"
                               value="<?= $value('registration_number') ?>"
                               maxlength="30"
                               placeholder="e.g. 1234 ABC"
                               required>

                        <?php if ($hasError('registration_number')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['registration_number']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- VIN -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            VIN / Chassis Number
                        </label>

                        <input type="text"
                               name="vin"
                               class="form-control <?= $hasError('vin') ? 'is-invalid' : '' ?>"
                               value="<?= $value('vin') ?>"
                               maxlength="50"
                               placeholder="Enter vehicle VIN">

                        <?php if ($hasError('vin')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['vin']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Make -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Vehicle Make *
                        </label>

                        <input type="text"
                               name="make"
                               class="form-control <?= $hasError('make') ? 'is-invalid' : '' ?>"
                               value="<?= $value('make') ?>"
                               maxlength="100"
                               placeholder="e.g. Toyota"
                               required>

                        <?php if ($hasError('make')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['make']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Model -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Vehicle Model *
                        </label>

                        <input type="text"
                               name="model"
                               class="form-control <?= $hasError('model') ? 'is-invalid' : '' ?>"
                               value="<?= $value('model') ?>"
                               maxlength="100"
                               placeholder="e.g. Corolla"
                               required>

                        <?php if ($hasError('model')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['model']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Manufacturing Year -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Manufacturing Year *
                        </label>

                        <input type="number"
                               name="manufacturing_year"
                               class="form-control <?= $hasError('manufacturing_year') ? 'is-invalid' : '' ?>"
                               value="<?= $value('manufacturing_year') ?>"
                               min="1901"
                               max="<?= (int) date('Y') + 1 ?>"
                               placeholder="e.g. 2024"
                               required>

                        <?php if ($hasError('manufacturing_year')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['manufacturing_year']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Colour -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Vehicle Colour
                        </label>

                        <input type="text"
                               name="color"
                               class="form-control <?= $hasError('color') ? 'is-invalid' : '' ?>"
                               value="<?= $value('color') ?>"
                               maxlength="50"
                               placeholder="e.g. Silver">

                        <?php if ($hasError('color')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['color']) ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- SECTION 2: VEHICLE SPECIFICATIONS -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-gear text-primary me-2"></i>
                    Vehicle Specifications
                </h5>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <!-- Category -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Vehicle Category *
                        </label>

                        <select name="category_id"
                                class="form-select <?= $hasError('category_id') ? 'is-invalid' : '' ?>"
                                required>

                            <option value="">Select category</option>

                            <?php foreach ($categories as $category): ?>

                                <option
                                    value="<?= (int) $category['category_id'] ?>"
                                    <?= (string) ($old['category_id'] ?? '') === (string) $category['category_id'] ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($category['category_name']) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                        <?php if ($hasError('category_id')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['category_id']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Transmission -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Transmission *
                        </label>

                        <select name="transmission"
                                class="form-select <?= $hasError('transmission') ? 'is-invalid' : '' ?>"
                                required>

                            <option value="">Select transmission</option>

                            <option value="automatic"
                                <?= $value('transmission') === 'automatic' ? 'selected' : '' ?>>
                                Automatic
                            </option>

                            <option value="manual"
                                <?= $value('transmission') === 'manual' ? 'selected' : '' ?>>
                                Manual
                            </option>

                        </select>

                        <?php if ($hasError('transmission')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['transmission']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Fuel Type -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Fuel Type *
                        </label>

                        <select name="fuel_type"
                                class="form-select <?= $hasError('fuel_type') ? 'is-invalid' : '' ?>"
                                required>

                            <option value="">Select fuel type</option>

                            <?php
                            $fuelTypes = [
                                'petrol' => 'Petrol',
                                'diesel' => 'Diesel',
                                'hybrid' => 'Hybrid',
                                'electric' => 'Electric',
                                'other' => 'Other'
                            ];
                            ?>

                            <?php foreach ($fuelTypes as $key => $label): ?>

                                <option value="<?= $key ?>"
                                    <?= $value('fuel_type') === $key ? 'selected' : '' ?>>

                                    <?= $label ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                        <?php if ($hasError('fuel_type')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['fuel_type']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Seating Capacity -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Seating Capacity *
                        </label>

                        <input type="number"
                               name="seating_capacity"
                               class="form-control <?= $hasError('seating_capacity') ? 'is-invalid' : '' ?>"
                               value="<?= $value('seating_capacity') ?>"
                               min="1"
                               max="255"
                               placeholder="e.g. 5"
                               required>

                        <?php if ($hasError('seating_capacity')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['seating_capacity']) ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- SECTION 3: RENTAL INFORMATION -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-cash-stack text-primary me-2"></i>
                    Rental Information
                </h5>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <!-- Daily Rate -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Daily Rental Rate (JMD) *
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">JMD $</span>

                            <input type="number"
                                   name="daily_rate"
                                   class="form-control <?= $hasError('daily_rate') ? 'is-invalid' : '' ?>"
                                   value="<?= $value('daily_rate') ?>"
                                   min="0.01"
                                   max="9999999999.99"
                                   step="0.01"
                                   placeholder="8500.00"
                                   required>

                        </div>

                        <?php if ($hasError('daily_rate')): ?>
                            <div class="text-danger small mt-1">
                                <?= htmlspecialchars($errors['daily_rate']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Security Deposit -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Security Deposit (JMD)
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">JMD $</span>

                            <input type="number"
                                   name="security_deposit"
                                   class="form-control <?= $hasError('security_deposit') ? 'is-invalid' : '' ?>"
                                   value="<?= $value('security_deposit', '0.00') ?>"
                                   min="0"
                                   max="9999999999.99"
                                   step="0.01"
                                   placeholder="20000.00">

                        </div>

                        <?php if ($hasError('security_deposit')): ?>
                            <div class="text-danger small mt-1">
                                <?= htmlspecialchars($errors['security_deposit']) ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- SECTION 4: VEHICLE ASSIGNMENT -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-geo-alt text-primary me-2"></i>
                    Vehicle Assignment & Status
                </h5>

            </div>

            <div class="card-body p-4">

                <div class="row g-3">

                    <!-- Home Location -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Home Rental Location *
                        </label>

                        <select name="home_location_id"
                                class="form-select <?= $hasError('home_location_id') ? 'is-invalid' : '' ?>"
                                required>

                            <option value="">Select rental location</option>

                            <?php foreach ($locations as $location): ?>

                                <option
                                    value="<?= (int) $location['location_id'] ?>"
                                    <?= (string) ($old['home_location_id'] ?? '') === (string) $location['location_id'] ? 'selected' : '' ?>>

                                    <?= htmlspecialchars($location['location_name']) ?>

                                </option>

                            <?php endforeach; ?>

                        </select>

                        <?php if ($hasError('home_location_id')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['home_location_id']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Odometer -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Current Odometer Reading (km) *
                        </label>

                        <input type="number"
                               name="current_odometer"
                               class="form-control <?= $hasError('current_odometer') ? 'is-invalid' : '' ?>"
                               value="<?= $value('current_odometer', '0') ?>"
                               min="0"
                               max="4294967295"
                               placeholder="e.g. 45000"
                               required>

                        <?php if ($hasError('current_odometer')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['current_odometer']) ?>
                            </div>
                        <?php endif; ?>

                    </div>


                    <!-- Vehicle Status -->
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Vehicle Status *
                        </label>

                        <select name="vehicle_status"
                                class="form-select <?= $hasError('vehicle_status') ? 'is-invalid' : '' ?>"
                                required>

                            <option value="active"
                                <?= $value('vehicle_status', 'active') === 'active' ? 'selected' : '' ?>>
                                Active
                            </option>

                            <option value="maintenance"
                                <?= $value('vehicle_status') === 'maintenance' ? 'selected' : '' ?>>
                                Maintenance
                            </option>

                            <option value="inactive"
                                <?= $value('vehicle_status') === 'inactive' ? 'selected' : '' ?>>
                                Inactive
                            </option>

                            <option value="retired"
                                <?= $value('vehicle_status') === 'retired' ? 'selected' : '' ?>>
                                Retired
                            </option>

                        </select>

                        <?php if ($hasError('vehicle_status')): ?>
                            <div class="invalid-feedback">
                                <?= htmlspecialchars($errors['vehicle_status']) ?>
                            </div>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


        <!-- SECTION 5: ADDITIONAL INFORMATION -->
        <div class="card border-0 shadow-sm mb-4">

            <div class="card-header bg-white py-3">

                <h5 class="fw-bold mb-0">
                    <i class="bi bi-info-circle text-primary me-2"></i>
                    Additional Information
                </h5>

            </div>

            <div class="card-body p-4">

                <label class="form-label fw-semibold">
                    Vehicle Description
                </label>

                <textarea name="description"
                          class="form-control"
                          rows="4"
                          placeholder="Enter additional information about this vehicle..."><?= $value('description') ?></textarea>

            </div>

        </div>


<!-- SECTION 6: VEHICLE IMAGES -->
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0">
            <i class="bi bi-images text-primary me-2"></i>
            Vehicle Images
        </h5>
    </div>

    <div class="card-body p-4">

        <label for="vehicle_images" class="form-label fw-semibold">
            Upload Vehicle Photographs
        </label>

        <input
            type="file"
            name="vehicle_images[]"
            id="vehicle_images"
            class="form-control"
            accept="image/jpeg,image/png,image/webp"
            multiple
        >

        <div class="form-text">
            Accepted formats: JPEG, PNG and WebP.
            Maximum 5 MB per image. Maximum 10 images.
            The first image will be the primary photograph.
        </div>

        <?php if (!empty($errors['vehicle_images'])): ?>
            <div class="text-danger small mt-2">
                <?= htmlspecialchars($errors['vehicle_images']) ?>
            </div>
        <?php endif; ?>

        <div id="imagePreview" class="row g-3 mt-3"></div>

    </div>
</div>


        <!-- FORM ACTIONS -->
        <div class="d-flex justify-content-end gap-2 mb-5">

            <a href="/admin/vehicles"
               class="btn btn-outline-secondary px-4">

                Cancel

            </a>

            <button type="submit"
                    class="btn btn-primary px-4">

                <i class="bi bi-check-circle me-1"></i>
                Register Vehicle

            </button>

        </div>

    </form>

</div>


<?php

// Capture page content.
//$content = ob_get_clean();

// Load the shared application layout.
//require BASE_PATH . '/resources/views/layouts/main.php';

?>

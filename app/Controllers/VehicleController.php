<?php

// VehicleController.php will connect the vehicle registration interface to the database through the models created.
// This controller will be responsible for handling vehicle registration requests, validating submitted information, checking user permissions and saving vehicle records.
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Vehicle;
use App\Models\VehicleCategory;
use App\Models\Location;
use App\Middleware\AuthMiddleware;
use App\Models\VehicleImage;
use App\Core\Database;
use PDOException;

class VehicleController extends Controller
{
    private Vehicle $vehicle;
    private VehicleCategory $category;
    private Location $location;
    private VehicleImage $vehicleImage;

    /**
     * Initialize vehicle management models.
     */
    public function __construct()
    {
        $this->vehicle = new Vehicle();
        $this->category = new VehicleCategory();
        $this->location = new Location();
        $this->vehicleImage = new VehicleImage();
    }

    /**
     * Display all registered vehicles.
     */
    public function index(): void
    {
        AuthMiddleware::requireRole([
            'Administrator',
            'Manager',
            'Rental Officer'
        ]);

        $vehicles = $this->vehicle->getAll();

        $this->render('vehicles/index', [
            'title' => 'Vehicle Management',
            'vehicles' => $vehicles
        ]);
    }

    /**
     * Display the vehicle registration form.
     */
    public function create(): void
    {
        AuthMiddleware::requireRole([
            'Administrator',
            'Manager',
            'Rental Officer'
        ]);

        $this->render('vehicles/create', [
            'title' => 'Register New Vehicle',
            'categories' => $this->category->getActiveAll(),
            'locations' => $this->location->getActiveAll(),
            'errors' => [],
            'old' => []
        ]);
    }

    /**
     * Process a new vehicle registration.
     */
    public function store(): void
    {
        AuthMiddleware::requireRole([
            'Administrator',
            'Manager',
            'Rental Officer'
        ]);

        // Verify CSRF token.
        if (!$this->validateCsrf()) {
            http_response_code(419);
            exit('Invalid or expired form token.');
        }

        // Normalize submitted information.
        $data = [
            'category_id' => trim($_POST['category_id'] ?? ''),
            'home_location_id' => trim($_POST['home_location_id'] ?? ''),
            'registration_number' => strtoupper(
                trim($_POST['registration_number'] ?? '')
            ),
            'vin' => strtoupper(trim($_POST['vin'] ?? '')),
            'make' => trim($_POST['make'] ?? ''),
            'model' => trim($_POST['model'] ?? ''),
            'manufacturing_year' => trim(
                $_POST['manufacturing_year'] ?? ''
            ),
            'color' => trim($_POST['color'] ?? ''),
            'transmission' => trim($_POST['transmission'] ?? ''),
            'fuel_type' => trim($_POST['fuel_type'] ?? ''),
            'seating_capacity' => trim(
                $_POST['seating_capacity'] ?? ''
            ),
            'daily_rate' => trim($_POST['daily_rate'] ?? ''),
            'security_deposit' => trim(
                $_POST['security_deposit'] ?? '0'
            ),
            'current_odometer' => trim(
                $_POST['current_odometer'] ?? '0'
            ),
            'vehicle_status' => trim(
                $_POST['vehicle_status'] ?? 'active'
            ),
            'description' => trim($_POST['description'] ?? '')
        ];

        // Validate submitted information.
        $errors = array_merge(
    $this->validateVehicle($data),
    $this->validateVehicleImages()
);

        if (!empty($errors)) {
            http_response_code(422);

            $this->render('vehicles/create', [
                'title' => 'Register New Vehicle',
                'categories' => $this->category->getActiveAll(),
                'locations' => $this->location->getActiveAll(),
                'errors' => $errors,
                'old' => $data
            ]);

            return;
        }

        // Save vehicle.
// Save vehicle and uploaded images.
$db = Database::getConnection();
$storedImages = [];

try {
    // Start database transaction.
    $db->beginTransaction();

    // Create vehicle record.
    $vehicleId = $this->vehicle->create($data);

    // Store uploaded image files.
    $storedImages = $this->storeVehicleImages($vehicleId);

    // Save image records.
    foreach ($storedImages as $image) {
        $this->vehicleImage->create(
            $vehicleId,
            $image['path'],
            $image['is_primary'],
            $image['display_order']
        );
    }

    // Commit database changes.
    $db->commit();

    // Redirect after successful registration.
    $this->redirect(
        '/admin/vehicles?created=' . $vehicleId
    );

} catch (\Throwable $e) {

    // Roll back database changes.
    if ($db->inTransaction()) {
        $db->rollBack();
    }

    // Remove uploaded files.
    $this->deleteStoredVehicleImages($storedImages);

    error_log(
        'Vehicle registration error: ' . $e->getMessage()
    );

    http_response_code(500);

    $this->render('vehicles/create', [
        'title' => 'Register New Vehicle',
        'categories' => $this->category->getActiveAll(),
        'locations' => $this->location->getActiveAll(),
        'errors' => [
            'general' => 'Unable to register vehicle. Please try again.'
        ],
        'old' => $data
    ]);

    return;
}
}
    /**
     * Validate vehicle registration information.
     */
    private function validateVehicle(array $data): array
    {
        $errors = [];

        // Registration number.
        if ($data['registration_number'] === '') {
            $errors['registration_number'] =
                'Registration number is required.';

        } elseif (strlen($data['registration_number']) > 30) {
            $errors['registration_number'] =
                'Registration number cannot exceed 30 characters.';

        } elseif (
            $this->vehicle->registrationExists(
                $data['registration_number']
            )
        ) {
            $errors['registration_number'] =
                'This registration number is already registered.';
        }

        // VIN.
        if (strlen($data['vin']) > 50) {
            $errors['vin'] =
                'VIN cannot exceed 50 characters.';

        } elseif (
            $data['vin'] !== '' &&
            $this->vehicle->vinExists($data['vin'])
        ) {
            $errors['vin'] =
                'This VIN is already registered.';
        }

        // Make.
        if ($data['make'] === '' || strlen($data['make']) > 100) {
            $errors['make'] =
                'Enter a valid vehicle make (maximum 100 characters).';
        }

        // Model.
        if ($data['model'] === '' || strlen($data['model']) > 100) {
            $errors['model'] =
                'Enter a valid vehicle model (maximum 100 characters).';
        }

        // Manufacturing year.
        $year = filter_var(
            $data['manufacturing_year'],
            FILTER_VALIDATE_INT
        );

        if (
            $year === false ||
            $year < 1901 ||
            $year > ((int) date('Y') + 1)
        ) {
            $errors['manufacturing_year'] =
                'Enter a valid manufacturing year.';
        }

        // Category.
        $categoryId = filter_var(
            $data['category_id'],
            FILTER_VALIDATE_INT
        );

        if (
            $categoryId === false ||
            !$this->category->findById($categoryId)
        ) {
            $errors['category_id'] =
                'Select a valid vehicle category.';
        }

        // Rental location.
        $locationId = filter_var(
            $data['home_location_id'],
            FILTER_VALIDATE_INT
        );

        if (
            $locationId === false ||
            !$this->location->findById($locationId)
        ) {
            $errors['home_location_id'] =
                'Select a valid rental location.';
        }

        // Transmission.
        if (!in_array(
            $data['transmission'],
            ['automatic', 'manual'],
            true
        )) {
            $errors['transmission'] =
                'Select a valid transmission type.';
        }

        // Fuel type.
        if (!in_array(
            $data['fuel_type'],
            ['petrol', 'diesel', 'hybrid', 'electric', 'other'],
            true
        )) {
            $errors['fuel_type'] =
                'Select a valid fuel type.';
        }

        // Seating capacity.
        $seats = filter_var(
            $data['seating_capacity'],
            FILTER_VALIDATE_INT
        );

        if ($seats === false || $seats < 1 || $seats > 255) {
            $errors['seating_capacity'] =
                'Enter a valid seating capacity.';
        }

        // Daily rental rate.
        if (
            !is_numeric($data['daily_rate']) ||
            !is_finite((float) $data['daily_rate']) ||
            (float) $data['daily_rate'] <= 0 ||
            (float) $data['daily_rate'] > 9999999999.99
        ) {
            $errors['daily_rate'] =
                'Enter a valid daily rental rate.';
        }

        // Security deposit.
        if (
            !is_numeric($data['security_deposit']) ||
            !is_finite((float) $data['security_deposit']) ||
            (float) $data['security_deposit'] < 0 ||
            (float) $data['security_deposit'] > 9999999999.99
        ) {
            $errors['security_deposit'] =
                'Enter a valid security deposit.';
        }

        // Current odometer.
        $odometer = filter_var(
            $data['current_odometer'],
            FILTER_VALIDATE_INT
        );

        if (
            $odometer === false ||
            $odometer < 0 ||
            $odometer > 4294967295
        ) {
            $errors['current_odometer'] =
                'Enter a valid odometer reading.';
        }

        // Vehicle status.
        if (!in_array(
            $data['vehicle_status'],
            ['active', 'maintenance', 'inactive', 'retired'],
            true
        )) {
            $errors['vehicle_status'] =
                'Select a valid vehicle status.';
        }

        // Colour.
        if (strlen($data['color']) > 50) {
            $errors['color'] =
                'Colour cannot exceed 50 characters.';
        }

        return $errors;
    }

    /**
     * Validate uploaded vehicle images.
     */

/**
 * Validate uploaded vehicle images.
 */
private function validateVehicleImages(): array
{
    $errors = [];

    if (
        !isset($_FILES['vehicle_images']) ||
        empty($_FILES['vehicle_images']['name'][0])
    ) {
        return $errors;
    }

    $files = $_FILES['vehicle_images'];

    $allowedMimeTypes = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    $maxFileSize = 5 * 1024 * 1024;
    $maxFiles = 10;

    if (count($files['name']) > $maxFiles) {
        $errors['vehicle_images'] =
            'You can upload a maximum of 10 images.';

        return $errors;
    }

    $finfo = new \finfo(FILEINFO_MIME_TYPE);

    foreach ($files['name'] as $index => $name) {

        if ($files['error'][$index] !== UPLOAD_ERR_OK) {
            $errors['vehicle_images'] =
                'One or more images could not be uploaded.';
            break;
        }

        if ($files['size'][$index] > $maxFileSize) {
            $errors['vehicle_images'] =
                'Each image must not exceed 5 MB.';
            break;
        }

        $mimeType = $finfo->file(
            $files['tmp_name'][$index]
        );

        if (!in_array($mimeType, $allowedMimeTypes, true)) {
            $errors['vehicle_images'] =
                'Only JPEG, PNG and WebP images are allowed.';
            break;
        }

        if (
            @getimagesize($files['tmp_name'][$index]) === false
        ) {
            $errors['vehicle_images'] =
                'One or more uploaded files are not valid images.';
            break;
        }
    }

    return $errors;
}



/**
 * Store uploaded vehicle images.
 *
 * Returns the relative paths of successfully stored images.
 */
private function storeVehicleImages(int $vehicleId): array
{
    $storedImages = [];

    if (
        !isset($_FILES['vehicle_images']) ||
        empty($_FILES['vehicle_images']['name'][0])
    ) {
        return $storedImages;
    }

    $uploadDirectory = BASE_PATH .
        '/public/assets/images/vehicles/';

    if (
        !is_dir($uploadDirectory) &&
        !mkdir($uploadDirectory, 0755, true) &&
        !is_dir($uploadDirectory)
    ) {
        throw new \RuntimeException(
            'Unable to create vehicle image directory.'
        );
    }

    $files = $_FILES['vehicle_images'];

    $extensions = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    try {
        foreach ($files['name'] as $index => $originalName) {

            $mimeType = (new \finfo(FILEINFO_MIME_TYPE))
                ->file($files['tmp_name'][$index]);

            if (!isset($extensions[$mimeType])) {
                throw new \RuntimeException(
                    'Unsupported vehicle image format.'
                );
            }

            $filename = bin2hex(random_bytes(16)) .
                '.' . $extensions[$mimeType];

            $destination = $uploadDirectory . $filename;

            if (!move_uploaded_file(
                $files['tmp_name'][$index],
                $destination
            )) {
                throw new \RuntimeException(
                    'Unable to store vehicle image.'
                );
            }

            $storedImages[] = [
                'path' => 'assets/images/vehicles/' . $filename,
                'is_primary' => $index === 0,
                'display_order' => $index
            ];
        }

        return $storedImages;

    } catch (\Throwable $e) {

        $this->deleteStoredVehicleImages($storedImages);

        throw $e;
    }
}



/**
 * Remove uploaded files if vehicle registration fails.
 */
private function deleteStoredVehicleImages(array $images): void
{
    $uploadDirectory = BASE_PATH .
        '/public/assets/images/vehicles/';

    foreach ($images as $image) {
        $filename = basename($image['path']);
        $filePath = $uploadDirectory . $filename;

        if (is_file($filePath)) {
            unlink($filePath);
        }
    }
}



    /**
     * Validate the submitted CSRF token.
     */
    private function validateCsrf(): bool
    {
        return isset(
            $_POST['csrf_token'],
            $_SESSION['csrf_token']
        ) && hash_equals(
            $_SESSION['csrf_token'],
            $_POST['csrf_token']
        );
    }
}


<?php

use App\Core\Router;
use App\Controllers\HomeController;
use App\Controllers\AuthController;
use App\Controllers\VehicleController;

// Initialize router
$router = new Router();

// ==========================================
// PUBLIC ROUTES
// ==========================================

// Homepage
$router->get('/', [HomeController::class, 'index']);

// ==========================================
// AUTHENTICATION ROUTES
// ==========================================

// Registration form for new users to create an account.
$router->get('/register', [AuthController::class, 'showRegister']);
$router->post('/register', [AuthController::class, 'register']);

// Login
$router->get('/login', [AuthController::class, 'showLogin']);
$router->post('/login', [AuthController::class, 'login']);

// Logout
$router->post('/logout', [AuthController::class, 'logout']);

// ==========================================
// VEHICLE MANAGEMENT ROUTES
// ==========================================

// Vehicle inventory. This route will display a list of all registered vehicles in the system.
$router->get(
    '/admin/vehicles',
    [VehicleController::class, 'index']
);

// Display vehicle registration form. This route will show a form where administrators can input details for a new vehicle to be added to the system.
$router->get(
    '/admin/vehicles/create',
    [VehicleController::class, 'create']
);

// Process vehicle registration. This route will handle the submission of the vehicle registration form, validate the input data, and save the new vehicle record to the database.
$router->post(
    '/admin/vehicles',
    [VehicleController::class, 'store']
);

// ==========================================
// DISPATCH REQUEST
// ==========================================

$router->dispatch();

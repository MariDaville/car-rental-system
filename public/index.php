<?php

// Define application root directory
define('BASE_PATH', dirname(__DIR__));

// Load Composer autoloader
require BASE_PATH . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Load application configuration
$appConfig = require BASE_PATH . '/config/app.php';

// Set application timezone
date_default_timezone_set($appConfig['timezone']);

// Display errors during development only
ini_set(
    'display_errors',
    $appConfig['debug'] ? '1' : '0'
);

error_reporting(E_ALL);

// Test database connection
try {

    $database = App\Core\Database::getConnection();

    echo '<h1>Car Rental Management System</h1>';

    echo '<p>Application initialized successfully.</p>';

    echo '<p style="color:green;">
        MySQL database connection successful!
    </p>';

} catch (Throwable $e) {

    http_response_code(500);

    echo '<h1>Application initialization failed</h1>';

    echo '<p>Check your application configuration and logs.</p>';

    error_log($e->getMessage());

}
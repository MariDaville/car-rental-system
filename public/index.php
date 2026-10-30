<?php

// Define application root
define('BASE_PATH', dirname(__DIR__));

// Load Composer autoloader
require BASE_PATH . '/vendor/autoload.php';

// Load environment variables
$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Load application configuration
$appConfig = require BASE_PATH . '/config/app.php';

// Set timezone
date_default_timezone_set($appConfig['timezone']);

// Configure error reporting
error_reporting(E_ALL);

ini_set(
    'display_errors',
    $appConfig['debug'] ? '1' : '0'
);

// Load application routes
require BASE_PATH . '/routes/web.php';
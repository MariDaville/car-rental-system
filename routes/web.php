<?php

use App\Core\Router;
use App\Controllers\HomeController;

// Initialize router
$router = new Router();

// Public routes
$router->get('/', [HomeController::class, 'index']);

// Dispatch incoming request
$router->dispatch();
<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    /**
     * Display the application homepage.
     */
    public function index(): void
    {
        $this->render('home/index', [
            'title' => 'Welcome to Car Rental Management System'
        ]);
    }
}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title) ?></title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        :root {
            --primary: #172B4D;
            --accent: #2563EB;
            --background: #F5F7FA;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--background);
            color: #263445;
        }

        /* Navigation */

        .navbar {
            background: white;
            padding: 18px 0;
        }

        .navbar-brand {
            color: var(--primary);
            font-size: 23px;
            font-weight: 700;
        }

        .navbar-brand span {
            color: var(--accent);
        }

        .nav-link {
            color: #39475A;
            font-weight: 500;
        }

        .btn-primary-custom {
            background: var(--accent);
            color: white;
            border: none;
            padding: 11px 23px;
            border-radius: 7px;
        }

        .btn-primary-custom:hover {
            background: #1D4ED8;
            color: white;
        }

        /* Hero section */

        .hero {
            background: linear-gradient(
                120deg,
                #172B4D,
                #263F67
            );
            color: white;
            padding: 90px 0 130px;
        }

        .hero h1 {
            font-size: clamp(2.2rem, 5vw, 3.7rem);
            font-weight: 750;
            line-height: 1.2;
        }

        .hero p {
            color: #D5DEEC;
            font-size: 17px;
        }

        .hero-icon {
            font-size: 150px;
            color: rgba(255,255,255,0.85);
        }

        /* Search form */

        .search-box {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 35px rgba(0,0,0,0.10);
            margin-top: -65px;
            position: relative;
            z-index: 2;
        }

        .form-label {
            font-weight: 600;
            font-size: 14px;
        }

        .form-control, .form-select {
            padding: 12px;
            border-color: #DEE3EA;
        }

        /* General sections */

        .section-padding {
            padding: 75px 0;
        }

        .section-heading {
            color: var(--primary);
            font-weight: 700;
        }

        .section-description {
            color: #718096;
        }

        /* Vehicle cards */

        .vehicle-card {
            background: white;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }

        .vehicle-image {
            height: 190px;
            background: #E9EFF8;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .vehicle-image i {
            font-size: 85px;
            color: var(--primary);
        }

        .vehicle-price {
            color: var(--accent);
            font-size: 20px;
            font-weight: 700;
        }

        .vehicle-specs {
            color: #718096;
            font-size: 13px;
        }

        /* Features */

        .feature-icon {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #E7EFFF;
            color: var(--accent);
            border-radius: 12px;
            font-size: 25px;
            margin-bottom: 18px;
        }

        /* Footer */

        footer {
            background: var(--primary);
            color: white;
            padding: 55px 0 20px;
        }

        footer a {
            color: #D5DEEC;
            text-decoration: none;
        }

        footer a:hover {
            color: white;
        }

        @media (max-width: 768px) {
            .hero {
                padding: 65px 0 100px;
                text-align: center;
            }

            .hero-icon {
                font-size: 90px;
                margin-top: 30px;
            }

            .search-box {
                padding: 20px;
            }
        }
    </style>

</head>

<body>

<!-- NAVIGATION BAR -->

<nav class="navbar navbar-expand-lg sticky-top shadow-sm">

    <div class="container">

        <a class="navbar-brand" href="/">
            <i class="bi bi-car-front-fill"></i>
            Car<span>Rental</span>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar">

            <span class="navbar-toggler-icon"></span>

        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/vehicles">Vehicles</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/about">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>

                <li class="nav-item">
                    <a href="/register" class="btn btn-primary-custom">
                        Get Started
                    </a>
                </li>

            </ul>

        </div>

    </div>

</nav>


<!-- HERO SECTION -->

<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7">

                <h1>
                    Find Your Perfect
                    <span class="text-info">Rental Car</span>
                </h1>

                <p class="mt-4">
                    Discover reliable, comfortable and affordable
                    vehicles for your next journey.
                    Book your vehicle with ease and enjoy the ride.
                </p>

                <a href="#vehicle-search"
                   class="btn btn-primary-custom mt-3">

                    Explore Vehicles
                    <i class="bi bi-arrow-right"></i>

                </a>

            </div>

            <div class="col-lg-5 text-center">

                <i class="bi bi-car-front-fill hero-icon"></i>

            </div>

        </div>

    </div>

</section>


<!-- VEHICLE SEARCH -->

<section class="container" id="vehicle-search">

    <div class="search-box">

        <h4 class="section-heading mb-4">
            Find Your Rental Vehicle
        </h4>

        <form action="/vehicles" method="GET">

            <div class="row g-3">

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Pickup Location
                    </label>

                    <select name="pickup_location"
                            class="form-select">

                        <option value="">Select location</option>
                        <option value="kingston">Kingston</option>
                        <option value="montego-bay">Montego Bay</option>
                        <option value="ochi-r ios">Ocho Rios</option>
                    </select>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Pickup Date
                    </label>

                    <input type="date"
                           name="pickup_date"
                           class="form-control"
                           required>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Return Date
                    </label>

                    <input type="date"
                           name="return_date"
                           class="form-control"
                           required>

                </div>

                <div class="col-lg-3 col-md-6">

                    <label class="form-label">
                        Vehicle Category
                    </label>

                    <select name="category"
                            class="form-select">

                        <option value="">All categories</option>
                        <option value="economy">Economy</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                        <option value="luxury">Luxury</option>

                    </select>

                </div>

                <div class="col-12 text-end">

                    <button type="submit"
                            class="btn btn-primary-custom mt-2">

                        <i class="bi bi-search"></i>
                        Search Vehicles

                    </button>

                </div>

            </div>

        </form>

    </div>

</section>


<!-- FEATURED VEHICLES -->

<section class="section-padding">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="section-heading">
                Featured Vehicles
            </h2>

            <p class="section-description">
                Explore some of our popular rental vehicles.
            </p>

        </div>

        <div class="row g-4">

            <!-- VEHICLE 1 -->

            <div class="col-lg-4 col-md-6">

                <div class="card vehicle-card h-100">

                    <div class="vehicle-image">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    <div class="card-body">

                        <h5 class="fw-bold">
                            Toyota Corolla
                        </h5>

                        <p class="text-muted small">
                            Economy Sedan
                        </p>

                        <div class="d-flex justify-content-between
                                    vehicle-specs mb-3">

                            <span>
                                <i class="bi bi-gear"></i>
                                Automatic
                            </span>

                            <span>
                                <i class="bi bi-people"></i>
                                5 Seats
                            </span>

                            <span>
                                <i class="bi bi-fuel-pump"></i>
                                Petrol
                            </span>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between
                                    align-items-center">

                            <div>
                                <span class="vehicle-price">
                                    JMD $10,000
                                </span>

                                <small class="text-muted">/ day</small>
                            </div>

                            <a href="/vehicles"
                               class="btn btn-outline-primary btn-sm">

                                View Details

                            </a>

                        </div>

                    </div>

                </div>

            </div>


            <!-- VEHICLE 2 -->

            <div class="col-lg-4 col-md-6">

                <div class="card vehicle-card h-100">

                    <div class="vehicle-image">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    <div class="card-body">

                        <h5 class="fw-bold">
                            Honda Civic
                        </h5>

                        <p class="text-muted small">
                            Compact Sedan
                        </p>

                        <div class="d-flex justify-content-between
                                    vehicle-specs mb-3">

                            <span>
                                <i class="bi bi-gear"></i>
                                Automatic
                            </span>

                            <span>
                                <i class="bi bi-people"></i>
                                5 Seats
                            </span>

                            <span>
                                <i class="bi bi-fuel-pump"></i>
                                Petrol
                            </span>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between
                                    align-items-center">

                            <div>
                                <span class="vehicle-price">
                                    JMD $12,000
                                </span>

                                <small class="text-muted">/ day</small>
                            </div>

                            <a href="/vehicles"
                               class="btn btn-outline-primary btn-sm">

                                View Details

                            </a>

                        </div>

                    </div>

                </div>

            </div>


            <!-- VEHICLE 3 -->

            <div class="col-lg-4 col-md-6">

                <div class="card vehicle-card h-100">

                    <div class="vehicle-image">
                        <i class="bi bi-car-front-fill"></i>
                    </div>

                    <div class="card-body">

                        <h5 class="fw-bold">
                            Toyota RAV4
                        </h5>

                        <p class="text-muted small">
                            Sport Utility Vehicle
                        </p>

                        <div class="d-flex justify-content-between
                                    vehicle-specs mb-3">

                            <span>
                                <i class="bi bi-gear"></i>
                                Automatic
                            </span>

                            <span>
                                <i class="bi bi-people"></i>
                                5 Seats
                            </span>

                            <span>
                                <i class="bi bi-fuel-pump"></i>
                                Petrol
                            </span>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between
                                    align-items-center">

                            <div>
                                <span class="vehicle-price">
                                    JMD $15,000
                                </span>

                                <small class="text-muted">/ day</small>
                            </div>

                            <a href="/vehicles"
                               class="btn btn-outline-primary btn-sm">

                                View Details

                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


<!-- WHY CHOOSE US -->

<section class="section-padding bg-white">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="section-heading">
                Why Choose Us?
            </h2>

            <p class="section-description">
                Making your rental experience simple and convenient.
            </p>

        </div>

        <div class="row g-4 text-center">

            <div class="col-md-4">

                <div class="feature-icon mx-auto">
                    <i class="bi bi-car-front"></i>
                </div>

                <h5 class="fw-bold">
                    Quality Vehicles
                </h5>

                <p class="text-muted">
                    Choose from a selection of reliable and
                    well-maintained vehicles.
                </p>

            </div>

            <div class="col-md-4">

                <div class="feature-icon mx-auto">
                    <i class="bi bi-cash-stack"></i>
                </div>

                <h5 class="fw-bold">
                    Competitive Pricing
                </h5>

                <p class="text-muted">
                    Enjoy transparent rental pricing with
                    no unexpected surprises.
                </p>

            </div>

            <div class="col-md-4">

                <div class="feature-icon mx-auto">
                    <i class="bi bi-headset"></i>
                </div>

                <h5 class="fw-bold">
                    Customer Support
                </h5>

                <p class="text-muted">
                    Our team is available to assist you
                    throughout your rental experience.
                </p>

            </div>

        </div>

    </div>

</section>


<!-- FOOTER -->

<footer>

    <div class="container">

        <div class="row g-4">

            <div class="col-lg-5">

                <h4 class="fw-bold">
                    <i class="bi bi-car-front-fill"></i>
                    CarRental
                </h4>

                <p class="mt-3 text-light-emphasis">
                    Your trusted partner for convenient,
                    reliable and affordable vehicle rentals.
                </p>

            </div>

            <div class="col-lg-3">

                <h6 class="fw-bold mb-3">
                    Quick Links
                </h6>

                <ul class="list-unstyled d-grid gap-2">

                    <li><a href="/">Home</a></li>
                    <li><a href="/vehicles">Vehicles</a></li>
                    <li><a href="/about">About Us</a></li>
                    <li><a href="/contact">Contact</a></li>

                </ul>

            </div>

            <div class="col-lg-4">

                <h6 class="fw-bold mb-3">
                    Contact Information
                </h6>

                <p>
                    <i class="bi bi-geo-alt"></i>
                    Jamaica
                </p>

                <p>
                    <i class="bi bi-envelope"></i>
                    info@example.com
                </p>

                <p>
                    <i class="bi bi-telephone"></i>
                    +1 (876) 000-0000
                </p>

            </div>

        </div>

        <hr class="border-secondary mt-4">

        <div class="text-center text-light-emphasis small">

            &copy; <?= date('Y') ?> Car Rental Management System.
            All rights reserved.

        </div>

    </div>

</footer>


<!-- Bootstrap JavaScript -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>

</body>
</html>

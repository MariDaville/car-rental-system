<!-- HERO SECTION -->

<section class="hero">

    <!-- Keep your existing hero content here -->
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

    <!-- Keep your existing search form here -->
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
                        <option value="ocho-rios">Ocho Rios</option>
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

    <!-- Keep your existing vehicle cards here -->
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

    <!-- Keep your existing feature content here -->
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
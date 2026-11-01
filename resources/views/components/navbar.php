<nav class="navbar navbar-expand-lg sticky-top shadow-sm">

    <div class="container">

        <a class="navbar-brand" href="/">
            <i class="bi bi-car-front-fill"></i>
            Car<span>Rental</span>
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#mainNavbar"
                aria-controls="mainNavbar"
                aria-expanded="false"
                aria-label="Toggle navigation">

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

                <!-- <li class="nav-item">
                    <a class="nav-link" href="/login">Login</a>
                </li>

                <li class="nav-item">
                    <a href="/register" class="btn btn-primary-custom">
                        Get Started
                    </a>
                </li> -->
                <?php if (!empty($_SESSION['user_id'])): ?>

    <span class="nav-link">
        Welcome, <?= htmlspecialchars($_SESSION['email']) ?>
    </span>

    <form method="POST" action="/logout" class="d-inline">

        <input
            type="hidden"
            name="csrf_token"
            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
        >

        <button type="submit" class="btn btn-outline-danger">
            Logout
        </button>

    </form>

<?php else: ?>

    <a href="/login" class="nav-link">
        Login
    </a>

    <a href="/register" class="btn btn-primary">
        Get Started
    </a>

<?php endif; ?>

            </ul>

        </div>

    </div>

</nav>
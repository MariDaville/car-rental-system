
<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-6 col-lg-5">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <h2 class="fw-bold text-center mb-2">
                        Welcome Back
                    </h2>

                    <p class="text-muted text-center mb-4">
                        Log in to your CarRental account.
                    </p>

                    <?php if (!empty($error)): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>

                    <?php if (!empty($_SESSION['flash_success'])): ?>

                        <div class="alert alert-success">
                            <?= htmlspecialchars($_SESSION['flash_success']) ?>
                        </div>

                        <?php unset($_SESSION['flash_success']); ?>

                    <?php endif; ?>

                    <form method="POST" action="/login">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
                        >

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                autocomplete="email"
                                required
                            >

                        </div>

                        <div class="mb-4">

                            <label class="form-label">
                                Password
                            </label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                autocomplete="current-password"
                                required
                            >

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 py-2"
                        >
                            Login
                        </button>

                    </form>

                    <p class="text-center mt-4 mb-0">

                        Don't have an account?

                        <a href="/register">
                            Register here
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

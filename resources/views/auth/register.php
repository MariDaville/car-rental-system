
<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-7 col-lg-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4 p-md-5">

                    <h2 class="fw-bold text-center mb-2">
                        Create Your Account
                    </h2>

                    <p class="text-muted text-center mb-4">
                        Register to start renting your vehicle.
                    </p>

                    <?php if (!empty($error)): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>

                    <form method="POST" action="/register">

                        <input
                            type="hidden"
                            name="csrf_token"
                            value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>"
                        >

                        <div class="row">

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    First Name
                                </label>

                                <input
                                    type="text"
                                    name="first_name"
                                    class="form-control"
                                    maxlength="100"
                                    required
                                >

                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Last Name
                                </label>

                                <input
                                    type="text"
                                    name="last_name"
                                    class="form-control"
                                    maxlength="100"
                                    required
                                >

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                maxlength="150"
                                autocomplete="email"
                                required
                            >

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Phone Number
                            </label>

                            <input
                                type="tel"
                                name="phone"
                                class="form-control"
                                maxlength="30"
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
                                minlength="8"
                                autocomplete="new-password"
                                required
                            >

                            <small class="text-muted">
                                Minimum 8 characters.
                            </small>

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100 py-2"
                        >
                            Create Account
                        </button>

                    </form>

                    <p class="text-center mt-4 mb-0">

                        Already have an account?

                        <a href="/login">
                            Login here
                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

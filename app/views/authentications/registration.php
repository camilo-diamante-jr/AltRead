<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AltRead</title>
    <link rel="stylesheet" href="/css/import.styles.css?v=<?= time(); ?>" />
    <script src="/assets/jquery/jquery.min.js"></script>
    <link rel="icon" type="image/png" href="/assets/images/logo/AltRead-Logo.jpg">

    <style>
        main {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .reg-box .card {
            width: 100%;
            max-width: 520px;
            padding: 20px;
        }

        .btn-success {
            background: #28a745;
            border: none;
            border-radius: 6px;
            transition: background 0.3s ease-in-out;
        }

        .btn-success:hover {
            background: #218838;
        }


        .bg-white-smoke {
            background-color: rgb(189, 182, 182);
        }

        .border-white {
            border: 2.5px solid white;
        }

        .avatar-lg {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .form-floating input:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
        }

        .toggle-password {
            background: transparent;
            border: none;
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>

<body>
    <?php
    $this->renderView('/preloader');
    include_once 'terms_and_condition.php';
    ?>
    <main>
        <section class="reg-box w-100">
            <div class="card m-auto shadow" style="max-width: 900px; border-radius: 1rem; overflow: hidden;">
                <div class="row g-0">
                    <!-- Left Side: Logo & Intro -->
                    <div class="col-md-5 d-flex flex-column justify-content-center align-items-center bg-light text-center p-4">
                        <img src="/assets/images/logo/AltRead-Logo.jpg" alt="AltRead Logo" class="img-fluid mb-3" style="width: 150px;">
                        <h5 class="fw-bold mb-3">Welcome to AltRead!</h5>
                        <p class="text-muted">Create your account to access powerful learning tools, smart reading, and more.</p>
                    </div>

                    <!-- Right Side: Registration Form -->
                    <div class="col-md-7 p-4">
                        <h5 class="mb-3 fw-bold text-center">Sign Up</h5>
                        <form id="registerNewUser" enctype="multipart/form-data" method="POST">
                            <div class="form-floating mb-2">
                                <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Complete name" required>
                                <label for="name">Complete Name</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="text" id="username" name="username" class="form-control form-control-sm" placeholder="Username" required>
                                <label for="username">Username</label>
                            </div>

                            <div class="form-floating mb-2">
                                <input type="email" id="email" name="email" class="form-control form-control-sm" placeholder="Email" required>
                                <label for="email">Email</label>
                            </div>

                            <div class="form-floating mb-2 position-relative">
                                <input type="password" name="password" id="password" class="form-control form-control-sm pe-5" placeholder="Password" required>
                                <label for="password">Password</label>
                                <button type="button"
                                    class="btn btn-link position-absolute top-50 end-0 translate-middle-y text-secondary toggle-password"
                                    onclick="togglePassword()">
                                    <i id="toggleIcon" class="bi bi-eye"></i>
                                </button>
                            </div>

                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="termsCheck" required>
                                <label class="form-check-label small text-muted" for="termsCheck">
                                    I accept the <a href="#termsModal" data-bs-toggle="modal" class="text-decoration-none text-primary fw-bold">Terms and Conditions</a>
                                </label>
                            </div>

                            <input type="hidden" id="userType" name="userType" value="learner" />

                            <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">Submit</button>

                            <div class="text-center py-3">
                                <p class="mb-3">Already have an account?
                                    <a href="/login" class="text-primary fw-semibold">Login</a>
                                </p>
                                <a href="/" class="text-warning fw-bold small text-decoration-none">
                                    <i class="fa fa-arrow-left"></i>
                                    Back to Home
                                </a>

                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/swal2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="/assets/aos/js/aos.js"></script>
    <script src="/js/registration.js?v=<?= time(); ?>"></script>
    <script src="/js/preloader.js"></script>
</body>

</html>
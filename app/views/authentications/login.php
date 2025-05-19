<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AltRead</title>
    <link rel="stylesheet" href="css/import.styles.css?v=<?= time(); ?>" />
    <script src="assets/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="icon" type="image/png" href="assets/images/logo/AltRead-Logo.jpg">

    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }

        .login-box {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .login-box form {
            margin-top: -15px;
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

        .footer {
            margin-top: 20px;
            font-size: 0.9rem;
            text-align: center;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
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

    <section class="login-box">
        <div class="card shadow-sm px-4">
            <div class="card-body text-center">
                <figure>
                    <img class="img-fluid" src="assets/images/logo/AltRead-Logo.jpg" alt="Logo" width="180">
                </figure>

                <!-- <h2 class="fw-bold">Welcome to AltRead</h2> -->
                <!-- <p class="text-muted">Your ultimate reading companion</p> -->

                <div class="toast align-items-center text-bg-danger mb-3 border-0" role="alert" id="loginToast"
                    data-bs-delay="3000">
                    <div class="d-flex">
                        <div class="toast-body text-center">
                            Invalid username or password. Please try again.
                        </div>
                    </div>
                </div>

                <form id="loginForm" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" id="username" class="form-control rounded-3" placeholder="Username"
                            required>
                        <label for="username">Username</label>
                    </div>

                    <div class="form-floating mb-3 position-relative">
                        <input type="password" name="password" id="userPass" class="form-control rounded-3"
                            placeholder="Password" required>
                        <label for="userPass">Password</label>
                        <button type="button" id="toggleBtn" class="toggle-password">
                            <i id="passToggleIcon" class="bi bi-eye"></i>
                        </button>
                    </div>

                    <div class="form-check mb-3 remember-me">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                    </div>

                    <button type="submit" class="btn btn-success btn-lg rounded-3 w-100">Sign In</button>
                    <p class="mt-4">Don't have an account? Please sign up <a href="/student/registration">Here.</a></p>
                    <a href="/" class="text-warning fw-bold small text-decoration-none">
                        <i class="fa fa-arrow-left"></i>
                        Back to Home
                    </a>
                </form>
            </div>
        </div>
    </section>

    <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/swal2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="js/login.js?v=<?= time(); ?>"></script>
    <script src="js/registration.js?v=<?= time(); ?>"></script>
    <script src="js/preloader.js"></script>
</body>

</html>
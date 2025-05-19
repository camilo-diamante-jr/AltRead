<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AltRead</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/css/homepage.css?v=<?= time() ?>" />
    <script src="/assets/jquery/jquery.min.js"></script>
</head>

<body>
    <!-- Loader From Uiverse.io by cosnametv -->
    <div class="loader-container">
        <div class="preloader">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div id="app-wrapper">
        <header id="app-header"></header>

        <main class="container-fluid">
            <!-- Homepage -->
            <div id="home"></div>
            <!-- Features -->
            <div id="features"></div>
            <!-- How it Works -->
            <div id="how-it-works"></div>
            <!-- About Us -->
            <div id="about"></div> <!-- 🔧 Add this missing section -->

            <!-- Contact -->
            <div id="contact"></div>
        </main>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="social-icons">
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i
                            class="fab fa-facebook"></i></a>
                    <a href="https://twitter.com" target="_blank" aria-label="Twitter"><i
                            class="fab fa-twitter"></i></a>
                    <a href="https://instagram.com" target="_blank" aria-label="Instagram"><i
                            class="fab fa-instagram"></i></a>
                    <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"><i
                            class="fab fa-linkedin"></i></a>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2025 Your Company. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>

    <!-- JS Libraries -->
    <script src="/assets/aos/js/aos.js"></script>
    <script src="/assets/OwlCarousel2-2.3.4/js/owl.carousel.min.js"></script>

    <script src="/js/libraries/homepage.js?v=<?= time() ?>"></script>
</body>

</html>
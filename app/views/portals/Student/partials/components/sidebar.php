<aside class="app-sidebar bg-body-secondary shadow sidebar-expand " data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/learner" class="brand-link">
            <img src="../../assets/images/logo/als logo.png" alt="ALS-Logo"
                class="brand-image rounded-circle opacity-75 shadow">

            <span class="brand-text fw-light"><?= $brand_text ?></span>
        </a>
    </div>
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/dashboard" class="nav-link active">
                        <i class="nav-icon fa fa-dashboard"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <!-- Assessments-->
                <li class="nav-item">
                    <a href="/assessments" class="nav-link">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Assessments</p>
                    </a>
                </li>

                <!-- Post-Evaluation Test -->
                <li class="nav-item">
                    <a href="/materials" class="nav-link">
                        <i class="nav-icon fa-solid fa-chalkboard"></i>
                        <p>Learning Materials</p>
                    </a>
                </li>

                <!-- Progress Tracker -->
                <li class="nav-item">
                    <a href="/submissions" class="nav-link">
                        <i class="nav-icon bi bi-bar-chart-line"></i>
                        <p>Submissions</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="/settings" class="nav-link">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Settings</p>
                    </a>
                </li>

                <!-- About Us -->
                <li class="nav-item">
                    <a href="/about-us" class="nav-link">
                        <i class="nav-icon bi bi-patch-check-fill"></i>
                        <p>About Us</p>
                    </a>
                </li>


                <!-- Logout -->
                <li class="nav-item">
                    <a href="/logout" class="nav-link">
                        <i class="nav-icon bi bi-box-arrow-right"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Get the current URL path
        let currentPath = window.location.pathname;

        // Remove 'active' from all links and apply it to the matching one
        $(".sidebar-menu .nav-link").removeClass("active");
        $(".sidebar-menu .nav-link").each(function() {
            if ($(this).attr("href") === currentPath) {
                $(this).addClass("active");
            }
        });

        // Update 'active' class on click
        $(".sidebar-menu .nav-link").on("click", function() {
            $(".sidebar-menu .nav-link").removeClass("active");
            $(this).addClass("active");
        });
    });
</script>
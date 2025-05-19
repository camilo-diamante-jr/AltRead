<?php

$userType = $_SESSION['user_type'];

// Include headers based on user type
if ($userType === 'Admin') {
    $this->renderView("./pages/Admin/partials/admin-header", $data);
} elseif ($userType === 'Teacher') {
    $this->renderView('./pages/Teacher/partials/teachers-header', $data);
} elseif ($userType === 'Learner') {
    $this->renderView('./pages/Student/partials/header-student', $data);
}

?>

<main id="account-settings-main-app" class="app-main">
    <section class="app-content">
        <div class="container p-3">
            <div class="section-guide px-3 pt-3">
                <p>Welcome to your Account Settings. Use the navigation on the left to update your profile, change your
                    password, and manage your personal information. Click on the respective tabs to get started.</p>
            </div>
            <div class="row flex-lg-nowrap">
                <div class="col-12 col-md-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <nav id="nav-settings" class="nav flex-column nav-pills">

                                <a class="nav-link active" href="#general-account-settings" data-bs-toggle="tab"><i
                                        class="bi bi-person-circle"></i> General Settings</a>

                                <?php if ($userType === 'Learner'): ?>
                                    <a class="nav-link" href="#personal-information-settings" data-bs-toggle="tab"><i
                                            class="bi bi-info-circle"></i> Personal Information</a>
                                <?php endif; ?>

                                <a class="nav-link" href="#password-security-settings" data-bs-toggle="tab"><i
                                        class="bi bi-lock"></i> Password</a>

                                <?php if ($userType === 'Admin'): ?>
                                    <a class="nav-link" href="#system-settings" data-bs-toggle="tab"><i
                                            class="bi bi-gear"></i> System Settings</a>
                                <?php endif; ?>

                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">Account Settings</div>
                        <div class="card-body">
                            <div id="tab-settings-content" class="tab-content">
                                <!-- General Settings -->
                                <article class="tab-pane active" id="general-account-settings">
                                    <?php include_once 'tabs/general-settings.php'; ?>
                                </article>

                                <?php if ($userType === 'Learner'): ?>
                                    <article class="tab-pane" id="personal-information-settings">
                                        <?php include_once 'tabs/personal-information-settings.php'; ?>
                                    </article>
                                <?php endif; ?>

                                <article class="tab-pane" id="password-security-settings">
                                    <?php include_once 'tabs/password-and-security.php'; ?>
                                </article>

                                <?php if ($userType === 'Admin'): ?>
                                    <article class="tab-pane" id="system-settings">
                                        <h3>System Settings</h3>
                                    </article>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    $(document).ready(function() {
        const navLinks = $('#nav-settings .nav-link');
        const tabContent = $('#tab-settings-content');

        // Retrieve the last active tab from localStorage
        const savedTabId = localStorage.getItem('activeTab');

        if (savedTabId) {
            // Activate the saved tab
            navLinks.removeClass('active');
            $(`a[href="${savedTabId}"]`).addClass('active');
            $('.tab-pane').removeClass('active');
            $(savedTabId).addClass('active');
        }

        // Listen for tab clicks
        navLinks.on('click', function(e) {
            e.preventDefault();
            const clickedTab = $(this);
            const tabId = clickedTab.attr('href');

            // Save the active tab's ID to localStorage
            localStorage.setItem('activeTab', tabId);

            // Update active states
            navLinks.removeClass('active');
            clickedTab.addClass('active');

            $('.tab-pane').removeClass('active');
            $(tabId).addClass('active');
        });
    });
</script>

<!-- Settings -->
<script src="../js/settings/settings.js?v=<?= time(); ?>"></script>

<?php

// Include footers based on user type
if ($userType === 'Admin') {
    $this->renderView("./pages/Admin/partials/admin-footer");
} elseif ($userType === 'Teacher') {
    $this->renderView('./pages/Teacher/partials/teachers-footer');
} elseif ($userType === 'Learner') {
    $this->renderView('./pages/Student/partials/footer-student');
}
?>
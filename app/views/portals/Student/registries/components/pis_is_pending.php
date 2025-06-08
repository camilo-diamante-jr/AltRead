<?php $this->renderView('portals/Student/partials/header-student', $data); ?>

<!-- Main Content -->
<main class="app-main d-flex align-items-center justify-content-center min-vh-100 bg-light">
    <section class="app-content text-center w-100">
        <div class="container">
            <div class="alert bg-white border rounded p-4 shadow text-center mx-auto" style="max-width: 500px;">
                <i class="bi bi-exclamation-circle-fill display-4 text-warning mb-3"></i>
                <h3 class="fw-bold">Access Restricted</h3>
                <p class="text-muted"><?= htmlspecialchars($message) ?></p>
                <a href="/logout" class="btn btn-outline-dark mt-3">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </section>
</main>

<?php $this->renderView('portals/Student/partials/footer-student'); ?>
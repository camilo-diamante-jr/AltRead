<?php $this->renderView('pages/Student/partials/header-student', $data); ?>

<!-- Main Content -->
<main class="app-main d-flex align-items-center justify-content-center min-vh-100">
    <section class="app-content text-center">
        <div class="container">
            <div class="alert alert-danger p-4 rounded shadow-lg fade show d-flex align-items-center justify-content-center" role="alert">
                <div class="d-flex flex-column">
                    <i class="bi bi-x-circle-fill display-4 text-danger mb-3"></i>
                    <h3 class="fw-bold">Access Denied</h3>
                    <p class="lead"><?= htmlspecialchars($message) ?></p>
                    <a href="javascript:history.back()" class="btn btn-outline-danger mt-3">
                        <i class="bi bi-arrow-left"></i> Go Back
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php $this->renderView('pages/Student/partials/footer-student'); ?>
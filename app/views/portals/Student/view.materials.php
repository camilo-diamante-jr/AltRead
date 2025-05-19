<?php

// Render the header view
$this->renderView('./pages/Student/partials/header-student', $data);

?>

<main class="app-main mt-5">
    <header class="app-content-header bg-light py-3 shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 text-primary">
                        <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </header>

    <section class="app-content py-5">
        <div class="container">


            <!-- Materials Container -->
            <?php include_once 'registries/materials/learning.materials.php'  ?>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active" aria-current="page">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </section>
</main>


<?php

// Render the footer view
$this->renderView('pages/Student/partials/footer-student');

?>
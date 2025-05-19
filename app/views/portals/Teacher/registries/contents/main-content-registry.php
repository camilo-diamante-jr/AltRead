<?php $this->renderView('./pages/Teacher/partials/teachers-header', $data); ?>

<main class="app-main">
    <header class="app-content-header">
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="mb-0"><?= $breadcrumb_title ?></h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $breadcrumb_title ?>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
    </header>

    <section class="app-content">
        <div id="mainContentRegistry" class="container-fluid">

            <div class="mt-3">

                <div class="card card-primary card-outline">
                    <header class="card-header py-0 pt-3">
                        <div class="">
                            <ul class="nav nav-underline" id="contentsTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2 active" data-bs-toggle="tab" data-bs-target="#modules" role="tab">Modules</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#lessons" role="tab">Lessons</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#parts" role="tab">Parts</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#questions" role="tab">Questions</button>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#choices" role="tab">Choices</button>
                                </li> -->
                            </ul>
                        </div>
                    </header>
                    <div class="card-body">

                        <div class="tab-content" id="contentsContent">
                            <article class="tab-pane fade show active" id="modules" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'modules/module-registry.php' ?>
                                </div>
                            </article>
                            <article class="tab-pane fade" id="lessons" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'lessons/lesson-registry.php' ?>
                                </div>
                            </article>
                            <article class="tab-pane fade" id="parts" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'parts/part-registry.php' ?>
                                </div>
                            </article>
                            <article class="tab-pane fade" id="questions" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'questions/questions-registry.php' ?>
                                </div>
                            </article>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<?php $this->renderView('./pages/Teacher/partials/teachers-footer'); ?>
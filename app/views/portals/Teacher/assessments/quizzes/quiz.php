<?php
$this->renderView("pages/Teacher/partials/teachers-header", $data);
?>


<main class="app-main"> <!--begin::App Content Header-->
    <div class="app-content-header"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= $data['breadcrumb_title'] ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="#"><?= $data['breadcrumb_go_back_home_text'] ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $data['breadcrumb_current_link_text'] ?>
                        </li>
                    </ol>
                </div>
            </div> <!--end::Row-->
        </div> <!--end::Container-->
    </div> <!--end::App Content Header--> <!--begin::App Content-->
    <div class="app-content"> <!--begin::Container-->
        <div class="container-fluid"> <!--begin::Row-->
            <div class="card examination-card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5>All quizzes (0)</h5>
                        <div>
                            <button id="openAddQuizModalBtn" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Quiz</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="quizzesTable" class="table table-hover table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Title</th>
                                <th>Question</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <?php foreach ($quizzes as $quiz) : ?>
                                    <tr>
                                        <td></td>
                                        <td><?= $quiz['quiz_title'] ?></td>
                                        <td><?= $quiz['quiz_question'] ?></td>
                                        <td>
                                            <button type="button" class="btn btn-sm editQuizButton btn-warning me-2" title="Edit" data-quiz-id="<?= $quiz['quiz_id'] ?>">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-danger" title="Remove">
                                                <i class="fa fa-archive"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
</main>

<?php
$this->renderView("pages/Teacher/partials/teachers-footer");
include_once "components/createQuizModal.php";
?>
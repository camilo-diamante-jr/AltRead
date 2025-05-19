<?php
$this->renderView("pages/Teacher/partials/teachers-header", $data);

?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= htmlspecialchars($data['breadcrumb_title']) ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="#"><?= htmlspecialchars($data['breadcrumb_go_back_home_text']) ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= htmlspecialchars($data['breadcrumb_current_link_text']) ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

        </div>
    </div>
</main>




<?php
include_once 'components/modals/view.pretest.modal.php';

$this->renderView("pages/Teacher/partials/teachers-footer");
?>
<?php
$this->renderView("/pages/Teacher/partials/teachers-header", $data);
?>
<style>
    #pretestTable td,
    #pretestTable th {
        font-size: 14px !important;
        border-right: 1px solid #dee2e6 !important;
    }

    .dataTables_scrollBody {
        overflow-x: auto !important;
        overflow-y: auto !important;
        max-height: 400px;
    }

    th.no-sort {
        pointer-events: none;
    }
</style>
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
            <div class="card shadow-lg">
                <div class="card-header">
                    <div class="d-flex justify-content-end align-items-center">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-0"
                            data-bs-target="#insertPretestModal" data-bs-toggle="modal">
                            <i class="fa fa-plus"></i> Publish New Pretest
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <?php
                        include_once 'components/tables/active.pretest.table.php'
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>




<?php
include_once 'components/modals/view.pretest.modal.php';
include_once 'components/modals/insert.pretest.modal.php';
include_once 'components/modals/edit.pretest.modal.php';
$this->renderView("/pages/Teacher/partials/teachers-footer");
?>

<script>
    let table = new DataTable('#pretestTable', {
        ordering: false,


    });
    $('.dataTables_filter input').attr('placeholder', '🔍 Search here...');
</script>
<?php $this->renderView('pages/Teacher/partials/teachers-header', $data); ?>

<style>
    .file_drag {
        border: 2px dashed #ccc;
        line-height: 400px;
        text-align: center;
        font-size: 24px;
    }

    .file_drag_over {
        color: #000;
        border-color: #000;
    }

    #uploaded_file {
        margin-top: 20px;
    }

    .none-border {
        border: 0px solid #ddd;
    }

    #del-image {
        margin-top: 5px;
    }
</style>


<!-- Modal -->
<div class="modal fade" id="answerKeysModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow">
            <form id="uploadAnswerKeysForm">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-upload me-2"></i>Upload Answer Keys</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- <h3 class="text-center">Drag & drop and delete file upload using JQuery Ajax and PHP</h3><br /> -->
                    <div class="file_drag">
                        <i class="fa fa-folder"></i>
                        Drop Files Here
                    </div>
                    <div class="container">
                        <div id="uploaded_file"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Submit
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<main class="app-main">
    <div class="app-content-header mb-4">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= $breadcrumb_title ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                        <li class="breadcrumb-item active">Manage Answer Keys</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">

                    <!-- Action Buttons -->
                    <div class="container d-flex align-items-center justify-content-start gap-2 mb-2">
                        <button class="btn btnExport btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#answerKeysModal">
                            <i class="bi bi-upload"></i>
                            Import
                        </button>
                        <button class="btn btnExport btn-sm btn-outline-info" data-export="">
                            <i class="bi bi-download"></i>
                            Export
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="answerKeysTable" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>File Name</th>
                                    <th>Upload Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="answerKeysTableBody">
                                <?php foreach ($answerKeys as $index => $answerKey) : ?>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary rounded-0"> View </button>
                                            <button class="btn btn-sm btn-outline-warning rounded-0"> Update </button>
                                            <button class="btn btn-sm btn-outline-danger rounded-0"> Remove </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>
</main>


<?php $this->renderView('./pages/Teacher/partials/teachers-footer'); ?>
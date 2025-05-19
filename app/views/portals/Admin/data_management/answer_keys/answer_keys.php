<?php
$this->renderView('./portals/Admin/partials/admin-header', $data);
include 'components/answerkeyUploadModal.php';
?>
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
                    <div class="container d-flex align-items-center justify-content-end gap-2 mb-2">
                        <button class="btn btnExport btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#answerKeysModal">
                            <i class="bi bi-upload"></i>
                            Import answerkeys
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="answerKeysTable" class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>File Name</th>
                                    <th>Upload Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="answerKeysTableBody">
                                <?php foreach ($answerKeys as $answerKey) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($answerKey['original_name']) ?></td>
                                        <td><?= date("F j, Y", strtotime($answerKey['uploaded_at'])) ?></td>
                                        <td class="text-center">
                                            <a
                                                data-fancybox
                                                data-type="iframe"
                                                data-src="../files/uploads/answer_keys/dfds.pdf"
                                                href="javascript:;"
                                                class="text-secondary me-2"
                                                title="View">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="#" class="text-warning me-2 update-file" data-id="<?= $answerKey['id'] ?>" title="Update">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="#" class="text-danger remove-file" data-id="<?= $answerKey['id'] ?>" title="Remove">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
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
<script>
    Fancybox.bind("[data-fancybox]", {
        Toolbar: {
            display: ["close"],
        },
        iframe: {
            preload: false,
        },
    });
</script>

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


<?php $this->renderView('./portals/Admin/partials/admin-footer'); ?>
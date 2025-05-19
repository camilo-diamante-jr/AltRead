<div class="tab-pane fade show active" id="activeMaterials" role="tabpanel" aria-labelledby="active-tab">
    <div class="card">
        <div class="card-body">

            <div class="d-flex justify-content-end">
                <button id="addNewMaterials" class="btn btn-primary btn-sm shadow-sm">
                    <i class="fa fa-plus"></i> <span>New material</span>
                </button>
            </div>

            <div class="table-responsive">
                <table id="materialTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Attach Files</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($materials as $material): ?>
                            <tr>
                                <td class="index-column"></td> <!-- Empty column for JavaScript numbering -->
                                <td><?= $material['materialTitle'] . ': ' . $material['materialSubtitle'] ?></td>
                                <td><?= $material['materialCategory'] ?></td>
                                <td>
                                    <a href="../../files/uploads/<?= $material['materialFiles'] ?>" data-fancybox="pdf-gallery" class="text-decoration-underline text-primary">
                                        <?= $material['materialFiles'] ?>
                                    </a>

                                </td>
                                <td>
                                    <button class="btn mat-edit-btn btn-sm btn-dark mb-1"
                                        data-material-id="<?= $material['materialID'] ?>">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        <!-- <span>Edit</span> -->
                                    </button>
                                    <button class="btn mat-archive-btn btn-sm btn-danger mb-1"
                                        data-material-id="<?= $material['materialID'] ?>">
                                        <i class=" fa fa-archive" aria-hidden="true"></i>
                                        <!-- <span>Archive</span> -->
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
<div class="tab-pane fade" id="archivedMaterials" role="tabpanel" aria-labelledby="archived-tab">
    <div class="card">
        <div class="card-header">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="archivedMaterialTable" class="table table-hover table-bordered">
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
                            <?php
                            foreach ($archivedMaterials as $index => $archived): ?>
                                <tr>
                                    <td class="index-column"><?php echo $index + 1 ?></td> <!-- Dynamically assign number -->
                                    <td><?= htmlspecialchars($archived['materialTitle'] . " " . $archived['materialSubtitle']) ?></td>
                                    <td><?= htmlspecialchars($archived['materialCategory']) ?></td>
                                    <td>
                                        <a href="../../files/uploads/<?= htmlspecialchars($archived['materialFiles'], ENT_QUOTES, 'UTF-8') ?>"
                                            data-fancybox="pdf-gallery"
                                            class="text-decoration-underline text-primary">
                                            <?= htmlspecialchars($archived['materialFiles']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-secondary mat-restore-btn" data-material-id="<?= $archived['materialID'] ?>">
                                            <i class="bi bi-box-arrow-up"></i>
                                            <span>Restore</span>
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
</div>
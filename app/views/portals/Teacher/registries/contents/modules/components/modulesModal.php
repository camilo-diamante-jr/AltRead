<div class="modal fade" id="addModuleModal" tabindex="-1" aria-labelledby="addModuleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModuleModalLabel">Add New Module</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addModuleForm">
                    <div class="mb-3">
                        <label for="moduleName" class="form-label">Module Name</label>
                        <input type="text" class="form-control" id="moduleName" name="moduleName" required>
                    </div>
                    <div class="mb-3">
                        <label for="moduleDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="moduleDescription" name="moduleDescription" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save Module</button>
                        <button type="button" class="btn btn-secondary closeModuleModal" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<?php foreach ($modules as $module) : ?>
    <div class="modal fade" id="editModuleModal_<?= $module['module_id'] ?>" tabindex="-1" aria-labelledby="editModuleModalLabel_<?= $module['module_id'] ?>" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModuleModalLabel_<?= $module['module_id'] ?>">Edit Module</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="editModuleForm" data-module-id="<?= $module['module_id'] ?>">
                        <input type="hidden" name="module_id" value="<?= $module['module_id'] ?>">

                        <div class="mb-3">
                            <label for="editModuleName_<?= $module['module_id'] ?>" class="form-label">Module Name</label>
                            <input type="text" class="form-control" id="editModuleName_<?= $module['module_id'] ?>" name="moduleName" value="<?= htmlspecialchars($module['module_name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="editModuleDescription_<?= $module['module_id'] ?>" class="form-label">Description</label>
                            <textarea class="form-control" id="editModuleDescription_<?= $module['module_id'] ?>" name="moduleDescription" rows="3" required><?= htmlspecialchars($module['module_description']) ?></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success updateModuleBtn">Update Module</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    $(document).ready(function() {
        const reloadBtn = $('.closeModuleModal');

        reloadBtn.on("click", function() {
            window.location.reload();
        });
    });
</script>
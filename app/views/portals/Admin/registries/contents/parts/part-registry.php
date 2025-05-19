<!-- Add Parts Button -->
<div class="d-flex justify-content-between mb-3">
    <h5 class="mb-0">Parts</h5>
    <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addPartsModal">
        <i class="fa fa-plus"></i> Add Parts
    </button>
</div>

<div class="table-responsive">
    <table id="partsTable" class="table table-hover table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Part name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($parts as $index => $part): ?>
                <tr>
                    <td style="width:5%"><?= $index + 1; ?></td>
                    <td><?= htmlspecialchars($part["part_name"]); ?></td>
                    <td style="width: 10%;">
                        <button class="btn btn-sm edit btn-warning" data-bs-toggle="modal" data-bs-target="#editPartsModal" data-part-id="<?= $index; ?>" data-part-name="<?= htmlspecialchars($part["part_name"]); ?>">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </button>
                        <button class="btn btn-sm delete btn-danger" data-part-id="<?= $index; ?>">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modal for Adding Parts -->
<div class="modal fade" id="addPartsModal" tabindex="-1" aria-labelledby="addPartsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPartsModalLabel">Add Parts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPartForm">
                    <div id="addPartsContainer">
                        <div class="mb-3">
                            <label for="partName" class="form-label">Part Name</label>
                            <input type="text" class="form-control partName" required>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary" id="addMoreParts">Add More Parts</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Editing Parts -->
<div class="modal fade" id="editPartsModal" tabindex="-1" aria-labelledby="editPartsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPartsModalLabel">Edit Part</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editPartForm">
                    <div class="mb-3">
                        <label for="editPartName" class="form-label">Part Name</label>
                        <input type="text" class="form-control" id="editPartName" required>
                    </div>
                    <input type="hidden" id="editPartId">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
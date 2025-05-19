<!-- Header Section -->



<!-- Table Section -->
<div class="table-responsive">
    <table id="moduleTable" class="table table-hover table-bordered align-middle">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th class="text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Data will be loaded dynamically via AJAX -->
        </tbody>
    </table>
    <div class="d-flex justify-content-start mt-3 align-items-center mb-3">
        <div>
            <button class="btn btn-warning rounded-0 btn-sm me-2" id="refreshTable">
                <i class="fa fa-sync"></i> Refresh
            </button>
            <button class="btn btn-success rounded-0 btn-sm" data-bs-toggle="modal" data-bs-target="#addModuleModal">
                <i class="fa fa-plus"></i> Add Module
            </button>
        </div>
    </div>
</div>

<?php require_once 'components/modulesModal.php'; ?>
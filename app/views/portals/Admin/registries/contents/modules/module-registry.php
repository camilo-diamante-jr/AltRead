<!-- Header Section -->


<div class="d-flex justify-content-end mt-3 align-items-center mb-3">
    <div>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addModuleModal">
            <i class="fa fa-plus"></i> Add Module
        </button>
    </div>
</div>

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

</div>

<?php require_once 'components/modulesModal.php'; ?>
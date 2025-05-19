<!-- Modal Body -->
<!-- If you want to close by clicking outside the modal, delete the last endpoint: data-bs-backdrop and data-bs-keyboard -->
<div class="modal fade" id="addNewMaterialsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <form id="addNewMaterialSubmitForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Add New Materials</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="title" name="title" class="form-control" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="subtitle" class="form-label">Subtitle <span class="text-danger">*</span></label>
                            <input type="text" id="subtitle" name="subtitle" class="form-control" required />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <input type="text" id="category" name="category" class="form-control" required />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="genre" class="form-label">Genre <small>(If any)</small></label>
                            <input type="text" id="genre" name="genre" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="file" class="form-label">Attach files <small>(Accepts PDF only)</small></label>
                            <input type="file" id="file" name="file" class="form-control" accept=".pdf" required />
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
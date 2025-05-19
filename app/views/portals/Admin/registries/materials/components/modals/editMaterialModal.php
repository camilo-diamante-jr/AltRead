<div class="modal fade" id="editMaterialsModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <form id="editMaterialSubmitForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitleId">Edit Materials</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <!-- Hidden material id  -->
                        <input type="hidden" name="updateMaterialID" id="updateMaterialID" />

                        <!-- Title -->
                        <div class="col-md-4 mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" id="updateTitle" name="updateTitle" class="form-control" required />
                        </div>

                        <!-- Subtitle -->
                        <div class="col-md-4 mb-3">
                            <label for="subtitle" class="form-label">Subtitle <span class="text-danger">*</span></label>
                            <input type="text" id="updateSubtitle" name="updateSubtitle" class="form-control"
                                required />
                        </div>

                        <!-- Category -->
                        <div class="col-md-4 mb-3">
                            <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                            <input type="text" id="updateCategory" name="updateCategory" class="form-control"
                                required />
                        </div>

                        <!-- Genre if any -->
                        <div class="col-md-6 mb-3">
                            <label for="genre" class="form-label">Genre <small>(If any)</small></label>
                            <input type="text" id="updateGenre" name="updateGenre" class="form-control" />
                        </div>

                        <!-- Attach files -->
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="updateFile">Upload New File</label>
                                <input type="file" id="updateFile" name="updateFile" class="form-control" accept="application/pdf">
                                <small class="text-muted">Current file: <span id="currentFileLabel">No file
                                        selected</span></small>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
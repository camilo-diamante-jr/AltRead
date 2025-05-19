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
<form id="insertPretestSubmitForm" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="insertPretestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <header class="modal-header ">
                    <h5 class="modal-title">Insert New Pretest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </header>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <textarea name="question" class="form-control" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select name="pretest_type" class="form-select" required>
                            <option value="Reading">Reading</option>
                            <option value="Writing">Writing</option>
                        </select>
                    </div>

                    <div class="mb-3 optional-field">
                        <label class="form-label">Main Context</label>
                        <textarea name="context" class="form-control"></textarea>
                    </div>

                    <div id="sub-context-container"></div>
                    <button type="button" id="add-sub-context" class="btn btn-success mb-3">Add Sub Context</button>

                    <div class="mb-3">
                        <label class="form-label">Choice Type</label>
                        <select id="choice-type" class="form-select" required>
                            <option value="text">Text</option>
                            <option value="image">Image</option>
                        </select>
                    </div>

                    <div class="mb-3" id="choices-section">
                        <label class="form-label">Choices</label>
                        <div class="choices-wrapper" id="text-choices">
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">A</span>
                                <input type="text" name="choice_a" class="form-control">
                            </div>
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">B</span>
                                <input type="text" name="choice_b" class="form-control">
                            </div>
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">C</span>
                                <input type="text" name="choice_c" class="form-control">
                            </div>
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">D</span>
                                <input type="text" name="choice_d" class="form-control">
                            </div>
                        </div>

                        <div class="choices-wrapper" id="image-choices" style="display:none;">
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">A</span>
                                <input type="file" name="choice_a" class="form-control" accept="image/*">
                            </div>
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">B</span>
                                <input type="file" name="choice_b" class="form-control" accept="image/*">
                            </div>
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">C</span>
                                <input type="file" name="choice_c" class="form-control" accept="image/*">
                            </div>
                            <div class="input-group mb-2 choice-group">
                                <span class="input-group-text">D</span>
                                <input type="file" name="choice_d" class="form-control" accept="image/*">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="correct-answer-section">
                        <label class="form-label">Correct Answer</label>
                        <select name="correct_answer" class="form-select" required>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                        </select>
                    </div>
                </div>

                <footer class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-save-pretest">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </footer>
            </div>
        </div>
    </div>
</form>
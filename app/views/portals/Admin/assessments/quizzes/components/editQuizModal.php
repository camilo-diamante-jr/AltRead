<!-- Edit Quiz Modal -->
<div class="modal fade" id="editQuizModal" tabindex="-1" aria-labelledby="editQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="quizEditForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="editQuizModalLabel">Edit Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row">
                    <!-- Quiz Title -->
                    <div class="col-md-6 mb-3">
                        <label for="edit_quiz_title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit_quiz_title" name="quiz_title">
                    </div>

                    <!-- Quiz Type - Select Dropdown -->
                    <div class="col-md-6 mb-3">
                        <label for="edit_quiz_type" class="form-label">Type</label>
                        <select class="form-select" id="edit_quiz_type" name="quiz_type">
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="true_false">True/False</option>
                            <option value="short_answer">Short Answer</option>
                        </select>
                    </div>

                    <!-- Quiz Question -->
                    <div class="col-12 mb-3">
                        <label for="edit_quiz_question" class="form-label">Question</label>
                        <textarea class="form-control" id="edit_quiz_question" name="quiz_question" rows="3"></textarea>
                    </div>

                    <!-- Sub Contents Card -->
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <strong>Sub Contents</strong>
                            </div>
                            <div class="card-body" id="editQuizSubContentsWrapper">
                                <!-- Textareas will be dynamically populated here -->
                            </div>
                        </div>
                    </div>

                    <!-- Choices Card -->
                    <div class="col-12 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <strong>Choices</strong>
                            </div>
                            <div class="card-body" id="editQuizChoicesWrapper">
                                <!-- Input fields will be dynamically populated here -->
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
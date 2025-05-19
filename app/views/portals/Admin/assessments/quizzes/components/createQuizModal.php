<!-- Add Quiz Modal -->
<div class="modal fade" id="addQuizModal" tabindex="-1" aria-labelledby="addQuizModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form id="addQuizForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="addQuizModalLabel">Add New Quiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row">
                    <div class="col-md-6 mb-3">
                        <label for="add_quiz_title" class="form-label">Quiz Title</label>
                        <input type="text" class="form-control" id="add_quiz_title" name="quiz_title">
                    </div>

                    <!-- Quiz Type - Select Dropdown -->
                    <div class="col-md-6 mb-3">
                        <label for="add_quiz_type" class="form-label">Quiz Type</label>
                        <select class="form-select" id="add_quiz_type" name="quiz_type">
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="true_false">True/False</option>
                            <option value="short_answer">Short Answer</option>
                        </select>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="add_quiz_question" class="form-label">Quiz Question</label>
                        <textarea class="form-control" id="add_quiz_question" name="quiz_question" rows="3"></textarea>
                    </div>

                    <!-- Sub Contents -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sub Contents</label>
                        <div id="addQuizSubContentsWrapper"></div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addQuizAddSubContentBtn">+ Add Sub Content</button>
                    </div>

                    <!-- Choices -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Choices</label>
                        <div id="addQuizChoicesWrapper"></div>
                        <button type="button" class="btn btn-outline-secondary btn-sm mt-2" id="addQuizAddChoiceBtn">+ Add Choice</button>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Quiz</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include 'editQuizModal.php';
?>
<!-- Insert Question Modal -->
<form id="insertQuestionForm" method="POST" enctype="multipart/form-data">
    <div class="modal fade" id="insertNewQuestionModal" tabindex="-1" aria-labelledby="insertModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <section class="modal-content">
                <header class="modal-header">
                    <h5 class="modal-title" id="insertModalTitle">Add New Question</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </header>
                <article class="modal-body">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-warning d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                <strong>Note:</strong> If the section is not applicable, simply ignore it.
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <label for="lesson_id">Lessons</label>
                                    <select class="form-select" name="lesson_id">
                                        <option value="" disabled>-- Select Lesson --</option>
                                        <?php foreach ($lessons as $lesson) : ?>
                                            <option value="<?= $lesson['lesson_id'] ?>"><?= $lesson['lesson_description'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="part_id">Parts Per Lesson</label>
                                    <select class="form-select" name="part_id">
                                        <option value="" disabled>-- Select Part --</option>
                                        <?php foreach ($parts as $part) : ?>
                                            <option value="<?= $part['part_id'] ?>"><?= $part['part_name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="question_type">Question Type</label>
                                    <select class="form-select" name="question_type" id="question_type">
                                        <option value="" disabled>-- Select Question Type --</option>
                                        <option value="multiple_choice">Multiple Choice</option>
                                        <option value="true_false">True or False</option>
                                        <option value="short_answer">Short Answer</option>
                                        <option value="fill_in_the_blank">Fill in the Blank</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="questions_direction">Directions</label>
                                    <textarea class="form-control" name="questions_direction" id="questions_direction" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <label for="question_text">Question Text</label>
                                    <textarea class="form-control" name="question_text" id="question_text" rows="3"></textarea>
                                </div>
                            </div>

                            <!-- Content image -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="content_title">Content Title</label>
                                    <input type="text" class="form-control" name="content_title" id="content_title" />
                                </div>
                                <div class="col-md-6">
                                    <label for="content_image">Content Image</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="content_image" id="content_image" placeholder="Click to upload image" />
                                    </div>
                                    <div class="text-center">
                                        <figure>
                                            <img id="imagePreview" src="" class="img-thumbnail d-none" width="200" />
                                        </figure>
                                        <button type="button" id="removeImageFileBtn" class="btn btn-danger d-none">Remove Image</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Sub-content Section -->
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <button type="button" id="addSubContentBtn" class="btn btn-sm btn-outline-primary rounded-pill">
                                        <i class="bi bi-plus-lg"></i> Add Sub Content
                                    </button>
                                    <div id="sub-content-container" class="mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Multiple Choice Section -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="multiple-choice-main-container d-none">
                                <div class="card p-4 shadow-sm border-0">
                                    <h5 class="d-flex align-items-center">
                                        <i class="bi bi-list-check me-2 text-primary"></i> Multiple Choice Setup
                                    </h5>
                                    <p class="text-muted">
                                        Please enter the answer choices below and select the correct one by checking the corresponding box.
                                    </p>
                                    <div class="alert alert-info d-flex align-items-center" role="alert">
                                        <i class="bi bi-info-circle me-2"></i>
                                        <strong>Note:</strong> This section is specifically for multiple-choice questions.
                                    </div>
                                    <div id="multiple-choice-container" class="mt-3"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>

                <footer class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Question</button>
                </footer>
            </section>
        </div>
    </div>
</form>
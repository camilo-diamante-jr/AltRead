<?php foreach ($pretests as $pretest) :  ?>
    <form id="editPretestSubmitForm">
        <div class="modal" id="editPretestModal_<?= $pretest['pretest_id'] ?>">
            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pretest</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="pretest_id" value="<?= $pretest['pretest_id'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Question</label>
                            <textarea name="edit_question" class="form-control" required><?= htmlspecialchars($pretest['question']) ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="edit_pretest_type" class="form-select" required>
                                <option value="Reading" <?= $pretest['pretest_type'] == 'Reading' ? 'selected' : '' ?>>Reading</option>
                                <option value="Writing" <?= $pretest['pretest_type'] == 'Writing' ? 'selected' : '' ?>>Writing</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Main Context</label>
                            <textarea name="edit_context" class="form-control"><?= htmlspecialchars($pretest['context'] ?? '') ?></textarea>
                        </div>

                        <!-- Choice Inputs -->
                        <div class="mb-3">
                            <label class="form-label">Choices</label>
                            <div class="row g-3">
                                <?php foreach (['A', 'B', 'C', 'D'] as $letter) :
                                    $choiceKey = 'choice_' . strtolower($letter);
                                    $choiceValue = $pretest[$choiceKey] ?? '';
                                    $isImage = is_image($choiceValue);
                                ?>
                                    <div class="col-md-6">
                                        <div class="p-6">
                                            <label class="form-label d-block text-center fw-bold p-2 text-primary">
                                                <u> Choice <?= $letter ?></u>
                                            </label>

                                            <?php if ($isImage) : ?>
                                                <div class="text-center mb-2">
                                                    <img src="../files/uploads/pretest_choices/<?= htmlspecialchars($choiceValue) ?>" alt="Choice <?= $letter ?>" class="img-thumbnail" style="max-width: 150px;">
                                                </div>
                                            <?php endif; ?>

                                            <input type="<?= $isImage ? 'file' : 'text' ?>" name="edit_<?= $choiceKey ?>" class="form-control"
                                                <?= !$isImage ? 'value="' . htmlspecialchars($choiceValue) . '"' : 'accept="image/*"' ?>>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correct Answer</label>
                            <select name="correct_answer" class="form-select" required>
                                <?php foreach (['A', 'B', 'C', 'D'] as $letter) : ?>
                                    <option value="<?= $letter ?>" <?= $pretest['correct_answer'] == $letter ? 'selected' : '' ?>><?= $letter ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php endforeach; ?>
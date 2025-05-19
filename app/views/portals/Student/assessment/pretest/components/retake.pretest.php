<section id="retakeSection" class="d-none">
    <!-- General Directions Card -->
    <div id="generalDirectionsUpdateCard" class="card border-0 shadow-sm bg-light p-4 mb-4">
        <h5 class="card-title fw-bold text-primary mb-3">General Directions:</h5>
        <p class="card-text">
            <?= $directions['pretestDirections'] ?>
        </p>

        <div class="text-center mt-3">
            <button type="button" id="startUpBtn" class="btn btn-primary btn-lg px-5">Start Pretest</button>
        </div>
    </div>

    <!-- Pre-Assessment Card -->
    <div id="preAssessmentUpdateCard" class="d-none">
        <div id="countdownTimer" class="alert alert-info text-center fw-bold mb-4" style="font-size: 1.5rem;">
            00:00:00
        </div>

        <form id="preAssessmentUpdateForm" method="POST">
            <?php foreach ($pre_assessments as $index => $pretest): ?>
                <div class="pretest-question card shadow-sm p-4 mb-3 d-none" data-question-id="<?= $pretest['pretest_id']; ?>">

                    <input type="hidden" class="learnerID" name="learner_id" value="<?= $data['learnerID'] ?>">
                    <input type="hidden" id="pretestID_<?= $index; ?>" name="pretest_id[<?= $pretest['pretest_id']; ?>]"
                        value="<?= $pretest['pretest_id']; ?>">
                    <input type="text" class="<?= $pretest['correct_answer'] ?>">

                    <!-- Directions based on question type (Reading/Writing) -->
                    <?php if ($pretest['pretest_type'] === "Reading"): ?>
                        <div class="text-primary mb-4 border-bottom pb-3">
                            <h5 class="fw-bold">Part I: Reading</h5>
                            <p class="mb-0"><strong>Directions:</strong>
                                <span><?= htmlspecialchars("For reading questions, select the most appropriate answer based on the text provided."); ?></span>
                            </p>
                        </div>

                    <?php elseif ($pretest['pretest_type'] === "Writing"): ?>
                        <div class="text-primary mb-4 border-bottom pb-3">
                            <h5 class="fw-bold">Part II: Writing</h5>
                            <p class="mb-0"><strong>Directions:</strong>
                                <span><?= htmlspecialchars("For writing questions, write your answer in the provided text box."); ?></span>
                            </p>
                        </div>
                    <?php endif; ?>

                    <h6 class="fw-bold mb-4"><?= $index + 1; ?>. <?= htmlspecialchars($pretest['question']); ?></h6>

                    <?php if (!empty($pretest['context'])): ?>
                        <div class="border mb-3 border-1 p-3 bg-light">
                            <!-- Main Context if Any -->
                            <?= htmlspecialchars($pretest['context']); ?>

                            <!-- Sub Context if Any -->
                            <section class="mt-3">
                                <p><?= !empty($pretest['first_sub_context']) ? htmlspecialchars($pretest['first_sub_context']) : ''; ?></p>

                                <p><?= !empty($pretest['second_sub_context']) ? htmlspecialchars($pretest['second_sub_context']) : ''; ?></p>

                                <p><?= !empty($pretest['third_sub_context']) ? htmlspecialchars($pretest['third_sub_context']) : ''; ?></p>

                                <p><?= !empty($pretest['fourth_sub_context']) ? htmlspecialchars($pretest['fourth_sub_context']) : ''; ?></p>
                            </section>
                        </div>
                    <?php endif; ?>

                    <div class="choices">
                        <!-- If pretest type is equal to Reading load this -->
                        <?php if ($pretest['pretest_type'] === "Reading"): ?>
                            <?php foreach (['a', 'b', 'c', 'd'] as $choice): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="pretest_answer[<?= $pretest['pretest_id']; ?>]"
                                        value="<?= strtoupper($choice); ?>" id="choice_<?= $pretest['pretest_id']; ?>_<?= $choice; ?>"
                                        required>
                                    <label class="form-check-label choice-content"
                                        for="choice_<?= $pretest['pretest_id']; ?>_<?= $choice; ?>"
                                        data-content="<?= htmlspecialchars($pretest["choice_$choice"]); ?>">
                                        <?= htmlspecialchars($pretest["choice_$choice"]); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>

                        <!-- If pretest type is equal to Writing load this -->
                        <?php if ($pretest['pretest_type'] === "Writing"): ?>
                            <textarea class="form-control" name="pretest_answer[<?= $pretest['pretest_id']; ?>]"
                                required></textarea>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Buttons to take action -->
            <div class="navigation-buttons d-flex justify-content-between mt-4">
                <button type="button" id="prevBtn" class="btn btn-secondary px-4 d-none">Previous</button>
                <button type="button" id="nextBtn" class="btn btn-primary px-4">Next</button>
                <button type="submit" id="submitBtn" class="btn btn-success px-4 d-none">Submit</button>
            </div>
        </form>
    </div>
</section>
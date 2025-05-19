<?php if (empty($data['pre_assessments'])): ?>
    <div class="alert alert-warning text-center mt-4" role="alert">
        <strong>Sorry!</strong> No pretest found.
    </div>
<?php else:

    $success = !empty($data['submitted_pretest']);

    $directions = [
        "pretestDirections" => "You have 30 minutes to complete the pretest. The test will automatically submit when the time expires. Answer each question carefully, and ensure you review your answers if time permits. Good luck!"
    ];

    $totalScore = $data['pretest_total_score'];
    $perfectScore = $data['perfectScore'];
    $passingScore = $data['passingScore'];

    // Calculate the percentage score
    $percentage = ($totalScore / $perfectScore) * 100;
?>

    <?php if ($success): ?>
        <div class="mt-4">
            <div class="progress rounded-pill">
                <div class="progress-bar <?php echo ($percentage >= $passingScore) ? 'bg-primary' : 'bg-danger'; ?>"
                    role="progressbar"
                    style="width: <?= $percentage ?>%;"
                    aria-valuenow="<?= $percentage ?>"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    <?= round($percentage, 2) ?>%
                </div>
            </div>
        </div>

        <?php if ($totalScore >= $passingScore): ?>
            <!-- Passed Message -->
            <div id="submissionSuccessMessage" class="alert alert-success mt-4" role="alert">
                <h4 class="alert-heading">Congratulations! You Passed 🎉</h4>
                <p>Great job! You scored <strong><?= $totalScore ?></strong> out of <strong><?= $perfectScore ?></strong>.</p>
                <p>Click <a href="nextlevel.php" class="alert-link text-decoration-underline">here</a> to proceed to the next level.</p>
            </div>
        <?php else: ?>
            <!-- Failed Message -->
            <div id="submissionFailedMessage" class="alert alert-warning mt-4" role="alert">
                <h4 class="alert-heading">Don't Give Up! 🚀</h4>
                <p>You scored <strong><?= $totalScore ?></strong> out of <strong><?= $perfectScore ?></strong>. Keep practicing!</p>

                <?php if ($percentage >= 40): ?>
                    <p>You're improving! Review your mistakes and try again.</p>
                <?php else: ?>
                    <p>Consider reviewing the study material before retaking the test.</p>
                <?php endif; ?>

                <hr class="border-black">
                <div class="text-center mt-3">
                    <button type="button" id="retakeButton" class="btn btn-secondary rounded-pill px-5">Retake Pretest</button>
                </div>
            </div>
            <?php require_once 'components/retake.pretest.php'; ?>
        <?php endif; ?>
    <?php else: ?>
        <!-- Show the take pretest section only if the user hasn't taken the test yet -->
        <?php require_once 'components/take.pretest.php'; ?>
    <?php endif; ?>

<?php endif; ?>
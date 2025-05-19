<section>
    <div class="d-flex align-items-center justify-content-between container mb-3">
        <h5>Question Details</h5>
        <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#insertNewQuestionModal">
            <i class="fa fa-plus"></i>
            <span>Add New</span>
        </button>
    </div>
    <div class="table-responsive">
        <table id="questionsTable" class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Modules</th>
                    <th>Lessons</th>
                    <th>Parts</th>
                    <th>Question Text</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($questions)) : ?>
                    <?php foreach ($questions as $index => $question) : ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($question['module_name']); ?></td>
                            <td><?= htmlspecialchars($question['lesson_name']); ?></td>
                            <td><?= htmlspecialchars($question['part_name']); ?></td>
                            <td><?= htmlspecialchars($question['question_text'] ?? "Not Applicable"); ?></td>
                            <td>
                                <a href="#" class="text-primary view-question" data-id="<?= $question['question_id'] ?>" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="#" class="text-warning edit-question" data-id="<?= $question['question_id'] ?>" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="text-center">No questions available.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</section>
<?php
include "components/questionModal.php";
?>
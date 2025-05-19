<div
    class="modal"
    id="lessonModal"
    tabindex="-1"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true">
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
        role="document">
        <div class="modal-content">
            <form id="lessonSubmitForm" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold  text-center" id="modalTitleId">
                        Create New Lesson
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="alert lessonAlert d-none" role="alert">
                        <p class="mb-0 alertMsg"></p>
                    </div>

                    <div class="mb-3">
                        <label for="moduleID" class="form-label">Select Module</label>
                        <select name="moduleID" id="moduleID" class="form-select" required>
                            <option value="">-- Select Module --</option>
                            <?php foreach ($modules as $module) : ?>
                                <option value="<?= htmlspecialchars($module['module_id']) ?>">
                                    <?= htmlspecialchars($module['module_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lessonName" class="form-label">Lessons</label>
                        <select name="lessonName" id="lessonName" class="form-select" required>
                            <option value="">-- Select Lesson --</option>
                            <?php
                            $lessonOptions = ['Lesson 1', 'Lesson 2', 'Lesson 3', 'Lesson 4'];
                            foreach ($lessonOptions as $lesson) : ?>
                                <option value="<?= htmlspecialchars($lesson) ?>">
                                    <?= htmlspecialchars($lesson) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="lessonDescription" class="form-label">Lesson Description</label>
                        <textarea name="lessonDescription" id="lessonDescription" class="form-control" rows="3" required></textarea>
                    </div>
                </div>
                <footer class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm" id="lessonSubmitBtn">Save</button>
                    <button type="reset" class="btn btn-secondary btn-sm lessonCloseBtn" data-bs-dismiss="modal"> Exit </button>
                </footer>
            </form>
        </div>
    </div>
</div>


<!-- Update modal -->
<?php foreach ($lessons as $lesson) : ?>
    <div class="modal fade" id="updateLessonModal_<?= $lesson['lesson_id'] ?>" tabindex="-1" aria-labelledby="updateLessonLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateLessonLabel">Update Lesson</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="updateLessonForm">
                        <input type="hidden" id="editModuleID" class="editModuleID" value="<?= $lesson['module_id'] ?>" />
                        <div class=" mb-3">
                            <label for="editModuleID" class="form-label">Module</label>
                            <select id="editModuleID" class="editModuleID form-control">
                                <?php foreach ($modules as $module) : ?>
                                    <option value="<?= $module['module_id'] ?>"><?= $module['module_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Lesson options -->
                        <div class="mb-3">
                            <label for="editLessonName" class="form-label">Lesson Name</label>
                            <select id="editLessonName" class="editLessonName form-select" required>
                                <option value="">-- Select Lesson --</option>
                                <?php
                                $lessonOptions = ['Lesson 1', 'Lesson 2', 'Lesson 3'];
                                foreach ($lessonOptions as $lessonOption) :
                                    $selected = ($lesson['lesson_name'] == $lessonOption) ? 'selected' : '';
                                ?>
                                    <option value="<?= htmlspecialchars($lessonOption) ?>" <?= $selected ?>>
                                        <?= htmlspecialchars($lessonOption) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="editLessonDescription" class="form-label">Lesson Description</label>
                            <textarea id="editLessonDescription" class="editLessonDescription form-control" required><?= $lesson['lesson_description'] ?></textarea>
                        </div>
                        <button type="button" class="btn btn-primary"
                            id="saveLessonChanges"
                            data-lesson-id="<?= $lesson['lesson_id'] ?>"
                            data-module-id="<?= $lesson['module_id'] ?>">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
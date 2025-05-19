<div class="d-flex align-items-center mt-3 justify-content-end">
    <button type="button" class="btn me-2 btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#lessonModal">
        <i class="bi bi-plus"></i>
        <span>Add new lesson</span>
    </button>

    <!-- <button type="button" class="btn btn-sm btn-success rounded-0">
        <i class="bi bi-download"></i>
        <span>Export lessons</span>
    </button> -->
</div>

<table id="lessonTable" class="table table-bordered">
    <thead>
        <tr>
            <th>Modules</th>
            <th>Lessons</th>
            <th>Descriptions</th>
            <th>Actions</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($lessons as $lesson) : ?>
            <tr>
                <td style="width:15%"><?= $lesson['module_name'] ?></td>
                <td><?= $lesson['lesson_name'] ?></td>
                <td><?= $lesson['lesson_description'] ?></td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-warning editLessonBtn"
                            data-bs-toggle="modal"
                            data-bs-target="#updateLessonModal_<?= $lesson['lesson_id'] ?>">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger removeLessonBtn" data-lesson-id="<?= $lesson['lesson_id'] ?>">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach;
        include 'components/lessonModal.php';
        ?>
    </tbody>
</table>
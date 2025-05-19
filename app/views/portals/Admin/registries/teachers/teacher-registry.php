<?php
$this->renderView('portals/Admin/partials/admin-header', $data);
?>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Teachers</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Teachers</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2 justify-content-end container">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-0 mb-3" data-bs-toggle="modal" data-bs-target="#addNewTeacherModal">
                            <i class="bi bi-person-fill-add"></i> <span>Insert</span>
                        </button>

                        <button type="button" id="exportTeachers" class="btn btn-outline-secondary btn-sm rounded-0 mb-3">
                            <i class="bi bi-download"></i> <span>Export</span>
                        </button>
                    </div>

                    <?php include 'modals.php'; ?>

                    <div class="table-responsive">
                        <table id="teachersTable" class="table table-sm table-bordered table-striped" data-teacher-id="<?= $teacher['teacher_id'] ?>">
                            <thead class="table-light">
                                <tr>
                                    <th>No.</th>
                                    <th>Fullname</th>
                                    <th>Address</th>
                                    <th>Position</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($teachers as $index => $teacher) :
                                    $fullname = htmlspecialchars(trim("{$teacher['last_name']}, {$teacher['first_name']} {$teacher['middle_name']}"));
                                ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td><?= $fullname ?></td>
                                        <td><?= $teacher['address']; ?></td>
                                        <td><?= htmlspecialchars($teacher['position']) ?></td>
                                        <td class="text-center">
                                            <a href="#teacherModal" class="text-warning update-teacher-btn" data-teacher-id="<?= $teacher['teacher_id'] ?>" data-bs-toggle="modal" data-bs-target="#teacherModal">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <a href="#delete-teacher" class="text-danger delete-teacher" data-teacher-id="<?= $teacher['teacher_id'] ?>">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
$this->renderView('portals/Admin/partials/admin-footer');
?>
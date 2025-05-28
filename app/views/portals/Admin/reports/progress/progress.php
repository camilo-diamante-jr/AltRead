<?php $this->renderView("./portals/Admin/partials/admin-header", $data); ?>

<main class="app-main mt-3">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= htmlspecialchars($data['breadcrumb_title']) ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="#"><?= htmlspecialchars($data['breadcrumb_go_back_home_text']) ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= htmlspecialchars($data['breadcrumb_current_link_text']) ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-main-content">
        <div class="container-fluid">
            <div id="progressCard" class="card shadow-sm">
                <div class="card-body">
                    <div class="row mb-2 position-relative">
                        <div class="col-md-6 mb-2">
                            <input type="text" class="form-control" placeholder="Enter a student name here..." id="searchStudentInput">
                            <div class="student-list position-absolute bg-white border"></div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select name="" id="moduleSelect" class="form-select">
                                    <option value="">Select a module</option>
                                    <?php foreach ($data['modules'] as $module): ?>
                                        <option value="<?= htmlspecialchars($module['module_id']) ?>">
                                            <?= htmlspecialchars($module['module_name'] . ": " . $module['module_description']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary" id="filterBtn">Filter</button>
                            </div>
                        </div>
                    </div>

                    <div class="card p-4 mb-3">
                        <p class="d-flex align-items-center mb-0 gap-2">
                            <label for="">Name:</label>
                            <input type="text" class="form-control shadow-0 border-0" id="studentName" readonly>
                        </p>
                    </div>

                    <div class="table-responsive pb-0">
                        <table id="progressTable" class="table table-bordered text-center table-striped shadow-sm">
                            <thead class="table-success">
                                <tr class="align-middle">
                                    <th rowspan="2">LESSONS</th>
                                    <th colspan="4">SECTIONS</th>
                                    <th rowspan="2">AVERAGE</th>
                                    <th rowspan="2">REMARKS</th>
                                </tr>
                                <tr>
                                    <th>S1</th>
                                    <th>S2</th>
                                    <th>S3</th>
                                    <th>S4</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    <p class="fst-italic mt-0">
                        <small><span>Note:</span> Please select a student to view their progress in the modules. You can also search for a student by name or filter by module to see their progress in that specific module.</small>
                    </p>
                </div>

                <footer class="card-footer">
                    <div class="text-center">
                        <button type="button" class="print-btn btn btn-outline-success btn-sm">
                            <i class="fa fa-print" aria-hidden="true"></i> Print Report
                        </button>
                    </div>
                </footer>
            </div>
        </div>
    </div>
</main>

<?php $this->renderView('./portals/Admin/partials/admin-footer'); ?>


<script>
    $(document).ready(function() {
        const searchInput = $('#searchStudentInput');
        const studentSuggestionList = $('.student-list');


        searchInput.on('input', function() {
            const inputValue = $(this).val().trim();
            if (inputValue.length > 0) {
                $.ajax({
                    url: '/admin/search-students',
                    method: 'GET',
                    data: {
                        student_name: inputValue
                    },
                    success: function(response) {
                        studentSuggestionList.empty();
                        if (response.success && response.data.length > 0) {
                            response.data.forEach(student => {
                                studentSuggestionList.append(`<div class="student-item" data-id="${student.id}">${student.name}</div>`);
                            });
                        } else {
                            studentSuggestionList.append('<div class="no-results">No students found</div>');
                        }
                    }
                });
            } else {
                studentSuggestionList.empty();
            }



        });

    });
</script>
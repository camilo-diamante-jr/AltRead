<?php $this->renderView('./pages/Admin/partials/admin-header', $data); ?>

<!-- Main Content -->
<main class="app-main mt-5">
    <section class="app-main-content">
        <div class="container px-3">
            <article class="row align-items-center mb-3">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= htmlspecialchars($data['breadcrumb_title']) ?></h3>
                </div>
                <div class="col-sm-6 text-sm-end">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item">
                            <a href="#"> <?= htmlspecialchars($data['breadcrumb_go_back_home_text']) ?> </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= htmlspecialchars($data['breadcrumb_current_link_text']) ?>
                        </li>
                    </ol>
                </div>
            </article>

            <div>
                <label for="filter">Filters</label>
                <select id="filter" class="form-select">
                    <option value="pretest">Pretest</option>
                    <option value="modules">Modules</option>
                    <option value="lessons">Lessons</option>
                    <option value="parts">Parts</option>
                    <option value="questions">Questions</option>
                </select>
            </div>

            <div class="card p-4 shadow-sm mt-5">

                <!-- Move Select All Checkbox Outside -->
                <div class="mb-3">
                    <label class="checkbox">
                        <input type="checkbox" id="checkAll"> Select All
                    </label>
                </div>

                <div id="archiveTables" class="filteredTables">
                    <div id="pretestTable" class="archive-table">
                        <?php include_once 'tables/assessments/pretest-archive-table.php'; ?>
                    </div>
                    <div id="modulesTable" class="archive-table">
                        <?php include_once 'tables/contents/module-archive-table.php'; ?>
                    </div>
                    <div id="lessonsTable" class="archive-table">
                        <?php include_once 'tables/contents/lesson-archive-table.php'; ?>
                    </div>
                    <div id="partsTable" class="archive-table">
                        <?php include_once 'tables/contents/part-archive-table.php'; ?>
                    </div>
                    <div id="questionsTable" class="archive-table">
                        <?php include_once 'tables/contents/question-archive-table.php'; ?>
                    </div>
                </div>


                <div class="mt-4">
                    <div class="mt-4">
                        <button id="restoreArchiveButton" type="button" class="btn btn-sm btn-success rounded-0">
                            <i class="fa fa-refresh"></i> Restore
                        </button>
                        <button id="deleteArchiveButton" type="button" class="btn btn-sm btn-danger rounded-0">
                            <i class="fa fa-trash"></i> Delete Permanently
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </section>
</main>

<?php $this->renderView('./pages/Admin/partials/admin-footer'); ?>

<script>
    $(document).ready(function() {
        function showSelectedTable() {
            let selectedFilter = $('#filter').val(); // Get selected filter
            $('.archive-table').hide(); // Hide all tables

            // Show the table corresponding to the selected filter
            switch (selectedFilter) {
                case 'pretest':
                    $('#pretestTable').show();
                    break;
                case 'modules':
                    $('#modulesTable').show();
                    break;
                case 'lessons':
                    $('#lessonsTable').show();
                    break;
                case 'parts':
                    $('#partsTable').show();
                    break;
                case 'questions':
                    $('#questionsTable').show();
                    break;
                default:
                    $('.archive-table').hide(); // Hide all if no match
            }
        }

        // Run function on page load (to set the correct table initially)
        showSelectedTable();

        // Update displayed table on filter change
        $('#filter').on('change', function() {
            showSelectedTable();
        });
        $('#archiveTables .table').DataTable({
            paging: true,
            columnDefs: [{
                orderable: false,
                targets: [2] // Disable sorting for the checkbox column
            }]
        });

        function getSelectedIDs() {
            return $('.row-checkbox:checked').map(function() {
                return $(this).val();
            }).get();
        }

        function showAlert(message) {
            alert(message);
        }

        // Restore Button Click Event
        $('#restoreArchiveButton').on("click", function() {
            let selectedIDs = getSelectedIDs();
            let selectedFilter = $('#filter').val(); // Get selected filter

            if (selectedIDs.length > 0) {
                $.ajax({
                    url: "/restore", // Update with correct backend URL
                    type: "POST",
                    data: {
                        filterDB: selectedFilter,
                        selectedIDs: selectedIDs
                    },
                    success: function(response) {
                        let data = JSON.parse(response);
                        showAlert(data.message);
                        if (data.success) {
                            location.reload();
                        }
                    }
                });
            } else {
                showAlert("No items selected for restoration.");
            }
        });

        // Delete Button Click Event
        $('#deleteArchiveButton').on("click", function() {
            let selectedIDs = getSelectedIDs();
            let selectedFilter = $('#filter').val();

            if (selectedIDs.length > 0) {
                if (confirm("Are you sure you want to delete these items permanently?")) {
                    $.ajax({
                        url: "your_delete_endpoint.php", // Update with correct backend URL
                        type: "POST",
                        data: {
                            filterDB: selectedFilter,
                            selectedIDs: selectedIDs
                        },
                        success: function(response) {
                            let data = JSON.parse(response);
                            showAlert(data.message);
                            if (data.success) {
                                location.reload();
                            }
                        }
                    });
                }
            } else {
                showAlert("No items selected for deletion.");
            }
        });

        // Handle "Select All" Checkbox
        $('#checkAll').on('change', function() {
            $('.row-checkbox').prop('checked', $(this).prop('checked'));
        });

        $('.row-checkbox').on('change', function() {
            let totalCheckboxes = $('.row-checkbox').length;
            let checkedCheckboxes = $('.row-checkbox:checked').length;
            $('#checkAll').prop('checked', checkedCheckboxes === totalCheckboxes);
        });
    });
</script>
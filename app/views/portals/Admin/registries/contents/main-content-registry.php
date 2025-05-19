<?php $this->renderView('./portals/Admin/partials/admin-header', $data); ?>

<main class="app-main">
    <header class="app-content-header">
        <section class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h5 class="mb-0"><?= $breadcrumb_title ?></h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= $breadcrumb_title ?>
                        </li>
                    </ol>
                </div>
            </div>
        </section>
    </header>

    <section class="app-content">
        <div id="mainContentRegistry" class="container-fluid">

            <div class="mt-3">

                <div class="card card-primary card-outline">
                    <header class="card-header py-0 pt-3">
                        <div class="">
                            <ul class="nav nav-underline" id="contentsTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2 active" data-bs-toggle="tab" data-bs-target="#modules" role="tab">Modules</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#lessons" role="tab">Lessons</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#parts" role="tab">Parts</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#questions" role="tab">Questions</button>
                                </li>
                                <!-- <li class="nav-item" role="presentation">
                                    <button class="nav-link py-2" data-bs-toggle="tab" data-bs-target="#choices" role="tab">Choices</button>
                                </li> -->
                            </ul>
                        </div>
                    </header>
                    <div class="card-body">

                        <div class="tab-content" id="contentsContent">
                            <article class="tab-pane fade show active" id="modules" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'modules/module-registry.php' ?>
                                </div>
                            </article>
                            <article class="tab-pane fade" id="lessons" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'lessons/lesson-registry.php' ?>
                                </div>
                            </article>
                            <article class="tab-pane fade" id="parts" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'parts/part-registry.php' ?>
                                </div>
                            </article>
                            <article class="tab-pane fade" id="questions" role="tabpanel">
                                <div class="table-responsive">
                                    <?php include 'questions/questions-registry.php' ?>
                                </div>
                            </article>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</main>

<?php $this->renderView('./portals/Admin/partials/admin-footer'); ?>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $("#partsTable").DataTable({
            "paging": true,
            "searching": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [2]
            }] // Disable sorting on the actions column
        });

        // Add More Parts functionality
        $('#addMoreParts').click(function() {
            var newInputField = `
            <div class="mb-3">
                <label for="partName" class="form-label">Part Name</label>
                 <div class="input-group">
                    <input type="text" class="form-control partName" required>
                    <button type="button" class="btn btn-danger btn-sm removePart">Remove</button>
                </div>
            </div>
        `;
            $('#addPartsContainer').append(newInputField);
        });

        // Remove a dynamically added part input field
        $('#addPartsContainer').on('click', '.removePart', function() {
            $(this).closest('.mb-3').remove();
        });

        // Handle Add Parts form submission
        $('#addPartForm').submit(function(e) {
            e.preventDefault();

            var partNames = [];
            $('.partName').each(function() {
                partNames.push($(this).val());
            });

            // Perform your add parts logic (e.g., send data to the server)
            // Assuming success in adding parts
            partNames.forEach(function(name) {
                table.row.add([
                    table.rows().count() + 1, // Auto-incremented index
                    name, // Part name
                    '<button class="btn btn-sm edit btn-warning"><i class="fa fa-pencil"></i></button>' +
                    '<button class="btn btn-sm delete btn-danger"><i class="fa fa-trash"></i></button>'
                ]).draw();
            });

            // Close the modal after adding parts
            $('#addPartsModal').modal('hide');
            Swal.fire('Success!', 'Parts have been added successfully.', 'success');
        });

        // Handle delete action for parts
        $('#partsTable').on('click', '.delete', function() {
            var row = $(this).closest('tr');
            table.row(row).remove().draw();
            Swal.fire('Deleted!', 'The part has been deleted.', 'success');
        });

        // Handle edit action for parts
        $('#partsTable').on('click', '.edit', function() {
            var partId = $(this).data('part-id');
            var partName = $(this).data('part-name');

            $('#editPartName').val(partName);
            $('#editPartId').val(partId);
            $('#editPartsModal').modal('show');
        });

        // Handle Edit Parts form submission
        $('#editPartForm').submit(function(e) {
            e.preventDefault();
            var partId = $('#editPartId').val();
            var partName = $('#editPartName').val();

            // Update the table with the new part name
            var row = table.row().data();
            row[1] = partName; // Update the part name
            table.row(row).invalidate().draw();

            $('#editPartsModal').modal('hide');
            Swal.fire('Updated!', 'Part has been updated successfully.', 'success');
        });
    });
</script>
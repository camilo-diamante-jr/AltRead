<?php $this->renderView('./portals/Admin/partials/admin-header', $data); ?>

<main class="app-main mt-5">
    <!-- Page Header -->
    <header class="app-content-header mb-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="fw-bold mb-0">Submissions</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Submission</li>
                    </ol>
                </nav>
            </div>
        </div>
    </header>

    <!-- Filter Form -->
    <section class="app-main-content mb-4">
        <div class="container-fluid">
            <div class="table-responsive">

                <table id="submissionTable" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Student Name</th>
                            <th>Total Submissions</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($submissions as $index => $submission) :

                            $learnerId = $submission['learner_id'];
                            $middleName = $submission['middle_name'];
                            $middleInitial = $middleName[0];
                            $completeName =  $submission['first_name'] . " " . $middleInitial . ". " . " " . $submission['last_name'];

                        ?>

                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $completeName ?></td>
                                <td><?= $submission['submission_count'] ?></td>
                                <td>
                                    <button type="button" class="btn view-submissions-btn btn-primary btn-sm" data-learner-id="<?= $learnerId ?>">view submission</button>
                                </td>
                            </tr>


                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </section>


</main>

<?php $this->renderView('./portals/Admin/partials/admin-footer'); ?>


<script>
    $(document).ready(function() {
        $("#submissionTable").DataTable();

        $(".view-submissions-btn").on("click", function() {
            const learnerId = $(this).data("learner-id");

            $.ajax({
                url: "/show/submissions-by-learner-id",
                type: "POST",
                data: {
                    learner_id: learnerId
                },
                dataType: "json",
                success: function(response) {

                    if (response.success) {
                        Swal.fire({
                            title: 'Submissions Retrieved!',
                            text: response.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Submissions !',
                            text: response.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }


                    console.log(response);
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while retrieving submissions.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });

                    console.error('AJAX error:', status, error);
                }
            });
        });
    });
</script>
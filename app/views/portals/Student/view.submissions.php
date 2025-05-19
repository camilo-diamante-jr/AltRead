<?php
// Render the header view
$this->renderView('./pages/Student/partials/header-student', $data);

// Example student info (you can replace these with real PHP variables)
$studentName = $student['full_name'] ?? 'John Doe';
$overallScore = $student['overall_score'] ?? '8/10';
$remarks = $student['remarks'] ?? 'Great job!';
?>

<main class="app-main mt-5">
    <!-- Page Header -->
    <header class="app-content-header py-3">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 text-primary">
                        <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= htmlspecialchars($page_title, ENT_QUOTES, 'UTF-8') ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </header>

    <!-- Student Submission Card -->
    <section class="app-content py-4">
        <div class="container">
            <!-- Pretest Table -->
            <div class="card shadow-sm rounded-4">
                <div class="card-header">
                    <h4 class="card-title">
                        <strong>
                            <i class="fa fa-table"></i>
                            Pretest table
                        </strong>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                         <div class="row">
                                <div class="col-md-3">
                                    <p>Name: <span class="text-decoration-underline">Eden Mae P. Cordero</span></p>
                                </div>
                                <div class="col-md-3">
                                    <p>Gender: <span class="text-decoration-underline">Female</span></p>
                                </div>
                                <div class="col-md-3">
                                    <p>Overall scores:</p>
                                </div>
                                <div class="col-md-3">
                                    <p>Remarks:</p>
                                </div>
                            </div>
                    </div>
                    <div class="table-responsive">
                        <?php include_once 'submissions/pretest/submitted-pretest.php' ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
// Render the footer view
$this->renderView('pages/Student/partials/footer-student');
?>

<!-- DataTables with Actions column not sortable -->
<script>
    $(document).ready(function() {
        $("#pretestSubmittedTable").DataTable({
            columnDefs: [{
                orderable: false,
                targets: 4
            }]
        });
    });
</script>
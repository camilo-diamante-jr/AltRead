<?php
/* Render Admin Header */
$this->renderView('./portals/Admin/partials/admin-header', $data);

include 'components/modals/publishNewMaterialModal.php';
include 'components/modals/editMaterialModal.php';

?>

<main class="app-main">
    <!-- Begin App Content Header -->
    <div class="app-content-header">
        <!-- Begin Container -->
        <div class="container-fluid">
            <!-- Begin Row -->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Materials</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Materials</li>
                    </ol>
                </div>
            </div>
            <!-- End Row -->
        </div>
        <!-- End Container -->
    </div>
    <!-- End App Content Header -->

    <!-- Begin App Content -->
    <div class="app-content">
        <!-- Begin Container -->
        <div class="container-fluid">


            <?php include 'components/tables/activeTable.php';                ?>


        </div>
        <!-- End Container -->
    </div>
    <!-- End App Content -->
</main>

<script>
    // Add any necessary scripts here.
</script>

<?php
/* Render Admin Footer */
$this->renderView('./portals/Admin/partials/admin-footer');
?>
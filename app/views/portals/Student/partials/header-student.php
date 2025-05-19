<?php

checkSession("Learner");

?>
<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $page_title; ?></title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="ALS v4 | Dashboard">
    <meta name="author" content="BSIT 4">
    <meta name="description" content="Reading App">
    <meta name="keywords" content="Alternative learning system, Intervention, Reading comprehenssion, Progress">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="../css/import.styles.css?v=<?= time(); ?>" />
    <link rel="stylesheet" href="../css/overlayscrollbars.min.css" />

    <!-- START: This external javascripts  is strickly prohibited to remove or moved in any placement. -->
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/OwlCarousel2-2.3.4/js/owl.carousel.min.js"></script>
    <script src="../assets/swal2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script src="../js/preloader.js?v=<?php echo time(); ?>"></script>
    <script src="../js/jquery.fancybox.min.js"></script>
    <!-- END 😊 -->

</head>

<body class="layout-fixed sidebar-mini sidebar-expand-lg bg-body-tertiary">
    <?php
    $this->renderView("/preloader");
    ?>

    <div class="app-wrapper">
        <?php
        require_once 'components/navbar.php';
        require_once 'components/sidebar.php';
        ?>
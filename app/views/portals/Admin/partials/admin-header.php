<?php



checkSession("Admin");


$fullname = $_SESSION['username'];
$brandText = "Admin Portal";




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title><?= $data['page_title'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content=" Admin | Portal ">

    <link rel="stylesheet" href="/css/import.styles.css" />
    <link rel="stylesheet" href="/css/overlayscrollbars.min.css" />
    <link rel="stylesheet" href="/css/buttons.dataTables.css" />




    <script src="/assets/jquery/jquery.min.js"></script>
    <script src="/js/jquery.fancybox.min.js"></script>

</head>

<body class="sidebar-expand-lg sidebar-mini bg-body-tertiary">
    <!-- Preloader -->
    <?php
    // $this->renderView('/preloader');
    ?>
    <div class="app-wrapper">


        <?php
        require_once 'components/navbar.php';
        require_once 'admin-sidebar.php'
        ?>
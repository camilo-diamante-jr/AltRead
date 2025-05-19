<?php

checkSession("Teacher");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>AltRead</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="AdminLTE v4 | Dashboard">
    <meta name="author" content="ColorlibHQ">
    <link rel="icon" type="image/png" href="/assets/images/logo/AR_LOGO400x200_2.png">

    <link rel="stylesheet" href="/css/import.styles.css" />
    <link rel="stylesheet" href="/css/overlayscrollbars.min.css" />


    <script src="/assets/jquery/jquery.min.js"></script>
    <script src="/assets/DataTables/node_modules/datatables.net/js/dataTables.min.js"></script>
    <script src="/assets/DataTables/node_modules/datatables.net-searchbuilder/js/dataTables.searchBuilder.min.js"></script>
    <script src="/assets/DataTables/node_modules/datatables.net-bs5/js/dataTables.bootstrap5.js"></script>
    <script src="/assets/swal2/node_modules/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <script type="module" src="/js/main-modules.js" defer></script>

    <script src="/js/jquery.fancybox.min.js"></script>


</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <?php
    include_once '../app/views/preloader.php'
    ?>

    <div class="app-wrapper">
        <?php
        require_once('components/navbar.php');
        require_once('teachers-sidebar.php');
        ?>
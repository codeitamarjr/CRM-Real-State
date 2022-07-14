<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}


// Load configs and functions
require "features/functions_user.php";
require "features/functions_messages.php";
require "features/functions_property.php";

//set the variable GLOBAL agent_prs_code
$agent_prs_code = $_SESSION["agent_prs_code"];

//It'll set the main property_code to the session if it's not set
if (!isset($_SESSION["property_code"])) {
    $_SESSION["property_code"] = userProperty($agent_prs_code);
}

//Get the access page
if (!isset($_GET['access'])) {
    //do nothing
} else
    //carryon the page to access
    $content =   $_GET['access'];

//to pass to child pages
if (!isset($_GET['page'])) {
    $page =  $_GET['page'];
}
if (!$_GET['message_id']) {
    $message_id = $_GET['message_id'];
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?php if (isset($_GET['access'])) echo (ucfirst($_GET['access']));
            else echo 'Dashboard'; ?> | <?php echo getPropertyData($_SESSION["property_code"], 'property_name'); ?> - Real Enquiries</title>
    <meta name="description" content="Customer Relationship Management for Real State Agents">
    <link rel="icon" type="image/x-icon" href="assets/img/fav_logo_size_invert.jpg">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=093230e10e41709a7a3d6ba7f3b3b116">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="assets/js/bs-init.js?h=e2b0d57f2c4a9b0d13919304f87f79ae"></script>
    <script src="assets/js/theme.js?h=79f403485707cf2617c5bc5a2d386bb0"></script>
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Menu Start -->
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0">
                    <div class="sidebar-brand-icon"><i class="far fa-building"></i></div>
                    <div class="sidebar-brand-text mx-3"><span><?php echo $agent_prs_code; ?></span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link <?php if ($content == null) {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php"><i class="fas fa-tachometer-alt" style="font-size: 20px;"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'enquiries') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=enquiries"><i class="fa fa-list" style="font-size: 20px;"></i><span>Enquiries</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'applications') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=applications"><i class="fa fa-address-card" style="font-size: 20px;"></i><span>Applications</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'tenantsView') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=tenantsView"><i class="fa fa-list" style="font-size: 20px;"></i><span>Tenants</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'unitsView') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=unitsView"><i class="fa fa-building-o" style="font-size: 20px;"></i><span>Units</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'report') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=report"><i class="fa fa-file-excel-o" style="font-size: 20px;"></i><span>Reports</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'automail') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=automail"><i class="icon ion-email" style="font-size: 20px;"></i><span>Templates</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'calendly') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=calendly"><i class="fa fa-calendar" style="font-size: 20px;"></i><span>Calendly</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($content == 'RTB') {
                                                                echo 'active';
                                                            } ?>" href="dashboard.php?access=RTB"><img src="/assets/img/RTB-Logo.png" class="img-fluid img-thumbnail" alt="RTB" width="22px"><span> RTB</span></a></li>
                </ul>
            </div>
        </nav>
        <!-- Menu End -->
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">

                <!-- Nav Bar Starts -->
                <?php require "features/nav_bar.php"; ?>
                <!-- Nav Bar ends-->
                <!-- User Finish Start-->

                <!-- Content Start-->
                <?php
                if (empty($content)) {
                    include "features/section.cards.php";
                } else {
                    include "features/$content.php";
                }
                ?>
                <!-- Content End-->
            </div>

        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>

    </div>
    <footer class="sticky-footer">
        <div class="container my-auto">
            <div class="text-center my-auto copyright"><span>Copyright © Real Enquiries 2022 | Designed by <a href="https://www.itjunior.dev/" target="_blank">Itamar Junior</a></span></div>
        </div>
    </footer>
</body>

</html>
<style>
    .alert {
        width: fit-content;
    }

    /* print styles */
    @media print {

        body {
            margin: 0;
            color: #000;
            background-color: #fff;
        }

        .sidebar-dark {
            display: none;
        }
    }
</style>
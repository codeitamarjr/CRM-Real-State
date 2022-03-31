<?php

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: index.php");
    exit;
}

// Load configs and functions
require "config/config.php";
require "features/functions_user.php";
require "features/functions_enquiries.php";
require "features/functions_messages.php";
$agent_prs_code = $_SESSION["agent_prs_code"];

//Get a property_code that the users manage for the Dashboard
$_SESSION["property_code"] = userProperty($agent_prs_code);

//Get the access page
if (!isset($_GET['access'])) {
    //do nothing
} else
    //carryon the page to access
    $content =   $_GET['access'];
//to pass to child pages
$page =   $_GET['page'];
$message_id = $_GET['message_id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Dashboard - Real Enquiries</title>
    <meta name="description" content="Customer Relationship Management for Real State Agents">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css?h=093230e10e41709a7a3d6ba7f3b3b116">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome5-overrides.min.css?h=37efe7e508357f382d0a5b2b73cd47ee">
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Menu Start -->
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon"><i class="far fa-building"></i></div>
                    <div class="sidebar-brand-text mx-3"><span><?php echo $agent_prs_code; ?></span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link active" href="dashboardv2.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                    <li class="nav-item"><a class="nav-link" href="dashboardv2.php?access=enquiries"><i class="fas fa-table"></i><span>Enquiries</span></a>
                        <a class="nav-link" href="dashboardv2.php?access=report"><i class="far fa-file-excel"></i><span>Reports</span></a>
                        <a class="nav-link" href="dashboardv2.php?access=automail"><i class="icon ion-email"></i><span>Automail</span></a>
                        <a class="nav-link" href="dashboardv2.php?access=calendly"><i class="fa fa-calendar"></i><span>Calendly</span></a>
                    </li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <!-- Menu End -->
        <!-- User Start -->
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">

                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                        <!-- Search Bar -->
                        <form method="GET" class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search" id="search_form">
                            <input type="hidden" name="access" value="search">
                            <div class="input-group">
                                <input class="bg-light form-control border-0 small" name="search" type="text" placeholder="Search for . . . ">
                                <button class="btn btn-primary py-0" type="submit" form="search_form" value="Submit" name="submit-search"><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                        <!-- Search Bar Ends -->
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="badge bg-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                        <h6 class="dropdown-header">alerts center</h6>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 12, 2019</span>
                                                <p>A new monthly report is ready to download!</p>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 7, 2019</span>
                                                <p>$290.29 has been deposited into your account!</p>
                                            </div>
                                        </a>
                                        <a class="dropdown-item d-flex align-items-center" href="#">
                                            <div class="me-3">
                                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 2, 2019</span>
                                                <p>Spending Alert: We've noticed unusually high spending for your account.
                                                </p>
                                            </div>
                                        </a><a class="dropdown-item text-center small text-gray-500" href="#">Show All
                                            Alerts</a>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item dropdown no-arrow mx-1">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown">
                                        <span class="badge bg-danger badge-counter"><?php echo messagesNotification(60) ?></span><i class="fas fa-envelope fa-fw"></i></a>

                                </div>
                                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
                            </li>
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><span class="d-none d-lg-inline me-2 text-gray-600 small">
                                            <?php echo userGetData($_SESSION["username"], 'agent_name'); ?>
                                        </span><img class="border rounded-circle img-profile" src="<?php echo htmlentities(userGetData($_SESSION["username"], 'agent_pic')); ?>"></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="dashboardv2.php?access=profile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                                        <a class="dropdown-item" href="dashboardv2.php?access=system_settings"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a>
                                        <a class="dropdown-item" href="dashboardv2.php?access=changelog"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Change log</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
                <!-- User Finish Start-->

                <!-- Content Start-->
                <?php
                if (empty($content)) {
                    include "features/cards.php";
                }
                if ($content == 'enquiries') {
                    include "features/enquiries.php";
                }
                if ($content == 'changelog') {
                    include "features/changelog.php";
                }
                if ($content == 'message') {
                    include "features/message.php";
                }
                if ($content == 'details') {
                    include "features/details.php";
                }
                if ($content == 'report') {
                    include "features/report.php";
                }
                if ($content == 'automail') {
                    include "features/automail.php";
                }
                if ($content == 'prospect_details') {
                    include "features/prospect_details.php";
                }
                if ($content == 'profile') {
                    include "features/profile.php";
                }
                if ($content == 'search') {
                    include "features/search.php";
                }
                if ($content == 'calendly') {
                    include "features/calendly.php";
                }
                if ($content == 'system_settings') {
                    include "features/system_settings.php";
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
    <script src="assets/js/bs-init.js?h=e2b0d57f2c4a9b0d13919304f87f79ae"></script>
    <script src="assets/js/theme.js?h=79f403485707cf2617c5bc5a2d386bb0"></script>
    <!-- New emails feature starts -->
    <object type="text/html" data="features/getting_email.php" width="1px" height="1px"></object>
    <!-- New emails feature end -->

</body>

</html>
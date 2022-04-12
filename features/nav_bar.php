<nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
    <div class="container-fluid">
        <!-- Search Bar -->
        <button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
        <form method="GET" class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search" id="search_form">
            <input type="hidden" name="access" value="search">
            <div class="input-group">
                <input class="bg-light form-control border-0 small" name="search" type="text" placeholder="Search for . . . ">
                <button class="btn btn-primary py-0" type="submit" form="search_form" value="Submit" name="submit-search"><i class="fas fa-search"></i></button>
            </div>
        </form>
        <!-- Search Bar Ends -->

        <ul class="navbar-nav flex-nowrap ms-auto">
            <!-- Property Selector Starts -->
            <li class="nav-item dropdown no-arrow">
                <div class="nav-item dropdown no-arrow">
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                        <span class="d-none d-lg-inline me-2 text-gray-600 small">
                            <form method="POST">
                                <select class="form-select" name="select_property">
                                    <option selected><?php echo getPropertyData($_SESSION["property_code"], 'property_name'); ?></option>
                                    <?php
                                    //List all the properties from an agent
                                    $query = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
                                    $result = mysqli_query($link, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        echo '<option value='.$row['property_code'];
                                        echo '>';
                                        echo $row['property_name'];
                                        echo '</option>';
                                    }
                                    ?>
                                </select>
                            </form>
                        </span>
                    </a>
                </div>
            </li>
            <!-- Property Selector Ends -->
            <div class="d-none d-sm-block topbar-divider"></div>
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
                        </span><img class="border rounded-circle img-profile" src="features/uploads/<?php echo htmlentities(userGetData($_SESSION["username"], 'agent_pic')); ?>"></a>
                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="dashboardv2.php?access=profile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a>
                        <a class="dropdown-item" href="dashboardv2.php?access=property"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Property Settings</a>
                        <a class="dropdown-item" href="dashboardv2.php?access=system_settings"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;System Settings</a>
                        <a class="dropdown-item" href="dashboardv2.php?access=changelog"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Change log</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
<script>
    //auto send form using Jquery
    $("form").on('change', function() {
        $("form").trigger('submit');
    });
</script>
<nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
    <div class="container-fluid">

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
                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false">
                        <span class="badge bg-danger badge-counter"><?php echo messagesNotification(60) ?></span><i class="fas fa-envelope fa-fw"></i></a>
                </div>
                <div class="shadow dropdown-list dropdown-menu dropdown-menu-end" aria-labelledby="alertsDropdown"></div>
            </li>
            <div class="d-none d-sm-block topbar-divider"></div>
            <li class="nav-item dropdown no-arrow">
                <div class="nav-item dropdown no-arrow">
                    <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                        <span class="d-none d-lg-inline me-2 text-gray-600 small">
                            <?php echo userGetData($_SESSION["username"], 'agent_name'); ?> | <?php echo getUserACL(userGetData($_SESSION["username"], 'userACLGroupID'), 'groupName'); ?>
                        </span>
                        <?php if (userGetData($_SESSION["username"], 'agent_pic') == null) { ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person-circle img-profile" viewBox="0 0 16 16">
                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                            </svg>
                        <?php } else { ?>
                            <img class="border rounded-circle img-profile" src="features/uploads/<?php echo userGetData($_SESSION["username"], 'agent_pic'); ?>">
                        <?php } ?>
                    </a>
                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in">
                        <a class="dropdown-item" href="dashboard.php?access=profile"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Agent</a>
                        <?php if (userACL('prsSettings') > 0) { ?>
                            <a class="dropdown-item" href="dashboard.php?access=prsSettings"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;PRS Settings</a>
                        <?php }
                        if (userACL('manage_property_add') > 0) { ?>
                            <a class="dropdown-item" href="dashboard.php?access=manage_property_add"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Create Property</a>
                        <?php }
                        if (userACL('manage_property') > 0) { ?>
                            <a class="dropdown-item" href="dashboard.php?access=manage_property"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Property Settings</a>
                        <?php }
                        if (userACL('fetchingEmail.php') > 0) { ?>
                            <a class="dropdown-item" href="/features/fetchingEmail.php" target="_blank"><i class="fas fa-file-import fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Fetching Emails</a>
                        <?php }
                        if (userACL('system_settings') > 0) { ?>
                            <a class="dropdown-item" href="dashboard.php?access=system_settings"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;System Settings</a>
                        <?php } 
                        if (userACL('userACL') > 0) { ?>
                            <a class="dropdown-item" href="dashboard.php?access=userACL"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;User Access Control</a>
                        <?php } ?>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
<?php
// Load functions
require_once "features/functions_tenant.php";
require_once "features/functions_profile.php";
require_once "features/functions_unit.php";
require_once "features/functions_property.php";
require "features/functions_billings.php";

// Define tenantID
$tenantsCod = $_GET['tenantsCod'];

// Define page content
if (isset($_GET['pageContent'])) {
    $pageContent = $_GET['pageContent'];
} else {
    $pageContent = 'applicationsDetail';
}
$tenantsDetails = true;
$profileID = getProfile('profileID', getTenantData($tenantsCod, 'tenantscod', 'profileID'), 'profileID');

if ($_POST['cancelMovein'] != null) {
    deleteTenant($_POST['cancelMovein']);
}


?>
<div class="container-fluid">
    <div class="profile-header">
        <div class="profile-header-cover"></div>
        <div class="profile-header-content">
            <div class="profile-header-img mb-4">
                <img src="assets/img/avatars/user_blank.png" class="mb-4" alt="Tenant img" width="100%" />
            </div>
            <div class="profile-header-info">
                <h4 class="m-t-sm"><?php echo getProfile('profileID', getTenantData($tenantsCod, 'tenantscod', 'profileID'), 'firstName') . ' '
                                        . getProfile('profileID', getTenantData($tenantsCod, 'tenantscod', 'profileID'), 'lastName'); ?></h4>
                <p class="m-b-sm"><?php echo getTenantData($tenantsCod, 'tenantscod', 'status'); ?>
                    <br>
                    <?php echo getPropertyData(getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'property_code'), 'property_name') . " | " . getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'unit_number'); ?>
                    <br>
                    CRM#: <?php echo getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'idunit'); ?> | Custom Code: <?php echo getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'unit_customCode'); ?>
                    <br>
                </p>
            </div>
        </div>

        <ul class="profile-header-tab nav nav-tabs">
            <li class="nav-item"><a href="?access=tenantsDetails&tenantsCod=<?php echo $tenantsCod; ?>" class="nav-link <?php if ($_GET['pageContent'] == null) echo 'active'; ?>" data-toggle="tab">Profile</a></li>
            <li class="nav-item"><a href="?access=tenantsDetails&tenantsCod=<?php echo $tenantsCod; ?>&pageContent=tenantsRentDetails" class="nav-link <?php if ($_GET['pageContent'] == 'tenantsRentDetails') echo 'active'; ?>" data-toggle="tab">Rent Details</a></li>
            <li class="nav-item"><a href="?access=tenantsDetails&tenantsCod=<?php echo $tenantsCod; ?>&pageContent=tenantsBillings" class="nav-link <?php if ($_GET['pageContent'] == 'tenantsBillings') echo 'active'; ?>" data-toggle="tab">Billings</a></li>
            <li class="nav-item"><a href="?access=tenantView&pageContent=rtb_detail&tenantscod=" class="nav-link <?php if ($_GET['pageContent'] == 'rtb_detail') echo 'active'; ?>" data-toggle="tab">RTB</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" data-bs-toggle="modal" data-bs-target="#cancelMovein">Cancel Move-in</a></li>
        </ul>
    </div>
</div>

<?php
include_once "features/" . $pageContent . ".php";
?>


<!-- Modal Cancel Movein -->
<div class="modal fade" id="cancelMovein" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Cancel Movein</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure do you want to cancel the move-in for this applicant?
                </p>
                <div class="alert alert-warning" role="alert">
                    This will cancel the movein date and this action cannot be undone!<br>
                    The first rent and deposit will be excluded from this tenant.
                </div>
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <button type="submit" class="btn btn-primary" name="cancelMovein" value="<?php echo $tenantsCod; ?>">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    .profile-header {
        position: relative;
        overflow: hidden;
    }

    .profile-header .profile-header-cover {
        background: url(assets/img/lissete-laverde-hha7-lfXZe0-unsplash.jpeg) center no-repeat;
        background-size: 100% auto;
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
    }

    .profile-header .profile-header-cover:before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, rgba(0, 0, 0, 0.25) 0, #4e73df 100%);
    }

    .profile-header .profile-header-content,
    .profile-header .profile-header-tab,
    .profile-header-img,
    body .fc-icon {
        position: relative;
    }

    .profile-header .profile-header-tab {
        /* background: #fff; */
        list-style-type: none;
        margin: -1.25rem 0 0;
        padding: 0 0 0 8.75rem;
        border-bottom: 1px solid #c8c7cc;
        white-space: nowrap;
    }

    .profile-header .profile-header-tab>li {
        display: inline-block;
        margin: 0;
    }

    .profile-header .profile-header-tab>li>a {
        display: block;
        color: #000;
        line-height: 1.25rem;
        padding: 0.625rem 1.25rem;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.75rem;
        border: none;
        color: white;
    }

    .profile-header .profile-header-tab>li>a:hover,
    .profile-header .profile-header-tab>li>a:focus {
        background: white;
        color: #007aff;
    }

    .profile-header .profile-header-tab>li.active>a,
    .profile-header .profile-header-tab>li>a.active {
        color: #007aff;
    }

    .profile-header .profile-header-content:after,
    .profile-header .profile-header-content:before {
        content: "";
        display: table;
        clear: both;
    }

    .profile-header .profile-header-content {
        color: #fff;
        padding: 1.25rem;
    }

    .profile-header-img {
        float: left;
        width: 7.5rem;
        height: 7.5rem;
        overflow: hidden;
        z-index: 10;
        margin: 0 1.25rem -1.25rem 0;
        padding: 0.1875rem;
        -webkit-border-radius: 0.25rem;
        -moz-border-radius: 0.25rem;
        border-radius: 0.25rem;
        background: #fff;
    }

    .profile-header-info h4 {
        font-weight: 500;
        margin-bottom: 0.3125rem;
    }
</style>
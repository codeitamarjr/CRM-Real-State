<?php
require "features/functions_prospect.php";
require "features/functions_tenant.php";
//This pages required tenantscod and hash
$hash = $_GET['hash'];
$tenantscod = $_GET['tenantscod'];
if($_POST['action'] == true){
    //Update the unit table with null in tenant_id
    require "features/functions_unit.php";
    $idunit = getUnit($_GET['tenantscod'],'tenant_id','idunit');
    setUnit($idunit, 'tenant_id', '00');

    //Delete from the tenant table
    deleteTenant($_POST['tenantscod']);
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
                <h4 class="m-t-sm"><?php echo getProspectData($hash, 'prospect_full_name'); ?></h4>
                <p class="m-b-sm"><?php echo getPropertyData(getTenantData($_GET['tenantscod'], 'tenantscod', 'property_code'), 'property_name'); ?>
                    <br>
                    CRM#: <?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'idunit'); ?>
                </p>
            </div>
        </div>

        <ul class="profile-header-tab nav nav-tabs">
            <li class="nav-item"><a href="?access=tenantView&content=prospect_details&tenantscod=<?php echo $tenantscod ?>&hash=<?php echo $hash ?>" class="nav-link <?php if ($_GET['content'] == 'prospect_details') echo 'active'; ?>" data-toggle="tab">Profile</a></li>
            <li class="nav-item"><a href="?access=tenantView&content=rent_details&tenantscod=<?php echo $tenantscod ?>&hash=<?php echo $hash ?>" class="nav-link <?php if ($_GET['content'] == 'rent_details') echo 'active'; ?>" data-toggle="tab">Rent Details</a></li>
            <li class="nav-item"><a href="?access=tenantView&content=rtb_detail&tenantscod=<?php echo $tenantscod ?>&hash=<?php echo $hash ?>" class="nav-link <?php if ($_GET['content'] == 'rtb_detail') echo 'active'; ?>" data-toggle="tab">RTB</a></li>
            <li class="nav-item"><a href="?access=tenantView&content=billings&tenantscod=<?php echo $tenantscod ?>&hash=<?php echo $hash ?>" class="nav-link <?php if ($_GET['content'] == 'billings') echo 'active'; ?>" data-toggle="tab">Billings</a></li>
            <li class="nav-item"><a class="nav-link" data-toggle="tab" data-bs-toggle="modal" data-bs-target="#tenantAction">Cancel Move-in</a></li>

        </ul>
    </div>
    <div class="content">
        <p>
            <?php
            $content = $_GET['content'];
            if (!empty($content)) {
                include "features/$content.php";
            }
            ?>
        </p>
    </div>
</div>

<!-- Action Modal -->
<div class="modal fade" id="tenantAction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cancel Move-in</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                This action can not be undone. Are you sure you want to cancel the move-in?
                <p>All the bills will be cancelled and the tenant will be removed from the property.</p>
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <input type="hidden" name="tenantscod" value="<?php echo $tenantscod; ?>">
                <button type="submit" class="btn btn-primary" name="action" value="true">&nbsp;Cancel Move-in</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
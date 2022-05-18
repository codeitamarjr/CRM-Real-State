<?php
require "features/functions_prospect.php";
require "features/functions_tenant.php";
//This pages required tenantscod and hash
$hash = $_GET['hash'];
$tenantscod = $_GET['tenantscod'];


?>
<div class="container-fluid">
    <div class="profile-header">
        <div class="profile-header-cover"></div>
        <div class="profile-header-content">
            <div class="profile-header-img mb-4">
                <img src="assets/img/avatars/user_blank.png" class="mb-4" alt="Tenant img" width="100%" />
            </div>

            <div class="profile-header-info">
                <h4 class="m-t-sm"><?php echo getProspectData($hash,'prospect_full_name'); ?></h4>
                <p class="m-b-sm"><?php echo getPropertyData(getTenantData($_GET['tenantscod'],'tenantscod','property_code'),'property_name'); ?>
                <br>
                Unit: <?php echo getTenantData($_GET['tenantscod'],'tenantscod','unit_rented_code'); ?></p>
            </div>
        </div>

        <ul class="profile-header-tab nav nav-tabs">
            <li class="nav-item"><a href="?access=tenantView&content=prospect_details&tenantscod=<?php echo $tenantscod ?>&hash=<?php echo $hash?>" class="nav-link <?php if ($_GET['content'] == 'prospect_details') echo 'active'; ?>" data-toggle="tab">Profile</a></li>
            <li class="nav-item"><a href="#profile-about" class="nav-link" data-toggle="tab">Rent Details</a></li>
            <li class="nav-item"><a href="#profile-about" class="nav-link" data-toggle="tab">RTB</a></li>
            <li class="nav-item"><a href="?access=tenantView&content=billings&tenantscod=<?php echo $tenantscod ?>&hash=<?php echo $hash?>" class="nav-link <?php if ($_GET['content'] == 'billings') echo 'active'; ?>" data-toggle="tab">Billings</a></li>
            <li class="nav-item"><a href="#profile-friends" class="nav-link" data-toggle="tab">Documents</a></li>
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
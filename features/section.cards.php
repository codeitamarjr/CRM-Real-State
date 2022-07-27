<?php
require_once "features/functions_unit.php";
require_once "features/functions_tenant.php";
$property_codeNavSelector = $_SESSION["property_code"];
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js" integrity="sha512-QSkVNOCYLtj73J4hbmVoOV6KVZuMluZlioC+trLpewV8qMjsWqlIQvkn1KGX2StWvPMdWGBqim1xlC8krl1EKQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<div class="container-fluid">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0">Dashboard</h3>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow border-start-info py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Property Selector</span></div>
                            <div class="col-auto">
                                <div class="text-dark fw-bold text-xs mb-1"><span><?php require "nav_bar_selector_property.php"; ?></span></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-building-o fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-primary py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Total
                                    Enquiries</span></div>
                            <div class="text-dark fw-bold h5 mb-0"><span>
                                    <?php echo totalMesssages($_SESSION["agent_prs_code"], "AND property_code = $property_codeNavSelector"); ?>
                                </span></div>
                        </div>
                        <div class="col-auto"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" fill="currentColor" viewBox="0 0 16 16" class="bi bi-mailbox fa-2x text-gray-300">
                                <path d="M4 4a3 3 0 0 0-3 3v6h6V7a3 3 0 0 0-3-3zm0-1h8a4 4 0 0 1 4 4v6a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V7a4 4 0 0 1 4-4zm2.646 1A3.99 3.99 0 0 1 8 7v6h7V7a3 3 0 0 0-3-3H6.646z"></path>
                                <path d="M11.793 8.5H9v-1h5a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.354-.146l-.853-.854zM5 7c0 .552-.448 0-1 0s-1 .552-1 0a1 1 0 0 1 2 0z"></path>
                            </svg></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-info py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-info fw-bold text-xs mb-1"><span>On
                                    Queue</span></div>
                            <div class="row g-0 align-items-center">
                                <div class="col-auto">
                                    <div class="text-dark fw-bold h5 mb-0 me-3"><span>
                                            <?php echo totalMesssages($_SESSION["agent_prs_code"], "AND status = 'Queue' AND property_code = $property_codeNavSelector"); ?>
                                        </span></div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg-info" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo (totalMesssages($_SESSION["agent_prs_code"], 'AND status = \'Queue\'') / totalMesssages($_SESSION["agent_prs_code"], '')) * 100; ?>%;">
                                            <span class="visually-hidden">50%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-success py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                <span>Approved</span>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0"><span>
                                    <?php echo totalApplications($_SESSION["property_code"], "AND status = 'Approved'"); ?>
                                </span></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card shadow border-start-warning py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                <span>Denied</span>
                            </div>
                            <div class="text-dark fw-bold h5 mb-0"><span>
                                    <?php echo totalApplications($_SESSION["property_code"], "AND status = 'Denied'"); ?>
                                </span></div>
                        </div>
                        <div class="col-auto"><i class="fas fa-exclamation-circle fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-2">
                    <h6 class="text-primary fw-bold m-0">Occupancy</h6>
                </div>
                <div class="card-body">
                    <?php
                    //List all the properties from an agent
                    require 'config/config.php';
                    $select = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code' ORDER BY property_name ASC";
                    $result = mysqli_query($link, $select);
                    while ($row = mysqli_fetch_array($result)) {
                        $totalAvaiable = mysqli_num_rows(mysqli_query($link, "SELECT * FROM tenant WHERE propertyCode = " . $row['property_code'] . ""));
                    ?>
                        <h4 class="small fw-bold"><?php echo $row['property_name']; ?><span class="float-end">Unit(s):<?php echo totalUnits($row['property_code'], '') ?> | Rented <?php echo $totalAvaiable ?> | Occupancy <?php echo round($totalAvaiable / (totalUnits($row['property_code'], '')) * 100, 0) ?>%</span></h4>
                        <div class="progress mb-4">
                            <div class="progress-bar bg-primary" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $totalAvaiable / (totalUnits($row['property_code'], '')) * 100 ?>%;"></div>
                        </div>
                    <?php
                    }
                    mysqli_close($link);
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
        <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                    <span>Tenants</span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0"><span>
                                        <?php echo totalTenants($_SESSION["property_code"], "AND status = 'Tenant'") ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-building fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                                <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                    <span>Future</span>
                                </div>
                                <div class="text-dark fw-bold h5 mb-0"><span>
                                    <?php echo totalTenants($_SESSION["property_code"], "AND status = 'Future'") ?>
                                    </span>
                                </div>
                            </div>
                            <div class="col-auto"><i class="fas fa-building fa-2x text-gray-300"></i></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="text-primary fw-bold m-0"><?php echo getPropertyData($_SESSION["property_code"], 'property_name'); ?></h6>
                    <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                        <div class="dropdown-menu shadow dropdown-menu-end animated--fade-in">
                            <p class="text-center dropdown-header">dropdown header:</p><a class="dropdown-item" href="#">&nbsp;Action</a><a class="dropdown-item" href="#">&nbsp;Another action</a>
                            <div class="dropdown-divider"></div><a class="dropdown-item" href="#">&nbsp;Something else here</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas data-bss-chart="{&quot;type&quot;:&quot;doughnut&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Rented&quot;,&quot;Future&quot;,&quot;Notice&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[&quot;#4e73df&quot;,&quot;#1cc88a&quot;,&quot;#36b9cc&quot;],&quot;borderColor&quot;:[&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;],&quot;data&quot;:[&quot;<?php echo totalTenants($_SESSION["property_code"], "AND status = 'Tenant'") ?>&quot;,&quot;<?php echo totalTenants($_SESSION["property_code"], "AND status = 'Future'") ?>&quot;,&quot;<?php echo totalTenants($_SESSION["property_code"], "AND status = 'Notice'") ?>&quot;]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false,&quot;labels&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}},&quot;title&quot;:{&quot;fontStyle&quot;:&quot;normal&quot;}}}"></canvas>
                    </div>
                    <div class="text-center small mt-4">
                        <span class="me-2">
                            <i class="fas fa-circle text-primary"></i>&nbsp;Rented</span><span class="me-2"><i class="fas fa-circle text-success"></i>&nbsp;Future</span><span class="me-2"><i class="fas fa-circle text-info"></i>&nbsp;Notice</span>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
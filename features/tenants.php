<?php
// Include config file
require "config/config.php";
require "features/functions_prospect.php";
//Get property code definied at the start of the login SESSION
$property_code = $_SESSION["property_code"];

//Define max of results per page 
if (!isset($_GET['show'])) {
    $results_per_page = 15;
} else {
    $results_per_page = $_GET['show'];
}

//Select all data from tenant table
$query = "SELECT * FROM tenant";
$result = mysqli_query($link, $query);

//find the total number of results
$number_of_result = mysqli_num_rows($result);

//total number of pages in total
$number_of_page = ceil($number_of_result / $results_per_page);

//which page number visitor is currently on  
if (!isset($_GET['page'])) {
    $page = 1;
} else {
    $page = $_GET['page'];
}

//determine the sql LIMIT starting number for the results on the displaying page  
$page_first_result = ($page - 1) * $results_per_page;

$query = "SELECT * FROM tenant ORDER BY tenantscod DESC LIMIT " . $page_first_result . ',' . $results_per_page;
$result = mysqli_query($link, $query);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Tenants
            </p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap">
                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;
                            <select class="d-inline-block form-select form-select-sm" onchange="javascript:handleSelect(this)">
                                <option value="&show=10" selected=""><?php echo $results_per_page; ?> </option>
                                <option value="&show=25">25</option>
                                <option value="&show=50">50</option>
                                <option value="&show=100">100</option>
                            </select>&nbsp;</label></div>
                </div>
                <div class="col-md-6">
                </div>
            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Lease starts</th>
                            <th>Tenant</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($result)) {
                            $tenantscod = $row['tenantscod'];
                            echo "<tr class=\"showsRow\" onclick=\"location.href='?access=tenantView&content=prospect_details&tenantscod=".$tenantscod ."&hash=".getProspectData2($row['prospect_id'], 'prospect_id', 'hash')."'\">
    <td>" . htmlspecialchars(getPropertyData($row['property_code'], 'property_name')) . "</td>
    <td>" . htmlspecialchars(date('Y-m-d', strtotime($row['lease_starts']))) . "</td>
    <td>" . htmlspecialchars(getProspectData2($row['prospect_id'], 'prospect_id', 'prospect_full_name')) . "</td>
    <td>" . htmlspecialchars($row['status']) . "</td>
    </tr>";
                        } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Property</th>
                            <th>Lease starts</th>
                            <th>Tenant</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>
            </div>




            <div class="row">

                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing <?php echo $page_first_result + 1; ?> to <?php echo ($page_first_result + $results_per_page); ?> of <?php echo totalMesssages($_SESSION["property_code"], ''); ?></p>
                </div>

                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <ul class="pagination">
                            <?php
                            //display the link of the pages in URL  
                            for ($page = 1; $page <= $number_of_page;) {
                                echo '<li class="page-item"><a class="page-link" href="?access=tenants&show=' . $results_per_page . '&page=' . $page . '">' . $page . ' </a></li>';
                                $page++;
                            }
                            //Close SQL connection
                            mysqli_close($link);
                            ?>
                        </ul>
                    </nav>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    //Function to handle the select box
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>

<script type="text/javascript">
    function handleSelect(elm) {
        window.location = "?access=tenants&" + elm.value;
    }
</script>

<style>
    tr.showsRow:hover{
  background-color: #4e73df;
  color: white;
  cursor: pointer;
}

</style>
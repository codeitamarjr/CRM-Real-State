<?php
// Include config file
require "config/config.php";
//Get property code definied at the start of the login SESSION
$property_code = $_SESSION["property_code"];

//Define max of results per page 
if (!isset($_GET['show'])) {
    $results_per_page = 10;
} else {
    $results_per_page = $_GET['show'];
}

//select all data from the mail_income sql
$query = "SELECT * FROM messages WHERE property_code = $property_code ";
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



$query = "SELECT * FROM messages WHERE property_code = $property_code ORDER BY message_date DESC LIMIT " . $page_first_result . ',' . $results_per_page;
$result = mysqli_query($link, $query);

?>

<div class="container-fluid">
    <h3 class="text-dark mb-4">Enquiries</h3>
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Inbox of Enquiries</p>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text-nowrap">
                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;
                        <select class="d-inline-block form-select form-select-sm" onchange="javascript:handleSelect(this)">
                                <option value="&show=10" selected=""><?php echo $results_per_page;?> </option>
                                <option value="&show=25">25</option>
                                <option value="&show=50">50</option>
                                <option value="&show=100">100</option>
                        </select>&nbsp;</label></div>
                </div>
                <div class="col-md-6">
                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                </div>
            </div>
            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                <table class="table my-0" id="dataTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Profile</th>
                            <th>Date Received</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php while ($row = mysqli_fetch_array($result)) {
                            $message_id = htmlspecialchars($row['message_id']);

                            echo "<tr>
    <td><a href=\"dashboardv2.php?access=message&message_id=$message_id \">" . htmlspecialchars($row['message_sender_name']) . "</a></td>
    <td><a href=\"dashboardv2.php?access=message&message_id=$message_id \">" . htmlspecialchars($row['messages_email']) . "</a></td>
    <td>";
                            //Check if the user fillout his data on prospect table, if so shows an clickable link to show his profile
                            $message_hash = $row['message_hash'];
                            $query_prospect = "SELECT * FROM prospect WHERE hash = '$message_hash'";
                            $result_prospect = mysqli_query($link, $query_prospect);
                            while ($row_prospect = mysqli_fetch_array($result_prospect)) {
                                $hash = $row_prospect['hash'];
                                if (!empty($hash)) {
                                    echo '<a href="dashboardv2.php?access=prospect_details&key=' . $hash . '"><img class="rounded-circle me-2" width="30" height="30" src="assets/img/profile.svg"></a>';
                                }
                            };

echo "</td>
    <td>" . htmlspecialchars($row['message_date']) . "</td>
    <td>" . htmlspecialchars($row['status']) . "</td>
</tr>";  //$row['index'] the index here is a field name
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Name</strong></td>
                            <td><strong>Email</strong></td>
                            <td><strong>Profile</strong></td>
                            <td><strong>Date Received</strong></td>
                            <td><strong>Status</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>




            <div class="row">
                <div class="col-md-6 align-self-center">
                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to <?php echo $results_per_page;?> of <?php echo enquiriesTotal($_SESSION["property_code"]); ?></p>
                </div>
                <div class="col-md-6">
                    <nav class="d-lg-flex justify-content-lg-end dataTables_paginate paging_simple_numbers">
                        <ul class="pagination">
                            <?php
                            //display the link of the pages in URL  
                            for ($page = 1; $page <= $number_of_page; ) {
                                echo '<li class="page-item"><a class="page-link" href="dashboardv2.php?access=enquiries&show='.$results_per_page.'&page=' . $page . '">' . $page . ' </a></li>';
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

<script type="text/javascript">
  function handleSelect(elm)
  {
     window.location = "dashboardv2.php?access=enquiries&"+elm.value;
  }
</script>
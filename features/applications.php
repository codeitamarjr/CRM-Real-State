<?php
// Include config file
require "config/config.php";

//Get property code definied at the start of the login SESSION
$property_code = $_SESSION["property_code"];

function getAllIncomes($profileID)
{
    $totalIncome = '0';
    require "config/config.php";
    if ($mainProfileID == null) $mainProfileID = $profileID;
    $query = "SELECT * FROM profile WHERE mainApplicantID = '$mainProfileID'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        $totalIncome += $row['netIncome'] + $row['extraIncome'];
    }
    return $totalIncome;
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.js"></script>


<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Applications
            </p>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table table-striped dt-responsive nowrap w-100" style="width:100%">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>Name</th>
                        <th>Sector</th>
                        <th>Position</th>
                        <th>HHI</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php



                    $query = "SELECT * FROM profile WHERE type = 'M' AND propertyCode = $property_code ORDER BY date DESC";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        $tenantscod = $row['tenantscod'];
                        echo "<tr class=\"showsRow ";
                        if ($row['status'] == "Approved") {
                            echo "table-success";
                        }
                        if ($row['status'] == "Denied") {
                            echo "table-danger";
                        }
                        echo " \" onclick=\"location.href='?access=applicationsDetail&profileID=" . htmlspecialchars($row['profileID']) . "'\" >
    <td>" . htmlspecialchars(getPropertyData($row['propertyCode'], 'property_name')) . "</td>
    <td>" . htmlspecialchars($row['firstName']) . ' ' . htmlspecialchars($row['lastName']) . "</td>
    <td>" . htmlspecialchars($row['employementSector']) . "</td>
    <td>" . htmlspecialchars($row['jobTitle']) . "</td>
    <td>" . htmlspecialchars($row['netIncome'] + $row['extraIncome'] + getAllIncomes($row['profileID'])) . "</td>
    <td>" . htmlspecialchars($row['status']) . "</td>

    </tr>";
                    } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Property</th>
                        <th>Name</th>
                        <th>Sector</th>
                        <th>Position</th>
                        <th>HHI</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    //Format Tables
    $(document).ready(function() {
        $('#dataTable').DataTable({
            stateSave: true,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]

        });
    });
</script>

<style>
    tr.showsRow:hover {
        background-color: #4e73df;
        color: white;
        cursor: pointer;
    }
</style>
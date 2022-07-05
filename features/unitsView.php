<?php
// Include config file
require "config/config.php";
require "features/functions_prospect.php";
require "features/functions_tenant.php";
require "features/functions_profile.php";

$prs_code = $_SESSION["agent_prs_code"];

//Add new unit
if (isset($_POST['addUnit'])) {
    require "features/functions_unit.php";
    createSingleUnit(
        $_SESSION["agent_prs_code"],
        $_POST['property_code_create_unit'],
        $_POST['customCode'],
        $_POST['description'],
        $_POST['floor'],
        $_POST['block'],
        $_POST['unitNumber'],
        $_POST['eirCode'],
        $_POST['bedrooms'],
        $_POST['type'],
        $_POST['dateAvailable'],
        $_POST['statusUnit'],
        $_POST['carParking'],
        $_POST['rent']
    );
    
};

$property_codeUnitView = $_SESSION["property_code"];

$query = "SELECT * FROM unit WHERE property_code = $property_codeUnitView ORDER BY property_code DESC";
$result = mysqli_query($link, $query);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.js"></script>


<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header py-3">
            <p class="text-primary m-0 fw-bold">Units
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newUnit"> + Add New Unit</button>

            </p>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Property</th>
                        <th>CRM#</th>
                        <th>Code</th>
                        <th>Resident</th>
                        <th>Block</th>
                        <th>Unit</th>
                        <th>Floor</th>
                        <th>Bed</th>
                        <th>Type</th>
                        <th>Eircode</th>
                        <th>Address</th>
                        <th>Availability</th>
                        <th>Rent</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) {
                        echo "<tr class=\"showsRow\" \">
    <td>" . htmlspecialchars(getPropertyData($row['property_code'], 'property_name')) . "</td>
    <td>" . htmlspecialchars($row['idunit']) . " </td>
    <td>" . htmlspecialchars($row['unit_customCode']) . " </td>
    <td>" . htmlspecialchars(getProfile('profileID',getTenantData($row['idunit'], 'idunit', 'profileID'),'firstName')) . "</td>
    <td>" . htmlspecialchars($row['unit_block']) . "</td>
    <td>" . htmlspecialchars($row['unit_number']) . "</td>
    <td>" . htmlspecialchars($row['floor']) . "</td>
    <td>" . htmlspecialchars($row['bedrooms']) . "</td>
    <td>" . htmlspecialchars($row['type']) . "</td>
    <td>" . htmlspecialchars($row['postal_code']) . "</td>
    <td>" . htmlspecialchars(getPropertyData($row['property_code'], 'property_address')) . "</td>
    <td>" . htmlspecialchars(date('Y-m-d', strtotime($row['date_available']))) . "</td>
    <td>" . htmlspecialchars($row['rental_price']) . "</td>
    <td class=\"";
                        if (getProfile('profileID',getTenantData($row['idunit'], 'idunit', 'profileID'),'firstName') == null) {
                            echo "text-success";
                        }
                        echo "\">" ;
                        if (getProfile('profileID',getTenantData($row['idunit'], 'idunit', 'profileID'),'firstName') == null) {
                            echo "Available";
                        } else {
                            echo getTenantData($row['idunit'], 'idunit', 'status');
                        }
                        echo "</td></tr>";
                    } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Property</th>
                        <th>CRM#</th>
                        <th>Code</th>
                        <th>Resident</th>
                        <th>Block</th>
                        <th>Unit</th>
                        <th>Floor</th>
                        <th>Bed</th>
                        <th>Type</th>
                        <th>Eircode</th>
                        <th>Address</th>
                        <th>Availability</th>
                        <th>Rent</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
</div>

<!-- New Unit Modal -->
<div class="modal fade" id="newUnit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Unit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <p>
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Property</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <select class="form-select" name="property_code_create_unit">
                                                    <?php
                                                    //List all the properties from an agent
                                                    require 'config/config.php';
                                                    $select = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
                                                    $result = mysqli_query($link, $select);
                                                    while ($row = mysqli_fetch_array($result)) {
                                                        echo '<option value="' . $row['property_code'] . '">' . $row['property_name'] . '</option>';
                                                    }
                                                    mysqli_close($link);
                                                    ?>
                                                </select>
                                            </div>
                                            </p>

                                            <p>
                                            <div class="col-md-2">
                                                <label class="form-label">Label</label>
                                                <input type="text" class="form-control" name="customCode">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Floor</label>
                                                <input class="form-control" list="floorList" placeholder="Type to search..." name="floor">
                                                <datalist id="floorList">
                                                    <option value="1">
                                                    <option value="2">
                                                    <option value="3">
                                                    <option value="4">
                                                    <option value="5">
                                                    <option value="6">
                                                    <option value="7">
                                                    <option value="8">
                                                    <option value="9">
                                                    <option value="10">
                                                    <option value="Basement">
                                                    <option value="Ground Floor">
                                                    <option value="1st Floor Return">
                                                    <option value="2nd Floor Return">
                                                    <option value="3rd Floor Return">
                                                </datalist>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Block</label>
                                                <input type="text" class="form-control" name="block">
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Unit</label>
                                                <input type="number" class="form-control" name="unitNumber">
                                            </div>
                                            <div class="col-md-3">
                                                <label class="form-label">Eircode</label>
                                                <input type="text" class="form-control" name="eirCode">
                                            </div>
                                            </p>

                                            <p>
                                            <div class="col-md-2">
                                                <label class="form-label">Bedrooms</label>
                                                <input type="number" class="form-control" name="bedrooms">
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label">Type</label>
                                                <select class="form-select" name="type">
                                                    <option selected>Choose...</option>
                                                    <option value="1 Bedroom">1 Bedroom</option>
                                                    <option value="2 Bedroom">2 Bedroom</option>
                                                    <option value="3 Bedroom">3 Bedroom</option>
                                                    <option value="Studio">Studio</option>
                                                    <option value="Double Studio">Double Studio</option>
                                                    <option value="1 Double bedroom">1 Double bedroom</option>
                                                    <option value="2 Double bedroom">2 Double bedroom</option>
                                                    <option value="3 Double bedroom">3 Double bedroom</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label">Car Parking</label>
                                                <select class="form-select" name="carParking">
                                                    <option selected>Choose...</option>
                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>
                                                </select>
                                            </div>
                                            <div class="col-md">
                                                <label class="form-label">Date Available</label>
                                                <input type="date" class="form-control" name="dateAvailable">
                                            </div>
                                            </p>
                                            <div class="col-md-6">
                                                <label class="form-label">Status</label>
                                                <select class="form-select" name="statusUnit">
                                                    <option selected>Choose...</option>
                                                    <option value="Available">Available</option>
                                                    <option value="Maintenance">Maintenance</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Rent</label>
                                                <input type="text" data-type="currency" class="form-control" name="rent">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" name="addUnit" value="Add Unit" class="btn btn-primary" value="Insert">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </div>
            </form>
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
                'copy', 'excel', 'pdf', 'print'
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
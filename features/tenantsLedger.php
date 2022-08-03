<?php
// Include config file
require "config/config.php";
require_once "features/functions_tenant.php";
require_once "features/functions_profile.php";
require_once "features/functions_bank.php";

// Insert Bank Transaction
if (isset($_POST['tenantsCode'])) {
    // Set type
    $typeTransaction = ($_POST['typeTransaction'] == 'Credit') ? 1 : -1;
    echo creditBank($_POST['bankSource'], $_POST['propertyCode'], $_POST['tenantsCode'], $_POST['dateTransaction'], $_POST['bankName'], $_POST['description'], $_POST['ammount'] * $typeTransaction, $_POST['notes']);
}
?>
<!-- Datatables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.css" />
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/jszip-2.5.0/dt-1.12.1/b-2.2.3/b-html5-2.2.3/b-print-2.2.3/cr-1.5.6/r-2.3.0/sb-1.3.4/sr-1.1.1/datatables.min.js"></script>

<!-- Top Cards -->
<div class="container-fluid px-4 mt-4">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card shadow border-start-info py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Dank Details</span></div>
                            <div class="text-muted"><?php echo getPropertyDataConditional('property_code', $_SESSION["property_code"], 'property_bank_deposit_BANK'); ?></div>
                            <div class="col-auto">
                                <div class="text-dark fw-bold mb-1"><span><?php echo getPropertyDataConditional('property_code', $_SESSION["property_code"], 'property_bank_deposit_IBAN'); ?></span></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-university fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card shadow border-start-info py-2">
                <div class="card-body">
                    <div class="row align-items-center no-gutters">
                        <div class="col me-2">
                            <div class="text-uppercase text-primary fw-bold text-xs mb-1"><span>Balance</span></div>
                            <div class="text-muted">Balance of the Period</div>
                            <div class="col-auto">
                                <div class="text-dark fw-bold mb-1"><span>€gdfgfd</span></div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-money fa-4x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header ">
            <div class="text-primary fw-bold py-2">Recent Transactions
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTransaction"> + Add New Transaction</button>
            </div>
            <div class="col-sm-9 text-secondary">
               The last 30 transactions of this property.
            </div>
        </div>
        <div class="card-body">
            <table id="dataTable" class="table dt-responsive nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Tenant</th>
                        <th>Description</th>
                        <th>Paid out</th>
                        <th>Paid in</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $propertyCode = $_SESSION["property_code"];
                    $query = "SELECT * FROM bank_deposit WHERE propertyCode = $propertyCode ORDER BY dateTransaction DESC LIMIT 30";
                    $result = mysqli_query($link, $query);
                    while ($row = mysqli_fetch_array($result)) {
                        echo "
                        <tr>
    <td> " . $row['dateTransaction'] . " </td>
    <td> " . htmlspecialchars(getProfile('profileID', getTenantData($row['tenantsCode'], 'tenantscod', 'profileID'), 'firstName')) . " </td>
    <td> " . $row['description'] . " </td>
    <td> ";
                        if ($row['ammount'] < 0) echo '<div class="text-danger">' . $row['ammount'] . '</div>';
                        echo " </td>
    <td> ";
                        if ($row['ammount'] > 0) echo '<div class="text-success">' . $row['ammount'] . '</div>';
                        echo " </td>
    </tr>";
                    } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Date</th>
                        <th>Tenant</th>
                        <th>Description</th>
                        <th>Paid out</th>
                        <th>Paid in</th>
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
            pageLength: 15,
            dom: 'Bfrtip',
            buttons: [
                'copy', 'excel', 'pdf', 'print'
            ]


        });
    });
</script>

<!-- New Transaction Modal -->
<div class="modal fade" id="addTransaction" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <input type="hidden" name="bankSource" value="bank_deposit">
                <input type="hidden" name="propertyCode" value="<?php echo $propertyCode; ?>">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New Transaction</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col">
                            <div class="col-lg">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row mb-3">
                                            <div class="row py-2">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Tenant</h6>
                                                </div>
                                                <div class="col">
                                                    <select class="form-select" name="tenantsCode">
                                                        <?php
                                                        //List all the properties from an agent
                                                        $select = "SELECT * FROM tenant WHERE propertyCode = '$propertyCode'";
                                                        $result = mysqli_query($link, $select);
                                                        while ($row = mysqli_fetch_array($result)) {
                                                            echo '<option value="' . $row['tenantscod'] . '">' . htmlspecialchars(getProfile('profileID', $row['profileID'], 'firstName')) . ' ' . htmlspecialchars(getProfile('profileID', $row['profileID'], 'lastName')) . '</option>';
                                                        }
                                                        mysqli_close($link);
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row py-2">
                                                <div class="col-sm-3">
                                                    <h6 class="mb-0">Date</h6>
                                                </div>
                                                <div class="col-sm-5">
                                                    <input type="date" class="form-control" name="dateTransaction" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select class="form-select" aria-label="Select" name="typeTransaction" required>
                                                        <option value="Debit">Debit</option>
                                                        <option value="Credit">Credit</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Bank Name</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="bankName" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Description</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="text" class="form-control" name="description" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Ammount</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <input type="number" class="form-control" name="ammount" placeholder="000.00" step="any" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Notes</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <textarea class="form-control" name="notes"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary" name="insert" value="insert">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
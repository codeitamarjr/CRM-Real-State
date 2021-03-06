<?php
// Edit option
if (isset($_POST['edit'])) {
    $edit = '';
} else {
    $edit = '-plaintext';
}

// Modal
function modal($messageModal)
{
    echo "<script>
        $(document).ready(function(){
            $(\"#alertModal\").modal('show');
        });
        </script>";
    echo '<!-- Modal Alert -->
        <div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <center>
                       ';
    echo $messageModal;
    echo '
                    </center></div>
                </div>
            </div>
        </div>';
}

if ($_POST['save'] == true) {
    if ($_POST['RTBDateRegistered'] != null) echo modal(setTenantDataSafe('profileID', $profileID, 'RTBDateRegistered', $_POST['RTBDateRegistered']));
    if ($_POST['RTBDateIssued'] != null) echo modal(setTenantDataSafe('profileID', $profileID, 'RTBDateIssued', $_POST['RTBDateIssued']));
    if ($_POST['RTBNumber'] != null) echo modal(setTenantDataSafe('profileID', $profileID, 'RTBNumber', $_POST['RTBNumber']));
}
?>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">RTB Details</div>
                <div class="card-body">
                    <form method="POST">
                        <?php if (getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'tenancyType') == 'Contract') { ; ?>
                        <div class="card-header text-center">
                            <center>
                        <div class="alert alert-warning" role="alert">
                            This unit it's on short Fixed Term Tenancy/Contract  and does not require a RTB. <a href="https://www.rtb.ie/register-a-tenancy/is-your-property-exempt-from-registration" class="alert-link" target="_blank">More Details on RTB.ie</a>
                        </div></center>
                        </div>
                        <?php } else { ; ?>
                        <div class="card-header">RTB Info</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Eir Code</label>
                                <input class="form-control-plaintext" type="text" value="<?php echo getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'postal_code'); ?> ">
                            </div>
                            <div class="col">
                                <label class="small mb-1">Status</label>
                                <select class="form-control<?php echo $edit; ?>" name="RTBStatus">
                                    <option selected><?php echo getTenantData($tenantsCod, 'tenantsCod', 'RTBStatus'); ?></option>
                                    <option value="Pending">Pending</option>
                                    <option value="Paid">Paid</option>
                                    <option value="Letter Received">Letter Received</option>
                                    <option value="Past">Past</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Date Registered</label>
                                <input class="form-control<?php echo $edit; ?>" name="RTBDateRegistered" type="date" value="<?php echo htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'RTBDateRegistered')) ? date('d-m-y', strtotime(htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'RTBDateRegistered')))) : ''; ?>">
                            </div>
                            <div class="col">
                                <label class="small mb-1">Date RTB Issued</label>
                                <input class="form-control<?php echo $edit; ?>" name="RTBDateIssued" type="date" value="<?php echo htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'RTBDateIssued')) ? date('d-m-y', strtotime(htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'RTBDateIssued')))) : ''; ?>">
                            </div>
                            <div class="col">
                                <label class="small mb-1">RTB Number</label>
                                <input class="form-control<?php echo $edit; ?>" name="RTBNumber" type="text" value="<?php echo htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'RTBNumber')); ?>">
                            </div>

                        </div>
                        <br>
                        <br>
                        <?php if (!$_POST['edit'] ?? null) echo '<button class="btn btn-primary" type="submit" name="edit" value="edit">Edit</button>'; ?>
                        <button class="btn btn-success" type="submit" name="eircode" value="<?php echo getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'postal_code'); ?>">Check RTB</button>
                        <?php if ($_POST['edit'] ?? null) echo '<button class="btn btn-primary" type="submit" name="save" value="true">Save</button>'; ?>
                        <?php } ; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (isset($_POST['eircode'])) {
    include 'features/RTB.php';
} ?>
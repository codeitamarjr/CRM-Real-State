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


// Update tenant details
if (isset($_POST['save'])) {
    if ($_POST['status'] != null) echo modal(setTenantDataSafe('profileID',$profileID,'status',$_POST['status']));
    if ($_POST['movein'] != null) echo modal(setTenantDataSafe('profileID',$profileID,'movein',$_POST['movein']));
    if ($_POST['leaseStart'] != null) echo modal(setTenantDataSafe('profileID',$profileID,'leaseStart',$_POST['leaseStart']));
    if ($_POST['leaseTerm'] != null) echo modal(setTenantDataSafe('profileID',$profileID,'leaseTerm',$_POST['leaseTerm']));
    if ($_POST['leaseExpire'] != null) echo modal(setTenantDataSafe('profileID',$profileID,'leaseExpire',$_POST['leaseExpire']));


}

?>
<div class="container-fluid">
    <div class="row">
        <div class="col">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Rent Details</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="card-header">Property Details</div>
                        <div class="mb-3">
                            <label class="small mb-1">Full Addres of the Property</label>
                            <input class="form-control<?php echo $edit; ?>-plaintext" type="text" placeholder="<?php echo getPropertyData(getUnit(getTenantData($tenantsCod, 'tenantscod', 'idunit'), 'idunit', 'property_code'), 'property_address');?>">
                        </div>
                        <br>
                        <div class="card-header">Lease Info</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Status</label>
                                <select class="form-control<?php echo $edit; ?><?php echo $edit; ?>" name="status" >
                                    <option selected><?php echo getTenantData($tenantsCod, 'tenantsCod', 'status'); ?></option>
                                    <option value="Future">Future</option>
                                    <option value="Tenant">Tenant</option>
                                    <option value="Notice">Notice</option>
                                    <option value="Past">Past</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Move-in</label>
                                <input class="form-control<?php echo $edit; ?><?php echo $edit; ?>" name="movein" type="date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'movein')))); ?>" >
                            </div>
                            <div class="col">
                                <label class="small mb-1">Lease Starts</label>
                                <input class="form-control<?php echo $edit; ?><?php echo $edit; ?>" name="leaseStart" type="date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'leaseStart')))); ?>" >
                            </div>
                            <div class="col">
                                <label class="small mb-1">Lease Term</label>
                                <input class="form-control<?php echo $edit; ?><?php echo $edit; ?>" name="leaseTerm" type="text" value="<?php echo getTenantData($tenantsCod, 'tenantsCod', 'leaseTerm'); ?>" >
                            </div>
                            <div class="col">
                                <label class="small mb-1">Lease To</label>
                                <input class="form-control<?php echo $edit; ?><?php echo $edit; ?>" name="leaseExpire" type="date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars(getTenantData($tenantsCod, 'tenantsCod', 'leaseExpire')))); ?>" >
                            </div>
                        </div>

                        <br>
                        <div class="card-header">Financial Details</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Deposit</label>
                                <input class="form-control<?php echo $edit; ?>-plaintext" value="<?php echo getBillByTenant($tenantsCod,'Deposit%','billings_amount') ?>" >
                            </div>
                            <div class="col">
                                <label class="small mb-1">First Rent</label>
                                <input class="form-control<?php echo $edit; ?>-plaintext" value="<?php echo getBillByTenant($tenantsCod,'First Rent%','billings_amount') ?>" >
                            </div>
                            <div class="col">
                                <label class="small mb-1">Rent</label>
                                <input class="form-control<?php echo $edit; ?>-plaintext" name="rent" type="text" value="<?php echo getBillByTenant($tenantsCod,'Rent%','billings_amount') ?>" >
                            </div>
                        </div>

                        <br>
                        <?php if(!$_POST['edit'] ?? null) echo '<button type="submit" class="btn btn-primary float-end" name="edit" value="edit">Edit</button>'; ?>
                        <?php if($_POST['edit'] ?? null) echo '<button type="submit" class="btn btn-primary float-end" name="save" value="update">Update</button>'; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
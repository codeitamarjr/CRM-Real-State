<?php

if($_POST['save'] == true) {
   if(!isset($_POST['tenantscod'])) {
       $status = $_POST['status'];
       require "config/config.php";
       $status = mysqli_real_escape_string($link, $status);
       setTenantDataSafe($_GET['tenantscod'],'status',$status);
   }
}

?>
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Rent Details</div>
                <div class="card-body">
                    <form method="POST" action="?access=tenantView&content=rent_details&editor=true&tenantscod=<?php echo $tenantscod; ?>&hash=<?php echo $hash; ?>">
                        <div class="card-header">Property Details</div>
                        <div class="mb-3">
                            <label class="small mb-1">Full Addres of the Property</label>
                            <input class="form-control" type="text" placeholder="Enter the full adress of the property" name="property_full_address" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                        </div>
                        <br>
                        <div class="card-header">Lease Info</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Status</label>
                                <select class="form-select" name="status" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                                    <option selected><?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'status'); ?></option>
                                    <option value="Tenant">Tenant</option>
                                    <option value="Notice">Notice</option>
                                    <option value="Past">Past</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Move-in</label>
                                <input class="form-control" name="move_in" type="date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars(getTenantData($_GET['tenantscod'], 'tenantscod', 'move_in')))); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Lease Starts</label>
                                <input class="form-control" name="lease_starts" type="date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars(getTenantData($_GET['tenantscod'], 'tenantscod', 'lease_starts')))); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Lease Term</label>
                                <input class="form-control" name="lease_term" type="text" value="<?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'lease_term'); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Lease To</label>
                                <input class="form-control" name="lease_expires" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                        </div>

                        <br>
                        <div class="card-header">Financial Details</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Deposit</label>
                                <input class="form-control" name="deposit" type="text" value="<?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'deposit'); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">First Rent</label>
                                <input class="form-control" name="first_rent" type="text" value="<?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'first_rent'); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Rent</label>
                                <input class="form-control" name="rent" type="text" value="<?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'rent'); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                        </div>

                        <br>

                        <div class="card-header">Lease Charges</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Code</label>
                                <select class="form-select" name="chargeCode" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                                    <option selected>Select Code</option>
                                    <option value="PET">PET</option>
                                    <option value="CARPARKING">CARPARKING</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Description</label>
                                <input class="form-control" name="chargeDescriptio" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Amount</label>
                                <input class="form-control" name="chargeAmmount" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">From Date</label>
                                <input class="form-control" name="chargeFromDate" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">To Date</label>
                                <input class="form-control" name="chargeToDate" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                        </div>
                        
                        <br>
                        <?php if(!$_GET['editor'] ?? null) echo '<button class="btn btn-primary" type="submit">Edit</button>'; ?>
                        <?php if($_GET['editor'] ?? null) echo '<button class="btn btn-primary" type="submit" name="save" value="true">Save</button>'; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
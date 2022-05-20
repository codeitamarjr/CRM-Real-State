<?php

if($_POST['save'] == true) {
   if(!isset($_POST['tenantscod'])) {
       $status = $_POST['status'];
       setTenantDataSafe($_GET['tenantscod'],'status',$status);
       setTenantDataSafe($_GET['tenantscod'],'user',$_SESSION["agent_id"]);
       setTenantDataSafe($_GET['tenantscod'],'user_date',date("Y-m-d H:i:s"));

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

                        <div class="card-header">Chargeable Items</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Code</label>
                                <select class="form-select" name="chargeCode1" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                                    <option selected>Select Code</option>
                                    <option value="PET">PET</option>
                                    <option value="CARPARKING">CARPARKING</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Description</label>
                                <input class="form-control" name="chargeDescription1" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Amount</label>
                                <input class="form-control" name="chargeAmmount1" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">From Date</label>
                                <input class="form-control" name="chargeFromDate1" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">To Date</label>
                                <input class="form-control" name="chargeToDate1" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Code</label>
                                <select class="form-select" name="chargeCode2" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                                    <option selected>Select Code</option>
                                    <option value="PET">PET</option>
                                    <option value="CARPARKING">CARPARKING</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Description</label>
                                <input class="form-control" name="chargeDescription2" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Amount</label>
                                <input class="form-control" name="chargeAmmount2" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">From Date</label>
                                <input class="form-control" name="chargeFromDate2" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">To Date</label>
                                <input class="form-control" name="chargeToDate2" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Code</label>
                                <select class="form-select" name="chargeCode3" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                                    <option selected>Select Code</option>
                                    <option value="PET">PET</option>
                                    <option value="CARPARKING">CARPARKING</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Description</label>
                                <input class="form-control" name="chargeDescription3" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Amount</label>
                                <input class="form-control" name="chargeAmmount3" type="text" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">From Date</label>
                                <input class="form-control" name="chargeFromDate3" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">To Date</label>
                                <input class="form-control" name="chargeToDate3" type="date" value="" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                        </div>
                        
                        <br>
                        <label class="small mb-1">Last edited by <?php echo userGetData2('agent_id',(getTenantData($_GET['tenantscod'], 'tenantscod', 'user')),'agent_name'); ?> on <?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'user_date'); ?> </label>
                        <br>
                        <?php if(!$_GET['editor'] ?? null) echo '<button class="btn btn-primary" type="submit">Edit</button>'; ?>
                        <?php if($_GET['editor'] ?? null) echo '<button class="btn btn-primary" type="submit" name="save" value="true">Save</button>'; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
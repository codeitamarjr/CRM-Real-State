<?php

if($_POST['save'] == true) {
   if(!isset($_POST['tenantscod'])) {
       setTenantDataSafe($_GET['tenantscod'],'rtb_status',$_POST['rtb_status']);
       setTenantDataSafe($_GET['tenantscod'],'rtb_date_registered',$_POST['rtb_date_registered']);
       setTenantDataSafe($_GET['tenantscod'],'rtb_date_issued',$_POST['rtb_date_issued']);
       setTenantDataSafe($_GET['tenantscod'],'rtb_numer',$_POST['rtb_numer']);
       setTenantDataSafe($_GET['tenantscod'],'rtb_user',$_SESSION["agent_id"]);
       setTenantDataSafe($_GET['tenantscod'],'rtb_user_date',date("Y-m-d H:i:s"));


   }
}

?>
<div class="container">
    <div class="row">
        <div class="col">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">RTB Details</div>
                <div class="card-body">
                    <form method="POST" action="?access=tenantView&content=rtb_detail&editor=true&tenantscod=<?php echo $tenantscod; ?>&hash=<?php echo $hash; ?>">
                        <div class="card-header">RTB Info</div>
                        <div class="row">
                            <div class="col">
                                <label class="small mb-1">Status</label>
                                <select class="form-select" name="rtb_status" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                                    <option selected><?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'rtb_status'); ?></option>
                                    <option value="Peding">Peding</option>
                                    <option value="Paid">Paid</option>
                                </select>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Date Registered</label>
                                <input class="form-control" name="rtb_date_registered" type="date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars(getTenantData($_GET['tenantscod'], 'tenantscod', 'rtb_date_registered')))); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">Date RTB Issued</label>
                                <input class="form-control" name="rtb_date_issued" type="date" value="<?php echo date('Y-m-d', strtotime(htmlspecialchars(getTenantData($_GET['tenantscod'], 'tenantscod', 'rtb_date_issued')))); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            <div class="col">
                                <label class="small mb-1">RTB Number</label>
                                <input class="form-control" name="rtb_numer" type="text" value="<?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'rtb_numer'); ?>" <?php if(!$_GET['editor'] ?? null) echo 'disabled'; ?>>
                            </div>
                            
                        </div>
                        <br>
                        <div class="col">
                                <label class="small mb-1">Edited by <?php echo userGetData2('agent_id',(getTenantData($_GET['tenantscod'], 'tenantscod', 'rtb_user')),'agent_name'); ?> on <?php echo getTenantData($_GET['tenantscod'], 'tenantscod', 'rtb_user_date'); ?> </label>
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
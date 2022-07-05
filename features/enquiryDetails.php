<?php

//Load automail functions
require "functions_automail.php";
require "config/config.php";

$message_id = $_GET['message_id'];

//select all data from the mail_income sql table

$from = getMessage('message_id', $message_id, 'messages_email');
$phone = getMessage('message_id', $message_id, 'message_phone_number');
$date = getMessage('message_id', $message_id, 'message_date');
$status = getMessage('message_id', $message_id, 'status');
$message = getMessage('message_id', $message_id, 'message_body');
$hash = getMessage('message_id', $message_id, 'message_hash');
$name = getMessage('message_id', $message_id, 'message_sender_name');
$property = getMessage('message_id', $message_id, 'property_code');


//Check if there's a status to change on this message
if (!isset($_GET['outcome'])) {
    // nothing happens 
} else if ($_GET['outcome'] == 'changeProperty') {
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

    echo setMessage($message_id, 'property_code', $_GET['change_property']);

    echo '
                </center></div>
            </div>
        </div>
    </div>';
} else if ($_GET['outcome'] == 'Approved') {
    // if the outcome has a variable Approved will update the status to Approved
    $outcome = $_GET['outcome'];
    echo "<script>
    $(document).ready(function(){
        $(\"#alertModal\").modal('show');
    });
    </script>";
    echo '<!-- Modal Alert -->
    <div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                <center>
                   ';
    echo setMessage($message_id, 'status', $outcome);
    $from = getMessage('message_id', $message_id, 'messages_email');
    sendAutomail($name, $hash, $property_name, $from, $from, $_SESSION["property_code"], 'viewing');
    echo '

    <p> Redirect in <span id="countdowntimer">3 </span> seconds</p>
    <meta http-equiv="refresh" content="3;?access=enquiries" />
    <script type="text/javascript">
    var timeleft = 5;
    var downloadTimer = setInterval(function(){
    timeleft--;
    document.getElementById("countdowntimer").textContent = timeleft;
    if(timeleft <= 0)
        clearInterval(downloadTimer);
    },1000);
    </script>
                </center></div>
            </div>
        </div>
    </div>';
} else if ($_GET['outcome'] == 'Denied') {
    // if the outcome has a variable will update the status 
    $outcome = $_GET['outcome'];
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
    echo setMessage($message_id, 'status', $outcome);
    $from = getMessage('message_id', $message_id, 'messages_email');
    sendAutomail($name, $hash, '', $from, $from, $_SESSION["property_code"], 'denied');
    echo '
                </center></div>
            </div>
        </div>
    </div>';
} else if ($_GET['outcome'] == 'Delete') {
    // if the outcome has a variable will update the status 
    $outcome = $_GET['outcome'];
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
    $query = "DELETE FROM messages WHERE (message_id = '$message_id')";
    if ($link->query($query) === TRUE) {
        echo '<div class="alert alert-danger" role="alert">This enquirie has been deleted with succes!</div>';
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    echo '
                <meta http-equiv="refresh" content="2;?access=enquiries" />
                </center></div>
            </div>
        </div>
    </div>';
} else if ($_GET['outcome'] == 'SendEmail') {
    $outcome = $_GET['outcome'];
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
    $from = getMessage('message_id', $message_id, 'messages_email');
    sendAutomail($name, $hash, $property_name, $from, $from, $_SESSION["property_code"], 'welcome');
    echo '
                </center></div>
            </div>
        </div>
    </div>';
}
if ($_POST['outcome'] == 'newTenant') {
    require "features/functions_tenant.php";

    echo "<script>
    $(document).ready(function(){
        $(\"#alertModal\").modal('show');
    });
    </script>";
    echo
    '<!-- Modal Alert -->
    <div class="modal" id="alertModal" tabindex="-1" aria-labelledby="alertModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <center>
                   ';

    if (
        getTenantData(getProspectData($hash, 'prospect_id'), 'prospect_id', 'prospect_id') != 0
    ) {
        echo "<div class='alert alert-danger' role='alert'>This prospect is already a tenant!</div>";
    } else {
        echo newTenantDataSafe($_POST['tenant-property'], getProspectData($hash, 'prospect_id'));
        $tenantscod = getTenantData(getProspectData($hash, 'prospect_id'), 'prospect_id', 'tenantscod');
        setTenantDataSafe($tenantscod, 'idunit', $_POST['idunit']);
        setTenantDataSafe($tenantscod, 'bedrooms', $_POST['bedrooms']);
        setTenantDataSafe($tenantscod, 'move_in', $_POST['move-in']);
        setTenantDataSafe($tenantscod, 'lease_starts', $_POST['lease-starts']);
        setTenantDataSafe($tenantscod, 'lease_term', $_POST['lease-term']);
        setTenantDataSafe($tenantscod, 'lease_expires', date('Y-m-d', (strtotime($_POST['lease-starts'] . ' + ' . $_POST['lease-term'] . ' month'))));
        setTenantDataSafe($tenantscod, 'rent', $_POST['rent']);
        setTenantDataSafe($tenantscod, 'deposit', $_POST['deposit']);
        setTenantDataSafe($tenantscod, 'first_rent', $_POST['first-rent']);
        require "features/functions_billings.php";
        //Create the bills for the tenant
        //Create bills for the next months based on the lease term
        $next_month =  date('Y-m-d', strtotime($_POST['lease-starts'] . ' + 1 months'));
        //Get the first day of the month
        $next_month = date('Y-m-01', strtotime($next_month));
        //Recurring rent
        $recurring = 1;
        do {
            createBill($tenantscod, $_POST['tenant-property'], 'Rent', $_POST['rent'], $next_month);
            $next_month =  date('Y-m-d', strtotime($next_month . ' + 1 months'));
            $recurring++;
        } while ($recurring <= $_POST['lease-term']);
        //Deposit and First Rent or Remaining Rent
        createBill($tenantscod, $_POST['tenant-property'], 'First Rent', $_POST['first-rent'], $_POST['lease-starts']);
        createBill($tenantscod, $_POST['tenant-property'], 'Deposit', $_POST['deposit'], $_POST['lease-starts']);
        //Update the tenant with the unit
        require "features/functions_unit.php";
        setUnit($_POST['idunit'], 'tenant_id', $tenantscod);
        setUnit($_POST['idunit'], 'status', 'Rented');
    }

    //$from = getMessage('message_id', $message_id, 'messages_email');
    //sendAutomail($name, $hash, $property_name, $from, $from, '', 'newtenant');
    echo '
                <meta http-equiv="refresh" content="2;?access=tenantView&content=prospect_details&tenantscod=' . $tenantscod . '&hash=' . $hash . '" />
                </center></div>
            </div>
        </div>
    </div>';
}
?>
<script src="https://cdn.tiny.cloud/1/wqh1zddiefonsyraeh8x3jwdkrswjtgv49fuarkvu1ggr9ad/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Enquirie Details</h6>
            <div class="dropdown no-arrow">
                <button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button">
                    <i class="fas fa-ellipsis-v text-gray-400"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                    <h6 class="dropdown-header text-center">Change Status</h6>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changeProperty">&nbsp;Change Property</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#approveModal">&nbsp;Approve</a>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#denyModal">&nbsp;Deny</a>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal">&nbsp;Delete</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sendModal">&nbsp;Send Welcome E-mail</a>
                </div>
            </div>
        </div>
        <div class="card-body">


            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Property</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo getPropertyData($property, 'property_name'); ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $from; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Phone</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $phone; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Received on:</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $date; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Status</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $status; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Message</h6>
                        </div>
                   
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="email-content">
                                <textarea id="tinyTextArea"><?php echo $message; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>

<!-- Change Property Modal -->
<div class="modal fade" id="changeProperty" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Change the enquirie to another property</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
                <div class="modal-body">
                    <p>Do you want to change the enquiry to another property?<br>
                        Select a new property:</p>
                    <select class="form-select" name="change_property">
                        <optgroup>
                            <option selected><?php echo getPropertyData(getMessage('message_id', $message_id, 'property_code'), 'property_name'); ?></option>
                        </optgroup>
                        <optgroup>
                            <option disabled>Select Another Property</option>

                            <?php
                            //List all the properties from an agent
                            include 'config/config.php';
                            $select = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
                            $result = mysqli_query($link, $select);
                            while ($row = mysqli_fetch_array($result)) {
                                echo '<option value=' . $row['property_code'] . '>' . $row['property_name'] . '</option>';
                            }
                            mysqli_close($link);
                            ?>
                        </optgroup>
                    </select>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="access" value="enquiryDetails">
                    <input type="hidden" name="message_id" value="<?php echo $message_id ?>">
                    <button type="submit" class="btn btn-primary" name="outcome" value="changeProperty">&nbsp;Change</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Status to Approve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Approve the enquirie from <?php echo $from; ?>?
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="dashboard.php?access=enquiryDetails&message_id=<?php echo $message_id ?>&outcome=Approved">&nbsp;Approve</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Deny -->
<div class="modal fade" id="denyModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Status to Deny</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Deny the enquirie from <?php echo $from; ?>? <br>
                If the settings are set to auto send an email, this will be sent to this applicant.
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="dashboard.php?access=enquiryDetails&message_id=<?php echo $message_id ?>&outcome=Denied">&nbsp;Deny</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm to Delete this Enquirie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Delete the enquirie from <?php echo $from; ?>? <br>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="dashboard.php?access=enquiryDetails&message_id=<?php echo $message_id ?>&outcome=Delete">&nbsp;Delete</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Send Welcome E-mail Modal -->
<div class="modal fade" id="sendModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm to Send the Welcome E-mail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to send the welcome e-mail based on the Automail template for <?php echo $from; ?>? <br>
            </div>
            <div class="modal-footer">
                <form method="GET" action="<?= $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="access" value="enquiryDetails">
                    <input type="hidden" name="message_id" value="<?php echo $message_id ?>">
                    <button type="submit" class="btn btn-primary" name="outcome" value="SendEmail">&nbsp;Send</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </div>
</div>

</div>
<p>

    <?php
    //include "prospect_details.php";
    ?>
</p>

<script>
    tinymce.init({
        selector: '#tinyTextArea',
        toolbar_location: 'bottom',
        visual: false,
        menubar: false,
        statusbar: false,
        height: 600,
    });
</script>
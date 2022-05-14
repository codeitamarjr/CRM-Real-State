<?php

//Load automail functions
require "functions_automail.php";
require "config/config.php";

//select all data from the mail_income sql table

$from = getMessage('message_id', $message_id, 'messages_email');
$phone = getMessage('message_id', $message_id, 'message_phone_number');
$date = getMessage('message_id', $message_id, 'message_date');
$status = getMessage('message_id', $message_id, 'status');
$message = getMessage('message_id', $message_id, 'message_body');
$hash = getMessage('message_id', $message_id, 'message_hash');
$name = getMessage('message_id', $message_id, 'message_sender_name');


$message_id = $_GET['message_id'];

//Check if there's a status to change on this message
if (!isset($_GET['outcome'])) {
    // nothing happens 
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
    sendAutomail($name, $hash, $property_name, $from, $from, '', 'viewing');
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
    sendAutomail($name, $hash, '', $from, $from, '', 'denied');
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
    sendAutomail($name, $hash, $property_name, $from, $from, '', 'welcome');
    echo '
                </center></div>
            </div>
        </div>
    </div>';
}
if ($_POST['outcome'] == 'newTenant') {
    require "features/functions_prospect.php";
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
        echo "<div class='alert alert-danger' role='alert'>This prospect already it's a tenant!</div>";
    } else {
        echo newTenantDataSafe($_POST['tenant-property'], getProspectData($hash, 'prospect_id'));
        $tenantscod = getTenantData(getProspectData($hash, 'prospect_id'), 'prospect_id', 'tenantscod');
        setTenantDataSafe($tenantscod, 'unit_rented_code', $_POST['unit_rented_code']);
        setTenantDataSafe($tenantscod, 'bedrooms', $_POST['bedrooms']);
        setTenantDataSafe($tenantscod, 'move_in', $_POST['move-in']);
        setTenantDataSafe($tenantscod, 'lease_starts', $_POST['lease-starts']);
        setTenantDataSafe($tenantscod, 'lease_term', $_POST['lease-term']);
        setTenantDataSafe($tenantscod, 'lease_expires', $_POST['lease-expires']);
        setTenantDataSafe($tenantscod, 'rent', $_POST['rent']);
        setTenantDataSafe($tenantscod, 'deposit', $_POST['deposit']);
        setTenantDataSafe($tenantscod, 'first_rent', $_POST['first-rent']);
    }

    //$from = getMessage('message_id', $message_id, 'messages_email');
    //sendAutomail($name, $hash, $property_name, $from, $from, '', 'newtenant');
    echo '
                <meta http-equiv="refresh" content="2;?access=tenantView&tenantContent=prospect_details&tenantscod=' . $tenantscod . '&hash=' . $hash . '" />
                </center></div>
            </div>
        </div>
    </div>';
}
?>


<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Enquirie Details</h6>
            <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                    <h6 class="dropdown-header text-center"><strong>Change Status</strong></h6>
                    <?php if ($status == 'Approved') { ?>
                        <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#newTenant">&nbsp;Set as Tenant</a>
                        <div class="dropdown-divider"></div>
                    <?php }; ?>
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
                        <div class="col-sm-9 text-secondary">
                            <?php echo $message; ?>
                        </div>
                    </div>
                </div>
            </div>


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
                <a class="btn btn-primary" href="dashboard.php?access=message&message_id=<?php echo $message_id ?>&outcome=Approved">&nbsp;Approve</a>
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
                <a class="btn btn-primary" href="dashboard.php?access=message&message_id=<?php echo $message_id ?>&outcome=Denied">&nbsp;Deny</a>
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
                <a class="btn btn-primary" href="dashboard.php?access=message&message_id=<?php echo $message_id ?>&outcome=Delete">&nbsp;Delete</a>
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
                    <input type="hidden" name="access" value="message">
                    <input type="hidden" name="message_id" value="<?php echo $message_id ?>">
                    <button type="submit" class="btn btn-primary" name="outcome" value="SendEmail">&nbsp;Send</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </div>
</div>

<!-- New Tenant Modal -->
<div class="modal fade" id="newTenant" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="?access=message&message_id=<?php echo $message_id ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Future Tenant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">


                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="property_selector">Select a Property</label>
                        <div class="col-8">
                            <select id="property_selector" name="tenant-property" class="form-control" required="required">
                                <?php
                                //List all the properties from an agent
                                require 'config/config.php';
                                $select = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
                                $result = mysqli_query($link, $select);
                                while ($row = mysqli_fetch_array($result)) {
                                    echo '<option value=' . $row['property_code'] . '>' . $row['property_name'] . '</option>';
                                };
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="code_unit" class="col-4 col-form-label">Code of the Unit</label>
                        <div class="col-8">
                            <input id="code_unit" name="unit_rented_code" type="text" class="form-control" required="required">
                            <span id="move-inHelpBlock" class="form-text text-muted">Custom code of the unit.</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-4 col-form-label" for="bedrooms">Bedrooms</label>
                        <div class="col-8">
                            <select id="bedrooms" name="bedrooms" class="form-control" required="required">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="move-in" class="col-4 col-form-label">Move-in Date</label>
                        <div class="col-8">
                            <div class="input-group">
                                <input id="move-in" name="move-in" type="date" aria-describedby="move-inHelpBlock" required="required" class="form-control">
                            </div>
                            <span id="move-inHelpBlock" class="form-text text-muted">Select the move-in date</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lease_starts" class="col-4 col-form-label">Lease Starts</label>
                        <div class="col-8">
                            <div class="input-group">
                                <input id="lease_starts" name="lease-starts" type="date" aria-describedby="lease_startsHelpBlock" required="required" class="form-control">
                            </div>
                            <span id="lease_startsHelpBlock" class="form-text text-muted">Select the date the lease starts.</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lease_term" class="col-4 col-form-label">Lease Term</label>
                        <div class="col-8">
                            <input id="lease_term" name="lease-term" type="number" aria-describedby="lease_termHelpBlock" required="required" class="form-control">
                            <span id="lease_termHelpBlock" class="form-text text-muted">What is the time of the lease in months</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lease_expires" class="col-4 col-form-label">Lease expires</label>
                        <div class="col-8">
                            <input id="lease_expires" name="lease-expires" type="date" aria-describedby="lease_expiresHelpBlock" required="required" class="form-control">
                            <span id="lease_expiresHelpBlock" class="form-text text-muted">The date that the lease will expire based on the start lease and term.</span>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">
                        <label for="rent" class="col-4 col-form-label">Rent</label>
                        <div class="col-8">
                            <input id="rent" name="rent" type="text" class="form-control" required="required" aria-describedby="rentHelpBlock" data-type="currency" placeholder="€0.000,00">
                            <span id="rentHelpBlock" class="form-text text-muted">Value of the rent per month.</span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="deposit" class="col-4 col-form-label">Deposit</label>
                        <div class="col-8">
                            <input id="deposit" name="deposit" type="text" class="form-control" required="required" data-type="currency" placeholder="€0.000,00">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="first_rent" class="col-4 col-form-label">First Rent</label>
                        <div class="col-8">
                            <input id="first_rent" name="first-rent" type="text" class="form-control" required="required" aria-describedby="first_rentHelpBlock" data-type="currency" placeholder="€0.000,00">
                            <span id="first_rentHelpBlock" class="form-text text-muted">First rent or remaining rent, in case of the tenant move-in in the middle of the month.</span>
                        </div>
                    </div>


                    <br>

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="outcome" value="newTenant">
                    <button type="submit" class="btn btn-primary" name="outcome" value="newTenant">&nbsp;Save New Tenant</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
                </div>
        </form>
    </div>
</div>
</div>
<p>

    <?php
    include "prospect_details.php";
    ?>
</p>
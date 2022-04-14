<?php

//Load automail functions
require "functions_automail.php";
require "config/config.php";

//select all data from the mail_income sql table

$from = getMessage('message_id',$message_id, 'messages_email');
$phone = getMessage('message_id',$message_id, 'message_phone_number');
$date = getMessage('message_id',$message_id, 'message_date');
$status = getMessage('message_id',$message_id, 'status');
$message = getMessage('message_id',$message_id, 'message_body');
$hash = getMessage('message_id',$message_id, 'message_hash');
$name = getMessage('message_id',$message_id, 'message_sender_name');


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
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <center>
                   ';
    echo setMessage($message_id, 'status', $outcome);
    $from = getMessage('message_id',$message_id, 'messages_email');
    sendAutomail($name, $hash, $property_name, $from, $from, '', 'viewing');
    echo '
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
    $from = getMessage('message_id',$message_id, 'messages_email');
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
    $from = getMessage('message_id',$message_id, 'messages_email');
    sendAutomail($name, $hash, $property_name, $from, $from, '', 'welcome');
    echo '
                </center></div>
            </div>
        </div>
    </div>';
}
?>


<div class="container-fluid">
    <h3 class="text-dark mb-1">Message</h3>
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="text-primary fw-bold m-0">Enquirie Details</h6>
            <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" aria-expanded="false" data-bs-toggle="dropdown" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                <div class="dropdown-menu dropdown-menu-end shadow animated--fade-in">
                    <h6 class="dropdown-header text-center"><strong>Change Status</strong></h6>
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
                <a class="btn btn-primary" href="dashboardv2.php?access=message&message_id=<?php echo $message_id ?>&outcome=Approved">&nbsp;Approve</a>
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
                <a class="btn btn-primary" href="dashboardv2.php?access=message&message_id=<?php echo $message_id ?>&outcome=Denied">&nbsp;Deny</a>
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
                <h5 class="modal-title" id="exampleModalLabel">Confirm to Delet this Enquirie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Delete the enquirie from <?php echo $from; ?>? <br>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" href="dashboardv2.php?access=message&message_id=<?php echo $message_id ?>&outcome=Delete">&nbsp;Delet</a>
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


<?php
//check if the HASH is inside prospect if so include details
$sql = "SELECT * FROM prospect WHERE hash = '$hash'";
$result = mysqli_query($link, $sql);
while ($row_prospect = mysqli_fetch_array($result)) {
    $hash = $row_prospect['hash'];
    if (!empty($hash)) {
        include "prospect_details.php";
    }
};
mysqli_close($link);
?>
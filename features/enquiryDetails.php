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
$welcomeEmail = getMessage('message_id', $message_id, 'emailWelcome');
$viewingEmail = getMessage('message_id', $message_id, 'emailViewing');
$message = getMessage('message_id', $message_id, 'message_body');
$hash = getMessage('message_id', $message_id, 'message_hash');
$name = getMessage('message_id', $message_id, 'message_sender_name');
$property = getMessage('message_id', $message_id, 'property_code');

// Modal box functions
function modalBox($message){
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
                     echo $message;
                     echo '
                </center>
                </div>
             </div>
        </div>
    </div>';
}


//Check if there's a status to change on this message
if (!isset($_POST['outcome'])) {
    // nothing happens 
} else if ($_POST['outcome'] == 'changeProperty') {
    modalBox(setMessage($message_id, 'property_code', $_POST['change_property']));
} else if ($_POST['outcome'] == 'sendViewing') {
    // if the outcome has a variable sendViewing will update the status to Invited
    $outcome = $_POST['outcome'];
    $from = getMessage('message_id', $message_id, 'messages_email');
    modalBox('<center>Viewing invitation sent!<br>'.setMessage($message_id, 'status', 'Invited').'<br>'.
    sendAutomail($name, $hash, $property_name, $from, $from, $_SESSION["property_code"], 'viewing') .'</center>');
    setMessage($message_id, 'emailViewing', date('Y-m-d H:i:s'));
} else if ($_POST['outcome'] == 'Denied') {
    // if the outcome has a variable will update the status 
    $outcome = $_POST['outcome'];
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
    //$from = getMessage('message_id', $message_id, 'messages_email');
    //sendAutomail($name, $hash, '', $from, $from, $_SESSION["property_code"], 'denied');
    echo '
                </center></div>
            </div>
        </div>
    </div>';
} else if ($_POST['outcome'] == 'Delete') {
    // if the outcome has a variable will update the status 
    $outcome = $_POST['outcome'];
    $query = "DELETE FROM messages WHERE (message_id = '$message_id')";
    if ($link->query($query) === TRUE) {
        modalBox('<div class="alert alert-danger" role="alert">This enquirie has been deleted with succes!</div>');
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
} else if ($_POST['outcome'] == 'SendEmail') {
    $outcome = $_POST['outcome'];
    $from = getMessage('message_id', $message_id, 'messages_email');
    modalBox('<center>Welcome email sent!<br>'.sendAutomail($name, $hash, $property_name, $from, $from, $_SESSION["property_code"], 'welcome').'<br>');
    setMessage($message_id, 'emailWelcome', date('Y-m-d H:i:s'));
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
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal">&nbsp;Delete</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sendModal">&nbsp;Send Welcome E-mail</a>
                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#sendViewing">&nbsp;Send Viewing E-mail</a>
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
                            <h6 class="mb-0">Welcome E-mail Sent on</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $welcomeEmail; ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Viewing E-mail Sent on</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo $viewingEmail; ?>
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
            <form method="POST">
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

<!-- Modal Delete -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <form method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm to Delete this Enquirie</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Delete the enquirie from <?php echo $from; ?>? <br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger" name="outcome" value="Delete">&nbsp;Delete</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </form>
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
                <form method="POST">
                    <input type="hidden" name="access" value="enquiryDetails">
                    <input type="hidden" name="message_id" value="<?php echo $message_id ?>">
                    <button type="submit" class="btn btn-primary" name="outcome" value="SendEmail">&nbsp;Send</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Send Viewing E-mail Modal -->
<div class="modal fade" id="sendViewing" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm to Send the Welcome E-mail</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Do you want to send the viewing e-mail based on the Automail template for <?php echo $from; ?>? <br>
            </div>
            <div class="modal-footer">
                <form method="POST">
                    <input type="hidden" name="access" value="enquiryDetails">
                    <input type="hidden" name="message_id" value="<?php echo $message_id ?>">
                    <button type="submit" class="btn btn-primary" name="outcome" value="sendViewing">&nbsp;Send</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel and Close</button>
            </div>
        </div>
    </div>
</div>

</div>


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
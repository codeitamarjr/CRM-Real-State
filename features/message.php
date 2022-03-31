<?php

require "functions_automail.php";
// Include config file
require "config/config.php";

$message_id = $_GET['message_id'];

//Check if there's a status to change on this message
if (!isset($_GET['outcome'])) {
    // nothing happens 
} else if ($_GET['outcome'] == 'Approved') {
    // if the outcome has a variable will update the status 
    $outcome = $_GET['outcome'];
    $query = "UPDATE messages SET status = '$outcome' WHERE (message_id = '$message_id')";
    if ($link->query($query) === TRUE) {
        echo '<h1><span style="color: #339966;"><center>This enquirie has been approved with succes!</center></span></h1>';
        $from = messagesDATA($message_id, 'messages_email');
        emailSend('', $from, $from, '', 'viewing');
        die();
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
} else if ($_GET['outcome'] == 'Denied') {
    // if the outcome has a variable will update the status 
    $outcome = $_GET['outcome'];
    $query = "UPDATE messages SET status = '$outcome' WHERE (message_id = '$message_id')";

    if ($link->query($query) === TRUE) {
        echo '<h1><span style="color: #ff0000;"><center>This enquirie has been denied with succes!</center></span></h1>';
        $from = messagesDATA($message_id, 'messages_email');
        emailSend('', $from, $from, '', 'denied');
        die();
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
} else if ($_GET['outcome'] == 'Delete') {
    // if the outcome has a variable will update the status 
    $outcome = $_GET['outcome'];
    $query = "DELETE FROM messages WHERE (message_id = '$message_id')";

    if ($link->query($query) === TRUE) {
        echo '<h1><span style="color: #ff0000;"><center>This enquirie has been deleted with succes!</center></span></h1>';
        die;
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}


//select all data from the mail_income sql
$query = "SELECT * FROM messages WHERE message_id = '$message_id'";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_array($result)) {
    //Creates a loop to loop through results
    $from = $row['messages_email'];
    $phone = $row['message_phone_number'];
    $date = $row['message_date'];
    $message = $row['message_body'];
    $status = $row['status'];
    $hash = $row['message_hash'];
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
                    <a class="dropdown-item" href="dashboardv2.php?access=message&message_id=<?php echo $message_id ?>&outcome=Approved">&nbsp;Approve</a>
                    <a class="dropdown-item" href="dashboardv2.php?access=message&message_id=<?php echo $message_id ?>&outcome=Denied">&nbsp;Denied</a>
                    <a class="dropdown-item" href="dashboardv2.php?access=message&message_id=<?php echo $message_id ?>&outcome=Delete">&nbsp;Delete</a>
                    <div class="dropdown-divider"></div>
                    <h6 class="dropdown-header text-center"><strong>Automail</strong></h6>
                    <!-- Button trigger modal -->
                    <button data-bs-toggle="modal" data-bs-target="#exampleModal" class="btn btn-default">Future Feature</button>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Future Feature</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                //emailSend("Property Name :D",$from, $from, 3);
                //echo emailPrintMessage("Property Name","email from",1);
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
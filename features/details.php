<?php
// Include config file
require "config/config.php";

if (!isset($_GET['outcome'])) {
    // nothing happens 
} else if ($_GET['outcome'] == 'Approved') {
    // if the outcome has a variable will update the status 
    $outcome = $_GET['outcome'];
    $query = "UPDATE messages SET status = '$outcome' WHERE (message_id = '$message_id')";
    if ($link->query($query) === TRUE) {
        echo '<h1><span style="color: #339966;"><center>This enquirie has been approved with succes!</center></span></h1>';
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
} else if ($_GET['outcome'] == 'Denied') {
    // if the outcome has a variable will update the status 
    $outcome = $_GET['outcome'];
    $query = "UPDATE messages SET status = '$outcome' WHERE (message_id = '$message_id')";

    if ($link->query($query) === TRUE) {
        echo '<h1><span style="color: #ff0000;"><center>This enquirie has been denied with succes!</center></span></h1>';
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
}


//select all data from the mail_income sql
$query = "SELECT * FROM messages WHERE message_id = '$message_id'";
$result = mysqli_query($link, $query);

while ($row = mysqli_fetch_array($result)) {
    //Creates a loop to loop through results
    $from = nl2br(htmlspecialchars($row['messages_email']));
    $phone = nl2br(htmlspecialchars($row['message_phone_number']));
    $date = nl2br(htmlspecialchars($row['message_date']));
    $message = nl2br(htmlspecialchars($row['message_body']));
    $status = nl2br(htmlspecialchars($row['status']));
}

mysqli_close($link); //Make sure to close out the database connection
?>

<div class="details">
    <!-- order details list -->
    <div class="buttonarea">
        <div class="cardHeader">
            <h2>Detail of the Enquiry</h2>
        </div>
        <table>
            <thead>
                <tr>
                    <td>From</td>
                    <td>Phone Number</td>
                    <td>Received on</td>
                    <td>Status</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $from ?></td>
                    <td><?php echo $phone ?></td>
                    <td><?php echo $date ?></td>
                    <td><?php echo "<span class=\"status $status\">";
                        echo $status ?></span></td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align:center"><?php echo $message ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="details">
    <div class="buttonarea">
        <center class="btn-approve">
            <a href="dashboard.php?access=details&message_id=<?php echo $message_id ?>&outcome=Approved" class="accept">Approve <span class="fa fa-check"></span></a>
            <a href="dashboard.php?access=details&message_id=<?php echo $message_id ?>&outcome=Denied" class="deny">Deny <span class="fa fa-close"></span></a>
        </center>
    </div>
</div>




<style>
    a {
        text-decoration: none;
    }

    .accept {
        color: #FFF;
        background: #44CC44;
        padding: 15px 20px;
        box-shadow: 0 4px 0 0 #2EA62E;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .accept:hover {
        background: #6FE76F;
        box-shadow: 0 4px 0 0 #7ED37E;
    }

    .deny {
        color: #FFF;
        background: tomato;
        padding: 15px 20px;
        box-shadow: 0 4px 0 0 #CB4949;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .deny:hover {
        background: rgb(255, 147, 128);
        box-shadow: 0 4px 0 0 #EF8282;
    }
</style>
<?php

// Include config file
include "config/config.php";

//select all data from the mail_income sql
$query = "SELECT message_retrieved FROM messages WHERE message_retrieved > (NOW()- INTERVAL 10 MINUTE);";
$result = mysqli_query($link,$query);

//find the total number of results
$notification = mysqli_num_rows($result); 

//Close SQL connection
mysqli_close($link); 

if ($notification > 0){
    echo '<div class="notification">'. $notification .'</div>';
}
?>


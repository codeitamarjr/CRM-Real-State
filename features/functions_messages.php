<?php

function messagesDATA($message_id, $colum){
    //This function will retrieve a data from a colum of a specific message_id
    require "config/config.php";
    $query = "SELECT * FROM messages WHERE message_id = '$message_id'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row['' . $colum . ''];
    }
    mysqli_close($link);
}

function messagesStatus($message_id)
{
    require "config/config.php";
    $query = "SELECT * FROM messages WHERE message_id = '$message_id'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        //Creates a loop to loop through results
        $from = $row['messages_email'];
        $phone = $row['message_phone_number'];
        $date = $row['message_date'];
        $message = $row['message_body'];
        $status = $row['status'];
    }
    mysqli_close($link);
}
function messagesNotification($timeForNotification){
    // This function will get the number of messages receives in the last $timeForNotification minutes;
    include "config/config.php";
    $query = "SELECT message_retrieved FROM messages WHERE message_retrieved > (NOW()- INTERVAL '$timeForNotification' MINUTE);";
    $result = mysqli_query($link, $query);
    $notification = mysqli_num_rows($result);
    mysqli_close($link);
    if ($notification > 0) {
        return $notification;
    }
}

?>

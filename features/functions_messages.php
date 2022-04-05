<?php

function messagesNotification($timeForNotification)
{
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
function setMessage($message_id, $rowName, $newData)
{
    require "config/config.php";
    $query = "UPDATE messages SET $rowName = '$newData' WHERE (message_id = '$message_id')";
    if (mysqli_query($link, $query)) {
        return '<center><div class="alert alert-success" role="alert">Enquiry updated with success!</div></center>';
    } else {
        return '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}
function getMessage($message_id, $rowName)
{
    require "config/config.php";
    $query = "SELECT * FROM messages WHERE (message_id = '$message_id')";
    $result = mysqli_query($link, $query);
    if (mysqli_query($link, $query)) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$rowName];
        }
    } else {
        return '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

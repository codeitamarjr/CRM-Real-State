<?php

function totalMesssages($property_code,$aditionalQuery){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * FROM messages WHERE property_code = '$property_code' $aditionalQuery");
    return mysqli_num_rows($result);
    mysqli_close($link);
}

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

//INSERT INTO `property_management`.`messages` (`messages_email`) VALUES ('mail@mail.com');

function insertMessage($email,$property_code)
{
    require "config/config.php";
    $key = hash('md5', $email);
    $message_date = date("Y/m/d H:i:s");
    $query = "INSERT INTO messages (messages_email, message_date, message_hash ,property_code) VALUES ('$email', '$message_date' ,'$key' ,'$property_code')";
    if (mysqli_query($link, $query)) {
        echo '<center><div class="alert alert-success" role="alert">Enquiry created with success!</div></center>';
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}



function setMessage($message_id, $rowName, $newData)
{
    require "config/config.php";
    $query = "UPDATE messages SET $rowName = ? WHERE (message_id = '$message_id')";
    $stmt = mysqli_stmt_init($link);
    if (mysqli_stmt_prepare($stmt,$query)) {
        mysqli_stmt_bind_param($stmt, "s", $newData);
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Enquiry updated with success!</div></center>';
    } else {
        return '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_stmt_error($stmt) . '</div></center>';
    }
    mysqli_close($link);
}
function getMessage($conditionalRow, $conditionalRowData, $rowDataReturn)
{
    require "config/config.php";
    $query = "SELECT * FROM messages WHERE ($conditionalRow = '$conditionalRowData')";
    $result = mysqli_query($link, $query);
    if (mysqli_query($link, $query)) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$rowDataReturn];
        }
    } else {
        return '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

<?php

function emailSend($property_name,$email_adress, $message_sender_name,$automail_id,$status){
    require "config/config.php";
    //select message from automail_id
    $query = "SELECT * FROM automail WHERE automail_id = '$automail_id' OR automail_autosender = '$status'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        //Creates a loop to loop through results
        $message = $row['automail_message'];
        $subject = $row['automail_title'];
    }
    require "email_sending.php";
    mysqli_close($link);
}

function emailPrintMessage($property_name,$email_adress,$automail_id){
    include "config/config.php";
    include "../config/config.php";
    $query = "SELECT * FROM automail WHERE automail_id = '$automail_id'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row['automail_message'];
    }
    mysqli_close($link);
}

function setAutomail($property_code,$automailOption,$status){
    require "config/config.php";
    $query = "UPDATE property SET $automailOption = '$status' WHERE (property_code = '$property_code')";
    $result = mysqli_query($link, $query);
    mysqli_close($link);
}

function getAutomail($property_code,$rowName){
    require "config/config.php";
    $query = "SELECT * FROM property WHERE (property_code = '$property_code')";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row[$rowName];
    }
    mysqli_close($link);
}

function getAutomailTitle($automail_id){
    include "config/config.php";
    include "../config/config.php";
    $query = "SELECT automail_title FROM automail WHERE (automail_id = $automail_id)";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row['automail_title'];
    }
    mysqli_close($link);
}

function getAutomailExternal($property_code,$automailOption){
    include "../config/config.php";
    $query = "SELECT * FROM property WHERE (property_code = '$property_code')";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row[$automailOption];
    }
    mysqli_close($link);
}

function createAutomailTemplate($automail_id){
    $message_automail = emailPrintMessage('','',$automail_id);
    $Title_file = "$automail_id";
    $uniqid="features/automail_generated_messsage_".$Title_file.".php";    
    $file = fopen($uniqid,"w");
    fwrite($file,"<?php \r\n \$message = '$message_automail';");
    fclose($file); 
}

?>
<?php


function sendAutomail($name ,$hash ,$property_name,$email_adress, $message_sender_name,$prs_code,$status){
    require "config/config.php";
    require "features/functions_prs.php";
    //select message from automail_id
    $query = "SELECT * FROM automail WHERE prs_code = '$prs_code' AND automail_autosender = '$status'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        //Creates a loop to loop through results
        $message = $row['automail_message'];
        $subject = $row['automail_title'];
        $automail_id = $row['automail_id'];
    }
    $message = str_replace('%propertyName%', getPropertyData($_SESSION["property_code"],'property_name') , $message);
    $message = str_replace('%propertyOfficeName%', getPropertyData($_SESSION["property_code"],'office_name') , $message);
    $message = str_replace('%propertyOfficePhone%', getPropertyData($_SESSION["property_code"],'office_phone') , $message);
    $message = str_replace('%PropertyOfficeEmail%', getPropertyData($_SESSION["property_code"],'office_email') , $message);
    $message = str_replace('%PropertyOfficeAddress%', getPropertyData($_SESSION["property_code"],'office_address') , $message);
    $message = str_replace('%prospectName%', $name , $message);
    $message = str_replace('%prospectEmail%', $email_adress , $message); 
    $base_mail = getAutomail($automail_id,'automail_website');
    $message = str_replace('%link%', ''.$base_mail.'/prospect_area.php?key='.$hash.'', $message);
    $message = str_replace('%prsName%', getPRSData(getPropertyData($_SESSION["property_code"],'property_prs_code'),'prs_name') , $message);
    $message = str_replace('%prsPhone%', getPRSData(getPropertyData($_SESSION["property_code"],'property_prs_code'),'prs_phone') , $message);
    $message = str_replace('%prsEmail%', getPRSData(getPropertyData($_SESSION["property_code"],'property_prs_code'),'prs_email') , $message);
    $message = str_replace('%prsAddress%', getPRSData(getPropertyData($_SESSION["property_code"],'property_prs_code'),'prs_full_address') , $message);
    $message = str_replace('%prsLogo%', $base_mail . '/features/uploads/' . getPRSData(getPropertyData($_SESSION["property_code"],'property_prs_code'),'prs_logo') , $message);
    $message = str_replace('%propertyLogo%', $base_mail . '/features/uploads/' . getPropertyData($_SESSION["property_code"],'property_logo') , $message);

    //require "composer.SES.php";
    require "email_sending.php";
    mysqli_close($link);
}

function setAutomail($automail_id,$rowName,$newData){
    require "config/config.php";
    $query = "UPDATE automail SET $rowName = '$newData' WHERE (automail_id = '$automail_id')";
    if (mysqli_query($link, $query)) {
        return '<center><div class="alert alert-success" role="alert">Message updated with success!</div></center>';
    } else {
        return '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

function getAutomail($automail_id,$rowName){
    require "config/config.php";
    $query = "SELECT * FROM automail WHERE (automail_id = '$automail_id')";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$rowName];
        }
    } else {
        return '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

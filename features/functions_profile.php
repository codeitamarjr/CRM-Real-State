<?php

function getProfile($row, $conditional, $return){
    require "config/config.php";
    $query = "SELECT $return FROM profile WHERE ($row = '$conditional')";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$return];
        }
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

function setProfile($profileID,$row,$data){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real conditional
    $sql = "UPDATE profile SET $row = ? WHERE (profileID = ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the conditional
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right conditionaltype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,'ss',$data,$profileID);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Profile updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function insertProfile($propertyCode,$type,$email){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real conditional
    $sql = "INSERT INTO profile (propertyCode,type, email) VALUES (?,?,?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the conditional
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right conditionaltype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,'iss',$propertyCode,$type,$email);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">conditional updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function insertProfileOccupant($propertyCode,$mainApplicantID,$type,$email,$firstName,$mobilePhone){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real conditional
    $sql = "INSERT INTO profile (propertyCode,mainApplicantID,type, email,firstName,mobilePhone) VALUES (?,?,?,?,?,?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the conditional
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right conditionaltype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,'iissss',$propertyCode,$mainApplicantID,$type,$email,$firstName,$mobilePhone);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">conditional updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function deleteProfile($profileID){
    require "config/config.php";

    // Check if the profile has attachements
    $query = "SELECT fileName FROM profileAttachments WHERE profileID = '$profileID'";
    $result = mysqli_query($link, $query);
    $numRows = mysqli_num_rows($result);
    //echo $result;
    if ($numRows > 0) {
        echo '<center><div class="alert alert-danger" role="alert">This profile has documents uploaded on it!</div></center>';
    } else {
        //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real conditional
        $sql = "DELETE FROM profile WHERE (profileID = ?)";
        //Start the prepare statement into the DB
        $stmt = mysqli_stmt_init($link);
        //Check if the SQL execute ok from the prepare statement, if so execute it and bind the conditional
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
        } else {
            //Bind parameters to the placeholder with the right conditionaltype s=String i=integer b=Blob d=Double
            mysqli_stmt_bind_param($stmt, 'i', $profileID);
            //Run parametes inside DB
            mysqli_stmt_execute($stmt);
            echo '<center><div class="alert alert-success" role="alert">Profile deleted with success!</div></center>';
        }
    }
    mysqli_stmt_close($stmt);
}

function changeProfileProperty($profileID, $propertyCode)
{
    require "config/config.php";
    $mainProfileID = getProfile('profileID', $profileID, 'mainApplicantID');
    if ($mainProfileID == null) $mainProfileID = $profileID;
    $query = "SELECT * FROM profile WHERE mainApplicantID = '$mainProfileID'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        // Update the profile with the new property code
        echo setProfile($row['profileID'], 'propertyCode', $propertyCode);
    }
    // Update the main applicant with the new property code
    echo setProfile($mainProfileID, 'propertyCode', $propertyCode);
}

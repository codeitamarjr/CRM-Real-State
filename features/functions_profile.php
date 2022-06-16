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
        return '<center><div class="alert alert-success" role="alert">conditional updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function insertProfile($type,$email){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real conditional
    $sql = "INSERT INTO profile (type, email) VALUES (?,?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the conditional
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right conditionaltype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,'ss',$type,$email);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">conditional updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

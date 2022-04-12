<?php

function getPropertyData($property_code, $rowName)
{
    include "config/config.php";
    $query = "SELECT * FROM property WHERE (property_code = '$property_code')";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$rowName];
        }
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

function setPropertyData($property_code, $rowName, $newData)
{
    require "config/config.php";
    $query = "UPDATE property SET $rowName = '$newData' WHERE (property_code = '$property_code')";
    if (mysqli_query($link, $query)) {
        echo '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

function setPropertyDataSafe($username,$rowName,$newData,$dataType){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "UPDATE property SET $rowName = ? WHERE (property_code = ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,$dataType,$newData,$username);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        echo '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

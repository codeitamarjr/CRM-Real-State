<?php

function createUnit($propertyType,$propertyUnits,$propertyName,$propertyAddress,$dataType,$propertyPRSCode){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "INSERT INTO property (property_type, property_units, property_name, property_address, property_prs_code) VALUES ('$propertyType', '$propertyUnits', ?, ?,'$propertyPRSCode')";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,$dataType,$propertyName,$propertyAddress);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        echo '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}
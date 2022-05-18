<?php

function createBill($billings_tenantscod,$billings_property_code,$billings_description,$billings_amount){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "INSERT INTO billings (billings_tenantscod, billings_property_code, billings_description, billings_amount) VALUES (?, ?, ?, ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,"iisd",$billings_tenantscod,$billings_property_code,$billings_description,$billings_amount);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function getBallanceBill($billings_tenantscod,$aditionalQuery){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT SUM(billings_amount) AS balance from billings WHERE billings_tenantscod = $billings_tenantscod $aditionalQuery");
    $row = mysqli_fetch_assoc($result); 
    return $row['balance'];
    mysqli_close($link);
}
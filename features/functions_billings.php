<?php

function createBill($billings_tenantscod,$billings_property_code,$billings_description,$billings_amount,$billings_invoice_date){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "INSERT INTO billings (billings_tenantscod, billings_property_code, billings_description, billings_amount , billings_invoice_date) VALUES (?, ?, ?, ? , ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,"iisds",$billings_tenantscod,$billings_property_code,$billings_description,$billings_amount, $billings_invoice_date);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function setBill($idbillings,$rowName,$newData){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "UPDATE billings SET $rowName = ? WHERE (idbillings = ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,"si",$newData,$idbillings);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function getBill($idbillings,$rowName){
    include "config/config.php";
    $query = "SELECT * FROM billings WHERE (idbillings = '$idbillings')";
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

function getBallanceBill($billings_tenantscod,$aditionalQuery){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT SUM(billings_amount) AS balance from billings WHERE billings_tenantscod = $billings_tenantscod $aditionalQuery");
    $row = mysqli_fetch_assoc($result); 
    return $row['balance'];
    mysqli_close($link);
}

function geNextBill($billings_tenantscod,$rowReturn,$aditionalQuery){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * from billings WHERE billings_tenantscod = $billings_tenantscod $aditionalQuery");
    $row = mysqli_fetch_assoc($result); 
    return $row[$rowReturn];
    mysqli_close($link);
}
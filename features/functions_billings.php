<?php

function createBill($tenantscod,$idunit,$billings_description,$billings_amount,$billings_invoice_date){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "INSERT INTO rent_book (tenantscod, idunit, billings_description, billings_amount , billings_invoice_date) VALUES (?, ?, ?, ? , ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,"iisds",$tenantscod,$idunit,$billings_description,$billings_amount, $billings_invoice_date);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function setBill($idbillings,$rowName,$newData){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "UPDATE rent_book SET $rowName = ? WHERE (idbillings = ?)";
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
    $query = "SELECT * FROM rent_book WHERE (idbillings = '$idbillings')";
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

function getBillByTenant($tenantscod,$billings_description,$rowNameReturn, $extraQuery = ''){
    include "config/config.php";
    $query = "SELECT * FROM rent_book WHERE (tenantscod = $tenantscod) AND (billings_description LIKE '$billings_description') $extraQuery";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$rowNameReturn];
        }
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

function getBallanceBill($billings_tenantscod,$aditionalQuery){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT SUM(billings_amount) AS balance from rent_book WHERE tenantscod = $billings_tenantscod $aditionalQuery");
    $row = mysqli_fetch_assoc($result); 
    if($row['balance'] != NULL){
        return $row['balance'];
    } else {
        return 0;
    }
    mysqli_close($link);
}

function geNextBill($billings_tenantscod,$rowReturn,$aditionalQuery){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * from rent_book WHERE tenantscod = $billings_tenantscod $aditionalQuery");
    $row = mysqli_fetch_assoc($result); 
    return $row[$rowReturn];
    mysqli_close($link);
}
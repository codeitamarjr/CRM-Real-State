<?php
function creditBank($bankSource,$propertyCode,$tenantsCode,$dateTransaction,$bankName, $description,$ammount,$notes='',$status = 'Payment processed by accountant') {
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "INSERT INTO `property_management`.`$bankSource` (`propertyCode`, `tenantsCode`, `dateTransaction`, `bankName`, `description`, `ammount`,`notes`, `user`, `status`) VALUES ( ?, ?, ?, ?, ?, ? , ? , ?, ?);";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,"iisssssis",$propertyCode,$tenantsCode,$dateTransaction,$bankName, $description,$ammount,$notes,$_SESSION['agent_id'],$status);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}
function deleteBankTransaction($id){
    require "config/config.php";
    $sql = "DELETE FROM `property_management`.`bank_transactions` WHERE `bank_transactions`.`id` = ?";
    $stmt = mysqli_stmt_init($link);
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        mysqli_stmt_bind_param($stmt,"i",$id);
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Transaction deleted with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}
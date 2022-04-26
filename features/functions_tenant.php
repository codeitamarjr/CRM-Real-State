<?php
function insertTenantDataSafe($property_code,$status,$move_in,$lease_starts,$lease_term,$lease_expires,$rent,$first_rent,$deposit,$unit_rented_code,$bedrooms,$carpark,$pet,$pet_breed,$dataType){
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data

    $sql = "INSERT INTO tenants (property_code, status, move_in, lease_starts, lease_term, lease_expires, rent, first_rent, deposit, unit_rented_code, bedrooms, carpark, pet, pet_breed)
     VALUES 
    ($property_code, '$status', '$move_in', '$lease_starts', '$lease_term', '$lease_expires', '$rent', '$first_rent', '$deposit', ?, '$bedrooms', '$carpark', '$pet', ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,$dataType,$unit_rented_code,$pet_breed);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        echo '<center><div class="alert alert-success" role="alert">Tenant added with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}
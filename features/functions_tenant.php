<?php
function newTenant($propertyCode, $idunit, $profileID, $leaseStarts, $moveInDate, $leaseTerm)
{
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "INSERT INTO tenant (propertyCode, idunit, profileID)
     VALUES 
    (?, ?, ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt, "iii", $propertyCode, $idunit, $profileID);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        //Create billings for the tenant( Deposit and first rent )
        require_once "features/functions_billings.php";
        require_once "features/functions_tenant.php";
        require_once "features/functions_unit.php";
        $tenantscod = getTenantData($profileID, 'profileID', 'tenantscod');
        // Get deposit from the rent of the unit
        $rent = getUnit($idunit, 'idunit', 'rental_price');
        // Check if the move-in is the first day of the month, if so repeat the deposit for the next month as rent
        if (date('j', strtotime($leaseStarts)) != 1) {
            // Calculate the first rent based on the remaininig days of the month
            // Get the rent per day from the unit rent
            $rentPerDay = ($rent * 12) / 365;
            // Get the last day of the month
            $lastDayOfTheMonth = date("Y-m-t", strtotime($leaseStarts));
            // Diference in days of the move in date and the last day of the month
            $remainingDays = floor((strtotime($lastDayOfTheMonth) - strtotime($leaseStarts)) / (60 * 60 * 24));
            // Multiplies the rent per day by the remaining days of the month
            $firstRent = $rentPerDay * ($remainingDays + 1);
        } else {
            $firstRent = $rent;
        }
        // Convert into time stamp
        strtotime($leaseStarts);

        
        createBill($tenantscod, $idunit, 'First Rent '.date('F',strtotime($leaseStarts)), $firstRent, $leaseStarts);
        createBill($tenantscod, $idunit, 'Deposit '.date('F',strtotime($leaseStarts)), $rent, $leaseStarts);

        // Create a new bill for each month of the lease term until it ends
        // First get the next month
        $next_month =  date('Y-m-d', strtotime($leaseStarts . ' + 1 months'));
        $recurring = 1;
        do {
            createBill($tenantscod, $idunit, 'Rent '.date('F',strtotime($next_month)), $rent, $next_month);
            $next_month =  date('Y-m-d', strtotime($next_month . ' + 1 months'));
            $recurring++;
        } while ($recurring < $leaseTerm);

        return '<center><div class="alert alert-success" role="alert">Tenant, Deposit and First Rent Created!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function getTenantData($data, $rowName, $rowReturn)
{
    require "config/config.php";
    $query = "SELECT $rowReturn FROM tenant WHERE ($rowName = '$data')";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$rowReturn];
        }
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}


function setTenantDataSafe($conditional, $test, $rowName, $newData)
{
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "UPDATE tenant SET $rowName = ? WHERE ($conditional = ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt, "ss", $newData, $test);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Data updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function deleteTenant($tenantscod)
{
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "DELETE FROM tenant WHERE (tenantscod = ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt, "s", $tenantscod);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Tenant deleted with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function totalTenants($property_code, $aditionalQuery)
{
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * FROM tenant WHERE propertyCode = '$property_code' $aditionalQuery");
    $total = mysqli_num_rows($result);
    if ($total == 0) {
        return 0;
    } else {
        return $total;
    }
    mysqli_close($link);
}

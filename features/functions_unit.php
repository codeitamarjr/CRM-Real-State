<?php

function createUnit($prs_code,$property_code, $totalUnits)
{
    require "config/config.php";

    $unit = 1;
    do {
        $query = "INSERT INTO unit (prs_code,property_code) VALUES ('$prs_code','$property_code')";
        if (mysqli_query($link, $query)) {
            echo '<center><div class="alert alert-success" role="alert">Unit #' . $unit . ' created with success!</div></center>';
        } else {
            echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
        }
        $unit++;
    } while ($unit <= $totalUnits);
    mysqli_close($link);
}

function removeUnit($property_code, $totalUnits)
{
    require "config/config.php";
    $query = "DELETE FROM unit WHERE property_code = $property_code ORDER BY idunit DESC LIMIT $totalUnits";
    if (mysqli_query($link, $query)) {
        echo '<center><div class="alert alert-success" role="alert">'.$totalUnits.' Units removed with success!</div></center>';
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }
    mysqli_close($link);
}

function setUnit($idunit, $rowName, $newData)
{
    require "config/config.php";
    //This is a safe way to prevent SQL injection, first add a placeholder ? instead of the real data
    $sql = "UPDATE unit SET $rowName = ? WHERE (idunit = ?)";
    //Start the prepare statement into the DB
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL execute ok from the prepare statement, if so execute it and bind the data
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt, "ss", $newData, $idunit);
        //Run parameters inside DB
        mysqli_stmt_execute($stmt);
        return '<center><div class="alert alert-success" role="alert">Unit #'.$idunit.' updated with success!</div></center>';
    }
    mysqli_stmt_close($stmt);
}

function getUnit($data, $rowName, $rowReturn)
{
    require "config/config.php";
    $query = "SELECT $rowReturn FROM unit WHERE ($rowName = '$data')";
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
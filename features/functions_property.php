<?php

function getPropertyData($property_code, $rowName)
{
    require "config/config.php";
    $query = "SELECT * FROM property WHERE (property_code = '$property_code')";
    $result = mysqli_query($link, $query);
    if (mysqli_query($link, $query)) {
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

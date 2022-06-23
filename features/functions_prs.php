<?php

function getPRSData($PRSCode, $rowName)
{
    include "config/config.php";
    include "../config/config.php";
    $query = "SELECT * FROM estate_agency WHERE (prs_code = '$PRSCode')";
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

function setPRSData($PRSCode, $rowName, $newData)
{
    require "config/config.php";
    $query = "UPDATE estate_agency SET $rowName = '$newData' WHERE (prs_code = '$PRSCode')";
    if (mysqli_query($link, $query)) {
        echo '<center><div class="alert alert-success" role="alert">'. $newData .' updated with success!</div></center>';
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
    }

    mysqli_close($link);
}

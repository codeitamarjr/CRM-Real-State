<?php

function getPRSData($PRSCode,$rowName){
    require "config/config.php";
    $query = "SELECT * FROM prs WHERE (prs_code = '$PRSCode')";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row[$rowName];
    }
    mysqli_close($link);
}

function setPRSData($PRSCode,$rowName,$newData){
    require "config/config.php";
    $query = "UPDATE prs SET $rowName = '$newData' WHERE (prs_code = '$PRSCode')";
    mysqli_query($link, $query);
    mysqli_close($link);
}
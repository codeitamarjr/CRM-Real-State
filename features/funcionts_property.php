<?php

function getPropertyData($property_code,$rowName){
    include "../config/config.php";
    $query = "SELECT * FROM property WHERE (property_code = '$property_code')";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row[$rowName];
    }
    mysqli_close($link);
}
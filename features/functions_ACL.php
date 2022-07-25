<?php

function userACL($pageAccess){
    require "config/config.php";

    // Get the userACLGroupID of the user
    $userACLGroupID = userGetData($_SESSION["username"],"userACLGroupID");

    $query = "SELECT * FROM userACLGroup WHERE (userACLGroupID = '$userACLGroupID')";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$pageAccess];
        }
    } else {
        return false;
    }
    mysqli_close($link);
}

function getUserACL($userACLGroupID,$return){
    require "config/config.php";

    $query = "SELECT * FROM userACLGroup WHERE (userACLGroupID = '$userACLGroupID')";
    $result = mysqli_query($link, $query);
    if ($result) {
        while ($row = mysqli_fetch_array($result)) {
            return $row[$return];
        }
    } else {
        return false;
    }
    mysqli_close($link);
}
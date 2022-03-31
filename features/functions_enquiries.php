<?php

function enquiriesTotal($property_code){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * FROM messages WHERE property_code = '$property_code'");
    return mysqli_num_rows($result);
    mysqli_close($link);
}
function enquiriesQueue($property_code){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * FROM messages WHERE status = 'Queue' AND property_code = '$property_code'");
    return mysqli_num_rows($result);
    mysqli_close($link);
}
function enquiriesApproved(){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * FROM messages WHERE status = 'Approved'");
    return mysqli_num_rows($result);
    mysqli_close($link);
}
function enquiriesDenied(){
    require "config/config.php";
    $result = mysqli_query($link, "SELECT * FROM messages WHERE status = 'Denied'");
    return mysqli_num_rows($result);
    mysqli_close($link);
}





$profile_completed = mysqli_num_rows(mysqli_query($link, "SELECT * FROM prospect WHERE prospect_property_code = $property_code"));
//select all data from the mail_income sql
$query = "SELECT * FROM property WHERE property_code = $property_code";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
    //Creates a loop to loop through results
    $property_name = $row['property_name'];
    $property_address = $row['property_address'];
}

?>
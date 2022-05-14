<?php

//To set data into a username > rowName > newData
function userSetData($username,$rowName,$newData){
    require "config/config.php";
    //Prevent SQL injection
    //Add a placeholder on the real data
    $sql = "UPDATE estate_agent SET $rowName = ? WHERE (agent_email = ?)";
    //Start the prepare statement
    $stmt = mysqli_stmt_init($link);
    //Check if the SQL is ok consulting the DB
    if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "Error SQL Statement Failed!";
    } else {
        //Bind parameters to the placeholder with the right datatype s=String i=integer b=Blob d=Double
        mysqli_stmt_bind_param($stmt,"ss",$newData,$username);
        //Run parametes inside DB
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);
}


//To get data from the agent username > rowName
function userGetData($username,$rowName){
    require "config/config.php";
    //Escape SQL injection
    //$username = $link->real_escape_string($username);
    $query = "SELECT * FROM estate_agent WHERE agent_email = '$username'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row[$rowName];
        mysqli_close($link);
    } 
}

//To get data from the property property_code > rowName
function propertyGetData($property_code,$rowName){
    require "config/config.php";
    //Escape SQL injection
    //$username = $link->real_escape_string($username);
    $query = "SELECT * FROM property WHERE property_code = $property_code";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        return $row[$rowName];
        mysqli_close($link);
    } 
}

function propertySetData($property_code,$rowName,$data){
    require "config/config.php";
    //Escape SQL injection
    $data = $link->real_escape_string($data);
    $query = "UPDATE property SET $rowName = '$data' WHERE (property_code = '$property_code')";
    mysqli_query($link, $query);
    if($link === false){
        die("ERROR: propertySetData. " . mysqli_connect_error());
    }
    mysqli_close($link);
}


//To select a property for the user
function userProperty($agent_prs_code){
    require "config/config.php";
    $query = "SELECT * FROM property WHERE property_prs_code = '$agent_prs_code'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
    return $row['property_code'];
    mysqli_close($link);
}
}

?>
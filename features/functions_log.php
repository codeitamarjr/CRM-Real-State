<?php

function logInsert($property_code,$value,$logTitle){
    echo "Loading logInsert for "+$logTitle;
    require "../config/config.php";
    $sql_query = "INSERT INTO log (property_code, status, source) VALUES ($property_code, $value, '$logTitle');";
    if ($link->query($sql_query) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    mysqli_close($link);
}
function logRetrieve(){

}

function logTimerToDie($property_code,$logTitle,$timeToStopMinutes){
    echo "Loading function logTimerToDie";
    require "../config/config.php";
    $query = "SELECT * FROM log WHERE property_code = $property_code AND source = '$logTitle' AND data > now() - interval $timeToStopMinutes minute;";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
    $data= $row['data'];
    } if(!empty($data)){
        echo 'Script interrupted by timer '.$timeToStopMinutes.' minutes';
        mysqli_close($link);
        die();
}
}

?>

<?php

function logInsert($property_code, $value, $logTitle, $content)
{
    echo "Loading logInsert for " + $logTitle;
    require "../config/config.php";
    $sql_query = "INSERT INTO log (property_code, status, source, content) VALUES ($property_code, $value, '$logTitle','$content');";
    if ($link->query($sql_query) === TRUE) {
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    mysqli_close($link);
}
function logRetrieve()
{
}

function logTimerToDie($property_code, $logTitle, $timeToStopMinutes)
{
    require "../config/config.php";
    $query = "SELECT * FROM log WHERE property_code = $property_code AND source = '$logTitle' AND data > now() - interval $timeToStopMinutes minute;";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        $data = $row['data'];
    }
    if (!empty($data)) {
        return true;
    } else false;
    mysqli_close($link);
}

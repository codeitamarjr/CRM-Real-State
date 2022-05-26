<?php

function logInsert($property_code, $status, $source, $title, $content)
{
    require "../config/config.php";
    $query = "INSERT INTO log (property_code, status, source, title,content) VALUES ('$property_code', '$status', '$source', '$title', '$content')";
    if (mysqli_query($link, $query)) {
        echo '<center><div class="alert alert-success" role="alert">Log updated with success!</div></center>';
    } else {
        echo '<center><div class="alert alert-danger" role="alert">Error: ' . mysqli_error($link) . '</div></center>';
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

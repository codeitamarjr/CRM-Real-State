<?php
/* Database credentials.*/
include __DIR__ . "/settings.php";

/* Attempt to connect to MySQL database */
$link = mysqli_connect($HOST, $USERNAME, $DBPASSWORD, $DBNAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check connection 2
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

<?php
/* Database credentials.*/
include "settings.php";
define('DB_SERVER', $HOST);
define('DB_USERNAME', $USERNAME);
define('DB_PASSWORD', $DBPASSWORD);
define('DB_NAME', $DBNAME);

/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($link === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Check connection 2
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}

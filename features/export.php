<?php  
$HOST = 'localhost';
$USERNAME = 'property_management';
$DBPASSWORD = 'pXf@-2Sw';
$DBNAME = 'property_management';

define('DB_SERVER', $HOST);
define('DB_USERNAME', $USERNAME);
define('DB_PASSWORD', $DBPASSWORD);
define('DB_NAME', $DBNAME);
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$sql = "SELECT message_date,message_sender_name,messages_email,message_phone_number,message_body,status FROM messages";  
$setRec = mysqli_query($link, $sql);  
$columnHeader = "Date Received" . "\t" . "Name" . "\t" . "Email" . "\t". "Phone" . "\t". "Message" . "\t". "Status" . "\t";  
$setData = '';  
  while ($rec = mysqli_fetch_row($setRec)) {  
    $rowData = '';  
    foreach ($rec as $value) {  
        $value = '"' . $value . '"' . "\t";  
        $rowData .= $value;  
    }  
    $setData .= trim($rowData) . "\n";  
}  
  
header("Content-type: application/octet-stream");  
header("Content-Disposition: attachment; filename=CRM_report.xls");  
header("Pragma: no-cache");  
header("Expires: 0");  

echo ucwords($columnHeader) . "\n" . $setData . "\n";
?> 

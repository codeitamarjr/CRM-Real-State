<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Getting Email Script</title>
</head>
<body>
    
</body>
</html>
<?PHP
session_start();
require "../config/settings.php";
require "../config/config.php";
require "../features/functions_log.php";
require "../features/functions_property.php";

//Get the property_code from the Global Session
$property_code = $_SESSION["property_code"];
echo 'Start getting email from property code ' . $property_code . '.<br>';

//Check if the script is already running
if (logTimerToDie($property_code, 'get_email', getPropertyData($property_code, 'getting_email_time'))) {
    echo 'Script is not running for this property code ' . $property_code . '.<br>';
    exit;
} else echo 'Script is running for this property code ' . $property_code . '. Please wait for the script to finish.<br>';

//Saves a log of the script, it'll prevent the script from running again if it's already running
logInsert($property_code, 1, 'get_email','Getting Emails','Start getting email from property code ' . $property_code . '.');

//Load email settings from the property
$property_email_hostname = getPropertyData($property_code, 'property_email_hostname');
$property_email_username = getPropertyData($property_code, 'property_email_username');
$property_email_password = getPropertyData($property_code, 'property_email_password');

/* Email server config based on the property settings collected above*/
$hostname =  '{' . $property_email_hostname . ':993/ssl/novalidate-cert}INBOX';

/* Open the email connection */
$inbox = imap_open($hostname, $property_email_username, $property_email_password) or die('Cannot connect to MAIL SERVER: ' . imap_last_error());

/* Grab emails with subject Enquiry */
//$emails = imap_search($inbox, 'ALL');
//Get all the emails with the word "enquiry" in the subject
$emails = imap_search($inbox, 'SUBJECT "Enquiry"');


/* if emails are returned, cycle through each email... */
if ($emails) {
    /* for each email... */
    foreach ($emails as $singleEmail) {
        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox, $singleEmail, 0);
        $message_raw = $link->real_escape_string(imap_fetchbody($inbox, $singleEmail, 1));
        // Retrieve and collect just new=0 / read=1 emails
        if (($overview[0]->seen) == 1) {
            //Prepare variables from the email to INSERT into the SQL TABLES
            $mail_from = $overview[0]->from;
            $mail_subject =  imap_utf8($overview[0]->subject);
            $date = date_create($overview[0]->date);
            //Parse the date time into the SQL pattern before insert into the SQL
            $mail_date = date_format($date, "Y/m/d H:i:s");

            //Search matches using preg_match() to get the FULL NAME inside the message, if can't find it keep the name from the original mail message
            preg_match("'From:(.*?)=20'si", $message_raw, $message_name);
            if ($message_name) {
                $message_sender_name = $message_name[1];
                $message_sender_name = utf8_decode(imap_utf8($message_sender_name));
                $message_sender_name = trim(quoted_printable_decode($message_sender_name));
            } else
                $message_sender_name = $mail_from;

            //Decode message body from quoted printable
            $mail_message = utf8_decode(imap_utf8($message_raw));
            $mail_message = trim(quoted_printable_decode($mail_message));

            //Get Email:Create a pattern to find an email address
            $pattern_mail = "/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i";
            preg_match($pattern_mail, $mail_message, $matches);
            if ($matches) {
                $email_adress = $matches[0];
            } else $email_adress = $mail_from;


            //Phone Numbers: Looks for numbers with at least 7 numbers for Irish numbers
            $pattern_phone = "/[0-9]+[0-9]{7}/";
            preg_match($pattern_phone, $mail_message, $phone_number);
            $message_phone_number = $phone_number[0];


            //Daft message:
            //Get message inside DAFT.IE email: grab the text after 'Message:' inside the body
            preg_match("'Message:(.*?)\(https://www.daft.ie'si", $message_raw, $message_daft_body_raw);
            //If it find the message inside email will replace the whole message for the small message
            if ($message_daft_body_raw) {
                //Clean the result from TAGS HTMLS and special characters
                $message_daft_body = str_replace("'", "", str_replace("=E2=82=AC", "€", str_replace("=20", "", str_replace("=E2=80=99", "", $message_daft_body_raw[1]))));
                $mail_message_sql = $message_daft_body;
            } else $mail_message_sql = $mail_message;

            //Function to create hash from email
            $message_hash = hash('md5', $email_adress);

            //Get the PRS code from property selected by session
            $messages_prs_code = getPropertyData($property_code, 'property_prs_code');
            //Get the address from the subject(Split by | and get the last part)
            $property_address = strtoupper(end(explode('|',$mail_subject)));

            //Prepared SQL and insert into the SQL
            $sql = "INSERT INTO messages (messages_prs_code, messages_email, message_date, property_address, message_title, message_body, message_from, message_phone_number, message_sender_name, message_hash, property_code)
                VALUES
                (?,?,?,?,?,'$mail_message_sql',?,?,?,?,?);";
            $stmt = mysqli_stmt_init($link);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                echo '<center><div class="alert alert-danger" role="alert">Error SQL Statement Failed: ' . mysqli_stmt_error($stmt) . '</div></center>';
            } else {
                mysqli_stmt_bind_param($stmt, "ssssssssss", $messages_prs_code, $email_adress, $mail_date, $property_address, $mail_subject, $mail_from, $message_phone_number, $message_sender_name, $message_hash, $property_code);
                mysqli_stmt_execute($stmt);
                echo "New record created successfully from $email_adress <br>";
            }
            mysqli_stmt_close($stmt);

            // Changing the email folder to specified folder
            $imapresult = imap_mail_move($inbox, $singleEmail, 'CRM');
            // if ($imapresult == false) {
            //     die(imap_last_error());
            // }

            //--Sending the automatic welcome mail--
        }
    }
    // Saves a log for a success retrieving emails
    logInsert($property_code, 1, 'get_email','Getting Emails','Finished getting email from property code ' . $property_code . '.');
}
/* close the connection */
imap_close($inbox);

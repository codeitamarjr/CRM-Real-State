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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require "../config/config.php";
require __DIR__ . "/functions_log.php";
require __DIR__ . "/functions_property.php";
require __DIR__ . "/functions_automail.php";
require __DIR__ . "/functions_prs.php";

//Get the property_code from the Global Session
$property_code = 3;

//Count the number of emails sent
$countEmail = 0;

//Check if the script is already running
// if (logTimerToDie($property_code, 'gettingEmail', getPropertyData($property_code, 'getting_email_time'))) {
//     echo 'Script is not running for this property code ' . $property_code . '.<br>';
//     exit;
// } else echo 'Script is running for this property code ' . $property_code . '. Please wait for the script to finish.<br>';

//Saves a log of the script, it'll prevent the script from running again if it's already running
logInsert('System', 0, 'gettingEmail', 'Getting Emails', 'Start getting email script.');

//Load email settings from the property
$IMAPHost = getPropertyData($property_code, 'IMAPHost');
$IMAPProtocol = getPropertyData($property_code, 'IMAPProtocol');
$IMAPPort = getPropertyData($property_code, 'IMAPPort');
$IMAPUser = getPropertyData($property_code, 'IMAPUser');
$IMAPPassword = getPropertyData($property_code, 'IMAPPassword');

/* Email server config based on the property settings collected above*/
$hostname =  '{' . $IMAPHost . ':' . $IMAPPort . '/' . $IMAPProtocol . '/novalidate-cert}INBOX';

/* Open the email connection */
$inbox = imap_open($hostname, $IMAPUser, $IMAPPassword) or die('Cannot connect to MAIL SERVER: ' . imap_last_error());

/* Grab emails with subject Enquiry */
//$emails = imap_search($inbox, 'ALL');
//Get all the emails with the word "enquiry" in the subject
$emails = imap_search($inbox, 'SUBJECT "Enquiry"');

$newEnquiries = (array) null;

/* if emails are returned, cycle through each email... */
if ($emails) {
    /* for each email... */
    foreach ($emails as $singleEmail) {

        /* get information specific to this email */
        $overview = imap_fetch_overview($inbox, $singleEmail, 0);
        //$message_raw = $link->real_escape_string(imap_fetchbody($inbox, $singleEmail, 1));
        $message_raw = htmlspecialchars(imap_qprint(imap_fetchbody($inbox, $singleEmail, 1)));

        // Retrieve and collect just new=0 / read=1 emails
        if (($overview[0]->seen) == 1) {
            //Prepare variables from the email to INSERT into the SQL TABLES
            $mail_from = $overview[0]->from;
            $mail_subject =  imap_utf8($overview[0]->subject);
            $date = date_create($overview[0]->date);
            //Parse the date time into the SQL pattern before insert into the SQL
            $mail_date = date_format($date, "Y/m/d H:i:s");

            //Search matches using preg_match() to get the FULL NAME inside the message, if can't find it keep the name from the original mail message
            preg_match("'Enquiry from(.*?)on Daft.ie'", $message_raw, $message_name);
            if ($message_name) {
                $message_sender_name = $message_name[1];
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
            
            //Get the address from the subject(Split by | and get the last part)
            $property_address = trim(end(explode('|', $mail_subject)));
            //Get the property_code from the enquirie address title
            $property_code = getPropertyDataConditional('property_address', $property_address, 'property_code');
            //Get the PRS code from property selected by session
            $messages_prs_code = getPropertyData($property_code, 'property_prs_code');

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
                echo "New enquiry created successfully for $email_adress <br>";
            }
            mysqli_stmt_close($stmt);

            array_push($newEnquiries, $email_adress);
        }
    }
    // Saves a log for a success retrieving emails
    logInsert($property_code, 1, 'gettingEmail', 'Getting Emails', 'Finished getting email from property code ' . $property_code . '.');
}
/* close the connection */
imap_close($inbox);

print_r($newEnquiries );

foreach ($newEnquiries as $email) {
   
    //Send welcome email to the new enquiries

    //Load message template
    //select message from automail_id
    $query = "SELECT * FROM automail WHERE prs_code = '$property_code' AND automail_autosender = 'welcome'";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        //Creates a loop to loop through results
        $message = $row['automail_message'];
        $subject = $row['automail_title'];
        $automail_id = $row['automail_id'];
    }
   

    require_once __DIR__ . '/PHPMailer/src/Exception.php';
    require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
    require_once __DIR__ . '/PHPMailer/src/SMTP.php';
    //Load email settings from DB
    $query = "SELECT * FROM property WHERE property_code = $property_code";
    $result = mysqli_query($link, $query);
    while ($row = mysqli_fetch_array($result)) {
        //Creates a loop to loop through results
        $property_code = $row['property_code'];
        $sender = $row['SMTPSender'];
        $senderName = $row['SMTPSenderName'];
        $usernameSmtp = $row['SMTPUser'];
        $passwordSmtp = $row['SMTPPassword'];
        $host = $row['SMTPHost'];
        $port = $row['SMTPPort'];
        $passwordSmtp = $row['SMTPPassword'];
    }
    $bodyText =  "Email Test\r\nThis email was sent through the Amazon SES SMTP interface.";
    
    
    $message = str_replace('%propertyName%', getPropertyData($property_code,'property_name') , $message);
    $message = str_replace('%propertyOfficeName%', getPropertyData($property_code,'office_name') , $message);
    $message = str_replace('%propertyOfficePhone%', getPropertyData($property_code,'office_phone') , $message);
    $message = str_replace('%PropertyOfficeEmail%', getPropertyData($property_code,'office_email') , $message);
    $message = str_replace('%PropertyOfficeAddress%', getPropertyData($property_code,'office_address') , $message);
    $message = str_replace('%prospectName%', $message_sender_name , $message);
    $message = str_replace('%prospectEmail%', $email, $message); 
    $base_mail = getAutomail($automail_id,'automail_website');
    $message = str_replace('%link%', ''.$base_mail.'/prospect_area.php?propertyCode='.$property_code.'', $message);
    $message = str_replace('%prsName%', getPRSData(getPropertyData($property_code,'property_prs_code'),'prs_name') , $message);
    $message = str_replace('%prsPhone%', getPRSData(getPropertyData($property_code,'property_prs_code'),'prs_phone') , $message);
    $message = str_replace('%prsEmail%', getPRSData(getPropertyData($property_code,'property_prs_code'),'prs_email') , $message);
    $message = str_replace('%prsAddress%', getPRSData(getPropertyData($property_code,'property_prs_code'),'prs_full_address') , $message);
    $message = str_replace('%prsLogo%', $base_mail . '/features/uploads/' . getPRSData(getPropertyData($property_code,'property_prs_code'),'prs_logo') , $message);
    $message = str_replace('%propertyLogo%', $base_mail . '/features/uploads/' . getPropertyData($property_code,'property_logo') , $message);
    echo $message;

    $bodyHtml = '' . $message . '';

    
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->setFrom($sender, $senderName);
        $mail->Username   = $usernameSmtp;
        $mail->Password   = $passwordSmtp;
        $mail->Host       = $host;
        $mail->Port       = $port;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = 'tls';
        $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
        $mail->addAddress($email_adress, $message_sender_name);
        $mail->isHTML(true);
        $mail->Subject    = $subject;
        $mail->Body       = $bodyHtml;
        $mail->AltBody    = $bodyText;
        $mail->Send();
        echo "Welcome email sent to ".$email, PHP_EOL;
        $countEmail++;
        $mail->clearAllRecipients();
    } catch (phpmailerException $e) {
        echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
    } catch (Exception $e) {
        echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
    }

    echo '<br>'.$countEmail;
    

}
if($countEmail > 0){
    // Saves a log for a success fetching emails
    logInsert('System', 1, 'gettingEmail', 'Getting Emails', 'Emails collected: ' . $countEmail);
}


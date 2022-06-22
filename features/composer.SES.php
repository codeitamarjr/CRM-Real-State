<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

require "config/config.php";
//Load email settings from DB
$property_code = $_SESSION["property_code"];
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

// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
//$sender = '';
//$senderName = '';

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
$recipient = 'contact@realenquiries.com';

// Replace smtp_username with your Amazon SES SMTP user name.
//$usernameSmtp = '';

// Replace smtp_password with your Amazon SES SMTP password.
//$passwordSmtp = '';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
//$host = '';
//$port = ;

// The subject line of the email
//$subject = 'Amazon SES test (SMTP interface accessed using PHP)';

// The plain-text body of the email
$bodyText =  "Email Test\r\nThis email was sent through the
    Amazon SES SMTP interface.";

// The HTML-formatted body of the email
$bodyHtml = ''.$message.'';

$mail = new PHPMailer(true);

try {
    // Specify the SMTP settings.
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output

    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
    $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);

    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.

    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    $mail->AltBody    = $bodyText;
    $mail->Send();
    echo "Email sent!" , PHP_EOL;
}
 catch (phpmailerException $e) {
     echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
 }
 catch (Exception $e) {
    echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
}



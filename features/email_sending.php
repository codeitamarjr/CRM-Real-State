<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/PHPMailer/src/Exception.php';
require_once __DIR__ . '/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/src/SMTP.php';

// passing true in constructor enables exceptions in PHPMailer
$mail = new PHPMailer(true);

//Load email settings from DB
$property_code = $_SESSION["property_code"];
$query = "SELECT * FROM property WHERE property_code = $property_code";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
    //Creates a loop to loop through results
    $property_code = $row['property_code'];
    $property_email_hostname = $row['property_email_hostname'];
    $property_email_username = $row['property_email_username'];
    $property_email_password = $row['property_email_password'];
}

try {
    // Server settings
    //$mail->SMTPDebug = SMTP::DEBUG_SERVER; // for detailed debug output
    $mail->isSMTP();
    $mail->Host = $property_email_hostname ;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = $property_email_username; // Username from DB
    $mail->Password = $property_email_password; // Password from DB

    // Sender and recipient settings
    $mail->setFrom($property_email_username, 'Real Enquiries'); //From
    $mail->addAddress($email_adress, $message_sender_name); // To
    $mail->addReplyTo($property_email_username, 'Real Enquiries'); // to set the reply to

    // Setting the email content
    $mail->IsHTML(true);
    $mail->Subject = $subject;
    $mail->Body = ''.$message.'';
    $mail->AltBody = 'This message was design for HTML content.';

    $mail->send();
    echo '<h1><span style="color: #339966;"><center>Email message sent with success.</center></span></h1>';
} catch (Exception $e) {
    echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
}
mysqli_close($link);
?>
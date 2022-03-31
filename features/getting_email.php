<?PHP
session_start();
 require "../config/settings.php";
 require "../config/config.php";
 require "functions_log.php";
 require "functions_automail.php";
$property_code = $_SESSION["property_code"];

//Get 'getting_email_time' from the DB
$getting_email_time =  getAutomailExternal($property_code, 'getting_email_time');

//Check last time script run and continues to run if the time is after the interval in minutes setted by the user
logTimerToDie($property_code,'getting_email',$getting_email_time);

// Saves a log for with 0 to prevent refresh page and double request
logInsert($property_code,0,'getting_email');

//Load email settings from the property
$query = "SELECT * FROM property WHERE property_code = $property_code";
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
    $property_code = $row['property_code'];
    $property_email_hostname = $row['property_email_hostname'];
    $property_email_username = $row['property_email_username'];
    $property_email_password = $row['property_email_password'];
}


    /* Email server config based on the property settings defined before*/
    $hostname =  '{'.$property_email_hostname.':993/ssl/novalidate-cert}INBOX';
    /* Open the email connection */
    $inbox = imap_open($hostname, $property_email_username, $property_email_password) or die('Cannot connect to MAIL SERVER: ' . imap_last_error());

    /* Grab emails */
    $emails = imap_search($inbox, 'ALL');

    /* if emails are returned, cycle through each email... */
    if ($emails) {
        /* for each email... */
        foreach ($emails as $email_number) {

            /* get information specific to this email */
            $overview = imap_fetch_overview($inbox, $email_number, 0);
            $message_raw = $link->real_escape_string(imap_fetchbody($inbox, $email_number, 1));

            // Retrieve and collect just new=0 / read=1 emails
            if (($overview[0]->seen) == 0) {
                //Prepare variables from the email to INSERT into the SQL TABLES
                $mail_from = $overview[0]->from;
                $mail_subject =  $overview[0]->subject;
                $date=date_create($overview[0]->date);//Parse the date time into the SQL pattern before insert into the SQL
                $mail_date = date_format($date,"Y/m/d H:i:s");

                //Search matches using preg_match() to get the FULL NAME inside the message, if can't find it keep the from name from the original mail message
                preg_match("'From:(.*?)=20'si", $message_raw, $message_name);
                if($message_name) {
                    $message_sender_name = $message_name[1];
                } else 
                    $message_sender_name=$mail_from;

                //Clearn messafe replace for =E2=82=AC for €
                //remove ' to not break the SQL INSERT
                $mail_message =  str_replace("=E2=82=AC", "€", str_replace("=20", "", $message_raw));

                //Get Email:Create a pattern to find an email address
                $pattern_mail = "/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i";
                preg_match($pattern_mail, $mail_message, $matches);
                if($matches){
                    $email_adress = $matches[0];
                } else $email_adress=$mail_from;
                

                //Phone Numbers: Looks for numbers with at least 7 numbers for Irish numbers
                $pattern_phone = "/[0-9]+[0-9]{7}/";
                preg_match($pattern_phone, $mail_message, $phone_number);
                $message_phone_number = $phone_number[0];


                //Daft message:
                //Get message inside DAFT.IE email: grab the text after 'Message:' inside the body
                preg_match("'Message:(.*?)\(https://www.daft.ie'si", $message_raw, $message_daft_body_raw);
                //If it find the message inside email will replace the whole message for the small message
                if ($message_daft_body_raw){
                    //Clean the result from TAGS HTMLS and special characters
                    $message_daft_body = str_replace("'", "", str_replace("=E2=82=AC", "€", str_replace("=20", "", str_replace("=E2=80=99", "", $message_daft_body_raw[1]))));
                    $mail_message_sql=$message_daft_body;
                }  else $mail_message_sql = $mail_message;

                //Function to create hash from email
                $message_hash = hash('md5', $email_adress);

                //Create SQL_QUERY to insert
                $sql_query = "INSERT INTO messages (messages_email, message_date, message_title, message_body, message_from, message_phone_number, message_sender_name, message_hash, property_code)
                VALUES
                ('$email_adress', '$mail_date', '$mail_subject', '$mail_message_sql', '$mail_from','$message_phone_number','$message_sender_name','$message_hash',$property_code);
                ";

                //Insert and show the result
                if ($link->query($sql_query) === TRUE) {
                    echo "<hr><br>New record created successfully from $email_adress <br><hr>";
                } else {
                    echo "Error email: " . $sql . "<br>" . $link->error;
                }

                //--Sending the automatic welcome mail--
                //Fisrt check if the property settings allows it to send the automail welcome message for the new enquiry:
                $getting_automail_option_welcome =  getAutomailExternal($property_code, 'automail_new');
                if($getting_automail_option_welcome==1){
                   
                //Set the variables to load into the message
                $key = $message_hash;
                $prospect_name = $message_sender_name;

                include 'automail_generated_messsage_3.php';
                $subject = ''.getAutomailTitle(3).'';
                
                // $message_automail = emailPrintMessage($property_name,$email_adress,3);
                // $Title = "Automail";
                // $uniqid="tmp".date("d-m-Y h-i-s").'_'.$Title."_".uniqid().".php";    
                // $file = fopen($uniqid,"w");
                // fwrite($file,"<?php \r\n \$message = '$message_automail';");
                // fclose($file); 
                // include $uniqid;

                // > Send email to the user with the messate included before
                require 'email_sending.php';
                } 
            }
        }
            // Saves a log for a success retrieving emails
            logInsert($property_code,1,'getting_email');
    }
    /* close the connection */
    imap_close($inbox);
?>

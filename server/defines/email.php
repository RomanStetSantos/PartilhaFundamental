<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
require '../settings/readsettings.php';

$smtpsettings = readsettings("smtp.txt", 4);

function SMTP($to, $from, $content) {
    try {
        //Server settings
        if ($smtpsettings["debug"] == "true") {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;  
        }
        else {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;  
        }
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $smtpsettings["host"];                  //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $smtpsettings["username"];              //SMTP username
        $mail->Password   = $smtpsettings["password"];              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = $smtpsettings["port"];                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($to["email"], $to["name"]);
        for ($i = 0; $i<=count($from); $i++) {
            $mail -> addAddress($from[$i]["email"], $from[$i]["name"]);
        }

        //Attachments
        $mail->addAttachment($content["imageurl"], $content["imagename"]);    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $content["subject"];
        $mail->Body    = $content["body"];
        $mail->AltBody = $content["altbody"];

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

?>

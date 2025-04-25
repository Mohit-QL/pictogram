<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendCode($to, $subject, $code)
{
    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Or use DEBUG_SERVER for debugging
        $mail->isSMTP();
        $mail->Host       = 'smtp.hostinger.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mohit.m@queueloopsolutions.com'; // ✅ Correct sender email
        $mail->Password   = 'z2V^14Q*#gYi';                   // ✅ SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('mohit.m@queueloopsolutions.com', 'Pictogram');
        $mail->addAddress($to); // ✅ Send to the user, not hardcoded

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = 'Your Verification Code is: <b>' . $code . '</b>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

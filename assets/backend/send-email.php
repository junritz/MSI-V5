<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer includes
require '../../vendor/phpmailer/phpmailer/src/Exception.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';


function sendEmail($to, $subject, $body, $altBody = '', $attachment = null)
{
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'smtp.gmail.com';
        $mail->Username = $_ENV['MAIL_USERNAME'];
        $mail->Password = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom($_ENV['MAIL_USERNAME'], 'Macromedia Notification');
        $mail->addAddress($to);
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->AltBody = $altBody;

        if ($attachment) {
            $mail->addEmbeddedImage($attachment['path'], $attachment['cid']);
        }

        $mail->send();
        return 'Message has been sent';
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $mail->ErrorInfo);
        return 'Mailer Error: ' . $mail->ErrorInfo;
    }
}

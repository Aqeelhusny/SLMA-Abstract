<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


class EmailService
{


    public function __construct()
    {
    }

    public static function sendEmail(String $subject, String $body, $recipents = array())
    {
        $mail = new PHPMailer(true);

        //Server settings
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'companysf6@gmail.com';
        $mail->Password   = 'ddduxwdxgwoqalro';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        $mail->From = "companysf6@gmail.com";

        //Recipients
        $mail->setFrom('companysf6@gmail.com', 'SLMA');
        foreach ($recipents["emails"] as $email) {
            $mail->addAddress($email);
        }
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->send();
    }
}

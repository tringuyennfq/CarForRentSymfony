<?php

namespace App\Service;

use App\Traits\JsonResponseTrait;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class MailService
{
    private $host;
    private $username;
    private $password;
    private $port;
    private $name;

    public function __construct($host, $username, $password, $port, $name)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->port = $port;
        $this->name = $name;
    }

    /**
     * @throws Exception
     */
    public function sendMail(string $recipientMail)
    {
        $mail = new PHPMailer(true);
        //Server settings
//        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = $this->host;                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = $this->username;                     //SMTP username
        $mail->Password = $this->password;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = $this->port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($this->username, $this->name);
//            $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
        $mail->addAddress($recipientMail);               //Name is optional
//            $mail->addReplyTo('info@example.com', 'Information');
//            $mail->addCC('cc@example.com');
//            $mail->addBCC('bcc@example.com');

        //Attachments
//            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Hello '. $recipientMail;
        $mail->Body = "Hello  <b>$recipientMail</b>";
        $mail->AltBody = "Hello  $recipientMail";
        $mail->send();
        return [
            'recipient' => $recipientMail,
            'subject' => $mail->Subject,
            'body' => $mail->Body
        ];
    }
}

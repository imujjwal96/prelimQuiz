<?php

namespace PQ\Core;


class Mail
{
    private $Config;
    private $error;

    public function __construct()
    {
        $this->Config = new Config();
    }

    public function withPHPMailer($user_email, $from_email, $from_name, $subject, $body)
    {
        $mail = new \PHPMailer;

        $mail->CharSet = 'UTF-8';
        if ($this->Config->get('EMAIL_USE_SMTP')) {
            $mail->IsSMTP();
            $mail->SMTPDebug = 0;
            $mail->SMTPAuth = $this->Config->get('EMAIL_SMTP_AUTH');
            // encryption
            if ($this->Config->get('EMAIL_SMTP_ENCRYPTION')) {
                $mail->SMTPSecure = $this->Config->get('EMAIL_SMTP_ENCRYPTION');
            }
            $mail->Host = $this->Config->get('EMAIL_SMTP_HOST');
            $mail->Username = $this->Config->get('EMAIL_SMTP_USERNAME');
            $mail->Password = $this->Config->get('EMAIL_SMTP_PASSWORD');
            $mail->Port = $this->Config->get('EMAIL_SMTP_PORT');
        } else {
            $mail->IsMail();
        }

        $mail->From = $from_email;
        $mail->FromName = $from_name;
        $mail->AddAddress($user_email);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $wasSendingSuccessful = $mail->Send();
        if ($wasSendingSuccessful) {
            return true;
        } else {
            $this->error = $mail->ErrorInfo;
            return false;
        }
    }

    public function sendMail($user_email, $from_email, $from_name, $subject, $body)
    {
        if ($this->Config->get('ENABLE_MAIL')) {
            if ($this->Config->get('EMAIL_USED_MAILER') === 'phpmailer') {
                return $this->withPHPMailer(
                    $user_email, $from_email, $from_name, $subject, $body
                );
            }
        }
    }

    public function getError()
    {
        return $this->error;
    }
}
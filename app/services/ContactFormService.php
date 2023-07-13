<?php

namespace App\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ContactFormService
{
    private $name;
    private $email;
    private $age;
    private $message;

    public function setData($name, $email, $age, $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->age = $age;
        $this->message = $message;
    }

    public function validForm()
    {
        if (strlen($this->name) < 3) {
            return "Имя слишком короткое";
        } elseif (strlen($this->email) < 3) {
            return "Email слишком короткий";
        } elseif (!is_numeric($this->age) || $this->age <= 0 || $this->age > 90) {
            return "Вы ввели не возраст";
        } elseif (strlen($this->message) < 5) {
            return "Сообщение слишком короткое";
        } else {
            return "Верно";
        }
    }

    public function mail()
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.sendgrid.net';
            $mail->SMTPAuth = true;
            $mail->Username = 'apikey';
            $mail->Password = 'apikey';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
            $mail->CharSet = 'UTF-8';

            $mail->setFrom($this->email, $this->name);
            $mail->addAddress('reugenemarkov@gmail.com', 'Евгений Марков');

            $mail->Subject = 'Сообщение с сайта';
            $message = 'Имя: ' . $this->name . ' Возраст: ' . $this->age . '. Сообщение: ' . $this->message;
            $mail->Body = $message;

            $mail->send();
            return 'Письмо успешно отправлено!';
        } catch (Exception $e) {
            return "Сообщение не было отправлено!<br>Причина: " . $mail->ErrorInfo;
        }
    }
}

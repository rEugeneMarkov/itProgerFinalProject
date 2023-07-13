<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\ContactFormService;

class ContactController extends Controller
{
    public function index()
    {
        $data = [];
        if (isset($_POST['name'])) {
            $mail = new ContactFormService();
            $mail->setData($_POST['name'], $_POST['email'], $_POST['age'], $_POST['message']);

            $isValid = $mail->validForm();
            if ($isValid == "Верно") {
                $data['message'] = $mail->mail();
            } else {
                $data['message'] = $isValid;
            }
        }

        $this->view('contact/index', $data);
    }

    public function about($param = '')
    {
        $this->view('contact/about', ['param' => $param]);
    }
}

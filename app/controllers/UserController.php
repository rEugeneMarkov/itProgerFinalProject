<?php

namespace App\Controllers;

use App\Core\Controller;

class UserController extends Controller
{
    public function index()
    {

        $user = $this->model('User');
        $data = $user->getUser();
        if (isset($_POST['exit_btn'])) {
            $user->logOut();
            exit();
        }

        $this->view('user/index', $data);
    }

    public function auth()
    {

        $data = [];
        if (isset($_POST['login'])) {
            $user = $this->model('User');
            $data['message'] = $user->auth($_POST['login'], $_POST['pass']);
        }

        $this->view('user/auth', $data);
    }
}

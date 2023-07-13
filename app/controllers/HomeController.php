<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Services\HomeFormService;

class HomeController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = new HomeFormService();
    }

    public function index()
    {
        $data = [];
        $user = $this->model('User');
        $link = $this->model('Link');

        if (isset($_POST['email'])) {
            $data['message'] = $this->service->regform($user, $_POST);
        }

        if (isset($_POST['link'])) {
            $data['message'] = $this->service->linkform($user, $link, $_POST);
        }

        $data['links'] = $link->getUserLinks($user->getUser()->id);
        $this->view('home/index', $data);
    }

    public function delete()
    {
        $link = $this->model('Link');
        $link->delete($_POST['id']);
        header('Location: /');
    }
}

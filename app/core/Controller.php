<?php

namespace App\Core;

class Controller
{
    protected function model($model)
    {
        $model = '\App\Models\\' . $model;
        return new $model();
    }

    protected function view($view = '', $data = [])
    {
        require_once 'app/views/' . $view . '.php';
    }
}

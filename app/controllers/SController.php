<?php

namespace App\Controllers;

use App\Core\App;
use App\Core\Controller;

class SController extends Controller
{
    public function index($shortLink = '')
    {
        $link = $this->model('Link');
        if ($link->checkShortLink($shortLink)) {
            $link = $link->getLink($shortLink);
            header("Location: " . $link->link);
        } else {
            App::pageNotFound();
        }
    }
}

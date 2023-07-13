<?php

namespace App\Services;

class HomeFormService
{
    public function regform($user, $request)
    {
        $user->setData($request['email'], $request['login'], $request['pass']);
        $isValid = $user->validForm();
        if ($isValid == "Верно") {
            $user->addUser();
            header('Location: /user');
        } else {
            return $isValid;
        }
    }

    public function linkform($user, $link, $request)
    {
        $userId = $user->getUser()->id;
        $link->setData($request['link'], $request['short_link'], $userId);
        $isValid = $link->validForm();
        if ($isValid == "Верно") {
            $link->addLink();
            header('Location: /');
        } else {
            return $isValid;
        }
    }
}

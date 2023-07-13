<?php

namespace App\Models;

use App\Models\DB;

class User
{
    private $login;
    private $email;
    private $pass;

    private $db = null;

    public function __construct()
    {
        $this->db = DB::getInstence();
    }

    public function setData($email, $login, $pass)
    {
        $this->email = $email;
        $this->login = $login;
        $this->pass = $pass;
    }

    public function validForm()
    {
        if (strlen($this->email) < 3) {
            return "Email слишком короткий";
        } elseif (strlen($this->login) < 3) {
            return "Логин слишком короткий";
        } elseif ($this->checkLogin($this->login)) {
            return "Пользователь с таким логином уже существует";
        } elseif (strlen($this->pass) < 3) {
            return "Пароль не менее 3 символов";
        } else {
            return "Верно";
        }
    }

    public function checkLogin($login)
    {
        $sql = "SELECT COUNT(*) FROM users WHERE login = :login";
        $query = $this->db->prepare($sql);
        $query->execute(['login' => $login]);

        $count = $query->fetchColumn();

        if ($count > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addUser()
    {
        $sql = 'INSERT INTO users(login, email, pass) VALUES(:login, :email, :pass)';
        $query = $this->db->prepare($sql);

        $pass = password_hash($this->pass, PASSWORD_DEFAULT);
        $query->execute(['login' => $this->login, 'email' => $this->email, 'pass' => $pass]);

        $this->setAuth($this->login);
    }

    public function getUser()
    {
        $login = $_COOKIE['login'];
        $result = $this->db->query("SELECT * FROM `users` WHERE `login` = '$login'");
        return $result->fetch(\PDO::FETCH_OBJ);
    }

    public function logOut()
    {
        setcookie('login', $this->email, time() - 3600, '/');
        unset($_COOKIE['login']);
        header('Location: /user/auth');
    }

    public function auth($login, $pass)
    {
        $result = $this->db->query("SELECT * FROM `users` WHERE `login` = '$login'");
        $user = $result->fetch(\PDO::FETCH_ASSOC);

        if ($user['login'] == '') {
            return 'Пользователя с таким логином не существует';
        } elseif (password_verify($pass, $user['pass'])) {
            $this->setAuth($login);
        } else {
            return 'Пароли не совпадают';
        }
    }

    public function setAuth($login)
    {
        setcookie('login', $login, time() + 3600, '/');
        header('Location: /user');
    }
}

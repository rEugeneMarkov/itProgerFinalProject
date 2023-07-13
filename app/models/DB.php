<?php

namespace App\Models;

class DB
{
    private static $db = null;

    public static function getInstence()
    {
        if (self::$db == null) {
            self::$db = new \PDO('mysql:host=localhost;dbname=urlshortener', 'root', 'root');
        }

        return self::$db;
    }

    private function __construct()
    {
    }
    private function __clone()
    {
    }
    private function __wakeup()
    {
    }
}

<?php

namespace App\Core;

use ReflectionMethod;

class App
{
    protected $controller = 'Home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();
        if (isset($url[0])) {
            if (file_exists('app/controllers/' . ucfirst($url[0]) . 'Controller.php')) {
                $this->controller = ucfirst($url[0]);
                unset($url[0]);
            } else {
                self::pageNotFound();
            }
        }


        $controllerClassName = '\App\Controllers\\' . $this->controller . 'Controller';
        $this->controller = new $controllerClassName();

        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = $url ? array_values($url) : [];

        $paramsCount = count($this->params);
        $countOfMethodParams = $this->hasMethodParams();

        if ($paramsCount > 0 && !$countOfMethodParams || $paramsCount > $countOfMethodParams) {
            self::pageNotFound();
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl()
    {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(
                rtrim($_GET['url'], '/'),
                FILTER_SANITIZE_STRING
            ));
        }
    }

    public static function pageNotFound()
    {
        $redirectUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/404.php';

        header("HTTP/1.0 404 Not Found");
        header("Location: " . $redirectUrl);
        exit();
    }

    public function hasMethodParams()
    {
        $reflectionMethod = new ReflectionMethod($this->controller, $this->method);
        $parameters = $reflectionMethod->getParameters();
        return count($parameters);
    }
}

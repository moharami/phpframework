<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    protected Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }


    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes['get'][$path] ?? false;

        if ($callback === false) {
            echo 'Not Found';
            exit;
        }
        if (is_string($callback)){
            return $this->renderView($callback);
        }
        echo call_user_func($callback);
    }

    private function renderView($view)
    {
        $path = __DIR__ . "/../views/$view.php";
        include_once $path;
    }
}


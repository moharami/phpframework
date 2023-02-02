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
        if (is_string($callback)) {
            return $this->renderView($callback);
        }
        echo call_user_func($callback);
    }

    private function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        $ViewContent = $this->renderOnlyView($view);
        return str_replace('{{content}}', $ViewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$RootDir . "/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view)
    {
        ob_start();
        include_once Application::$RootDir . "/views/$view.php";
        return ob_get_clean();
    }

}


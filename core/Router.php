<?php

namespace app\core;

class Router
{
    protected array $routes = [];
    protected Request $request;
    protected Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setStatusCode(404);
            return $this->renderView(404);
        }
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        echo call_user_func($callback);
    }

    public function renderView($view, $params=[])
    {
        $layoutContent = $this->layoutContent();
        $ViewContent = $this->renderOnlyView($view, $params);
        return str_replace('{{content}}', $ViewContent, $layoutContent);
    }

    private function renderContent($ViewContent)
    {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $ViewContent, $layoutContent);
    }

    protected function layoutContent()
    {
        ob_start();
        include_once Application::$RootDir . "/views/layouts/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view, $params = [])
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$RootDir . "/views/$view.php";
        return ob_get_clean();
    }

    public function post(string $path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }


}



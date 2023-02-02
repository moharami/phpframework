<?php

namespace app\core;


class Application
{

    public static string $RootDir;
    public Router $router;

    public function __construct($rootPath)
    {
        self::$RootDir = $rootPath;
        $this->router = new Router();
    }

    public function run()
    {
        echo $this->router->resolve();
    }

}
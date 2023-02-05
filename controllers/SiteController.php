<?php

namespace app\controllers;


use app\core\Application;

class SiteController
{
    public function home()
    {
        $params = [
            'name' => 'amir'
        ];
        return Application::$app->router->renderView('home', $params);

    }

    public function Contact()
    {
        return Application::$app->router->renderView('contact');
    }

    public function handleContact()
    {
        return "handling submitted data";
    }
}
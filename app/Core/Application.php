<?php


namespace App\Core;

class Application
{
    public Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function run()
    {
        echo $this->router->resolve();
    }

}
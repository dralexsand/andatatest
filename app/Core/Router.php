<?php


namespace App\Core;

use App\Controllers\NotFoundController;

class Router
{
    protected array $routes = [];
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            $callback = [NotFoundController::class, 'index'];
        }

        return $this->getAction($callback);
    }

    public function getAction(array $callback)
    {
        $controller = $callback[0];
        $method = $callback[1];

        return (new $controller)->{$method}($this->request->getArgs());
    }

}
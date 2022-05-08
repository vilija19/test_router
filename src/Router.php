<?php

namespace Vilija19\router;


class router implements \Aigletter\Contracts\Routing\RouteInterface
{
    protected $routes;
    protected $uri;
    protected $controller;
    protected $method;

    protected function getActionByRoute()
    {
        if (!isset($this->routes[$this->uri])) {
            throw new \Exception("Error. Route not found", 1);
        }

        if ($this->uri === '/') {
            $this->controller = $this->routes[$this->uri];
            $this->method = 'index';
        } else {
            $segments = explode("/", $this->uri);

            array_shift($segments);

            if (count($segments)< 2) {
                throw new \Exception("Error. Must be at least two parameters in route", 1);
            }

            $this->controller = $segments[0];
            $this->method     = $segments[1];
        }
    }

    public function route(string $uri): callable
    {
        $this->uri = $uri;

        $this->getActionByRoute();

        if (method_exists($this->controller, $this->method)) {
            return function () {
                return call_user_func([$this->controller, $this->method]);
            };
        }

        throw new \Exception("Error. Controller or method is not exists", 1);
    }

    public function addRoute(string $path, $action)
    {
        if ($path && $action) {
            $this->routes[$path] = $action;
        }
    }

}
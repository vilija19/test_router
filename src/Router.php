<?php

namespace Vilija19\Router;


class Router implements \Aigletter\Contracts\Routing\RouteInterface
{
    protected $routes;
    protected $uri;

    public function route(string $uri): callable
    {
        $this->uri = $uri;

        if ($uri === '/') {
            // Do nothing
            exit;
        } elseif (isset($this->routes[$uri])) {

            return function () { 
                return call_user_func($this->routes[$this->uri]);
            };

        }else{
            
            throw new \Exception("Error. Route not found", 1);
        }

    }

    public function addRoute(string $path, $action)
    {
        if ($path && $action) {
            $this->routes[$path] = $action;
        }
    }

}
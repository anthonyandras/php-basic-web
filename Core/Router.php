<?php
namespace Core;

use \Core\Middleware\Guest;
use \Core\Middleware\Auth;
use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    public function previousUrl() {
        return $_SERVER['HTTP_REFERER'];
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri and $route['method'] === strtoupper($method)) {

                if ($route['middleware']) {
                    Middleware::resolve($route['middleware']);
                }

                return require base_path("Http/controllers/" . $route['controller']);
            }
        }

        $this->abort();
    }

    public function only($key) {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add($uri, 'GET', $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add($uri, 'POST', $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add($uri, 'DELETE', $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add($uri, 'PATCH', $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add($uri, 'PUT', $controller);
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }

    protected function add($uri, $method, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }
}
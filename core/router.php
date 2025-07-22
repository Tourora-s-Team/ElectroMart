<?php

class Router
{
    private $routes = [];
    public function add($path, $options)
    {
        $this->routes[$this->normalize($path)] = $options;
    }
    public function dispatch($uri)
    {
        $uri = $this->normalize($uri);

        foreach ($this->routes as $route => $options) {
            $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([a-zA-Z0-9-_]+)', $route);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Bỏ match đầu tiên

                return $this->callAction($options, $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
    private function callAction($options, $params = [])
    {
        if (!isset($options['controller']) || !isset($options['action'])) {
            die("Invalid route options.");
        }

        $controllerName = $options['controller'];
        $method = $options['action'];

        $controllerFile = ROOT_PATH . '/app/controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("Controller $controllerName not found.");
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            die("Class $controllerName does not exist.");
        }

        $controller = new $controllerName();

        if (!method_exists($controller, $method)) {
            die("Method $method not found in controller $controllerName.");
        }

        return call_user_func_array([$controller, $method], $params);
    }
    private function normalize($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        return rtrim($uri, '/') ?: '/';
    }

}
?>
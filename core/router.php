<?php

class Router
{
    private $routes = [
        'GET' => [],
        'POST' => [],
        'DELETE' => []
    ];

    // Đăng ký route GET
    public function get($path, $action)
    {
        $this->routes['GET'][$this->normalize($path)] = $action;
    }

    // Đăng ký route POST
    public function post($path, $action)
    {
        $this->routes['POST'][$this->normalize($path)] = $action;
    }

    public function delete($path, $action)
    {
        $this->routes['DELETE'][$this->normalize($path)] = $action;
    }

    // Hàm điều phối (dispatch)
    public function dispatch($method, $uri)
    {

        $uri = $this->normalize($uri);
        $routes = $this->routes[$method] ?? [];
        $method = strtoupper($method); // Bổ sung dòng này

        foreach ($routes as $route => $action) {
            $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([a-zA-Z0-9-_]+)', $route);
            $pattern = "#^$pattern$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Xóa phần match đầy đủ
                return $this->callAction($action, $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }

    // Gọi controller@method
    private function callAction($action, $params = [])
    {
        [$controllerName, $method] = explode('@', $action);

        $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';

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

    // Chuẩn hóa URL
    private function normalize($uri)
    {
        $uri = parse_url($uri, PHP_URL_PATH);
        return rtrim($uri, '/') ?: '/';
    }
}

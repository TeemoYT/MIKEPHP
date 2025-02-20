<?php

class Router {
    private $routes = [];

    public function get($route, $callback) {
        $this->routes['GET'][$route] = $callback;
    }

    public function post($route, $callback) {
        $this->routes['POST'][$route] = $callback;
    }

    public function dispatch($requestUri, $requestMethod) {
        $route = explode("?", $requestUri)[0];

        if (isset($this->routes[$requestMethod][$route])) {
            call_user_func($this->routes[$requestMethod][$route]);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}

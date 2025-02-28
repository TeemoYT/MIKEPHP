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

        foreach ($this->routes[$requestMethod] as $pattern => $callback) {
           
            $patternRegex = preg_replace('/:[a-zA-Z0-9_]+/', '([^/]+)', $pattern);
            $patternRegex = str_replace('/', '\/', $patternRegex);

            
            if (preg_match("/^$patternRegex$/", $route, $matches)) {
                array_shift($matches);
                return call_user_func_array($callback, $matches);
            }
        }

       
        http_response_code(404);
        echo "404 Not Found";
    }
}

?>

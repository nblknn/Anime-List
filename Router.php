<?php

declare (strict_types = 1);

class Router {
    public function getControllerName(string $route): string | false {
        $controllerName = ucfirst($route) . "Controller";
        if (file_exists(__DIR__ . "/controller/$controllerName.php")) {
            return $controllerName;
        }
        return false;
    }
    public function getMethod(string | null $route, $controller): string | false {
        $route = $route ?? "default";
        $method = $route . "Action";
        if (method_exists($controller, $method)) {
            return $method;
        }
        return false;
    }

    public function route() : string {
        $uri = parse_url($_SERVER["REQUEST_URI"] ?? "", PHP_URL_PATH);
        $uri = urldecode(trim($uri, '/'));
        $uriParts = explode('/', $uri);
        $controllerName = $this->getControllerName($uriParts[0]);
        if (!$controllerName) {
            return "404 Not Found";
        }
        require_once __DIR__ . "/controller/$controllerName.php";
        $controller = new $controllerName();
        $methodName = $this->getMethod($uriParts[1] ?? null, $controller);
        if (!$methodName) {
            return "404 Not Found";
        }
        return $controller->$methodName();
    }
}
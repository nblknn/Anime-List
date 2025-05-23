<?php

declare (strict_types = 1);

require_once __DIR__ . "/controller/AdminController.php";
require_once __DIR__ . "/controller/AnimeController.php";
require_once __DIR__ . "/controller/UserController.php";
require_once __DIR__ . "/service/UserService.php";

class Router {
    public function getControllerName(string $route): string | false {
        $controllerName = $route === "" ? "AnimeController" : ucfirst($route) . "Controller";
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
            http_response_code(404);
            return "404 Not Found";
        }
        if ($controllerName === "AnimeController") {
            $userService = new UserService();
            if (!$userService->checkLogin()) {
                header('Location: /user/login');
                exit;
            }
        }
        $controller = new $controllerName();
        $methodName = $this->getMethod($uriParts[1] ?? null, $controller);
        if (!$methodName) {
            http_response_code(404);
            return "404 Not Found";
        }
        return $controller->$methodName();
    }
}
<?php

declare (strict_types = 1);

class Router {
    private array $routes = ["list" => "AnimeController",
        "admin" => "AdminController"];
    private array $methodRoutes = ["AnimeController" => [],
        "AdminController" => ["" => "getFileAction",
            "getFile" => "getFileAction",
            "addFile" => "addFileAction",
            "addDir" => "addDirAction",
            "deleteFile" => "deleteFileAction",
            "deleteDir" => "deleteDirAction",
            "updateFile" => "updateFileAction",
            "renameFile" => "renameFileAction",
        ]];

    public function Route() : string {
        $uri = parse_url($_SERVER["REQUEST_URI"] ?? "", PHP_URL_PATH);
        $uri = urldecode(trim($uri, '/'));
        $uriParts = explode('/', $uri);
        $controllerName = $this->routes[$uriParts[0]] ?? false;
        if (!$controllerName) {
            return "404 Not Found";
        }
        require_once __DIR__ . "/controller/$controllerName.php";
        $controller = new $controllerName();
        $methodName = $this->methodRoutes[$controllerName][$uriParts[1] ?? ""] ?? false;
        if (!$methodName) {
            return "404 Not Found";
        }
        return $controller->$methodName();
    }
}
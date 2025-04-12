<?php
namespace App\Core;

class Router {
    public static function run() {
        // Get URL entered by user
        $url = isset($_GET['url']) ? explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL)) : [];

        // Define default controller and method
        $controllerName = isset($url[0]) && $url[0] != "" ? ucfirst($url[0]) . "Controller" : "HomeController";
        $methodName = isset($url[1]) ? $url[1] : "index";
        $params = array_slice($url, 2); // Get extra URL parameters

        // Controller path
        $controllerPath = "../app/controllers/" . $controllerName . ".php";

        // Check if controller exists
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $controllerClass = "App\\Controllers\\" . $controllerName;
            $controller = new $controllerClass();

            // Check if method exists in controller
            if (method_exists($controller, $methodName)) {
                call_user_func_array([$controller, $methodName], $params);
            } else {
                throw new \Exception("Method '{$methodName}' not found in controller.");
            }
        } else {
            throw new \Exception("Controller not found: {$controllerPath}");
        }
    }
}

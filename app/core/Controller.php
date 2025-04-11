<?php

namespace core;

abstract class Controller {
    protected function view(string $view, array $dados = []) {
        extract($dados); // Transforma os índices do array em variáveis
        require_once "../app/views/$view.php";
    }

    protected function redirect(string $url) {
        header("Location: $url");
        exit;
    }

    protected function loadModel(string $model) {
        require_once "../app/models/$model.php";
    }

    protected function getBaseUrl() {
        return "http://" . $_SERVER['HTTP_HOST'] . "/test/";
    }

    protected function input(string $key, $default = null) {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }

    protected function isPost(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function isGet(): bool {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    // protected function loadComponent(string $component) {
    //     require_once "../app/components/$component.php";
    // }

    // protected function loadHelper(string $helper) {
    //     require_once "../app/helpers/$helper.php";
    // }

    // protected function loadConfig(string $config) {
    //     require_once "../app/config/$config.php";
    // }

    // protected function loadLibrary(string $library) {
    //     require_once "../app/libraries/$library.php";
    // }

    // protected function loadMiddleware(string $middleware) {
    //     require_once "../app/middlewares/$middleware.php";
    // }

    // protected function loadRoute(string $route) {
    //     require_once "../app/routes/$route.php";
    // }

    // protected function loadService(string $service) {
    //     require_once "../app/services/$service.php";
    // }
    
    // protected function loadUtil(string $util) {
    //     require_once "../app/utils/$util.php";
    // }

    // protected function loadValidator(string $validator) {
    //     require_once "../app/validators/$validator.php";
    // }

    // protected function loadException(string $exception) {
    //     require_once "../app/exceptions/$exception.php";
    // }

   
}
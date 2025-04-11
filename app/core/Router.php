<?php

class Router {
    public static function run() {
        // Obtém a URL digitada pelo usuário
        $url = isset($_GET['url']) ? explode("/", filter_var(rtrim($_GET['url'], "/"), FILTER_SANITIZE_URL)) : [];

        // Define controller e método padrão
        $controller = isset($url[0]) && $url[0] != "" ? ucfirst($url[0]) . "Controller" : "HomeController";
        $method = isset($url[1]) ? $url[1] : "index";
        $params = array_slice($url, 2); // Pega os parâmetros extras da URL

        // Caminho do controller
        $controllerPath = "../app/controllers/" . $controller . ".php";

        // Verifica se o controller existe
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $obj = new $controller();

            // Verifica se o método existe no controller
            if (method_exists($obj, $method)) {
                call_user_func_array([$obj, $method], $params);
            } else {
                echo "Erro 404 - Método '$method' não encontrado.";
            }
        } else {
            echo "Erro 404 - Página não encontrada.";
        }
    }
}

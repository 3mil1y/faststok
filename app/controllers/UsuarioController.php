<?php
require_once "../app/core/autoloader.php";
require_once "../app/core/dbConfig.php";

use core\Controller;
use models\UsuarioModel;

class UsuarioController extends Controller {
    public function login($errorMessage = null) {
        $titulo = "Login";
        $error = ($errorMessage === 'dadoIncorreto') ? 'Login ou Senha Incorretos, favor tente novamente!' : null;
        $this->view("login", compact("titulo", "error"));
    }

    public function listar() {
        $titulo = "Listagem de Usuários";
        $usuarios = UsuarioModel::listar() ?? [];
        //$produtos = ProdutoModel::listar() ?? [];

        // Agora chamamos a View pelo método da classe base
        $this->view("listaUsuarios", compact("titulo", "usuarios"));
    }

    public function cadastrar() {
        $this->view("cadUsuario");
    }
}
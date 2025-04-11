<?php
require_once "../app/core/autoloader.php";
use core\Controller; // Importamos a classe base
use models\ProdutoModel;
use core\DbConnect;

//$connect = DbConnect::getConnection();

class TransferenciaController extends Controller {
    public function interna() {
        $titulo = "Relatório de validade";
        //$produtos = ProdutoModel::listarPorValidade() ?? [];
        $action = '';

        // Agora chamamos a View pelo método da classe base
        $this->view("transferenciaInt", compact("titulo","action"));
    }

    public function saida() {
        $titulo = "Relatório de estoque";
        //$produtos = ProdutoModel::listarPorEstoque() ?? [];
        $action = '';

        // Agora chamamos a View pelo método da classe base
        $this->view("transferenciaSaida", compact("titulo","action"));
    }
}
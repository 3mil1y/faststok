<?php
require_once "../app/core/autoloader.php";
use core\Controller; // Importamos a classe base
use models\ProdutoModel;
use core\DbConnect;

$connect = DbConnect::getConnection();

class RelatorioController extends Controller {
    public function validade() {
        $titulo = "Relatório de validade";
        $produtos = ProdutoModel::listarPorValidade() ?? [];
        $action = '';

        // Agora chamamos a View pelo método da classe base
        $this->view("relatorio", compact("titulo", "produtos","action"));
    }

    public function estoque() {
        $titulo = "Relatório de estoque";
        $produtos = ProdutoModel::listarPorEstoque() ?? [];
        $action = '';

        // Agora chamamos a View pelo método da classe base
        $this->view("relatorio", compact("titulo", "produtos","action"));
    }
}
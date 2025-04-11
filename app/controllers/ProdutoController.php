<?php
require_once "../app/core/autoloader.php";
use core\Controller; // Importamos a classe base
use models\ProdutoModel;
use core\DbConnect;

$connect = DbConnect::getConnection();

class ProdutoController extends Controller {
    public function listar() {
        $titulo = "Listagem de Produtos";
        $produtos = ProdutoModel::listar() ?? [];

        // Agora chamamos a View pelo método da classe base
        $this->view("listaProdutos", compact("titulo", "produtos"));
    }

    public function cadastrar() {
        $titulo = "Cadastro de Produtos";
        $action = "Validacoes/cadastroProduto";
        $this->view("cadProduto", compact("titulo", "action"));
    }
    
    public function baixar($id) {
        $titulo = "Baixa de Produtos";
        $action = '';
        $produto = ProdutoModel::listarPorId($id);
        $this->view("baixaProduto", compact("titulo"));
    }

    public function pesquisar(){
        $titulo = "Pesquisa de Produtos";
        $action = 'Validacoes/pesquisaProduto';
        //$produto = ProdutoModel::listarPorId($id);
        $this->view("pesquisaProduto", compact("titulo","action"));
    }

    public function home(){
        $titulo = "Home";
        $produtos = ProdutoModel::listar() ?? [];

        // Agora chamamos a View pelo método da classe base
        $this->view("listaProdutos", compact("titulo", "produtos"));
    }

    public function popup($titulo, $conteudo){
        $this->view("popup", compact("titulo", "conteudo"));
    }
}
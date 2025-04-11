<?php

require_once "../app/core/autoloader.php";

use core\Controller;
use Endereco\Endereco;
use models\ProdutoModel;
use models\EnderecoModel;
use Produto\Produto;

class ValidacoesController extends Controller
{
    public function cadastroProduto()
    {
        // Verifica se o formulário foi enviado via POST
        if ($this->isPost()) {
            // Captura os dados
            $nome       = $this->input('nome');
            $codBarras  = $this->input('codBarras');
            $quantidade = $this->input('quantidade');
            $validade   = $this->input('validade');
            $setor      = $this->input('setor');
            $andar      = $this->input('andar');
            $posicao    = $this->input('posicao');

            // Validações básicas
            $erros = [];

            if (empty($nome))        $erros[] = "O nome é obrigatório.";
            if (empty($codBarras))   $erros[] = "O código de barras é obrigatório.";
            if (!is_numeric($codBarras)) $erros[] = "O código de barras deve ser numérico.";
            if (empty($quantidade) || $quantidade <= 0) $erros[] = "Quantidade inválida.";
            if (empty($validade))    $erros[] = "A validade é obrigatória.";
            if (empty($setor))       $erros[] = "O setor é obrigatório.";
            if (empty($andar))       $erros[] = "O andar é obrigatório.";
            if (empty($posicao))     $erros[] = "A posição é obrigatória.";

            if (!empty($erros)) {
                // Retorna para a view com os erros
                $this->view('produto/cadastro', ['erros' => $erros]);
            } else {
                // Aqui você poderia salvar no banco, por exemplo
                // $this->loadModel('ProdutoModel');
                // $this->loadModel('EnderecoModel');
                $endereco = EnderecoModel::buscarPorDados(new Endereco($setor, $andar, $posicao));
                ProdutoModel::Cadastrar(new Produto($codBarras, $nome, $quantidade, $validade, $endereco));

                // Redireciona para uma página de sucesso
                $this->redirect($this->getBaseUrl() . 'produto/listar');
            }
        } else {
            // Redireciona se não for POST
            $this->redirect($this->getBaseUrl());
        }
    }

    public function pesquisaProduto() {
        if ($this->isPost()) {
            $termoPesquisa = $this->input('termo_pesquisa');
            
            // Validação do termo de pesquisa
            if (empty($termoPesquisa)) {
                $this->view("pesquisaProduto", [
                    'titulo' => 'Pesquisa de Produtos',
                    'error' => 'Por favor, insira um termo para pesquisa'
                ]);
                return;
            }

            try {
                // Busca no Model
                $produtos = ProdutoModel::pesquisar($termoPesquisa);

                // Passa os resultados para a view
                $this->view("listaProdutos", [
                    'titulo' => 'Resultados da Pesquisa',
                    'produtos' => $produtos,
                    'termoPesquisa' => $termoPesquisa
                ]);
            } catch (Exception $e) {
                $this->view("pesquisaProduto", [
                    'titulo' => 'Pesquisa de Produtos',
                    'error' => 'Erro ao realizar a pesquisa: ' . $e->getMessage()
                ]);
            }
        } else {
            // Se não for POST, redireciona para a página de pesquisa
            header('Location: /produto/pesquisar');
        }
    }
}

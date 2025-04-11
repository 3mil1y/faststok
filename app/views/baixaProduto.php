<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Cabecalho;
use Components\Form\FormDecremento;
use Components\Layout\Head;
use models\ProdutoModel;

$titulo = "Baixa de Produto";

echo Head::render($titulo);
echo Cabecalho::render();


$idProduto = $_GET['id'] ?? null;
$produto = ProdutoModel::listarPorId($idProduto);

if (!$produto) {
    header('Location: listaProdutos.php?error=produto_nao_encontrado');
    exit;
}

FormDecremento::render("Validacoes/baixaProduto", $produto);

<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="tail.css">
</head>
<body class="bg-gray-200">

<?php
require_once "autoloader.php";
require_once "control.php";

use Componentes\Cabecalho;
use Componentes\FormDecremento;

echo (new Cabecalho)->exibirCabecalho(true);

$formDecremento = new FormDecremento;

$idProduto = $_GET['id'] ?? null;
$produto = buscarProdutoPorId($idProduto);

echo $formDecremento->gerarFormDecremento("validarBaixaProduto.php", $produto);


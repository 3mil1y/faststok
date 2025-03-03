<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link rel="stylesheet" href="tail.css">
</head>
<body class="bg-gray-200">

<?php
require_once "autoloader.php";
require_once "control.php";

use Componentes\FormProd;
use Componentes\ListaProd;
use Componentes\Pesquisa;
use Componentes\Cabecalho;


//sessionLogout();
if(!checaLogin()){
    header("Location:login/login.php");
}

echo (new Cabecalho)->exibirCabecalho(true);
//echo (new Cabecalho)->exibirCabecalho(true);

$produtos = listarProdutos();
echo (new ListaProd)->gerarListaProdutos($produtos);


?>

</body>
</html>
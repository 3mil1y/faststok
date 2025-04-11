<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Cabecalho;
use Components\Form\CadastroProduto;
use Components\Layout\Head;

echo Head::render($titulo);
echo Cabecalho::render();
echo CadastroProduto::render($action);
?> 
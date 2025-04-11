<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Cabecalho;
use Components\Report\Relatorio;
use Components\Layout\Head;

echo Head::render($titulo);
echo Cabecalho::render();
echo Relatorio::render($produtos, $titulo);
?>
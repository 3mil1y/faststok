<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Cabecalho;
use Components\Common\Pesquisa;
use Components\Layout\Head;

echo Head::render($titulo);
echo Cabecalho::render();
echo Pesquisa::render($action);
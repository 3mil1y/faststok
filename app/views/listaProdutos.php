<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Cabecalho;
use Components\Lists\ProductList;
use Components\Layout\Head;

    echo Head::render($titulo);
    echo Cabecalho::render();
    echo ProductList::render($produtos);
?>
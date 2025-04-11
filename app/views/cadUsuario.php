<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Cabecalho;
use Components\Form\CadastroUsuario;
use Components\Layout\Head;

        echo Head::render($titulo);
        echo Cabecalho::render();
        echo CadastroUsuario::render($action, $mensagemErro);
?>
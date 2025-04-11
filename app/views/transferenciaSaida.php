<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Cabecalho;
use Components\Form\TransferenciaExtForm;
use Components\Layout\Head;

$titulo = "Transferência de Saída";
$action = "validacoes/transferenciaSaida.php";

echo Head::render($titulo);
echo Cabecalho::render();
echo TransferenciaExtForm::render($action);
?>
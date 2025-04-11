<?php
require_once "../app/core/autoloader.php";

use Components\Common\Popup;

echo Popup::render($titulo, $conteudo);
?>
<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Form\ProdutoForm;
use App\Components\Layout\Head;

echo Head::render($title);
echo Header::render();
echo ProdutoForm::render($action);
?>
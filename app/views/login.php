<?php
require_once "../app/core/autoloader.php";

use Components\Layout\Head;
use Components\Form\LoginForm;

$error = isset($_GET['error']) ? $_GET['error'] : '';
$titulo = "Login";

echo Head::render($titulo);
echo LoginForm::render('Validacoes/login', $error);
<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Head;
use App\Components\Form\Login;

$error = isset($_GET['error']) ? $_GET['error'] : '';
$titulo = "Login";

echo Head::render($titulo);
echo Login::render('Validacoes/login', $error);
?>
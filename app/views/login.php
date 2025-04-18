<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Head;
use App\Components\Form\Login;

echo Head::render($title);
echo Login::render($action, $error);
?>
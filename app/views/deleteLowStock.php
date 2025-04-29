<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Layout\Head;
use App\Components\Form\DeleteLowStock;

echo Head::render($title);
echo Header::render();
echo DeleteLowStock::render($action);

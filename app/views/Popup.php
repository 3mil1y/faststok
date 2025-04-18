<?php
require_once "../app/core/autoloader.php";

use App\Components\Common\Popup;
use App\Components\Layout\Head;

echo Head::render($title);
echo Popup::render($title, $content);
?>
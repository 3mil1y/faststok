<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Common\Search;
use App\Components\Layout\Head;

echo Head::render($title);
echo Header::render();
echo Search::render($action, $error);
?>
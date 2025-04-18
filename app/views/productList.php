<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Lists\ProductList;
use App\Components\Layout\Head;

echo Head::render($title);
echo Header::render();
echo ProductList::render($products);
?>
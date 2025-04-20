<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Form\createProduct;
use App\Components\Layout\Head;

echo Head::render($title);
echo Header::render();
echo createProduct::render($action,
[
    'errorMessage' => $errorMessage ?? null,
    'successMessage' => $successMessage ?? null
]);
?>
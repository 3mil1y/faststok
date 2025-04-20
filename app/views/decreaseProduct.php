<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Form\DecreaseProduct;
use App\Components\Layout\Head;
use App\Models\ProductModel;

echo Head::render($title);
echo Header::render();
echo DecreaseProduct::render($action, [
    "product" => $product,
    "errorMessage" => $errorMessage ?? null,
    "successMessage" => $successMessage ?? null
]);
?>

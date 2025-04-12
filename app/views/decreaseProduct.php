<?php
require_once "../app/core/autoloader.php";

use App\Components\Layout\Header;
use App\Components\Form\DecreaseForm;
use App\Components\Layout\Head;
use App\Models\ProductModel;

$title = "Product Decrease";

echo Head::render($title);
echo Header::render();

$productId = $_GET['id'] ?? null;
$product = ProductModel::getById($productId);

if (!$product) {
    header('Location: productList?error=product_not_found');
    exit;
}

DecreaseForm::render("validations/decreaseProduct", $product);
?>

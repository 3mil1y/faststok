<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;

class ReportController extends Controller {
    public function expiry() {
        $title = "Relatório de Validade";

        // Fetch products that are about to expire
        $products = ProductModel::getByExpiryDate() ?? [];
        $action = '';

        $this->view("report", compact("title", "products", "action"));
    }

    public function stock() {
        $title = "Relatório de Estoque";

        // Fetch products that are low in stock
        $products = ProductModel::getByLowStock() ?? [];
        $action = '';

        $this->view("report", compact("title", "products", "action"));
    }
}
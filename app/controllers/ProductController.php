<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use App\Core\DbConnect;

class ProductController extends Controller {
    public function home() {
        $title = "Lista de Produtos";
        // Fetch all products from the database
        $products = ProductModel::list() ?? [];
        $this->view("productList", compact("title", "products"));
    }

    public function create() {
        $title = "Criar Produto";
        // Action for form submission
        $action = "validations/createProduct";
        $this->view("createProduct", compact("title", "action"));
    }
    
    public function decrease($id) {
        $title = "Baixa de Produto";
        // Action for form submission (if any)
        $action = '';
        $product = ProductModel::getById($id);
        $this->view("decreaseProduct", compact("title", "product"));
    }

    public function search() {
        $title = "Pesquisa de Produtos";
        // Action for form submission (if any)
        $action = 'validations/searchProduct';
        $this->view("searchProduct", compact("title", "action"));
    }

    // public function home() {
    //     $title = "Home";
    //     $products = ProductModel::list() ?? [];
    //     $this->view("productList", compact("title", "products"));
    // }

    public function popup($title, $content) {
        $this->view("popup", compact("title", "content"));
    }
}
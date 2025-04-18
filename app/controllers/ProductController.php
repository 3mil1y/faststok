<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use App\Models\LocationModel;
use App\entities\Location;

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
        $action = "product/create";
        $this->view("createProduct", compact("title", "action"));
    }
    
    public function decrease($id) {
        if(self::isPost()){
            if(self::anyNull(self::input("decreaseAmount")) || !self::inInterval(self::input("decreaseAmount"), 1, self::input("stock"))) {
                $errorMessage = "Favor informe uma quantidade maior que zero e menor que o estoque!";
                $title = "Baixa de Produto";
                $action = 'product/decrease/' . $id;
                $product = ProductModel::getById($id);
                $this->view("decreaseProduct", compact("title", "product", "action", "errorMessage"));
                return;
            }

            ProductModel::updateStock(    
                (ProductModel::getById($id))->setQuantity(
                    self::input("stock") - self::input("decreaseAmount")
                )
            );
            self::redirect('product/home');
        }

        $title = "Baixa de Produto";
        // Action for form submission (if any)
        $action = 'product/decrease/' . $id;
        $product = ProductModel::getById($id);
        $this->view("decreaseProduct", compact("title", "product", "action"));
    }

    public function search() {
        if(self::isPost()){
        $searchType = self::input("searchType");
        $products = [];
        $title = "Pesquisa de Produtos";

        switch ($searchType) {
            case 'name':
                $query = self::input("query");
                $title = "Pesquisa de Produtos por Nome";
                $products = ProductModel::getByName($query) ?? [];
                break;

            case 'barCode':
                $query = self::input("query");
                $title = "Pesquisa de Produtos por Código de Barras";
                $products = ProductModel::getByBarcode($query) ?? [];
                break;

            case 'location':
                
                if(!self::anyNull(self::input("sector"), self::input("floor"), self::input("position"))) {
                    if(!self::inInterval(self::input("floor"), 1, 5) || !self::inInterval(self::input("position"), 1, 12)) {
                        $error = "Os produtos devem seguir os intervalos definidos!";
                        break;
                    }

                    // $sector = self::input("sector");
                    // $floor = self::input("floor");
                    // $position = self::input("position");

                    $title = "Pesquisa de Produtos por Endereço";
                    $products = ProductModel::getByLocationId(
                        LocationModel::findIdByData(
                            new Location(self::input("sector"), self::input("floor"), self::input("position"))
                        )
                    ) ?? [];
                } else {
                    $error = "Preencha todos os campos de endereço!";
                    //$this->redirect("product/search", compact("error"));
                    return;
                }
                break;

            default:
                $this->redirect("product/search");
                return;
        }
            // If we reach here, it means search was successful

            // Perform the search logic here (e.g., update database)
            //$products = ProductModel::search($name, $sector, $floor, $position) ?? [];

            // Redirect or show success message
            $this->view("productList", compact("products", "title"));
            return;
        }

        // If we reach here, it means search failed or no search was performed or method is get
        $title = "Pesquisa de Produtos";
        // Action for form submission (if any)
        $action = 'product/search';
        $error = null;
        $this->view("searchProduct", compact("title", "action", "error"));
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
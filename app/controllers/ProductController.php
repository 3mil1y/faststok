<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use App\Models\LocationModel;
use App\entities\Location;
use App\entities\Product;

class ProductController extends Controller {
    private const FLOOR_RANGE = [1, 5];
    private const POSITION_RANGE = [1, 12];

    private const ERRORS = [
        "AllFieldsNeeded" => "Todos os campos são obrigatórios.",
        "InvalidInterval" => "Os produtos devem seguir os intervalos definidos!"
    ];

    public function home() {
        $title = "Lista de Produtos";
        // Fetch all products from the database
        $products = ProductModel::list() ?? [];
        $this->view("productList", compact("title", "products"));
    }

    public function create() {
        $this->handleProductCreate("Criar Produto", "product/create", true);
    }

    public function continueCreate(){
        $this->handleProductCreate("Endereçamento Continuo de Produto", "product/continueCreate", false);
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
                $title = "Pesquisa de Produtos por Nome";
                $products = ProductModel::getByName(self::input("query")) ?? [];
                break;
            case 'barCode':
                $title = "Pesquisa de Produtos por Código de Barras";
                $products = ProductModel::getByBarcode(self::input("query")) ?? [];
                break;
            case 'location':
                
                if(!self::anyInputNull(["sector", "floor", "position"])) {
                    if(!self::inputsInRange(["floor" => self::FLOOR_RANGE, "position" => self::POSITION_RANGE])) {
                        $error = "Os produtos devem seguir os intervalos definidos!";
                        break;
                    }

                    $title = "Pesquisa de Produtos por Endereço";
                    $products = ProductModel::getByLocationId(
                        LocationModel::findIdByData(
                            new Location(self::input("sector"), self::input("floor"), self::input("position"))
                        )
                    ) ?? [];
                } else {
                    $error = "Preencha todos os campos de endereço!";
                    return;
                }
                break;

            default:
                $this->redirect("product/search");
                return;
        }

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

    protected function handleProductCreate(string $title, string $action, bool $shouldRedirect = false){
        $errorMessage = null;
        $successMessage = null;

        if (self::isPost()) {
            $errorMessage = $this->validateInputs();


            if (!$errorMessage) {
                try {
                    $successMessage = $this->executeProductCreate();
                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();
                }
            }

            if ($shouldRedirect && $successMessage) {
                $this->redirect("product/home");
            }
        }

        $this->view("createProduct", compact("title", "action", "errorMessage", "successMessage"));
    }

    protected function validateInputs(): ?string {
        $requiredFields = [
            "sector", "floor", "position",
            "name", "barCode", "quantity", "expirationDate"
        ];
    
        $requiredRanges = [
            "floor" => self::FLOOR_RANGE, "position" => self::POSITION_RANGE
        ];
    
        if (self::anyInputNull($requiredFields)) {
            return self::ERRORS["AllFieldsNeeded"];
        }

        if (!empty($requiredRanges) && !self::inputsInRange($requiredRanges)) {
            return self::ERRORS["InvalidInterval"];
        }

        return null;
    }

    protected function executeProductCreate(){
        try{
            ProductModel::create(new Product(
                self::input("name"),
                self::input("barCode"),
                self::input("quantity"),
                self::input("expirationDate"),
                LocationModel::findByData(new Location(
                    self::input("sector"), self::input("floor"), self::input("position")
            ))));

            return "Produto cadastrado com sucesso.";
        }catch(Exception $e){
            throw new Exception("Erro ao cadastrar produto: " . $e->getMessage());
        }
    }
}
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
        "InvalidInterval" => "Os produtos devem seguir os intervalos definidos!",
        "StockRange" => "Favor informe uma quantidade maior que zero e menor que o estoque!"
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
        $this->handleProductDecrease("Baixa de Produto", "product/decrease/" . $id, $id);
    }

    //need refactoring
    public function search() {
        if(self::isPost()){
            $searchType = self::input("searchType");
            $products = [];
            $title = "Pesquisa de Produtos";
            $error = null;
            
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
                
                if(self::anyInputNull(["sector", "floor", "position"])) {
                    $error = "Preencha todos os campos de endereço!";
                    break;
                }

                if(!self::inputsInRange(["floor" => self::FLOOR_RANGE, "position" => self::POSITION_RANGE])) {
                    $error = "Os produtos devem seguir os intervalos definidos!";
                    break;
                }

                $title = "Pesquisa de Produtos por Endereço";
                $products = ProductModel::getByLocationId(
                        LocationModel::findIdByData(
                            new Location(self::input("sector"), self::input("floor"), self::input("position"))
                        )) ?? [];
                break;

                default:
                    $this->redirect("product/search");
                    return;
        }

        if(empty($products)) {
            $action = "product/search";
            $error = "Nenhum produto encontrado.";
            $this->view("searchProduct", compact("action", "title", "error"));
            return;
        }

        $this->view("productList", compact("products", "title", "error"));
        return;
        }
    

        // If we reach here, it means search failed or no search was performed or method is get
        $title = "Pesquisa de Produtos";
        // Action for form submission (if any)
        $action = 'product/search';
        $error = null;
        $this->view("searchProduct", compact("title", "action", "error"));
    }

    //need refactoring
    //Need implement view
    //Need Error treatment
    public function deleteByStock() {
        // if(self::isPost()){
            ProductModel::deleteByStock();
            $this->redirect("product/home");
            return;
        // }

        

        // $title = "Excluir Estoque Baixo";
        // $action = "product/deleteByStock";
        // $this->view("deleteByStock", compact("title", "action"));
    }

    protected function handleProductCreate(string $title, string $action, bool $shouldRedirect = false){
        $errorMessage = null;
        $successMessage = null;

        if (self::isPost()) {
            $errorMessage = $this->validateCreateInputs();


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

    protected function handleProductDecrease(string $title, string $action, int $id){
        $errorMessage = null;
        $successMessage = null;

        if (self::isPost()) {
            $errorMessage = $this->validateDecreaseInputs();

            if (!$errorMessage) {
                try {
                    $successMessage = $this->executeProductDecrease($id);
                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();
                }
            }

            $this->redirect("product/home");
        }

        $product = ProductModel::getById($id);
        $this->view("decreaseProduct", compact("title", "product", "action", "errorMessage", "successMessage"));
    }

    protected function validateInputs($requiredFields, $requiredRanges = []): ?string {
        if (self::anyInputNull($requiredFields)) {
            return self::ERRORS["AllFieldsNeeded"];
        }

        if (!empty($requiredRanges) && !self::inputsInRange($requiredRanges)) {
            return self::ERRORS["InvalidInterval"];
        }

        return null;
    }

    protected function validateCreateInputs(): ?string {
        $requiredFields = [
            "sector", "floor", "position",
            "name", "barCode", "quantity", "expirationDate"
        ];
    
        $requiredRanges = [
            "floor" => self::FLOOR_RANGE, "position" => self::POSITION_RANGE
        ];
    
        return $this->validateInputs($requiredFields, $requiredRanges);
    }

    protected function validateDecreaseInputs(): ?string {
        $requiredFields = [
            "decreaseAmount"
        ];

    
        $requiredRanges = [
            "decreaseAmount" => [1, self::input("stock")]
        ];

    
        return $this->validateInputs($requiredFields, $requiredRanges);
    }

    protected function validateSearchInputs($requiredFields, $requiredRanges = []): ?string {
        return $this->validateInputs($requiredFields, $requiredRanges);
    }

    protected function executeProductCreate(){
        try{
            ProductModel::create(new Product(
                self::input("barCode"),
                self::input("name"),
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

    protected function executeProductDecrease($id){
        try{
            ProductModel::updateStock(    
                (ProductModel::getById($id))->setQuantity(
                    self::input("stock") - self::input("decreaseAmount")
                )
            );
            return "Baixa de produto realizada com sucesso.";
        }catch(Exception $e){
            throw new Exception("Erro ao realizar baixa de produto: " . $e->getMessage());
        }
    }
}
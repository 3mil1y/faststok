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
        $this->handleProductSearch($title, $action);
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

    protected function handleProductSearch(string $title, string $action){
        $title = "Pesquisa de Produtos";
        $action = "product/search";

        if (self::isPost()) {
            $products = [];
            $error = null;
        
            switch (self::input("searchType")) {
                case 'name':
                    $title = "Pesquisa de Produtos por Nome";
                    $products = ProductModel::getByName(self::input("query")) ?? [];
                    break;
        
                case 'barCode':
                    $title = "Pesquisa de Produtos por Código de Barras";
                    $products = ProductModel::getByBarcode(self::input("query")) ?? [];
                    break;
        
                case 'location':
                    $error = $this->validateSearchInputs(["sector", "floor", "position"], [
                        "floor" => self::FLOOR_RANGE,
                        "position" => self::POSITION_RANGE
                    ]);
        
                    if (!$error) {
                        $title = "Pesquisa de Produtos por Endereço";
                        $location = new Location(self::input("sector"), self::input("floor"), self::input("position"));
                        $locationId = LocationModel::findIdByData($location);
        
                        $products = ProductModel::getByLocationId($locationId) ?? [];
                    } else {
                        $this->view("searchProduct", [
                            'title' => 'Pesquisa de Produtos',
                            'action' => 'product/search',
                            'error' => $error
                        ]);
                        return;
                    }
                    break;
        
                default:
                    $this->redirect("product/search");
                    return;
            }
        
            $this->view("productList", compact("products", "title", "errorMessage"));
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
<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use App\Models\LocationModel;
use App\entities\Location;

class TransferController extends Controller {
    private const FLOOR_RANGE = [1, 5];
    private const POSITION_RANGE = [1, 12];

    private const ERRORS = [
        "AllFieldsNeeded" => "Todos os campos são obrigatórios.",
        "InvalidInterval" => "Os produtos devem seguir os intervalos definidos!",
        "EqualFields" => "Em transferências internas, origem e destino devem ser diferentes."
    ];

    public function internal() {
    $this->handleInternalTransfer("Transferência Interna", "transfer/internal", true);
}

    public function external() {
        $this->handleExternalTransfer("Transferência Externa", "transfer/external", true);
    }

    public function continueInternal() {
        $this->handleInternalTransfer("Transferência Interna Contínua", "transfer/continueInternal");
    }
    

    public function continueExternal() {
        $this->handleExternalTransfer("Transferência Externa Contínua", "transfer/continueExternal");
    }

    protected function handleInternalTransfer(string $title, string $action, bool $shouldRedirect = false){
        $errorMessage = null;
        $successMessage = null;

        if (self::isPost()) {
            $errorMessage = $this->validateInternalTransferInputs();


            if (!$errorMessage) {
                try {
                    $successMessage = $this->executeInternalTransfer();
                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();
                }
            }

            if ($shouldRedirect && $successMessage) {
                $this->redirect("product/home");
            }
        }

        $this->view("InternalTransfer", compact("title", "action", "errorMessage", "successMessage"));
    }

    protected function handleExternalTransfer(string $title, string $action, bool $shouldRedirect = false){
        $errorMessage = null;
        $successMessage = null;
    
        if (self::isPost()) {
            $errorMessage = $this->validateExternalTransferInputs();
    
            if (!$errorMessage) {
                try {
                    $successMessage = $this->executeExternalTransfer();
                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();
                }
            }
            if ($shouldRedirect && $successMessage) {
                $this->redirect("product/home");
            }
        }

        $this->view("ExternalTransfer", compact("title", "action", "errorMessage", "successMessage"));
    }

    protected function validateExternalTransferInputs(): ?string {
        $requiredFields = ["sector", "floor", "position"];
        
        $requiredRanges = ["floor" => self::FLOOR_RANGE, "position" => self::POSITION_RANGE];
        
        return $this->validateInputs("external", $requiredFields, $requiredRanges);
    }
    
    protected function validateInternalTransferInputs(): ?string {
        $requiredFields = [
            "originSector", "originFloor", "originPosition",
            "destinationSector", "destinationFloor", "destinationPosition"
        ];
    
        $requiredRanges = [
            "originFloor" => self::FLOOR_RANGE, "originPosition" => self::POSITION_RANGE,
            "destinationFloor" => self::FLOOR_RANGE, "destinationPosition" => self::POSITION_RANGE
        ];
    
        return $this->validateInputs("internal", $requiredFields, $requiredRanges);
    }

    protected function validateInputs(string $type, array $requiredFields, array $requiredRanges = []): ?string {
        if (self::anyInputNull($requiredFields)) {
            return self::ERRORS["AllFieldsNeeded"];
        }

        if (!empty($requiredRanges) && !self::inputsInRange($requiredRanges)) {
            return self::ERRORS["InvalidInterval"];
        }
        
        if($type === "internal" &&
           self::equalInputs(["originSector", "destinationSector"]) &&
           self::equalInputs(["originFloor", "destinationFloor"]) &&
           self::equalInputs(["originPosition", "destinationPosition"])){
            return self::ERRORS["EqualFields"];
        }

        return null;
    }

    protected function executeInternalTransfer(){
        try{
            ProductModel::updateAllLocations(
                LocationModel::findIdByData(new Location(
                    self::input("originSector"), self::input("originFloor"), self::input("originPosition")
                )),
                LocationModel::findIdByData(new Location(
                    self::input("destinationSector"), self::input("destinationFloor"), self::input("destinationPosition")
                ))
            );

            return "Transferência interna realizada com sucesso.";
        }catch(Exception $e){
            throw new Exception("Erro ao realizar transferência interna: " . $e->getMessage());
        }
    }

    protected function executeExternalTransfer(){
        try {
            ProductModel::deletebyLocationId(
                LocationModel::findIdByData(new Location(
                    self::input("sector"), self::input("floor"), self::input("position")
                ))
            );
    
            return "Transferência externa realizada com sucesso.";
        } catch(Exception $e) {
            throw new Exception("Erro ao realizar transferência externa: " . $e->getMessage());
        }
    }
}

<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use App\Models\LocationModel;
use App\entities\Location;

class TransferController extends Controller {
    public function internal() {
        if(self::isPost()){

            // Validate the product and quantity
            if (self::anyNull(self::input("originSector"), self::input("originFloor"), self::input("originPosition"), self::input("destinationSector"), self::input("destinationFloor"), self::input("destinationPosition"))) {
                $errorMessage = "Todos os campos são obrigatórios.";
                $this->view("internalTransfer", compact("errorMessage"));
                return;
            }

            if(self::inInterval(self::input("originFloor"), 1, 5) && self::inInterval(self::input("originPosition"), 1, 12) && self::inInterval(self::input("destinationFloor"), 1, 5) && self::inInterval(self::input("destinationPosition"), 1, 12)) {
                $errorMessage = "Os produtos devem seguir os intervalos definidos!";
                $this->view("internalTransfer", compact("errorMessage"));
                return;
            }

            // Perform the transfer logic here (e.g., update database)
        
            ProductModel::updateAllLocations(
                LocationModel::findIdByData(new Location(self::input("originSector"), self::input("originFloor"), self::input("originPosition"))),
                LocationModel::findIdByData(new Location(self::input("destinationSector"), self::input("destinationFloor"), self::input("destinationPosition")))
            );

            //errors message needs to be implemented in the view

            // if(!){
            //     $errorMessage = "Erro ao transferir o produto. Verifique os dados e tente novamente.";
            // }

            // Redirect or show success message
            $this->redirect("product/home");
            return;
        }

        $title = "Transferência Interna";
        $action = 'transfer/internal';
        $this->view("internalTransfer", compact("title", "action"));
    }

    public function external() {

        if(self::isPost()){
            $sector = self::input("sector");
            $floor = self::input("floor");
            $position = self::input("position");

            // Validate the product and quantity
            if (self::anyNull([$sector, $floor, $position])) {
                $errorMessage = "Todos os campos são obrigatórios.";
                $this->view("externalTransfer", compact("errorMessage"));
                return;
            }

            // Perform the transfer logic here (e.g., update database)
            
            ProductModel::deletebyLocationId(
                LocationModel::findIdByData(new Location($sector, $floor, $position))
            );

            //errors message needs to be implemented in the view

            // if(!){
            //     $errorMessage = "Erro ao transferir o produto. Verifique os dados e tente novamente.";
            // }

            // Redirect or show success message
            $this->redirect("product/home");
            return;
        }

        //If we reach here, it means the form was not submitted or there was an error
        // Show the external transfer form again11
        $title = "Transferência Externa";
        $action = 'transfer/external';
        $this->view("externalTransfer", compact("title", "action"));
    }
}
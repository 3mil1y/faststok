<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use App\Models\LocationModel;
use App\entities\Location;

class TransferController extends Controller {
    public function internal() {
        if(self::isPost()){
            $originSector = self::input("originSector");
            $originFloor = self::input("originFloor");
            $originPosition = self::input("originPosition");
            $destinationSector = self::input("destinationSector");
            $destinationFloor = self::input("destinationFloor");
            $destinationPosition = self::input("destinationPosition");

            // Validate the product and quantity
            if (self::anyNull([$originSector, $originFloor, $originPosition, $destinationSector, $destinationFloor, $destinationPosition])) {
                $errorMessage = "Todos os campos são obrigatórios.";
                $this->view("internalTransfer", compact("errorMessage"));
                return;
            }

            // Perform the transfer logic here (e.g., update database)
            
            ProductModel::updateAllLocations(
                LocationModel::findIdByData(new Location($originSector, $originFloor, $originPosition)),
                LocationModel::findIdByData(new Location($destinationSector, $destinationFloor, $destinationPosition))
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
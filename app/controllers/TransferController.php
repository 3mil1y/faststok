<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\ProductModel;
use App\Core\DbConnect;

class TransferController extends Controller {
    public function internal() {
        $title = "Transferência Interna";
        $action = '';
        $this->view("internalTransfer", compact("title", "action"));
    }

    public function external() {
        $title = "Transferência Externa";
        $action = '';
        $this->view("externalTransfer", compact("title", "action"));
    }
}
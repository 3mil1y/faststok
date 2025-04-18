<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Entities\Location;
use App\Models\ProductModel;
use App\Models\LocationModel;
use App\Entities\Product;
use Exception;

class ValidationController extends Controller {
    public function validateProduct() {
        if ($this->isPost()) {
            $name = $this->input('name');
            $barcode = $this->input('barcode');
            $quantity = $this->input('quantity');
            $expiryDate = $this->input('expiryDate');
            $sector = $this->input('sector');
            $floor = $this->input('floor');
            $position = $this->input('position');

            $errors = [];

            if (empty($name)) $errors[] = "Name is required.";
            if (empty($barcode)) $errors[] = "Barcode is required.";
            if (!is_numeric($barcode)) $errors[] = "Barcode must be numeric.";
            if (empty($quantity) || $quantity <= 0) $errors[] = "Invalid quantity.";
            if (empty($expiryDate)) $errors[] = "Expiry date is required.";
            if (empty($sector)) $errors[] = "Sector is required.";
            if (empty($floor)) $errors[] = "Floor is required.";
            if (empty($position)) $errors[] = "Position is required.";

            if (!empty($errors)) {
                $this->view('product/create', ['errors' => $errors]);
            } else {
                $location = LocationModel::findByData(new Location($sector, $floor, $position));
                ProductModel::create(new Product($barcode, $name, $quantity, $expiryDate, $location));
                $this->redirect($this->getBaseUrl() . 'product/list');
            }
        } else {
            $this->redirect($this->getBaseUrl());
        }
    }

    public function searchProduct() {
        if ($this->isPost()) {
            $searchTerm = $this->input('searchTerm');
            
            if (empty($searchTerm)) {
                $this->view("searchProduct", [
                    'title' => 'Search Products',
                    'error' => 'Please enter a search term'
                ]);
                return;
            }

            try {
                $products = ProductModel::search($searchTerm);
                $this->view("productList", [
                    'title' => 'Search Results',
                    'products' => $products,
                    'searchTerm' => $searchTerm
                ]);
            } catch (Exception $e) {
                $this->view("searchProduct", [
                    'title' => 'Search Products',
                    'error' => 'Error performing search: ' . $e->getMessage()
                ]);
            }
        } else {
            header('Location: /product/search');
        }
    }
}

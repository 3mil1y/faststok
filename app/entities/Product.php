<?php
namespace App\Entities;

use App\Entities\Location;

class Product {
    private int $id;
    private string $barcode;
    private string $name;
    private int $quantity;
    private string $expiryDate;
    private Location $location;

    public function __construct(string $barcode, string $name, int $quantity, string $expiryDate, Location $location, int $id = -1) {
        $this->id = $id;
        $this->barcode = $barcode;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->expiryDate = $expiryDate;
        $this->location = $location;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): Product {
        $this->id = $id;
        return $this;
    }

    public function getBarcode(): string {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): Product {
        $this->barcode = $barcode;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): Product {
        $this->name = $name;
        return $this;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): Product {
        $this->quantity = $quantity;
        return $this;
    }

    public function getExpiryDate(): string {
        return $this->expiryDate;
    }

    public function setExpiryDate(string $expiryDate): Product {
        $this->expiryDate = $expiryDate;
        return $this;
    }

    public function getLocation(): Location {
        return $this->location;
    }

    public function getLocationId(): int {
        return $this->location->getId();
    }

    public function getLocationString(): string {
        return $this->location->getLocationString();
    }

    public function setLocation(Location $location): Product {
        $this->location = $location;
        return $this;
    }

    public function __toString(): string {
        return "Product: {$this->name}<br>
                Barcode: {$this->barcode}<br>
                Quantity: {$this->quantity}<br>
                Expiry Date: {$this->expiryDate}<br>
                Location: {$this->location}";
    }
}
?>
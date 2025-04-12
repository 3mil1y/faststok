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

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getBarcode(): string {
        return $this->barcode;
    }

    public function setBarcode(string $barcode): void {
        $this->barcode = $barcode;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getExpiryDate(): string {
        return $this->expiryDate;
    }

    public function setExpiryDate(string $expiryDate): void {
        $this->expiryDate = $expiryDate;
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

    public function setLocation(Location $location): void {
        $this->location = $location;
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
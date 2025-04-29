<?php
namespace App\Entities;

use Exception;

class Location {
    private string $sector;
    private int $floor;
    private int $position;
    private int $id;

    public function __construct(string $sector, int $floor, int $position, int $id = -1) {
        $this->sector = $sector;
        $this->floor = $floor;
        $this->position = $position;
        $this->id = $id;
    }

    public function getSector(): string {
        return $this->sector;
    }

    public function setSector(string $sector): void {
        $this->sector = $sector;
    }

    public function getFloor(): int {
        return $this->floor;
    }

    public function setFloor(int $floor): void {
        $this->floor = $floor;
    }

    public function getPosition(): int {
        return $this->position;
    }

    public function setPosition(int $position): void {
        $this->position = $position;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $newId): void {
        if($this->id !== -1) {
            throw new Exception("Location already registered, try reloading the application!");
        }
        $this->id = $newId;
    }

    public function getLocationString(): string {
        return "{$this->sector}{$this->floor}-{$this->position}";
    }

    public function __toString(): string {
        return "Sector: {$this->sector}, Floor: {$this->floor}, Position: {$this->position}";
    }

    public function __toJson(): string {
        return json_encode([
            'id' => $this->id,
            'sector' => $this->sector,
            'floor' => $this->floor,
            'position' => $this->position
        ]);
    }
}
?>
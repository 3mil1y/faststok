<?php

namespace App\Entities;

class User {
    private int $id;
    private string $name;
    private string $password;
    private string $role;

    public function __construct(string $name, string $password, string $role = 'user', int $id = -1) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getRole(): string {
        return $this->role;
    }

    public function setRole(string $role): void {
        $this->role = $role;
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }
}
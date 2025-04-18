<?php

namespace App\Entities;

class User {
    private int $id;
    private string $login;
    private string $password;
    private string $role;

    public function __construct(string $login, string $password, string $role = 'user', int $id = -1) {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->role = $role;
    }

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getlogin(): string {
        return $this->login;
    }

    public function setlogin(string $login): void {
        $this->login = $login;
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
<?php

namespace Usuario;
use InvalidArgumentException;

class Usuario {
    private int $id;
    private string $login;
    private string $permissao; // "admin" ou "usuario"

    public function __construct(string $login, string $permissao, int $id = -1) {
        $this->login = $login;
        $this->setPermissao($permissao);
        $this->id = $id;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getLogin(): string {
        return $this->login;
    }

    public function getPermissao(): string {
        return $this->permissao;
    }

    public function setPermissao(string $permissao): void {
        $permissoesValidas = ["admin", "usuario"];
        if (!in_array($permissao, $permissoesValidas)) {
            throw new InvalidArgumentException("Permissão inválida. Use 'admin' ou 'usuario'.");
        }
        $this->permissao = $permissao;
    }
}
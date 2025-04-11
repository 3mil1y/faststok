<?php

namespace models;

use Usuario\Usuario;
use core\DbConnect;
use Exception;

class UsuarioModel {
    /**
     * Cadastra um novo usuário no sistema
     */
    public static function cadastrar(Usuario $usuario, string $senha): bool {
        try {
            $sql = "INSERT INTO usuarios (login, senha, permissao) VALUES (?, ?, ?)";
            $hashSenha = password_hash($senha, PASSWORD_BCRYPT);
            $params = [
                $usuario->getLogin(),
                $hashSenha,
                $usuario->getPermissao()
            ];
            
            DbConnect::executePrepared($sql, "sss", $params);
            
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar usuário: " . $e->getMessage());
        }
    }

    /**
     * Lista todos os usuários cadastrados
     */
    public static function listar(): array {
        try {
            $sql = "SELECT * FROM usuarios";
            $result = DbConnect::query($sql);
            
            $usuarios = [];
            while ($row = $result->fetch_assoc()) {
                $usuario = new Usuario($row['login'], $row['permissao'], $row['id']);
                $usuarios[] = $usuario;
            }
            
            return $usuarios;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar usuários: " . $e->getMessage());
        }
    }

    /**
     * Busca um usuário pelo ID
     */
    public static function buscarPorId(int $id): ?Usuario {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = ?";
            $result = DbConnect::executePrepared($sql, "i", [$id]);
            
            if ($row = $result->fetch_assoc()) {
                return new Usuario($row['login'], $row['permissao'], $row['id']);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar usuário: " . $e->getMessage());
        }
    }

    /**
     * Busca um usuário pelo login
     */
    public static function buscarPorLogin(string $login): ?Usuario {
        try {
            $sql = "SELECT * FROM usuarios WHERE login = ?";
            $result = DbConnect::executePrepared($sql, "s", [$login]);
            
            if ($row = $result->fetch_assoc()) {
                return new Usuario($row['login'], $row['permissao'], $row['id']);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar usuário: " . $e->getMessage());
        }
    }

    /**
     * Valida as credenciais de login
     */
    public static function validarLogin(string $login, string $senha): bool {
        try {
            $sql = "SELECT senha FROM usuarios WHERE login = ?";
            $result = DbConnect::executePrepared($sql, "s", [$login]);
            
            if ($row = $result->fetch_assoc()) {
                return password_verify($senha, $row['senha']);
            }
            
            return false;
        } catch (Exception $e) {
            throw new Exception("Erro ao validar login: " . $e->getMessage());
        }
    }

    /**
     * Atualiza as permissões de um usuário
     */
    public static function atualizarPermissoes(int $id, string $novaPermissao): bool {
        try {
            $sql = "UPDATE usuarios SET permissao = ? WHERE id = ?";
            DbConnect::executePrepared($sql, "si", [$novaPermissao, $id]);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar permissão: " . $e->getMessage());
        }
    }

    /**
     * Exclui um usuário do sistema
     */
    public static function deletar(int $id): bool {
        try {
            $sql = "DELETE FROM usuarios WHERE id = ?";
            DbConnect::executePrepared($sql, "i", [$id]);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao deletar usuário: " . $e->getMessage());
        }
    }
}
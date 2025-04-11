<?php
namespace models;

use core\DbConnect;
use Endereco\Endereco;
use Exception;

class EnderecoModel {
    /**
     * Cadastra um novo endereço no banco de dados
     */
    public static function cadastrar(Endereco $endereco): bool {
        try {
            $sql = "INSERT INTO endereco (setor, andar, posicao) VALUES (?, ?, ?)";
            $params = [
                $endereco->getSetor(),
                $endereco->getAndar(),
                $endereco->getPosicao()
            ];
            
            DbConnect::executePrepared($sql, "sii", $params);
            
            // Obter o ID gerado e atribuir ao objeto endereço
            $id = DbConnect::getLastInsertId();
            $endereco->setId($id);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar endereço: " . $e->getMessage());
        }
    }

    /**
     * Lista todos os endereços cadastrados
     */
    public static function listar(): array {
        try {
            $sql = "SELECT * FROM endereco";
            $result = DbConnect::query($sql);
            
            $enderecos = [];
            while ($row = $result->fetch_assoc()) {
                $endereco = new Endereco($row["setor"], $row["andar"], $row["posicao"], $row["id"]);
                $enderecos[] = $endereco;
            }
            
            return $enderecos;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar endereços: " . $e->getMessage());
        }
    }

    /**
     * Busca um endereço pelo ID
     */
    public static function buscarPorId(int $id): ?Endereco {
        try {
            $sql = "SELECT * FROM endereco WHERE id = ?";
            $result = DbConnect::executePrepared($sql, "i", [$id]);
            
            if ($row = $result->fetch_assoc()) {
                return new Endereco($row["setor"], $row["andar"], $row["posicao"], $row["id"]);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar endereço: " . $e->getMessage());
        }
    }

    /**
     * Busca um endereço pelos dados (setor, andar, posição)
     */
    public static function buscarPorDados(Endereco $endereco): ?Endereco {
        try {
            $sql = "SELECT * FROM endereco WHERE setor = ? AND andar = ? AND posicao = ?";
            $params = [
                $endereco->getSetor(),
                $endereco->getAndar(),
                $endereco->getPosicao()
            ];
            
            $result = DbConnect::executePrepared($sql, "sii", $params);
            
            if ($row = $result->fetch_assoc()) {
                return new Endereco($row["setor"], $row["andar"], $row["posicao"], $row["id"]);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar endereço: " . $e->getMessage());
        }
    }

    /**
     * Atualiza um endereço existente
     */
    public static function atualizar(Endereco $endereco): bool {
        try {
            $sql = "UPDATE endereco SET setor = ?, andar = ?, posicao = ? WHERE id = ?";
            $params = [
                $endereco->getSetor(),
                $endereco->getAndar(),
                $endereco->getPosicao(),
                $endereco->getId()
            ];
            
            DbConnect::executePrepared($sql, "siii", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar endereço: " . $e->getMessage());
        }
    }

    /**
     * Exclui um endereço do banco de dados
     */
    public static function deletar(Endereco $endereco): bool {
        try {
            $sql = "DELETE FROM endereco WHERE id = ?";
            DbConnect::executePrepared($sql, "i", [$endereco->getId()]);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao deletar endereço: " . $e->getMessage());
        }
    }
}

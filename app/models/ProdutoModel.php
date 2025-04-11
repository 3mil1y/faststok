<?php
namespace models;

use core\DbConnect;
use Produto\Produto;
use Endereco\Endereco;
use Exception;

class ProdutoModel {

    // private DbConnect $dbConnect;

    // public function __construct(DbConnect $dbConnect) {
    //     $this->dbConnect = $dbConnect;
    // }

    /**
     * Função para inserir um novo produto no banco de dados.
     */
    public static function Cadastrar(Produto $produto): bool {
        try {
            // SQL para inserir o produto
            $sql = "INSERT INTO produto (codBarras, nome, quantidade, validade, idEndereco) 
                    VALUES (?, ?, ?, ?, ?)";
            
            // Parâmetros a serem passados para o prepared statement
            $params = self::extrairDadosProduto($produto);
            
            // Executa a query
            DbConnect::executePrepared($sql, "ssiss", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir produto: " . $e->getMessage());
        }
    }

    /**
     * Função para listar todos os produtos do banco de dados.
     */
    public static function listar(): array {
        try {
            $sql = "SELECT produto.*, endereco.* FROM produto INNER JOIN endereco ON produto.idEndereco = endereco.id";
            $result = DbConnect::query($sql);
            
            $produtos = [];
            while ($row = $result->fetch_assoc()) {
                $produtos[] = self::mapearProduto($row);
            }
            return $produtos;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    /**
     * Lista os produtos próximos a validade.
     */
    public static function listarPorValidade(): array {
        try {
            $sql = "SELECT produto.*, endereco.* FROM produto INNER JOIN endereco ON produto.idEndereco = endereco.id WHERE produto.validade <= DATE_ADD(CURDATE(), INTERVAL 3 DAY)";
            $result = DbConnect::query($sql);
            
            $produtos = [];
            while ($row = $result->fetch_assoc()) {
                $produtos[] = self::mapearProduto($row);
            }
            return $produtos;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    /**
     * Lista os produtos com baixo estoque.
     */
    public static function listarPorEstoque(): array {
        try {
            $sql = "SELECT produto.*, endereco.* FROM produto
                    INNER JOIN endereco ON produto.idEndereco = endereco.id
                    WHERE produto.quantidade <= 10 
                    GROUP BY produto.codBarras";
            $result = DbConnect::query($sql);
            
            $produtos = [];
            while ($row = $result->fetch_assoc()) {
                $produtos[] = self::mapearProduto($row);
            }
            return $produtos;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    public static function listarPorIdEstoque(int $id): array {
        try {
            $sql = "SELECT produto.*, endereco.* FROM produto
                    INNER JOIN endereco ON produto.idEndereco = endereco.id
                    WHERE produto.idEndereco = ?";
            $params = [$id];
            $result = DbConnect::executePrepared($sql, "i", $params);
            
            $produtos = [];
            while ($row = $result->fetch_assoc()) {
                $produtos[] = self::mapearProduto($row);
            }
            return $produtos;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    /**
     * Função para listar produtos pelo ID.
     */
    public static function listarPorId(int $id): ?Produto {
        try {
            // SQL para listar produtos pelo ID
            $sql = "SELECT produto.*, endereco.* 
                    FROM produto
                    INNER JOIN endereco ON produto.idEndereco = endereco.id
                    WHERE produto.idProduto = ?";
            
            // Parametrização da consulta
            $params = [$id];
            
            // Executa a consulta com executePrepared
            $result = DbConnect::executePrepared($sql, "i", $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapearProduto($row);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produto pelo ID: " . $e->getMessage());
        }
    }
    

    /**
     * Função para listar produtos pelo código de barras.
     */
    public static function listarPorCodigoDeBarras(string $codBarras): array {
        try {
            // SQL para listar produtos pelo código de barras
            $sql = "SELECT produto.*, endereco.* 
                    FROM produto
                    INNER JOIN endereco ON produto.idEndereco = endereco.id
                    WHERE produto.codBarras = ?";
            
            // Parametrização da consulta
            $params = [$codBarras];
            
            // Executa a consulta com executePrepared
            $result = DbConnect::executePrepared($sql, "s", $params);
            
            // Mapeia os resultados
            $produtos = [];
            while ($row = $result->fetch_assoc()) {
                $produtos[] = self::mapearProduto($row);
            }
            
            return $produtos;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos pelo código de barras: " . $e->getMessage());
        }
    }


    public static function listarPorNome(string $nome): array {
        try {
            // SQL para listar produtos pelo nome
            $sql = "SELECT produto.*, endereco.* 
                    FROM produto
                    INNER JOIN endereco ON produto.idEndereco = endereco.id
                    WHERE produto.nome LIKE ?";
            
            // Parametrização da consulta
            $params = ["%".$nome."%"];
            
            // Executa a consulta com executePrepared
            $result = DbConnect::executePrepared($sql, "s", $params);
            
            // Mapeia os resultados
            $produtos = [];
            while ($row = $result->fetch_assoc()) {
                $produtos[] = self::mapearProduto($row);
            }
            
            return $produtos;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos pelo nome: " . $e->getMessage());
        }
    }

    /**
     * Função para atualizar um produto no banco de dados.
     */
    public static function atualizarProduto(Produto $produto): bool {
        try {
            $sql = "UPDATE produto SET nome = ?, codBarras = ?, quantidade = ?, validade = ?, idEndereco = ?
                    WHERE idProduto = ?";
            
            // Parâmetros para a query
            $params = self::extrairDadosProdutoCompleto($produto);
            
            DbConnect::executePrepared($sql, "ssissi", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    public static function atualizarEnderecoProdutos(Endereco $origem, Endereco $destino): bool {
        try {
            $sql = "UPDATE produto SET idEndereco = ?
                    WHERE idEndereco = ?";
            
            // Parâmetros para a query
            $params = [$destino->getId(), $origem->getId()];
            
            DbConnect::executePrepared($sql, "ii", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    /**
     * Função para atualizar quantidade de um produto no banco de dados.
     */
    public static function alterarEstoque(int $idProduto, int $quantidade): bool {
        try {
            $sql = "UPDATE produto SET quantidade = ?
                    WHERE idProduto = ?";
            
            // Parâmetros para a query
            $params = [$quantidade, $idProduto];
            
            DbConnect::executePrepared($sql, "ii", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar quantidade do produto: " . $e->getMessage());
        }
    }

    /**
     * Função para excluir um produto do banco de dados.
     */
    public static function excluirProduto(int $idProduto): bool {
        try {
            $sql = "DELETE FROM produto WHERE idProduto = ?";
            $params = [$idProduto];
            DbConnect::executePrepared($sql, "i", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }

    public static function excluirProdutoPorEndereco(Endereco $endereco): bool {
        try {
            $sql = "DELETE FROM produto WHERE idEndereco = ?";
            $params = [$endereco->getId()];
            DbConnect::executePrepared($sql, "i", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto por endereço: " . $e->getMessage());
        }
    }

    /**
     * Função para mapear o resultado do banco para o objeto Produto.
     */
    private static function mapearProduto(array $row): Produto {
        $endereco = new Endereco($row['setor'], $row['andar'], $row['posicao'], $row['id']);
        return new Produto($row['codBarras'], $row['nome'], $row['quantidade'], $row['validade'], $endereco, $row['idProduto']);
    }

    /**
     * Extrai os dados básicos do produto para inserção
     */
    private static function extrairDadosProduto(Produto $produto): array {
        return [
            $produto->getCodBarras(),
            $produto->getNome(),
            $produto->getQuantidade(),
            $produto->getValidade(),
            $produto->getEndereco()->getId()
        ];
    }

    /**
     * Extrai os dados completos do produto para atualização
     */
    private static function extrairDadosProdutoCompleto(Produto $produto): array {
        return [
            $produto->getNome(),
            $produto->getCodBarras(),
            $produto->getQuantidade(),
            $produto->getValidade(),
            $produto->getEndereco()->getId(),
            $produto->getIdProduto()
        ];
    }

}
?>
<?php
namespace App\Models;

use App\Entities\Product;
use App\Entities\Location;
use App\Core\Database;
use Exception;

class ProdutoModel {

    /* needs refactoring */

    // private Database $Database;

    // public function __construct(Database $Database) {
    //     $this->Database = $Database;
    // }

    /**
     * Função para inserir um novo product no banco de dados.
     */
    public static function Cadastrar(Product $product): bool {
        try {
            // SQL para inserir o product
            $sql = "INSERT INTO product (codBarras, nome, quantidade, validade, idlocation) 
                    VALUES (?, ?, ?, ?, ?)";
            
            // Parâmetros a serem passados para o prepared statement
            $params = self::extrairDadosproduct($product);
            
            // Executa a query
            Database::executePrepared($sql, "ssiss", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir product: " . $e->getMessage());
        }
    }

    /**
     * Função para listar todos os products do banco de dados.
     */
    public static function list(): array {
        try {
            $sql = "SELECT product.*, location.* FROM product INNER JOIN location ON product.idEndereco = location.id";
            $result = Database::query($sql);
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::productMap($row);
            }
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar products: " . $e->getMessage());
        }
    }

    /**
     * Lista os products próximos a validade.
     */
    public static function listByExpiry(): array {
        try {
            $sql = "SELECT product.*, location.* FROM product INNER JOIN location ON product.idEndereco = location.id WHERE product.validade <= DATE_ADD(CURDATE(), INTERVAL 3 DAY)";
            $result = Database::query($sql);
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::productMap($row);
            }
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar products: " . $e->getMessage());
        }
    }

    /**
     * Lista os products com baixo estoque.
     */
    public static function listByStock(): array {
        try {
            $sql = "SELECT product.*, location.* FROM product
                    INNER JOIN location ON product.idEndereco = location.id
                    WHERE product.quantidade <= 10 
                    GROUP BY product.codBarras";
            $result = Database::query($sql);
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::productMap($row);
            }
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar products: " . $e->getMessage());
        }
    }

    public static function listarPorIdEstoque(int $id): array {
        try {
            $sql = "SELECT product.*, location.* FROM product
                    INNER JOIN location ON product.idlocation = location.id
                    WHERE product.idlocation = ?";
            $params = [$id];
            $result = Database::executePrepared($sql, "i", $params);
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::mapearproduct($row);
            }
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar products: " . $e->getMessage());
        }
    }

    /**
     * Função para listar products pelo ID.
     */
    public static function listarPorId(int $id): ?Product {
        try {
            // SQL para listar products pelo ID
            $sql = "SELECT product.*, location.* 
                    FROM product
                    INNER JOIN location ON product.idlocation = location.id
                    WHERE product.idproduct = ?";
            
            // Parametrização da consulta
            $params = [$id];
            
            // Executa a consulta com executePrepared
            $result = Database::executePrepared($sql, "i", $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapearproduct($row);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar product pelo ID: " . $e->getMessage());
        }
    }
    

    /**
     * Função para listar products pelo código de barras.
     */
    public static function listarPorCodigoDeBarras(string $codBarras): array {
        try {
            // SQL para listar products pelo código de barras
            $sql = "SELECT product.*, location.* 
                    FROM product
                    INNER JOIN location ON product.idlocation = location.id
                    WHERE product.codBarras = ?";
            
            // Parametrização da consulta
            $params = [$codBarras];
            
            // Executa a consulta com executePrepared
            $result = Database::executePrepared($sql, "s", $params);
            
            // Mapeia os resultados
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::mapearproduct($row);
            }
            
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar products pelo código de barras: " . $e->getMessage());
        }
    }


    public static function listarPorNome(string $nome): array {
        try {
            // SQL para listar products pelo nome
            $sql = "SELECT product.*, location.* 
                    FROM product
                    INNER JOIN location ON product.idlocation = location.id
                    WHERE product.nome LIKE ?";
            
            // Parametrização da consulta
            $params = ["%".$nome."%"];
            
            // Executa a consulta com executePrepared
            $result = Database::executePrepared($sql, "s", $params);
            
            // Mapeia os resultados
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::mapearproduct($row);
            }
            
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar products pelo nome: " . $e->getMessage());
        }
    }

    /**
     * Função para atualizar um product no banco de dados.
     */
    public static function atualizarproduct(Product $product): bool {
        try {
            $sql = "UPDATE product SET nome = ?, codBarras = ?, quantidade = ?, validade = ?, idlocation = ?
                    WHERE idproduct = ?";
            
            // Parâmetros para a query
            $params = self::extrairDadosproductCompleto($product);
            
            Database::executePrepared($sql, "ssissi", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar product: " . $e->getMessage());
        }
    }

    public static function atualizarlocationproducts(Location $origem, Location $destino): bool {
        try {
            $sql = "UPDATE product SET idlocation = ?
                    WHERE idlocation = ?";
            
            // Parâmetros para a query
            $params = [$destino->getId(), $origem->getId()];
            
            Database::executePrepared($sql, "ii", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar product: " . $e->getMessage());
        }
    }

    /**
     * Função para atualizar quantidade de um product no banco de dados.
     */
    public static function alterarEstoque(int $idproduct, int $quantidade): bool {
        try {
            $sql = "UPDATE product SET quantidade = ?
                    WHERE idproduct = ?";
            
            // Parâmetros para a query
            $params = [$quantidade, $idproduct];
            
            Database::executePrepared($sql, "ii", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar quantidade do product: " . $e->getMessage());
        }
    }

    /**
     * Função para excluir um product do banco de dados.
     */
    public static function excluirproduct(int $idproduct): bool {
        try {
            $sql = "DELETE FROM product WHERE idproduct = ?";
            $params = [$idproduct];
            Database::executePrepared($sql, "i", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir product: " . $e->getMessage());
        }
    }

    public static function deleteProductByLocation(Location $location): bool {
        try {
            $sql = "DELETE FROM product WHERE idlocation = ?";
            $params = [$location->getId()];
            Database::executePrepared($sql, "i", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir product por endereço: " . $e->getMessage());
        }
    }

    /**
     * Função para mapear o resultado do banco para o objeto product.
     */
    private static function productMap(array $row): Product {
        $location = new Location($row['sector'], $row['floor'], $row['position'], $row['id']);
        return new Product($row['codBarras'], $row['nome'], $row['quantidade'], $row['validade'], $location, $row['idProduto']);
    }

    /**
     * Extrai os dados básicos do product para inserção
     */
    private static function extractBasicData(Product $product): array {
        return [
            $product->getCodBarras(),
            $product->getNome(),
            $product->getQuantidade(),
            $product->getValidade(),
            $product->getlocation()->getId()
        ];
    }

    /**
     * Extrai os dados completos do product para atualização
     */
    private static function extractData(Product $product): array {
        return [
            $product->getNome(),
            $product->getCodBarras(),
            $product->getQuantidade(),
            $product->getValidade(),
            $product->getlocation()->getId(),
            $product->getIdproduct()
        ];
    }

}
?>
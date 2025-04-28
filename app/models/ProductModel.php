<?php
namespace App\Models;

use App\Entities\Product;
use App\Entities\Location;
use App\Core\Database\Database;
use Exception;

class ProductModel {
    /**
     * Create a new product in database
     */
    public static function create(Product $product): bool {
        try {
            $sql = "INSERT INTO product (barcode, name, quantity, expiry_date, location_id) 
                    VALUES (?, ?, ?, ?, ?)";
            
            $params = self::extractBasicData($product);
            
            Database::executePrepared($sql, "ssiss", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir produto: " . $e->getMessage());
        }
    }

    /**
     * List all products
     */
    public static function list(): array {
        try {
            $sql = "SELECT product.*, location.* FROM product 
                    INNER JOIN location ON product.location_id = location.id";
            $result = Database::query($sql);
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::mapToProduct($row);
            }
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    /**
     * List products near expiry date
     * need refactor
     */
    public static function getByExpiryDate(): array {
        try {
            $sql = "SELECT product.*, location.* FROM product 
                    INNER JOIN location ON product.location_id = location.id 
                    WHERE product.expiry_date <= DATE_ADD(CURDATE(), INTERVAL 3 DAY)";
            $result = Database::query($sql);
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::mapToProduct($row);
            }
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    /**
     * List products with low stock
     * need refactor
     */
    public static function getByLowStock(): array {
        try {
            $sql = "SELECT product.barcode,
                        MIN(product.product_id) as product_id,
                        MIN(product.name) as name,
                        SUM(product.quantity) as quantity,
                        MIN(product.expiry_date) as expiry_date,
                        MIN(location.id) as location_id,
                        MIN(location.sector) as sector,
                        MIN(location.floor) as floor,
                        MIN(location.position) as position
                    FROM product
                    INNER JOIN location ON product.location_id = location.id
                    WHERE product.quantity <= ?
                    GROUP BY product.barcode";
            $params = [10];
            $result = Database::executePrepared($sql, "i", $params);
            
            $products = [];
            while ($row = $result->fetch_assoc()) {
                $products[] = self::mapToProduct($row);
            }
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos: " . $e->getMessage());
        }
    }

    /*
    *Get product by -- informed --
    */
    private static function getProductBy(string $field, int|string $value): ?Product{
        try{
            $sql = "SELECT product.*, location.* 
                    FROM product
                    INNER JOIN location ON product.location_id = location.id
                    WHERE product.$field = ?";
            
            $params = [$value];
            $paramType = is_int($value) ? "i" : "s";
            $result = Database::executePrepared($sql, $paramType, $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapToProduct($row);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar produto pelo $field: " . $e->getMessage());
        }
    }

    private static function getMultipleProductsBy(string $field, int|string $value, string $operator = '='): array{
        try {
            $sql = "SELECT product.*, location.* 
                    FROM product
                    INNER JOIN location ON product.location_id = location.id
                    WHERE product.$field $operator ?";
            
            $params = [$value];
            $paramType = is_int($value) ? "i" : "s";
            $result = Database::executePrepared($sql, $paramType, $params);
            
            $products = []; 
            while ($row = $result->fetch_assoc()) {
                $products[] = self::mapToProduct($row);
            }
            
            return $products;
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos pelo código de barras: " . $e->getMessage());
        }
    }

    /**
     * Get product by ID
     */
    public static function getById(int $id): ?Product {
        try {
            return self::getProductBy("product_id", $id);
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar produto pelo ID: " . $e->getMessage());
        }
    }

    /**
     * Get products by barcode
     */
    public static function getByBarcode(string $barcode): array {
        try {
            return self::getMultipleProductsBy("barcode", $barcode);
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos pelo código de barras: " . $e->getMessage());
        }
    }

    /**
     * Get products by name
     */
    public static function getByName(string $name): array {
        try {
            return self::getMultipleProductsBy("name", "%$name%", "like");
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos pelo nome: " . $e->getMessage());
        }
    }
    
    /**
     * Get products by location
     */
    public static function getByLocationId(int $locationId): array {
        try {
            return self::getMultipleProductsBy("location_id", $locationId);
        } catch (Exception $e) {
            throw new Exception("Erro ao listar produtos pelo endereço: " . $e->getMessage());
        }
    }

    /**
     * Update product
     */
    public static function update(Product $product): bool {
        try {
            $sql = "UPDATE product 
                    SET name = ?, barcode = ?, quantity = ?, expiry_date = ?, location_id = ?
                    WHERE product_id = ?";
                    
            Database::executePrepared($sql, "ssissi", self::extractData($product));
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }
    
    /**
     * Update a field of products
     */
    public static function updateField(string $modifiedField, string|int $modifiedValue, string $baseField, string|int $baseValue): bool {
        try {
            $sql = "UPDATE product SET $modifiedField = ? WHERE $baseField = ?";
            $paramsType = [is_int($modifiedValue) ? "i" : "s", is_int($baseValue) ? "i" : "s"];
            Database::executePrepared($sql, $paramsType, [$modifiedValue, $baseValue]);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }
    
    /**
     * Update all products in a location
     */

    public static function updateAllLocations($originLocationId, $destinationLocationId): bool {
        try {
            $sql = "UPDATE product SET location_id = ? WHERE location_id = ?";
            Database::executePrepared($sql, "ii", [$destinationLocationId, $originLocationId]);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    /**
     * Update stock quantity of a product
     */
    public static function updateStock(Product $product): bool {
        try {
            $sql = "UPDATE product SET quantity = ? WHERE product_id = ?";
            Database::executePrepared($sql, "ii", [$product->getQuantity(), $product->getId()]);

            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar estoque: " . $e->getMessage());
        }
    }
    
    /*
    * Delete product by -- informed --
    */

    public static function deleteProductsBy(string $field, string|int $value): bool {
        try {
            $sql = "DELETE FROM product WHERE $field = ?";
            $params = [$value];
            $paramType = "s";
            if(is_int($value)){
                $paramType = "i";
            }
            Database::executePrepared($sql, $paramType, $params);
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }
    
    /**
     * Delete product
     */
    public static function deleteById(int $id): bool {
        try {
            return self::deleteProductsBy("product_id", $id);
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }

    /**
     * Delete product by location id
     */

    public static function deleteByLocationId(int $locationId): bool {
        try {
            return self::deleteProductsBy("location_id", $locationId);
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }

    /**
     * Delete products where stock is 0
     */

    public static function deleteByStock(): bool {
        try {
            return self::deleteProductsBy("quantity", 0);
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }

    /**
     * Map database result to Product object
    */
    private static function mapToProduct(array $row): Product {
        $location = new Location($row['sector'], $row['floor'], $row['position'], $row['location_id']);
        return new Product(
            $row['barcode'],
            $row['name'],
            $row['quantity'],
            $row['expiry_date'],
            $location,
            $row['product_id']
        );
    }

    /**
     * Extract basic product data for insertion
     */
    private static function extractBasicData(Product $product): array {
        return [
            $product->getBarcode(),
            $product->getName(),
            $product->getQuantity(),
            $product->getExpiryDate(),
            $product->getLocation()->getId()
        ];
    }

    /**
     * Extract complete product data for update
     */
    private static function extractData(Product $product): array {
        return [
            $product->getName(),
            $product->getBarcode(),
            $product->getQuantity(),
            $product->getExpiryDate(),
            $product->getLocation()->getId(),
            $product->getId()
        ];
    }
}
<?php
namespace App\Models;

use App\Entities\Product;
use App\Entities\Location;
use App\Core\Database;
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
     */
    public static function getByLowStock(): array {
        try {
            $sql = "SELECT product.*, location.* FROM product
                    INNER JOIN location ON product.location_id = location.id
                    WHERE product.quantity <= 10 
                    GROUP BY product.barcode";
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
     * Get product by ID
     */
    public static function getById(int $id): ?Product {
        try {
            $sql = "SELECT product.*, location.* 
                    FROM product
                    INNER JOIN location ON product.location_id = location.id
                    WHERE product.id = ?";
            
            $params = [$id];
            $result = Database::executePrepared($sql, "i", $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapToProduct($row);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Erro ao buscar produto pelo ID: " . $e->getMessage());
        }
    }

    /**
     * Get products by barcode
     */
    public static function getByBarcode(string $barcode): array {
        try {
            $sql = "SELECT product.*, location.* 
                    FROM product
                    INNER JOIN location ON product.location_id = location.id
                    WHERE product.barcode = ?";
            
            $params = [$barcode];
            $result = Database::executePrepared($sql, "s", $params);
            
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
     * Update product
     */
    public static function update(Product $product): bool {
        try {
            $sql = "UPDATE product 
                    SET name = ?, barcode = ?, quantity = ?, expiry_date = ?, location_id = ?
                    WHERE id = ?";
            
            $params = self::extractData($product);
            
            Database::executePrepared($sql, "ssissi", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao atualizar produto: " . $e->getMessage());
        }
    }

    /**
     * Delete product
     */
    public static function delete(int $id): bool {
        try {
            $sql = "DELETE FROM product WHERE id = ?";
            $params = [$id];
            Database::executePrepared($sql, "i", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir produto: " . $e->getMessage());
        }
    }

    /**
     * Map database result to Product object
     */
    private static function mapToProduct(array $row): Product {
        $location = new Location($row['sector'], $row['floor'], $row['position'], $row['id']);
        return new Product(
            $row['barcode'],
            $row['name'],
            $row['quantity'],
            $row['expiry_date'],
            $location,
            $row['id']
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

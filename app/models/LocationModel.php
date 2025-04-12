<?php
namespace App\Models;

use App\Core\Database;
use App\Entities\Location;
use Exception;

class LocationModel {
    /**
     * Create a new location in the database
     */
    public static function create(Location $location): bool {
        try {
            $sql = "INSERT INTO location (sector, floor, position) VALUES (?, ?, ?)";
            $params = [
                $location->getSector(),
                $location->getFloor(),
                $location->getPosition()
            ];
            
            Database::executePrepared($sql, "sii", $params);
            
            // Get generated ID and assign to location object
            $id = Database::getLastInsertId();
            $location->setId($id);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erro ao cadastrar endereço: " . $e->getMessage());
        }
    }

    /**
     * List all registered locations
     */
    public static function list(): array {
        try {
            $sql = "SELECT * FROM location ORDER BY sector, floor, position";
            $result = Database::query($sql);
            
            $locations = [];
            while ($row = $result->fetch_assoc()) {
                $locations[] = self::mapToLocation($row);
            }
            
            return $locations;
        } catch (Exception $e) {
            throw new Exception("Error listing locations: " . $e->getMessage());
        }
    }

    /**
     * Find location by ID
     */
    public static function findById(int $id): ?Location {
        try {
            $sql = "SELECT * FROM location WHERE id = ?";
            $params = [$id];
            
            $result = Database::executePrepared($sql, "i", $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapToLocation($row);
            }
            
            return null;
        } catch (Exception $e) {
            throw new Exception("Error finding location: " . $e->getMessage());
        }
    }

    /**
     * Find location by data
     */
    public static function findByData(Location $location): ?Location {
        try {
            $sql = "SELECT * FROM location WHERE sector = ? AND floor = ? AND position = ?";
            $params = [
                $location->getSector(),
                $location->getFloor(),
                $location->getPosition()
            ];
            
            $result = Database::executePrepared($sql, "sii", $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapToLocation($row);
            }
            
            return self::create($location) ? $location : null;
        } catch (Exception $e) {
            throw new Exception("Error finding location: " . $e->getMessage());
        }
    }

    /**
     * Delete a location
     */
    public static function delete(int $id): bool {
        try {
            $sql = "DELETE FROM location WHERE id = ?";
            $params = [$id];
            Database::executePrepared($sql, "i", $params);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error deleting location: " . $e->getMessage());
        }
    }

    /**
     * Update location details
     */
    public static function update(Location $location): bool {
        try {
            $sql = "UPDATE location SET sector = ?, floor = ?, position = ? WHERE id = ?";
            $params = [
                $location->getSector(),
                $location->getFloor(),
                $location->getPosition(),
                $location->getId()
            ];
            
            Database::executePrepared($sql, "siii", $params);
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Error updating location: " . $e->getMessage());
        }
    }
    /**
     * Get all locations in a specific sector
     */

    public static function getLocationsBySector(string $sector): array {
        try {
            $sql = "SELECT * FROM location WHERE sector = ? ORDER BY floor, position";
            $params = [$sector];
            
            $result = Database::executePrepared($sql, "s", $params);
            
            $locations = [];
            while ($row = $result->fetch_assoc()) {
                $locations[] = self::mapToLocation($row);
            }
            
            return $locations;
        } catch (Exception $e) {
            throw new Exception("Error getting locations by sector: " . $e->getMessage());
        }
    }

    /**
     * Map database row to Location entity
     */
    private static function mapToLocation(array $row): Location {
        return new Location(
            $row['sector'],
            $row['floor'],
            $row['position'],
            $row['id']
        );
    }
}

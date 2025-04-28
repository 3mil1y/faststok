<?php
namespace App\Models;

use App\Core\Database\Database;
use App\Entities\Location;
use Exception;

class LocationModel {
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
     * Find location by -- informed --
     */

    private static function getLocationsBy(string $field, string|int $value): ?Location {
        try {
            $sql = "SELECT * FROM location WHERE $field = ?";
            $params = [$value];
            $result = Database::executePrepared($sql, "s", $params);
            
            if ($row = $result->fetch_assoc()) {
                return self::mapToLocation($row);
            }

            throw new Exception("Location not found");
        } catch (Exception $e) {
            throw new Exception("Error finding location: " . $e->getMessage());
        }
    }

    /**
     * Find location by ID
     */
    public static function findById(int $id): ?Location {
        try {
            return self::getLocationsBy("id", $id); 
        } catch (Exception $e) {
            throw new Exception("Error finding location: " . $e->getMessage());
        }
    }

    /**
     * Find fields by Data
     */
    
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
            
            //return self::create($location) ? $location : null;
        } catch (Exception $e) {
            throw new Exception("Error finding location: " . $e->getMessage());
        }
    }

    public static function findIdByData(Location $location): ?int {
        try {
            $sql = "SELECT id FROM location WHERE sector = ? AND floor = ? AND position = ?";
            $params = [
                $location->getSector(),
                $location->getFloor(),
                $location->getPosition()
            ];
            
            $result = Database::executePrepared($sql, "sii", $params);
            
            return $result->fetch_assoc()['id'] ?? null;
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

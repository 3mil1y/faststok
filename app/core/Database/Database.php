<?php
namespace App\Core\Database;

use mysqli;
use Exception;

class Database {
    private static ?mysqli $connection = null;

    public static function getConnection(): mysqli {
        if (self::$connection === null) {
            try {
                self::$connection = new mysqli(
                    DatabaseConfig::getHost(),
                    DatabaseConfig::getUser(),
                    DatabaseConfig::getPass(),
                    DatabaseConfig::getDB()
                );
                
                if (self::$connection->connect_error) {
                    throw new Exception('Database connection error: ' . self::$connection->connect_error);
                }

                self::$connection->set_charset('utf8');
            } catch (Exception $e) {
                throw new Exception('Database connection error: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }

    public static function query(string $sql) {
        $result = self::getConnection()->query($sql);
        if ($result === false) {
            throw new Exception('Query error: ' . self::getConnection()->error);
        }
        return $result;
    }

    public static function executePrepared(string $sql, string $types, array $params) {
        $stmt = self::getConnection()->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Prepare statement error: ' . self::getConnection()->error);
        }

        $stmt->bind_param($types, ...$params);
        if (!$stmt->execute()) {
            throw new Exception('Execute error: ' . $stmt->error);
        }

        $result = $stmt->get_result();
        $stmt->close();
        
        return $result;
    }

    public static function getLastInsertId(): int {
        return self::getConnection()->insert_id;
    }

    public static function closeConnection(): void {
        if (self::$connection !== null) {
            self::$connection->close();
            self::$connection = null;
        }
    }
}

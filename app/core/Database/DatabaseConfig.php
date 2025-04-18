<?php
namespace App\Core\Database;

class DatabaseConfig {
    private static function getEnvValue(string $key, string $default = '') {
        $envFile = dirname(__DIR__, 3) . '/.env';
        if (!file_exists($envFile)) {
            return $default;
        }

        $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos($line, '=') !== false) {
                list($envKey, $envValue) = explode('=', $line, 2);
                if (trim($envKey) === $key) {
                    return trim($envValue);
                }
            }
        }
        return $default;
    }

    public static function getHost(): string {
        return self::getEnvValue('DB_HOST', 'localhost');
    }

    public static function getUser(): string {
        return self::getEnvValue('DB_USER', 'root');
    }

    public static function getPass(): string {
        return self::getEnvValue('DB_PASS', '');
    }

    public static function getDB(): string {
        return self::getEnvValue('DB_NAME', 'faststok');
    }
    
    public static function init() {
        date_default_timezone_set('America/Sao_Paulo');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
}

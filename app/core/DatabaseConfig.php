<?php
namespace App\Core;

class DatabaseConfig {
    const HOST = 'localhost';
    const USER = 'root';
    const PASS = '';
    const DB = 'faststok';
    
    public static function init() {
        date_default_timezone_set('America/Sao_Paulo');
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }
}

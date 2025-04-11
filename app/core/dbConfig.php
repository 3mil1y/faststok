<?php

namespace core;

use core\DbConnect;

class DbConfig {
    // Método para configurar a conexão com o banco de dados
    public static function init(): void {
        // Carrega as credenciais do arquivo config.php
        $config = require_once 'config.php'; // Ajuste o caminho conforme necessário
        
        $host = $config['DB_HOST'];
        $username = $config['DB_USERNAME'];
        $password = $config['DB_PASSWORD'];
        $database = $config['DB_DATABASE'];
        
        // Configura a conexão com o banco de dados
        DbConnect::configure($host, $username, $password, $database);
    }
}

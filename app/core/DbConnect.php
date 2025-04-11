<?php
namespace core;

use mysqli;
use Exception;

class DbConnect {
    private static string $host;
    private static string $username;
    private static string $password;
    private static string $database;
    private static ?mysqli $connection = null;

    /**
     * Construtor: Inicializa a conexão com o banco de dados.
     * Este construtor agora é privado para evitar instâncias.
     */
    private function __construct() {
        // Não é possível instanciar a classe diretamente.
    }

    /**
     * Configura os parâmetros de conexão.
     */
    public static function configure(string $host, string $username, string $password, string $database): void {
        self::$host = $host;
        self::$username = $username;
        self::$password = $password;
        self::$database = $database;
    }

    /**
     * Estabelece a conexão com o banco de dados.
     * Lança uma exceção em caso de falha.
     */
    private static function connect(): void {
        if (self::$connection === null) {
            self::$connection = new mysqli(self::$host, self::$username, self::$password, self::$database);
            if (self::$connection->connect_error) {
                throw new Exception("Erro de conexão: " . self::$connection->connect_error);
            }
            self::$connection->set_charset("utf8mb4");
        }
    }

    /**
     * Executa uma consulta SQL normal (sem prepared statement).
     * Lança uma exceção se a consulta falhar.
     */
    public static function query(string $sql) {
        self::connect(); // Garante que a conexão seja estabelecida
        $result = self::$connection->query($sql);
        
        if (!$result) {
            throw new Exception("Erro na consulta: " . self::$connection->error);
        }
        
        return $result;
    }

    /**
     * Recebe os dados e parâmetros para uma query SQL e realiza a execução com prepared statement.
     */
    public static function executePrepared(string $sql, string $types, array $params) {
        self::connect(); // Garante que a conexão seja estabelecida
        $stmt = self::prepare($sql);
        $stmt->bind_param($types, ...$params);
        
        if (!$stmt->execute()) {
            throw new Exception("Erro ao executar a consulta preparada: " . $stmt->error);
        }

        return $stmt->get_result();
    }

    /**
     * Prepara uma consulta SQL (para uso com prepared statements).
     * Lança uma exceção se a preparação falhar.
     */
    private static function prepare(string $sql) {
        self::connect(); // Garante que a conexão seja estabelecida
        $stmt = self::$connection->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Erro ao preparar consulta: " . self::$connection->error);
        }
        
        return $stmt;
    }

    /**
     * Retorna o ID do último registro inserido no banco de dados.
     */
    public static function getLastInsertId(): int {
        self::connect(); // Garante que a conexão seja estabelecida
        return self::$connection->insert_id;
    }

    /**
     * Fecha a conexão com o banco de dados.
     */
    public static function close(): void {
        if (self::$connection) {
            self::$connection->close();
            self::$connection = null;
        }
    }

    /**
     * Retorna a conexão ativa com o banco de dados.
     * Útil para classes que precisam de mais controle sobre a conexão.
     */
    public static function getConnection(): ?mysqli {
        self::connect(); // Garante que a conexão seja estabelecida
        return self::$connection;
    }
}

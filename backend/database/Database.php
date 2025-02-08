<?php

class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset = 'utf8mb4';
    private $pdo;
    private $error;

    public function __construct() {
        // Verificar si está en local o producción
        if ($_SERVER['SERVER_NAME'] === 'localhost') {
            // Credenciales para local
            $this->host = 'localhost';
            $this->db = 'ecommersewol'; 
            $this->user = 'root';
            $this->pass = '';
        } else {
            // Credenciales para producción (Hostinger)
            require_once __DIR__ . '/../config/config.php'; // Mejor usar un archivo separado
            $this->host = DB_HOST;
            $this->db = DB_NAME;
            $this->user = DB_USER;
            $this->pass = DB_PASS;
        }

        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            error_log("Error en la conexión: " . $e->getMessage(), 3, __DIR__ . '/../logs/db_errors.log');
            die("Error en la conexión a la base de datos. Contacta al administrador.");
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    public function closeConnection() {
        $this->pdo = null;
    }
}

?>

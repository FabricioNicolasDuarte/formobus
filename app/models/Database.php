<?php

class Database {
   
    private static $instance = null;
    private $connection;


    private function __construct() {
        require_once __DIR__ . '/../../config/database.php';
        try {
            $this->connection = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PASS,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    /**
     * Métodos estáticos.
     * El método estático `getInstance` es la única forma de obtener un objeto Database.
     * Si no existe, lo crea. Si ya existe, devuelve el existente.
     */
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Método para obtener la conexión PDO real
    public function getConnection() {
        return $this->connection;
    }

    // Prevenimos la clonación de la instancia
    private function __clone() {}
}

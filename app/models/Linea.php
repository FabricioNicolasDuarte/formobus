<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Parada.php';

class Linea {
    private $conn;
    private $table = 'lineas';

    public $id;
    public $nombre;
    public $descripcion;
    public $imagen_recorrido;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public static function all() {
        $db = Database::getInstance()->getConnection();
        // Ordenamos por nombre para mantener la consistencia
        $stmt = $db->query("SELECT * FROM lineas ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Linea');
    }
    
    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM lineas WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Linea');
        return $stmt->fetch();
    }

    public function getRecorridoCompleto() {
        // Consulta para IDA
        $query_ida = "SELECT p.* FROM linea_parada lp
                      JOIN paradas p ON lp.parada_id = p.id
                      WHERE lp.linea_id = :id AND lp.sentido = 'IDA'
                      ORDER BY lp.orden ASC";
        $stmt_ida = $this->conn->prepare($query_ida);
        $stmt_ida->execute(['id' => $this->id]);
        $recorrido_ida = $stmt_ida->fetchAll(PDO::FETCH_CLASS, 'Parada');

        // Consulta para VUELTA
        $query_vuelta = "SELECT p.* FROM linea_parada lp
                         JOIN paradas p ON lp.parada_id = p.id
                         WHERE lp.linea_id = :id AND lp.sentido = 'VUELTA'
                         ORDER BY lp.orden ASC";
        $stmt_vuelta = $this->conn->prepare($query_vuelta);
        $stmt_vuelta->execute(['id' => $this->id]);
        $recorrido_vuelta = $stmt_vuelta->fetchAll(PDO::FETCH_CLASS, 'Parada');
        
        return [
            'ida' => $recorrido_ida,
            'vuelta' => $recorrido_vuelta
        ];
    }
}
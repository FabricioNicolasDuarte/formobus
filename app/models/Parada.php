<?php


require_once __DIR__ . '/Database.php';


class Parada {
    
    private $conn;
    private $table = 'paradas';

    public $id;
    public $nombre;
    public $latitud;
    public $longitud;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Obtiene todas las paradas de la base de datos.
     * @return array Lista de objetos Parada.
     */
    public static function all() {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->query("SELECT * FROM paradas ORDER BY nombre ASC");
        return $stmt->fetchAll(PDO::FETCH_CLASS, 'Parada');
    }
    
    /**
     * Obtiene una parada por su ID.
     * @param int $id
     * @return Parada|false
     */
    public static function find($id) {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare("SELECT * FROM paradas WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Parada');
        return $stmt->fetch();
    }
}

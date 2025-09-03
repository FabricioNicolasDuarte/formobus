<?php

require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/Parada.php';


class Historial {
    private $conn;
    private $table = 'historial_viajes';

    public $id;
    public $usuario_id;
    public $origen_parada_id;
    public $destino_parada_id;
    public $fecha_busqueda;

    
    public $origen_parada;
    public $destino_parada;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Guarda una nueva búsqueda en el historial del usuario.
     * @return bool True si se guardó correctamente.
     */
    public function save() {
        $query = "INSERT INTO " . $this->table . " (usuario_id, origen_parada_id, destino_parada_id) VALUES (:usuario_id, :origen_parada_id, :destino_parada_id)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':usuario_id', $this->usuario_id);
        $stmt->bindParam(':origen_parada_id', $this->origen_parada_id);
        $stmt->bindParam(':destino_parada_id', $this->destino_parada_id);

        return $stmt->execute();
    }

    /**
     * Obtiene todo el historial de búsquedas para un usuario específico.
     * @param int $usuario_id El ID del usuario.
     * @return array Una lista de objetos Historial.
     */
    public static function findByUserId($usuario_id) {
        $db = Database::getInstance()->getConnection();
        $query = "
            SELECT 
                h.*,
                po.nombre as origen_nombre,
                pd.nombre as destino_nombre
            FROM historial_viajes h
            JOIN paradas po ON h.origen_parada_id = po.id
            JOIN paradas pd ON h.destino_parada_id = pd.id
            WHERE h.usuario_id = :usuario_id
            ORDER BY h.fecha_busqueda DESC
        ";
        
        $stmt = $db->prepare($query);
        $stmt->execute(['usuario_id' => $usuario_id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Elimina todo el historial para un usuario.
     * @param int $usuario_id El ID del usuario cuyo historial se borrará.
     * @return bool True si la operación fue exitosa.
     */
    public static function deleteByUserId($usuario_id) {
        $db = Database::getInstance()->getConnection();
        $query = "DELETE FROM historial_viajes WHERE usuario_id = :usuario_id";
        $stmt = $db->prepare($query);
        return $stmt->execute(['usuario_id' => $usuario_id]);
    }
}

<?php


require_once __DIR__ . '/Database.php';


class Reporte {
    private $conn;
    private $table = 'reportes';

   
    public $id;
    public $linea_id;
    public $tipo_reporte;
    public $comentario;
    public $fecha_creacion;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    /**
     * Guarda un nuevo reporte en la base de datos.
     * @return bool True si se guardó, false si no.
     */
    public function save() {
        $query = "INSERT INTO " . $this->table . " (linea_id, tipo_reporte, comentario) VALUES (:linea_id, :tipo_reporte, :comentario)";
        $stmt = $this->conn->prepare($query);

        // Limpiamos los datos
        $this->linea_id = htmlspecialchars(strip_tags($this->linea_id));
        $this->tipo_reporte = htmlspecialchars(strip_tags($this->tipo_reporte));
        $this->comentario = htmlspecialchars(strip_tags($this->comentario));

        $stmt->bindParam(':linea_id', $this->linea_id);
        $stmt->bindParam(':tipo_reporte', $this->tipo_reporte);
        $stmt->bindParam(':comentario', $this->comentario);

        if ($stmt->execute()) {
            return true;
        }
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}

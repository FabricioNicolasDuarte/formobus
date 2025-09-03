<?php

// Agrego este texto para simular algun cambio de la verificación de email.

require_once __DIR__ . '/Database.php';

class Usuario {
    private $conn;
    private $table = 'usuarios';

    public $id;
    public $nombre;
    public $email;
    public $password;
    public $avatar_url;

    public function __construct() {
        $this->conn = Database::getInstance()->getConnection();
    }

    public function registrar() {
        if ($this->findByEmail($this->email)) {
            return false;
        }
        $query = "INSERT INTO " . $this->table . " (nombre, email, password) VALUES (:nombre, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        return $stmt->execute();
    }

    public function findByEmail($email) {
        $query = "SELECT * FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['email' => $email]);
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->avatar_url = $row['avatar_url']; // Cargar avatar
            return $this;
        }
        return false;
    }

    public static function findById($id) {
        $db = Database::getInstance()->getConnection();
        $query = "SELECT * FROM usuarios WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $id]);
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Usuario');
        return $stmt->fetch();
    }

    public function update($data) {
        if (empty($data)) return false;

        $query = "UPDATE " . $this->table . " SET ";
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
        }
        $query .= implode(', ', $fields);
        $query .= " WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        foreach ($data as $key => &$value) {
            $stmt->bindParam(":$key", $value);
        }
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
    
    public function updatePassword($new_password) {
        $query = "UPDATE " . $this->table . " SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function verificarPassword($password) {
        return password_verify($password, $this->password);
    }
}
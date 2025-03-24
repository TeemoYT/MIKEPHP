<?php 
require_once __DIR__ . '/../server/server.php';
class Module 
{
    protected $db;
    protected $table;

    public function __construct($table) {
        $this->db = Database::getInstance()->getConnection();
        $this->table = $table;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $columns = implode(", ", array_keys($data));
        $values = implode(", ", array_fill(0, count($data), "?"));
        $stmt = $this->db->prepare("INSERT INTO {$this->table} ($columns) VALUES ($values)");
        return $stmt->execute(array_values($data));
    }

    public function getUserById($userId) {
        try {
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->bindParam(':id', $userId);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error getting user: " . $e->getMessage());
        }
    }
}



?>
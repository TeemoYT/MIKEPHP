<?php
require_once __DIR__.'/module.php';


class TrademarkModule extends Module {

    public function __construct() {
        parent::__construct('trademarks');
    }

    public function getAllTrademarks() {
        try {
            $stmt = $this->db->prepare("SELECT id, name FROM trademarks ORDER BY name");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching trademarks: " . $e->getMessage());
        }
    }

    public function addTrademark($name) {
        try {
            $stmt = $this->db->prepare("INSERT INTO trademarks (name) VALUES (:name)");
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error adding trademark: " . $e->getMessage());
        }
    }

    public function updateTrademark($id, $name) {
        try {
            $stmt = $this->db->prepare("UPDATE trademarks SET name = :name WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating trademark: " . $e->getMessage());
        }
    }

    public function deleteTrademark($id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM trademarks WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting trademark: " . $e->getMessage());
        }
    }
} 
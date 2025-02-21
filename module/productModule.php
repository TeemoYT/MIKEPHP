<?php
require_once __DIR__ . '/module.php';


class ProductsModule extends Module {
    public function __construct() {
        parent::__construct("products");
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table}");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductBySlug($slug) {
    
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>

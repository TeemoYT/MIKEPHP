<?php
require_once __DIR__ . '/module.php';


class ProductsModule extends Module {
    public function __construct() {
        parent::__construct("products");
    }

    public function getProductByItem($slug) {
    
        $stmt = $this->db->prepare("SELECT name,description,price FROM {$this->table} WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getProductByImage($slug) {
        $stmt = $this->db->prepare("SELECT image_json, image_url FROM {$this->table} WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function getProductBySize($slug) {
        $stmt = $this->db->prepare("SELECT size_json FROM {$this->table} WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    

}
?>

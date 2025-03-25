<?php 
require_once __DIR__ . '/module.php';


class CollectionsModules extends Module{

    public function __construct()
    {
        parent::__construct('categories');
    }


    public function getCategory(){
        $stmt = $this->db->prepare("SELECT id, name, slug, parent_id FROM {$this->table} ORDER BY parent_id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getIdNameCategory(){
        $stmt = $this->db->prepare("SELECT id, name FROM {$this->table} ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdFromName($name){
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getProductsByCategoryOrParent($category_id) {
        // Lấy danh sách các category con (nếu có)
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE parent_id = :parent_id");
        $stmt->execute([':parent_id' => $category_id]);
        $childCategories = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
        // Gộp category hiện tại + các category con
        $allCategoryIds = array_merge([$category_id], $childCategories);
    
        // Tạo chuỗi placeholder (:id1, :id2, ...) cho PDO
        $placeholders = implode(',', array_fill(0, count($allCategoryIds), '?'));
    
        // Truy vấn sản phẩm từ các category đó
        $stmt = $this->db->prepare("
            SELECT DISTINCT p.*
            FROM products p
            JOIN product_categories pc ON p.id = pc.product_id
            WHERE pc.category_id IN ($placeholders)
        ");
    
        $stmt->execute($allCategoryIds);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

?>
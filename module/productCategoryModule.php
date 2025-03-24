<?php
require_once __DIR__ . '/module.php';

class ProductCategoryModule extends Module
{

    public function __construct()
    {
        parent::__construct('product_categories');
    }


    public function addCategory($productId,$categoryId)
    {
        $stmt = $this->db->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (:productId, :categoryId)");
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':categoryId', $categoryId, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function addCategoryToProduct($productId, $categoryName) {
        $stmt = $this->db->prepare("
            INSERT INTO product_categories (product_id, category_id)
            SELECT :productId, id FROM categories WHERE name = :categoryName
        ");
        $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
        $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            return ["success" => true, "message" => "Category added successfully"];
        } else {
            return ["success" => false, "message" => "Database error"];
        }
    }

    public function getProductCategories(){
        $stmt= $this->db->prepare("
        SELECT category_id,product_id FROM product_categories 
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removeCategory($productId, $categoryName) {
        try {
            $stmt = $this->db->prepare("
                DELETE pc FROM product_categories pc
                JOIN categories c ON pc.category_id = c.id
                WHERE pc.product_id = :productId AND c.name = :categoryName
            ");
            $stmt->bindParam(':productId', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':categoryName', $categoryName, PDO::PARAM_STR);
            
            if ($stmt->execute()) {
                return ["success" => true, "message" => "Category removed successfully"];
            } else {
                return ["success" => false, "message" => "Failed to remove category"];
            }
        } catch (Exception $e) {
            return ["success" => false, "message" => "Database error: " . $e->getMessage()];
        }
    }
}

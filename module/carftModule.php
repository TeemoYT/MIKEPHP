<?php
require_once 'module.php';

class CarftModule extends Module{

    public function __construct()
    {
        parent::__construct('cart');
    }


    public function getCart($id) {
        $stmt = $this->db->prepare("
            SELECT 
                c.product_id, c.size, c.quantity,c.id,
                p.name, p.price, p.image_url 
            FROM {$this->table} c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id
        ");
    
        $stmt->bindParam(":user_id", $id, PDO::PARAM_INT);
        $stmt->execute();
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartItem($userId, $productID, $productSize) {
        $stmt = $this->db->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ? AND size = ?");
        $stmt->execute([$userId, $productID, $productSize]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addCart($userId, $productID, $productSize, $quantity) {
        $existingItem = $this->getCartItem($userId, $productID, $productSize);
        
        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ? AND size = ?");
            return $stmt->execute([$newQuantity, $userId, $productID, $productSize]);
        } else {
            
            $stmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, size, quantity) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$userId, $productID, $productSize, $quantity]);
        }
    }
    public function deleteCartItem($itemId) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE id = ?");
        return $stmt->execute([$itemId]);
    }
    
    

}


?>
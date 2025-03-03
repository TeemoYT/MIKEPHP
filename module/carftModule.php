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
    public function deleteCartItem($itemId) {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE id = ?");
        return $stmt->execute([$itemId]);
    }
    
    

}


?>
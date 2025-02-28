<?php 
require_once __DIR__.'/module.php';


class ReviewsModule extends Module
{

    public function __construct()
    {
        parent::__construct("reviews");
    }



    public function postComment($userId, $productId, $rating, $comment) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (user_id, product_id, rating, comment) VALUES (:user_id, :product_id, :rating, :comment)");
        $stmt->bindParam(":user_id", $userId, PDO::PARAM_INT);
        $stmt->bindParam(":product_id", $productId, PDO::PARAM_INT);
        $stmt->bindParam(":rating", $rating, PDO::PARAM_INT);
        $stmt->bindParam(":comment", $comment, PDO::PARAM_STR);
        $stmt->execute(); 
    }
    

}


?>
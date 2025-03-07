<?php
require_once __DIR__ . '/module.php';


class ProductsModule extends Module
{
    public function __construct()
    {
        parent::__construct("products");
    }

    public function getProductByItem($slug)
    {

        $stmt = $this->db->prepare("SELECT name,description,price,id FROM {$this->table} WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getProductByImage($slug)
    {
        $stmt = $this->db->prepare("SELECT image_json, image_url FROM {$this->table} WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductBySize($slug)
    {
        $stmt = $this->db->prepare("SELECT size_json FROM {$this->table} WHERE slug = :slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProductIdFromSlug($slug){

        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE slug=:slug");
        $stmt->bindParam(':slug',$slug,PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getProductByComment($slug)
    {
        $sql = "SELECT r.id, r.user_id, u.name AS user_name, r.rating, r.comment, r.created_at 
        FROM reviews r
        JOIN products p ON r.product_id = p.id
        JOIN users u ON r.user_id = u.id
        WHERE p.slug = :slug
        ORDER BY r.created_at DESC
        LIMIT 3";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(["slug" => $slug]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProductByRating($slug)
    {
        $sql = "SELECT p.slug, ROUND(AVG(r.rating), 1) AS avg_rating, COUNT(r.id) AS total_reviews
        FROM reviews r
        JOIN products p ON r.product_id = p.id
        WHERE p.slug = :slug";

        $stmt= $this->db->prepare($sql);
        $stmt->execute(['slug'=> $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
}

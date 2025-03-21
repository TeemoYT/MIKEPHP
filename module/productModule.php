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

    // public function getProductBySize($slug)
    // {
    //     $stmt = $this->db->prepare("SELECT size_json FROM {$this->table} WHERE slug = :slug");
    //     $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
    //     $stmt->execute();
    //     return $stmt->fetch(PDO::FETCH_ASSOC);
    // }

    public function getProductIdFromSlug($slug)
    {

        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE slug=:slug");
        $stmt->bindParam(':slug', $slug, PDO::PARAM_STR);
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

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function slugify($text, string $divider = '-')
    {

        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);


        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);


        $text = preg_replace('~[^-\w]+~', '', $text);


        $text = trim($text, $divider);


        $text = preg_replace('~-+~', $divider, $text);


        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }


    public function getAllProducts()
    {

        $stmt = $this->db->prepare("SELECT 
        p.id AS product_id, 
        p.name AS product_name, 
        p.description, 
        p.price, 
        p.image_url, 
        t.id AS trademark_id, 
        t.name AS trademark_name,
        GROUP_CONCAT(DISTINCT c.name ORDER BY c.name SEPARATOR ', ') AS category_names,
        GROUP_CONCAT(DISTINCT pc.color_name ORDER BY pc.color_name SEPARATOR ', ') AS colors,
        GROUP_CONCAT(DISTINCT ps.size ORDER BY ps.size SEPARATOR ', ') AS sizes,
        SUM(ps.stock) AS total_stock
        FROM {$this->table} p
        LEFT JOIN trademarks t ON p.trademark_id = t.id
        LEFT JOIN product_categories pcat ON p.id = pcat.product_id  
        LEFT JOIN categories c ON pcat.category_id = c.id
        LEFT JOIN product_colors pc ON p.id = pc.product_id  
        LEFT JOIN product_sizes ps ON pc.id = ps.product_color_id
        GROUP BY p.id, t.id;
");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getCategoriesNotInProduct($id){
        $stmt= $this->db->prepare("
        SELECT id, name 
FROM categories 
WHERE id NOT IN (
    SELECT category_id FROM product_categories WHERE product_id = $id
);
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

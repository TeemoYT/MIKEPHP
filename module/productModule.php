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
        p.image_json,
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

    public function saveProduct($data) {
        try {
            // Start transaction
            $this->db->beginTransaction();
            
            // Validate required fields
            if (empty($data['name']) || empty($data['description']) || empty($data['price']) || empty($data['trademark_id'])) {
                throw new Exception('Vui lòng điền đầy đủ thông tin sản phẩm');
            }
            
            // Get form data
            $name = $data['name'] ?? '';
            $description = $data['description'] ?? '';
            $price = $data['price'] ?? 0;
            $trademark_id = $data['trademark_id'] ?? 0;
            $slug = $data['slug'] ?? '';
            $colors = json_decode($data['colors'] ?? '[]', true);
            $categories = json_decode($data['categories'] ?? '[]', true);
            
            // Get product ID from form data
            $product_id = $data['product_id'] ?? null;
            
            // Get current product data if updating
            $current_product = null;
            if ($product_id) {
                $stmt = $this->db->prepare("SELECT image_url, image_json FROM products WHERE id = ?");
                $stmt->execute([$product_id]);
                $current_product = $stmt->fetch(PDO::FETCH_ASSOC);
            }
            
            // Set upload directory
            $upload_dir = $_SERVER['DOCUMENT_ROOT'] . '/MIKEPHP/img/';
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            // Handle image upload
            $image_url = '';
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file_extension = strtolower(pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION));
                $new_filename = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['image_url']['tmp_name'], $upload_path)) {
                    // Delete old image if exists
                    if ($current_product && $current_product['image_url']) {
                        $old_image_path = $upload_dir . $current_product['image_url'];
                        if (file_exists($old_image_path)) {
                            unlink($old_image_path);
                        }
                    }
                    $image_url = $new_filename;
                }
            } else if ($current_product) {
                $image_url = $current_product['image_url'];
            }
            
            // Get current images from database
            $current_images = [];
            if ($current_product && $current_product['image_json']) {
                $current_images = json_decode($current_product['image_json'], true) ?? [];
            }
            
            // Get existing images that weren't deleted
            $existing_images = [];
            if (isset($data['existing_images'])) {
                $existing_images = json_decode($data['existing_images'], true) ?? [];
            }
            
            // Handle new image uploads
            $product_images = [];
            
            // First, add existing images that weren't deleted
            foreach ($existing_images as $existing_image) {
                if (in_array($existing_image, $current_images)) {
                    $product_images[] = $existing_image;
                }
            }
            
            // Then add new images
            if (isset($_FILES['productImages'])) {
                foreach ($_FILES['productImages']['tmp_name'] as $key => $tmp_name) {
                    if ($_FILES['productImages']['error'][$key] === UPLOAD_ERR_OK) {
                        $file_extension = strtolower(pathinfo($_FILES['productImages']['name'][$key], PATHINFO_EXTENSION));
                        $new_filename = uniqid() . '.' . $file_extension;
                        $upload_path = $upload_dir . $new_filename;
                        
                        if (move_uploaded_file($tmp_name, $upload_path)) {
                            $product_images[] = $new_filename;
                        }
                    }
                }
            }
            
            // Delete removed images from server
            foreach ($current_images as $current_image) {
                if (!in_array($current_image, $product_images)) {
                    $old_image_path = $upload_dir . $current_image;
                    if (file_exists($old_image_path)) {
                        unlink($old_image_path);
                    }
                }
            }
            
            // Update or insert product
            if ($product_id) {
                // Update existing product
                $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ?, trademark_id = ?, slug = ?, image_url = ?, image_json = ? WHERE id = ?");
                $stmt->execute([$name, $description, $price, $trademark_id, $slug, $image_url, json_encode($product_images), $product_id]);
            } else {
                // Insert new product
                $stmt = $this->db->prepare("INSERT INTO products (name, description, price, trademark_id, slug, image_url, image_json) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $description, $price, $trademark_id, $slug, $image_url, json_encode($product_images)]);
                $product_id = $this->db->lastInsertId();
            }
            
            // Handle colors and sizes
            if ($product_id) {
                // Get current colors
                $stmt = $this->db->prepare("SELECT id, color_name FROM product_colors WHERE product_id = ?");
                $stmt->execute([$product_id]);
                $current_colors = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // Delete colors that are not in the new colors array
                foreach ($current_colors as $current_color) {
                    $color_exists = false;
                    foreach ($colors as $color) {
                        if ($color['color_name'] === $current_color['color_name']) {
                            $color_exists = true;
                            break;
                        }
                    }
                    if (!$color_exists) {
                        $stmt = $this->db->prepare("DELETE FROM product_colors WHERE id = ?");
                        $stmt->execute([$current_color['id']]);
                    }
                }
                
                // Update or insert colors and sizes
                foreach ($colors as $color) {
                    $color_name = $color['color_name'];
                    $sizes = $color['sizes'] ?? [];
                    
                    // Check if color exists
                    $stmt = $this->db->prepare("SELECT id FROM product_colors WHERE product_id = ? AND color_name = ?");
                    $stmt->execute([$product_id, $color_name]);
                    $color_id = $stmt->fetchColumn();
                    
                    if ($color_id) {
                        // Update existing color
                        $stmt = $this->db->prepare("UPDATE product_colors SET color_name = ? WHERE id = ?");
                        $stmt->execute([$color_name, $color_id]);
                    } else {
                        // Insert new color
                        $stmt = $this->db->prepare("INSERT INTO product_colors (product_id, color_name) VALUES (?, ?)");
                        $stmt->execute([$product_id, $color_name]);
                        $color_id = $this->db->lastInsertId();
                    }
                    
                    // Handle sizes for this color
                    if ($color_id) {
                        // Get current sizes
                        $stmt = $this->db->prepare("SELECT id, size FROM product_sizes WHERE product_color_id = ?");
                        $stmt->execute([$color_id]);
                        $current_sizes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        
                        // Delete sizes that are not in the new sizes array
                        foreach ($current_sizes as $current_size) {
                            $size_exists = false;
                            foreach ($sizes as $size) {
                                if ($size['size'] === $current_size['size']) {
                                    $size_exists = true;
                                    break;
                                }
                            }
                            if (!$size_exists) {
                                $stmt = $this->db->prepare("DELETE FROM product_sizes WHERE id = ?");
                                $stmt->execute([$current_size['id']]);
                            }
                        }
                        
                        // Update or insert sizes
                        foreach ($sizes as $size) {
                            $size_name = $size['size'];
                            $stock = $size['stock'];
                            
                            // Check if size exists
                            $stmt = $this->db->prepare("SELECT id FROM product_sizes WHERE product_color_id = ? AND size = ?");
                            $stmt->execute([$color_id, $size_name]);
                            $size_id = $stmt->fetchColumn();
                            
                            if ($size_id) {
                                // Update existing size
                                $stmt = $this->db->prepare("UPDATE product_sizes SET stock = ? WHERE id = ?");
                                $stmt->execute([$stock, $size_id]);
                            } else {
                                // Insert new size
                                $stmt = $this->db->prepare("INSERT INTO product_sizes (product_color_id, size, stock) VALUES (?, ?, ?)");
                                $stmt->execute([$color_id, $size_name, $stock]);
                            }
                        }
                    }
                }
            }
            
            // Handle categories
            if ($product_id) {
                // Delete existing categories
                $stmt = $this->db->prepare("DELETE FROM product_categories WHERE product_id = ?");
                $stmt->execute([$product_id]);
                
                // Insert new categories
                foreach ($categories as $category_id) {
                    $stmt = $this->db->prepare("INSERT INTO product_categories (product_id, category_id) VALUES (?, ?)");
                    $stmt->execute([$product_id, $category_id]);
                }
            }
            
            // Commit transaction
            $this->db->commit();
            
            return [
                "success" => true,
                "message" => "Sản phẩm đã được lưu thành công!"
            ];
            
        } catch (Exception $e) {
            // Rollback transaction on error
            $this->db->rollBack();
            throw $e;
        }
    }

    public function deleteProduct($id) {
        try {
            // Start transaction
            $this->db->beginTransaction();
            
            // Get product data to delete images
            $stmt = $this->db->prepare("SELECT image_url, image_json FROM products WHERE id = ?");
            $stmt->execute([$id]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($product) {
                // Delete main image
                if ($product['image_url']) {
                    $image_path = $_SERVER['DOCUMENT_ROOT'] . '/MIKEPHP/img/' . $product['image_url'];
                    if (file_exists($image_path)) {
                        unlink($image_path);
                    }
                }
                
                // Delete additional images
                if ($product['image_json']) {
                    $images = json_decode($product['image_json'], true) ?? [];
                    foreach ($images as $image) {
                        $image_path = $_SERVER['DOCUMENT_ROOT'] . '/MIKEPHP/img/' . $image;
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }
                    }
                }
                
                // Delete product data
                $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
                $stmt->execute([$id]);
            }
            
            // Commit transaction
            $this->db->commit();
            
            return ['success' => true];
        } catch (Exception $e) {
            // Rollback transaction on error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}

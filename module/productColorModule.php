<?php
require_once __DIR__ . '/module.php';

class ProductColorModule extends Module {


    public function __construct() {
        parent::__construct("product_colors");
    }

    public function getProductColorsAndSizes($productId) {
        try {
            // Get colors
            $stmt = $this->db->prepare("SELECT id, color_name FROM product_colors WHERE product_id = ?");
            $stmt->execute([$productId]);
            $colors = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Get sizes for each color
            foreach ($colors as &$color) {
                $stmt = $this->db->prepare("SELECT size, stock, disabled FROM product_sizes WHERE product_color_id = ?");
                $stmt->execute([$color['id']]);
                $color['sizes'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return ['success' => true, 'colors' => $colors];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function saveProductColorsAndSizes($productId, $colors) {
        try {
            $this->db->beginTransaction();

            // Delete existing colors and sizes
            $stmt = $this->db->prepare("DELETE FROM product_sizes WHERE product_color_id IN (SELECT id FROM product_colors WHERE product_id = ?)");
            $stmt->execute([$productId]);
            
            $stmt = $this->db->prepare("DELETE FROM product_colors WHERE product_id = ?");
            $stmt->execute([$productId]);

            // Insert new colors and sizes
            foreach ($colors as $color) {
                $stmt = $this->db->prepare("INSERT INTO product_colors (product_id, color_name) VALUES (?, ?)");
                $stmt->execute([$productId, $color['name']]);
                $colorId = $this->db->lastInsertId();

                foreach ($color['sizes'] as $size) {
                    $stmt = $this->db->prepare("INSERT INTO product_sizes (product_color_id, size, stock, disabled) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$colorId, $size['size'], $size['stock'], $size['disabled'] ?? 0]);
                }
            }

            $this->db->commit();
            return ['success' => true];
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
} 
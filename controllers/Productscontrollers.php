<?php
require_once __DIR__ . '/../module/productModule.php';


class ProductsController {
    public function showProduct($slug) {
        $productModule = new ProductsModule();
        $product = $productModule->getProductBySlug($slug);

        if ($product) {
            require_once __DIR__ . '/../views/information.php';
        } else {
            echo "Không tìm thấy sản phẩm!";
        }
    }
}

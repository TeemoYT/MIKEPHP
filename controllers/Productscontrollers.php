<?php
require_once __DIR__ . '/../module/productModule.php';


class ProductsController {
    public function showProduct($slug) {
        require_once __DIR__ . '/../views/navbar.php';
        require_once __DIR__ . '/../views/information.php';
    }
}

<?php

class HomeController {
    public static function index() {
        require_once __DIR__ . '/../views/navbar.php';
        require_once __DIR__ . '/../views/products.php';
    }
}

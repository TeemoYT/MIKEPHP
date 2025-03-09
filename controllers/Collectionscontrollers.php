<?php
require_once __DIR__ . '/../module/collectionsModule.php';


class CollectionsController {
    public function showCollection($slug,$category_name,$products) {
        require_once __DIR__ . '/../views/navbar.php';
        require_once __DIR__ . '/../views/collections.php';
    }
}

<?php
require_once __DIR__ . '/../module/collectionsModule.php';

class CollectionsController {
    public function showCollection($slug, $category_name, $category_id) {
        $model = new CollectionsModules();

      
        $products = $model->getProductsByCategoryOrParent($category_id);

        require_once __DIR__ . '/../views/navbar.php';
        require_once __DIR__ . '/../views/collections.php';
    }
}
?>

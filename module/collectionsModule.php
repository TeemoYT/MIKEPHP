<?php 
require_once __DIR__ . '/module.php';


class CollectionsModules extends Module{

    public function __construct()
    {
        parent::__construct('categories');
    }


    public function getCategory(){
        $stmt = $this->db->prepare("SELECT id, name, slug, parent_id FROM {$this->table} ORDER BY parent_id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
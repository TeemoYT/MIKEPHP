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
    public function getIdNameCategory(){
        $stmt = $this->db->prepare("SELECT id, name FROM {$this->table} ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdFromName($name){
        $stmt = $this->db->prepare("SELECT id FROM {$this->table} WHERE :name ");
        $stmt->bindParam(':name', $name, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>
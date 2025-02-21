<?php
require_once "server.php";

try {
    $db = Database::getInstance()->getConnection();

    
    $check = $db->query("SHOW TABLES LIKE 'migrations'");
    if ($check->rowCount() > 0) {
        return;
    }

   
    $sql = file_get_contents(__DIR__ . '/setup.sql');
    if (!$sql) {
        die("Lỗi: Không thể đọc file setup.sql");
    }

 
    $db->exec($sql);

    
    $db->exec("CREATE TABLE migrations (id INT PRIMARY KEY AUTO_INCREMENT, setup_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP)");

   

} catch (PDOException $e) {
    die("Lỗi khi thiết lập database: " . $e->getMessage());
}
?>

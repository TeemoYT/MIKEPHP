<?php
require_once "server.php";

try {
  
    $db = Database::getInstance()->getConnection();


    $sql = file_get_contents(__DIR__ . '/setup.sql');

    if (!$sql) {
        die("Lỗi: Không thể đọc file setup.sql");
    }


    $db->exec($sql);
} catch (PDOException $e) {
    die("Lỗi khi thiết lập database: " . $e->getMessage());
}



?>


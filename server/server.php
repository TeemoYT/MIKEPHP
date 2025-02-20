<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mikephp";

$conn = new mysqli($servername, $username, $password);

if ($conn->connect_error) {
    die("Failed Connect Data: " . $conn->connect_error);
}

$sql = file_get_contents(__DIR__ . '/setup.sql');

if (!$sql) {
    die("Lỗi: Không thể đọc file setup.sql");
}


$conn->multi_query($sql);

$conn->close();
?>

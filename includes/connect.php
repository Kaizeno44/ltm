<?php
session_start();

$servername = "localhost";
$server_user = "root";
$server_pass = "";
$dbname = "shop";
$port = 3307; // ⚠️ Thêm dòng này


// Kiểm tra session tồn tại để tránh warning
$name = $_SESSION['name'] ?? '';
$role = $_SESSION['role'] ?? '';

// Kết nối MySQL
$con = new mysqli($servername, $server_user, $server_pass, $dbname , $port); // ⚠️ Thêm $port vào đây

// Kiểm tra kết nối lỗi
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// ✅ Thêm dòng này để MySQL và PHP cùng dùng utf8mb4
$con->set_charset("utf8mb4");
?>

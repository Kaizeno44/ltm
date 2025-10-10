<?php
include '../includes/connect.php';

$name = htmlspecialchars($_POST['name']);
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$phone = htmlspecialchars($_POST['phone']);

// ⚙️ Kiểm tra dữ liệu cơ bản
if (empty($name) || empty($username) || empty($password) || empty($phone)) {
    die("Vui lòng nhập đầy đủ thông tin đăng ký!");
}

// ✅ Mã hóa mật khẩu an toàn
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// ✅ Thêm người dùng mới vào bảng users
$sql = "INSERT INTO users (name, username, password, contact) 
        VALUES ('$name', '$username', '$hashedPassword', '$phone')";

if ($con->query($sql) === TRUE) {
    // Đăng ký thành công → chuyển sang trang đăng nhập
    header("Location: ../login.php");
    exit;
} else {
    echo "Lỗi khi đăng ký: " . $con->error;
}
?>

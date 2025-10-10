<?php
session_start();
include '../includes/connect.php';

// ✅ Kiểm tra nếu người dùng chưa đăng nhập thì chuyển hướng
if (!isset($_SESSION['customer_sid']) || $_SESSION['customer_sid'] != session_id()) {
    header("location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Lấy dữ liệu an toàn từ form
$name = trim(htmlspecialchars($_POST['name']));
$username = trim(htmlspecialchars($_POST['username']));
$password = trim($_POST['password']);
$phone = trim($_POST['phone']);
$email = trim(htmlspecialchars($_POST['email']));
$address = trim(htmlspecialchars($_POST['address']));

// ✅ Kiểm tra dữ liệu hợp lệ cơ bản (tránh lỗi trống hoặc format sai)
if (empty($name) || empty($username) || empty($email) || empty($phone) || empty($address)) {
    header("location: ../details.php?error=missing_fields");
    exit();
}

// ✅ Xử lý cập nhật có điều kiện (chỉ đổi mật khẩu nếu người dùng nhập mới)
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE users 
            SET name = ?, username = ?, password = ?, contact = ?, email = ?, address = ? 
            WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssi", $name, $username, $hashed_password, $phone, $email, $address, $user_id);
} else {
    $sql = "UPDATE users 
            SET name = ?, username = ?, contact = ?, email = ?, address = ? 
            WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssi", $name, $username, $phone, $email, $address, $user_id);
}

// ✅ Thực thi truy vấn
if ($stmt->execute()) {
    $_SESSION['name'] = $name;
    header("location: ../details.php?success=1");
} else {
    header("location: ../details.php?error=update_failed");
}

$stmt->close();
$con->close();
?>

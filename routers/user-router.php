<?php
include '../includes/connect.php';
session_start();

// ✅ Kiểm tra quyền (chỉ admin mới được cập nhật user)
if ($_SESSION['role'] !== 'Administrator') {
    header("Location: ../index.php");
    exit;
}

foreach ($_POST as $key => $value) {
    // Lấy user_id từ key (vd: "3_role" => 3)
    if (preg_match("/^(\d+)_role$/", $key, $matches)) {
        $user_id = intval($matches[1]);
        $stmt = $con->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $value, $user_id);
        $stmt->execute();
    }

    if (preg_match("/^(\d+)_verified$/", $key, $matches)) {
        $user_id = intval($matches[1]);
        $verified = intval($value);
        $stmt = $con->prepare("UPDATE users SET verified = ? WHERE id = ?");
        $stmt->bind_param("ii", $verified, $user_id);
        $stmt->execute();
    }

    if (preg_match("/^(\d+)_deleted$/", $key, $matches)) {
        $user_id = intval($matches[1]);
        $deleted = intval($value);
        $stmt = $con->prepare("UPDATE users SET deleted = ? WHERE id = ?");
        $stmt->bind_param("ii", $deleted, $user_id);
        $stmt->execute();
    }
}

// ✅ Quay lại trang danh sách người dùng
header("Location: ../users.php");
exit;
?>

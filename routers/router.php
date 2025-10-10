<?php
include '../includes/connect.php';
session_start();

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$success = false;

// ✅ Truy vấn người dùng theo username
$sql = "SELECT * FROM users WHERE username = ? AND deleted = 0 LIMIT 1";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // ✅ Kiểm tra mật khẩu (đã mã hóa trong DB)
    if (password_verify($password, $row['password'])) {
        $success = true;
        $user_id = $row['id'];
        $name = $row['name'];
        $role = $row['role'];
    }
}

if ($success) {
    // ✅ Lưu session tùy theo vai trò
    if ($role === 'Administrator') {
        $_SESSION['admin_sid'] = session_id();
        header("Location: ../admin-page.php");
    } else {
        $_SESSION['customer_sid'] = session_id();
        header("Location: ../index.php");
    }

    $_SESSION['user_id'] = $user_id;
    $_SESSION['role'] = $role;
    $_SESSION['name'] = $name;
    exit;
} else {
    // ❌ Sai tài khoản hoặc mật khẩu
    header("Location: ../login.php?error=1");
    exit;
}
?>

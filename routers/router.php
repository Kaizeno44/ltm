<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include '../includes/connect.php';
session_start();

$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Basic input validation
if ($username === '' || $password === '') {
    header("Location: ../login.php?error=1");
    exit;
}

$success = false;

// Truy vấn người dùng theo username
$sql = "SELECT * FROM users WHERE username = ? AND deleted = 0 LIMIT 1";
$stmt = $con->prepare($sql);
if (!$stmt) {
    // Prepared statement failed
    header("Location: ../login.php?error=1");
    exit;
}
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $stored = $row['password'];
    // Nếu mật khẩu lưu trong DB có dạng hash (bắt đầu bằng $2y$ hoặc $2a$ ...)
    if (password_needs_rehash($stored, PASSWORD_DEFAULT) || strpos($stored, '$') === 0) {
        // Giả sử đây là hash, dùng password_verify
        if (password_verify($password, $stored)) {
            $success = true;
        }
    } else {
        // Có thể là mật khẩu chưa được hash (legacy). So sánh trực tiếp.
        if ($password === $stored) {
            $success = true;
            // Upgrade: hash mật khẩu mới và lưu vào DB
            $newHash = password_hash($password, PASSWORD_DEFAULT);
            $update = $con->prepare("UPDATE users SET password = ? WHERE id = ?");
            if ($update) {
                $update->bind_param("si", $newHash, $row['id']);
                $update->execute();
                $update->close();
            }
        }
    }

    if ($success) {
        $user_id = $row['id'];
        $name = $row['name'];
        $role = $row['role'];
    }
}

if ($success) {
    // Lưu session tùy theo vai trò
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
    // Sai tài khoản hoặc mật khẩu
    header("Location: ../login.php?error=1");
    exit;
}
?>

<?php
// Đảm bảo session đã khởi tạo
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$balance = 0; // giá trị mặc định
$wallet_id = null;

// Kiểm tra nếu user đã đăng nhập
if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];

    // Lấy thông tin ví dựa trên user_id
    $sql = mysqli_query($con, "SELECT id FROM wallet WHERE customer_id = $user_id LIMIT 1");
    if ($sql && mysqli_num_rows($sql) > 0) {
        $row1 = mysqli_fetch_assoc($sql);
        $wallet_id = $row1['id'];

        // Lấy số dư ví
        $sql2 = mysqli_query($con, "SELECT balance FROM wallet_details WHERE wallet_id = $wallet_id LIMIT 1");
        if ($sql2 && mysqli_num_rows($sql2) > 0) {
            $row2 = mysqli_fetch_assoc($sql2);
            $balance = $row2['balance'];
        }
    }
} else {
    // Nếu chưa đăng nhập, có thể điều hướng hoặc giữ nguyên giá trị mặc định
    // header("Location: login.php"); // Bỏ comment nếu muốn tự chuyển đến trang đăng nhập
}
?>

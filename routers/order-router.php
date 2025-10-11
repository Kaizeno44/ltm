<?php
include '../includes/connect.php';

$total = 0;
$address = htmlspecialchars($_POST['address']);
$description = htmlspecialchars($_POST['description']);
$payment_type = $_POST['payment_type'];
$total = $_POST['total'];
$user_id = $_SESSION['user_id']; // ⚠️ thêm dòng này nếu chưa có

// ✅ Thêm kiểm tra an toàn
if (!$user_id || !$total) {
    die("Invalid order data.");
}

$sql = "INSERT INTO orders (customer_id, payment_type, address, total, description) 
        VALUES ($user_id, '$payment_type', '$address', $total, '$description')";

if ($con->query($sql) === TRUE) {
    $order_id = $con->insert_id;
    // Gửi tín hiệu đến Socket Server (port 3001) báo có đơn hàng mới
    $message = "Khách hàng ID #$user_id vừa đặt đơn hàng mới (Mã đơn: $order_id)";
    @file_get_contents("http://localhost:3001/new-order?msg=" . urlencode($message));

    foreach ($_POST as $key => $value) {
        if (is_numeric($key)) {
            $result = mysqli_query($con, "SELECT price FROM items WHERE id = $key");
            if ($row = mysqli_fetch_array($result)) {
                $price = $row['price'];
                $final_price = $value * $price;

                $sql = "INSERT INTO order_details (order_id, item_id, quantity, price) 
                        VALUES ($order_id, $key, $value, $final_price)";
                $con->query($sql);
            }
        }
    }

  

    header("location: ../orders.php");
    exit;
} else {
    echo "Error: " . $con->error;
}
?>

<?php
include 'includes/connect.php';
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}
if ($_SESSION['customer_sid'] == session_id()) {
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Đơn hàng của bạn</title>

    <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->    
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
 
</head>
<!-- Socket.IO client -->
<script src="https://cdn.socket.io/4.7.5/socket.io.min.js"></script>
<script>
  // Kết nối tới Socket server (port 3001)
  const socket = io("http://localhost:3001");

  // Khi server phát sự kiện "new-order"
  socket.on("new-order", (msg) => {
    // Thông báo popup
    alert("📦 " + msg);
    
    // (Tuỳ chọn) Có thể tự động reload danh sách đơn hàng:
    // location.reload();
  });
</script>

<body>
  <!-- Thanh menu -->
  <header>
    <nav class="red lighten-1" role="navigation">
      <div class="nav-wrapper container">
        <a href="index.php" class="brand-logo"><img src="images/logo.png" alt="logo"></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="orders.php">Đơn hàng</a></li>
          <li><a href="logout.php">Đăng xuất</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <main>
    <div class="container">
      <h4 class="header">Danh sách đơn hàng của bạn</h4>

      <?php
      $result = mysqli_query($con, "SELECT * FROM orders WHERE customer_id=" . $_SESSION['user_id'] . " ORDER BY id DESC;");
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
          $status_en = $row['status'];
          switch ($status_en) {
              case 'Ordered':
                  $status_vi = 'Đã đặt hàng';
                  break;
              case 'Yet to be delivered':
                  $status_vi = 'Chưa giao hàng';
                  break;
              case 'Delivered':
                  $status_vi = 'Đã giao hàng';
                  break;
              case 'Cancelled':
                  $status_vi = 'Đã hủy';
                  break;
              default:
                  $status_vi = $status_en; // Phòng trường hợp khác
          }

          echo '
          <div class="card">
            <div class="card-content">
              <span class="card-title">Đơn hàng #' . $row['id'] . '</span>
              <p><strong>Ngày đặt:</strong> ' . $row['date'] . '</p>
              <p><strong>Tổng tiền:</strong> ' . $row['total'] . ' VNĐ</p>
              <p><strong>Hình thức thanh toán:</strong> Thanh toán khi nhận hàng</p>
              <p><strong>Trạng thái:</strong> ' . $status_vi . '</p>
            </div>';

          if ($row['status'] == 'Ordered') {
            echo '
            <div class="card-action">
              <form action="cancel_order.php" method="post">
                <input type="hidden" name="order_id" value="' . $row['id'] . '">
                <button class="btn red lighten-1 waves-effect waves-light" type="submit" name="action">Hủy đơn</button>
              </form>
            </div>';
          }

          echo '</div>';
        }
      } else {
        echo '<p>Bạn chưa có đơn hàng nào.</p>';
      }
      ?>
    </div>
  </main>

  
</body>
</html>

<?php
} else {
  header("location:login.php");
}
?>

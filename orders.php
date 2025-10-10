<?php
include 'includes/connect.php';

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
          echo '
          <div class="card">
            <div class="card-content">
              <span class="card-title">Đơn hàng #' . $row['id'] . '</span>
              <p><strong>Ngày đặt:</strong> ' . $row['date'] . '</p>
              <p><strong>Tổng tiền:</strong> ' . $row['total'] . ' VNĐ</p>
              <p><strong>Hình thức thanh toán:</strong> Thanh toán khi nhận hàng</p>
              <p><strong>Trạng thái:</strong> ' . $row['status'] . '</p>
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

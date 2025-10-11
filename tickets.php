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
  <title>Hỗ trợ khách hàng</title>

  <!-- CSS -->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
</head>

<body>
  <!-- HEADER -->
  <header>
    <nav class="red lighten-1">
      <div class="nav-wrapper container">
        <a href="index.php" class="brand-logo">Food Order</a>
        <ul class="right hide-on-med-and-down">
          <li><a href="index.php">Trang chủ</a></li>
          <li><a href="orders.php">Đơn hàng</a></li>
          <li><a href="tickets.php">Hỗ trợ</a></li>
          <li><a href="logout.php">Đăng xuất</a></li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- MAIN -->
  <main>
    <div class="container">
      <h4 class="header">Gửi yêu cầu hỗ trợ</h4>
      <p class="caption">Nếu bạn gặp bất kỳ sự cố nào, vui lòng gửi yêu cầu để chúng tôi hỗ trợ.</p>

      <!-- Form gửi ticket -->
      <div class="card">
        <div class="card-content">
          <form id="formValidate" method="post" action="routers/add-ticket.php" novalidate>
            <div class="input-field">
              <input name="subject" id="subject" type="text" required>
              <label for="subject">Chủ đề</label>
            </div>
            <div class="input-field">
              <textarea name="description" id="description" class="materialize-textarea" required></textarea>
              <label for="description">Mô tả chi tiết</label>
            </div>
            <div class="input-field">
              <select name="type" required>
                <option disabled selected>Chọn loại yêu cầu</option>
                <option value="Support">Hỗ trợ kỹ thuật</option>
                <option value="Payment">Vấn đề thanh toán</option>
                <option value="Complaint">Khiếu nại</option>
                <option value="Others">Khác</option>
              </select>
              <label>Loại yêu cầu</label>
            </div>
            <input type="hidden" name="id" value="<?php echo $_SESSION['user_id']; ?>">
            <div class="input-field right-align">
              <button class="btn red lighten-1 waves-effect waves-light" type="submit" name="action">
                Gửi yêu cầu
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="divider"></div>

      <!-- Danh sách ticket -->
      <h5 class="header">Danh sách yêu cầu của bạn</h5>

      <ul class="collection">
        <?php
        $status = isset($_GET['status']) ? $_GET['status'] : '%';
        $sql = mysqli_query($con, "SELECT * FROM tickets WHERE poster_id = " . $_SESSION['user_id'] . " AND status LIKE '$status' AND NOT deleted;");
        if (mysqli_num_rows($sql) > 0) {
          while ($row = mysqli_fetch_array($sql)) {
            echo '
              <a href="view-ticket.php?id=' . $row['id'] . '" class="collection-item">
                <div class="row" style="margin-bottom:0;">
                  <div class="col s6">
                    <p class="collections-title"><strong>' . $row['subject'] . '</strong></p>
                  </div>
                  <div class="col s3">
                    <span class="task-cat cyan">' . $row['status'] . '</span>
                  </div>
                  <div class="col s3 right-align">
                    <span class="grey-text">' . $row['date'] . '</span>
                  </div>
                </div>
              </a>
            ';
          }
        } else {
          echo '<p>Bạn chưa gửi yêu cầu hỗ trợ nào.</p>';
        }
        ?>
      </ul>
    </div>
  </main>


  <!-- JS -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script>
    $(document).ready(function() {
      $('select').material_select();
    });
  </script>
</body>
</html>

<?php
} else {
  header("location:login.php");
}
?>

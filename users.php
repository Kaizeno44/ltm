<?php
include 'includes/connect.php';
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}
if ($_SESSION['admin_sid'] == session_id()) {
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <title>Quản lý người dùng</title>

  <!-- CSS -->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>

<body>
  <!-- HEADER -->
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="navbar-color red lighten-1">
        <div class="nav-wrapper">
          <ul class="left">
            <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo">Food Order</a></h1></li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <!-- MAIN -->
  <div id="main">
    <div class="wrapper">

      <!-- SIDEBAR -->
      <aside id="left-sidebar-nav">
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
          <li class="user-details red lighten-1 white-text">
            <div class="row">
              <div class="col s4">
                <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
              </div>
              <div class="col s8">
                <a class="btn-flat dropdown-button waves-effect white-text profile-btn" href="#">
                  <?php echo $name; ?>
                </a>
                <p><?php echo $role; ?></p>
                <a href="routers/logout.php" class="white-text">Đăng xuất</a>
              </div>
            </div>
          </li>
          <li><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Thực đơn</a></li>
          <li><a href="all-orders.php" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Quản lý đơn hàng</a></li>
          <li><a href="all-tickets.php" class="waves-effect waves-cyan"><i class="mdi-action-question-answer"></i> Hỗ trợ</a></li>
          <li class="active"><a href="users.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Người dùng</a></li>
        </ul>
      </aside>

      <!-- NỘI DUNG CHÍNH -->
      <section id="content">
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Danh sách người dùng</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">Kích hoạt, vô hiệu hoặc xác minh người dùng.</p>
          <div class="divider"></div>

          <!-- DANH SÁCH NGƯỜI DÙNG -->
          <div id="editableTable" class="section">
            <form method="post" action="routers/user-router.php">
              <h5 class="header">Danh sách tài khoản</h5>
              <table class="highlight responsive-table">
                <thead>
                  <tr>
                    <th>Tên</th>
                    <th>Email</th>
                    <th>Điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Vai trò</th>
                    <th>Xác minh</th>
                    <th>Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                <?php
                $result = mysqli_query($con, "SELECT * FROM users");
                while ($row = mysqli_fetch_array($result)) {
                  echo '<tr>';
                  echo '<td>' . $row["name"] . '</td>';
                  echo '<td>' . $row["email"] . '</td>';
                  echo '<td>' . $row["contact"] . '</td>';
                  echo '<td>' . $row["address"] . '</td>';
                  echo '<td>
                          <select name="'.$row['id'].'_role">
                            <option value="Administrator" '.($row['role']=='Administrator'?'selected':'').'>Quản trị</option>
                            <option value="Customer" '.($row['role']=='Customer'?'selected':'').'>Khách hàng</option>
                          </select>
                        </td>';
                  echo '<td>
                          <select name="'.$row['id'].'_verified">
                            <option value="1" '.($row['verified']?'selected':'').'>Đã xác minh</option>
                            <option value="0" '.(!$row['verified']?'selected':'').'>Chưa xác minh</option>
                          </select>
                        </td>';
                  echo '<td>
                          <select name="'.$row['id'].'_deleted">
                            <option value="0" '.(!$row['deleted']?'selected':'').'>Hoạt động</option>
                            <option value="1" '.($row['deleted']?'selected':'').'>Vô hiệu</option>
                          </select>
                        </td>';
                  echo '</tr>';
                }
                ?>
                </tbody>
              </table>
              <div class="input-field right-align">
                <button class="btn red waves-effect waves-light" type="submit" name="action">Cập nhật</button>
              </div>
            </form>

            <div class="divider"></div>

            <!-- THÊM NGƯỜI DÙNG -->
            <form method="post" action="routers/add-users.php">
              <h5 class="header">Thêm người dùng mới</h5>
              <table class="highlight responsive-table">
                <thead>
                  <tr>
                    <th>Tên đăng nhập</th>
                    <th>Mật khẩu</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Địa chỉ</th>
                    <th>Vai trò</th>
                    <th>Xác minh</th>
                    <th>Trạng thái</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input name="username" type="text" required></td>
                    <td><input name="password" type="password" required></td>
                    <td><input name="name" type="text" required></td>
                    <td><input name="email" type="email" required></td>
                    <td><input name="contact" type="text" required></td>
                    <td><input name="address" type="text"></td>
                    <td>
                      <select name="role">
                        <option value="Administrator">Quản trị</option>
                        <option value="Customer" selected>Khách hàng</option>
                      </select>
                    </td>
                    <td>
                      <select name="verified">
                        <option value="1">Đã xác minh</option>
                        <option value="0" selected>Chưa xác minh</option>
                      </select>
                    </td>
                    <td>
                      <select name="deleted">
                        <option value="0" selected>Hoạt động</option>
                        <option value="1">Vô hiệu</option>
                      </select>
                    </td>
                  </tr>
                </tbody>
              </table>
              <div class="input-field right-align">
                <button class="btn red waves-effect waves-light" type="submit" name="action">Thêm mới</button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script>
    $(document).ready(function(){
      $('select').material_select();
    });
  </script>
</body>
</html>
<?php
} else {
  if ($_SESSION['customer_sid'] == session_id()) {
    header("location:index.php");
  } else {
    header("location:login.php");
  }
}
?>

<?php
include 'includes/connect.php';

if(isset($_SESSION['admin_sid']) || isset($_SESSION['customer_sid'])) {
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Quản lý thực đơn món ăn</title>

  <!-- Biểu tượng -->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <!-- CSS Cốt lõi -->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- CSS Plugin -->
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <style type="text/css">
    .input-field div.error {
      position: relative;
      top: -1rem;
      left: 0rem;
      font-size: 0.8rem;
      color: #FF4081;
    }
    .input-field label.active {
      width: 100%;
    }
  </style>
</head>

<body>
  <!-- Hiệu ứng tải trang -->
  <div id="loader-wrapper">
    <div id="loader"></div>        
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <!-- THANH ĐIỀU HƯỚNG -->
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="navbar-color">
        <div class="nav-wrapper">
          <ul class="left">
            <li>
              <h1 class="logo-wrapper">
                <a href="index.php" class="brand-logo darken-1">
                  <img src="images/logo.png" alt="logo">
                </a>
                <span class="logo-text">Bảng điều khiển quản trị</span>
              </h1>
            </li>
          </ul>
        </div>
      </nav>
    </div>
  </header>

  <!-- NỘI DUNG CHÍNH -->
  <div id="main">
    <div class="wrapper">
      
      <!-- THANH BÊN -->
      <aside id="left-sidebar-nav">
        <ul id="slide-out" class="side-nav fixed leftside-navigation">
          <li class="user-details cyan darken-2">
            <div class="row">
              <div class="col s4">
                <img src="images/avatar.jpg" alt="" class="circle responsive-img valign profile-image">
              </div>
              <div class="col s8">
                <ul id="profile-dropdown" class="dropdown-content">
                  <li><a href="routers/logout.php"><i class="mdi-hardware-keyboard-tab"></i> Đăng xuất</a></li>
                </ul>
              </div>
              <div class="col s8">
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown">
                  <?php echo $name;?> <i class="mdi-navigation-arrow-drop-down right"></i>
                </a>
                <p class="user-roal"><?php echo $role;?></p>
              </div>
            </div>
          </li>

          <li class="bold active"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Thực đơn món ăn</a></li>

          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Đơn hàng</a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="all-orders.php">Tất cả đơn hàng</a></li>
                    <?php
                    $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders;");
                    while($row = mysqli_fetch_array($sql)) {
                      echo '<li><a href="all-orders.php?status='.$row['status'].'">Đơn '.$row['status'].'</a></li>';
                    }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </li>

          <li class="bold"><a href="users.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Người dùng</a></li>
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan"><i class="mdi-navigation-menu"></i></a>
      </aside>

      <!-- NỘI DUNG TRANG -->
      <section id="content">
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Thực đơn món ăn</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">Thêm, chỉnh sửa hoặc xóa các món ăn bên dưới.</p>
          <div class="divider"></div>

          <!-- QUẢN LÝ MÓN ĂN -->
          <form class="formValidate" id="formValidate" method="post" action="routers/menu-router.php" novalidate="novalidate">
            <div class="row">
              <div class="col s12 m4 l3">
                <h4 class="header">Quản lý món ăn</h4>
              </div>
              <div>
                <table id="data-table-admin" class="responsive-table display" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Tên món</th>
                      <th>Giá (mỗi phần)</th>
                      <th>Tình trạng</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM items");
                    while($row = mysqli_fetch_array($result)) {
                      echo '<tr><td><div class="input-field col s12"><label for="'.$row["id"].'_name">Tên món</label>';
                      echo '<input value="'.$row["name"].'" id="'.$row["id"].'_name" name="'.$row['id'].'_name" type="text"></td>';					
                      echo '<td><div class="input-field col s12"><label for="'.$row["id"].'_price">Giá</label>';
                      echo '<input value="'.$row["price"].'" id="'.$row["id"].'_price" name="'.$row['id'].'_price" type="text"></td>';                   
                      echo '<td>';
                      $text1 = $row['deleted'] == 0 ? 'selected' : '';
                      $text2 = $row['deleted'] != 0 ? 'selected' : '';
                      echo '<select name="'.$row['id'].'_hide">
                              <option value="1"'.$text1.'>Còn bán</option>
                              <option value="2"'.$text2.'>Ngừng bán</option>
                            </select></td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Lưu thay đổi
                  <i class="mdi-content-send right"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- THÊM MÓN MỚI -->
          <form class="formValidate" id="formValidate1" method="post" action="routers/add-item.php" novalidate="novalidate">
            <div class="row">
              <div class="col s12 m4 l3">
                <h4 class="header">Thêm món mới</h4>
              </div>
              <div>
                <table>
                  <thead>
                    <tr>
                      <th>Tên món</th>
                      <th>Giá (mỗi phần)</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><div class="input-field col s12"><label for="name">Tên món</label><input id="name" name="name" type="text"></div></td>
                      <td><div class="input-field col s12"><label for="price">Giá</label><input id="price" name="price" type="text"></div></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Thêm món
                  <i class="mdi-content-send right"></i>
                </button>
              </div>
            </div>
          </form>

          <div class="divider"></div>
        </div>
      </section>
    </div>
  </div>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
  <script src="js/plugins/data-tables/data-tables-script.js"></script>
  <script src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script src="js/plugins.min.js"></script>
  <script src="js/custom-script.js"></script>
</body>
</html>
<?php
} else {
  if($_SESSION['customer_sid'] == session_id()) {
    header("location:index.php");		
  } else {
    header("location:login.php");
  }
}
?>

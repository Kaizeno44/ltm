<?php
include 'includes/connect.php';
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}
$user_id = $_SESSION['user_id'];

$continue = 0;
$total = 0;

if($_SESSION['customer_sid'] == session_id()) {
    $continue = 1;
}

$result = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
while($row = mysqli_fetch_array($result)) {
    $name = $row['name'];
    $contact = $row['contact'];
}

if ($continue) {
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Xác nhận đơn hàng</title>

  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <link href="css/materialize.min.css" rel="stylesheet" type="text/css">
  <link href="css/style.min.css" rel="stylesheet" type="text/css">
  <link href="css/custom/custom.min.css" rel="stylesheet" type="text/css">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css">
</head>

<body>
  <div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
  </div>

  <!-- HEADER -->
  <header id="header" class="page-topbar">
    <div class="navbar-fixed">
      <nav class="navbar-color">
        <div class="nav-wrapper">
          <ul class="left">
            <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"><img src="images/logo.png" alt="logo"></a></h1></li>
          </ul>
          <ul class="right hide-on-med-and-down">
            <li><a href="#" class="waves-effect waves-block waves-light"><i class="mdi-editor-attach-money"><?php echo $balance; ?></i></a></li>
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
                <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $name; ?> <i class="mdi-navigation-arrow-drop-down right"></i></a>
                <p class="user-roal"><?php echo $role; ?></p>
              </div>
            </div>
          </li>
          <li class="bold"><a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Đặt món ăn</a></li>
          <li class="bold"><a href="orders.php" class="waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Đơn hàng</a></li>
          <li class="bold"><a href="details.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Thông tin cá nhân</a></li>
        </ul>
      </aside>

      <!-- CONTENT -->
      <section id="content">
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Xác nhận đơn hàng</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">Vui lòng kiểm tra thông tin trước khi xác nhận đơn hàng.</p>
          <div class="divider"></div>

          <div id="work-collections" class="section">
            <div class="row">
              <div>
                <ul id="issues-collection" class="collection">
<?php
    echo '<li class="collection-item avatar">
        <i class="mdi-content-content-paste red circle"></i>
        <p><strong>Tên:</strong> '.$name.'</p>
        <p><strong>Số liên hệ:</strong> '.$contact.'</p>
        <p><strong>Địa chỉ:</strong> '.htmlspecialchars($_POST['address']).'</p>
        <p><strong>Hình thức thanh toán:</strong> Thanh toán khi nhận hàng</p>';

	foreach ($_POST as $key => $value) {
		if (is_numeric($key)) {
			$result = mysqli_query($con, "SELECT * FROM items WHERE id = $key");
			while ($row = mysqli_fetch_array($result)) {
				$price = $row['price'];
				$item_name = $row['name'];
				$item_id = $row['id'];
			}
			$price = $value * $price;
			echo '<li class="collection-item">
        <div class="row">
            <div class="col s7">
                <p class="collections-title"><strong>#'.$item_id.' </strong>'.$item_name.'</p>
            </div>
            <div class="col s2">
                <span>'.$value.' phần</span>
            </div>
            <div class="col s3">
                <span>'.$price.' VNĐ</span>
            </div>
        </div>
    </li>';
			$total += $price;
		}
	}

    echo '<li class="collection-item">
        <div class="row">
            <div class="col s7"><p class="collections-title">Tổng cộng</p></div>
            <div class="col s3"><span><strong>'.$total.' VNĐ</strong></span></div>
        </div>
    </li>';

	if (!empty($_POST['description']))
		echo '<li class="collection-item avatar"><p><strong>Ghi chú:</strong> '.htmlspecialchars($_POST['description']).'</p></li>';
?>
<form action="routers/order-router.php" method="post">
<?php
	foreach ($_POST as $key => $value) {
		if (is_numeric($key)) {
			echo '<input type="hidden" name="'.$key.'" value="'.$value.'">';
		}
	}
?>
<input type="hidden" name="payment_type" value="Cash On Delivery">
<input type="hidden" name="address" value="<?php echo htmlspecialchars($_POST['address']); ?>">
<?php if (isset($_POST['description'])) echo '<input type="hidden" name="description" value="'.htmlspecialchars($_POST['description']).'">'; ?>
<input type="hidden" name="total" value="<?php echo $total; ?>">
<div class="input-field col s12">
  <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Xác nhận đơn hàng
    <i class="mdi-content-send right"></i>
  </button>
</div>
</form>
</ul>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script> 
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript" src="js/custom-script.js"></script>
</body>

</html>
<?php
} else {
	if($_SESSION['admin_sid']==session_id()) {
		header("location:admin-page.php");
	} else {
		header("location:login.php");
	}
}
?>

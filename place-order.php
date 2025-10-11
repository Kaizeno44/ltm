<?php
include 'includes/connect.php';
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}
$user_id = $_SESSION['user_id'];

$total = 0;
if($_SESSION['customer_sid']==session_id())
{
  $result = mysqli_query($con, "SELECT * FROM users where id = $user_id");
  while($row = mysqli_fetch_array($result)){
    $name = $row['name'];	
    $address = $row['address'];
    $contact = $row['contact'];
    $verified = $row['verified'];
  }
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <title>Cung cấp thông tin đơn hàng</title>

  <link href="css/materialize.min.css" type="text/css" rel="stylesheet">
  <link href="css/style.min.css" type="text/css" rel="stylesheet">   
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet">

  <style>
    .input-field div.error{
      position: relative;
      top: -1rem;
      font-size: 0.8rem;
      color:#FF4081;
    }
  </style>
</head>

<body>
<header id="header" class="page-topbar">
  <div class="navbar-fixed">
    <nav class="navbar-color">
      <div class="nav-wrapper">
        <ul class="left">                      
          <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"><img src="images/logo.png" alt="logo"></a></h1></li>
        </ul>
        <ul class="right hide-on-med-and-down">    
          <li><a href="#" class="waves-effect waves-block waves-light">
  <i class="mdi-editor-attach-money">0 VNĐ</i>
</a></li>                    
        </ul>						
      </div>
    </nav>
  </div>
</header>

<div id="main">
  <div class="wrapper">
    <aside id="left-sidebar-nav">
      <!-- MENU BÊN TRÁI (giữ nguyên) -->
      ...
    </aside>

    <section id="content">
      <div id="breadcrumbs-wrapper">
        <div class="container"><div class="row"><div class="col s12"><h5>Cung cấp thông tin đơn hàng</h5></div></div></div>
      </div>

      <div class="container">
        <p class="caption">Vui lòng nhập thông tin giao hàng.</p>
        <div class="divider"></div>

        <div class="card-panel">
          <form class="col s12" id="formValidate" method="post" action="confirm-order.php" novalidate>
            
            <!-- Hình thức thanh toán -->
            <div class="input-field col s12">
              <label for="payment_type">Hình thức thanh toán</label><br><br>
              <select id="payment_type" name="payment_type" disabled>
                <option value="Cash On Delivery" selected>Thanh toán khi nhận hàng</option>
              </select>
              <input type="hidden" name="payment_type" value="Cash On Delivery">
            </div>

            <!-- Địa chỉ -->
            <div class="input-field col s12">
              <i class="mdi-action-home prefix"></i>
              <textarea name="address" id="address" class="materialize-textarea validate" required><?php echo $address;?></textarea>
              <label for="address">Địa chỉ</label>
            </div>

            <!-- Nút Gửi -->
            <div class="input-field col s12">
              <button class="btn cyan waves-effect waves-light right" type="submit" name="action">Gửi
                <i class="mdi-content-send right"></i>
              </button>
            </div>

            <?php
            foreach ($_POST as $key => $value){
              if($key == 'action' || $value == '') continue;
              echo '<input name="'.$key.'" type="hidden" value="'.$value.'">';
            }
            ?>
          </form>
        </div>
      </div>

      <!-- Hóa đơn tạm tính -->
      <div class="container">
        <p class="caption">Hóa đơn tạm tính</p>
        <div class="divider"></div>
        <ul class="collection">
        <?php
          echo '<li class="collection-item avatar">
            <i class="mdi-content-content-paste red circle"></i>
            <p><strong>Tên:</strong> '.$name.'</p>
            <p><strong>Số liên hệ:</strong> '.$contact.'</p>
            <a href="#" class="secondary-content"><i class="mdi-action-grade"></i></a>';

          foreach ($_POST as $key => $value)
          {
            if(is_numeric($key)){
              $result = mysqli_query($con, "SELECT * FROM items WHERE id = $key");
              while($row = mysqli_fetch_array($result)){
                $price = $row['price'];
                $item_name = $row['name'];
                $item_id = $row['id'];
              }
              $price = $value * $price;
              echo '<li class="collection-item">
                <div class="row">
                  <div class="col s7"><p><strong>#'.$item_id.'</strong> '.$item_name.'</p></div>
                  <div class="col s2"><span>'.$value.' phần</span></div>
                  <div class="col s3"><span>'.$price.' VNĐ</span></div>
                </div>
              </li>';
              $total += $price;
            }
          }

          echo '<li class="collection-item">
            <div class="row">
              <div class="col s7"><p><strong>Tổng cộng</strong></p></div>
              <div class="col s5"><span><strong>'.$total.' VNĐ</strong></span></div>
            </div>
          </li>';
        ?>
        </ul>
      </div>
    </section>
  </div>
</div>


<!-- Scripts -->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/plugins.min.js"></script>
<script type="text/javascript" src="js/custom-script.js"></script>
</body>
</html>
<?php
}
else {
  if($_SESSION['admin_sid']==session_id()) {
    header("location:admin-page.php");		
  } else {
    header("location:login.php");
  }
}
?>

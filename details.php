<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'includes/connect.php';
if (!isset($_SESSION['user_id'])) {
  header("location:login.php");
  exit();
}
// ✅ Kiểm tra nếu người dùng chưa đăng nhập thì quay lại trang login
if (!isset($_SESSION['customer_sid']) || $_SESSION['customer_sid'] != session_id()) {
    header("location: login.php");
    exit();
}

// ✅ Lấy thông tin người dùng hiện tại
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];
$name = $username = $email = $contact = $address = "";

// ✅ Dùng prepared statement để tránh SQL Injection
$stmt = $con->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $name = htmlspecialchars($row['name']);
    $username = htmlspecialchars($row['username']);
    $email = htmlspecialchars($row['email']);
    $contact = htmlspecialchars($row['contact']);
    $address = htmlspecialchars($row['address']);
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Edit Details</title>

  <!-- Favicons-->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->


  <!-- CORE CSS-->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <!-- Custome CSS-->    
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
   <style type="text/css">
  .input-field div.error{
    position: relative;
    top: -1rem;
    left: 0rem;
    font-size: 0.8rem;
    color:#FF4081;
    -webkit-transform: translateY(0%);
    -ms-transform: translateY(0%);
    -o-transform: translateY(0%);
    transform: translateY(0%);
  }
  .input-field label.active{
      width:100%;
  }
  .left-alert input[type=text] + label:after, 
  .left-alert input[type=password] + label:after, 
  .left-alert input[type=email] + label:after, 
  .left-alert input[type=url] + label:after, 
  .left-alert input[type=time] + label:after,
  .left-alert input[type=date] + label:after, 
  .left-alert input[type=datetime-local] + label:after, 
  .left-alert input[type=tel] + label:after, 
  .left-alert input[type=number] + label:after, 
  .left-alert input[type=search] + label:after, 
  .left-alert textarea.materialize-textarea + label:after{
      left:0px;
  }
  .right-alert input[type=text] + label:after, 
  .right-alert input[type=password] + label:after, 
  .right-alert input[type=email] + label:after, 
  .right-alert input[type=url] + label:after, 
  .right-alert input[type=time] + label:after,
  .right-alert input[type=date] + label:after, 
  .right-alert input[type=datetime-local] + label:after, 
  .right-alert input[type=tel] + label:after, 
  .right-alert input[type=number] + label:after, 
  .right-alert input[type=search] + label:after, 
  .right-alert textarea.materialize-textarea + label:after{
      right:70px;
  }
  </style> 
</head>
<body class="cyan">

  <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="navbar-color">
                <div class="nav-wrapper">
                    <ul class="left">                      
                      <li><h1 class="logo-wrapper"><a href="index.php" class="brand-logo darken-1"><img src="images/logo.png" alt="logo"></a> <span class="logo-text">Logo</span></h1></li>
                    </ul>				
                </div>
            </nav>
        </div>
        <!-- end header nav-->
  </header>

  <main>
    <div class="section"></div>
    <div class="container">
      <div id="profile-page" class="section">
        <div id="profile-page-header" class="card">
          <div class="card-image waves-effect waves-block waves-light">
            <img src="images/user-bg.jpg" alt="user background">
          </div>
          <figure class="card-profile-image">
            <img src="images/avatar.jpg" alt="profile image" class="circle z-depth-2 responsive-img activator">
          </figure>
          <div class="card-content">
            <div class="row">
              <div class="col s12 center-align">
                <h4 class="card-title grey-text text-darken-4"><?php echo $name; ?></h4>
                <p class="user-role"><?php echo $role; ?></p>
              </div>
            </div>
          </div>
        </div>

        <!-- Form cập nhật thông tin -->
        <div class="card">
          <div class="card-content">
            <h5 class="card-title center">Cập nhật thông tin tài khoản</h5>
            <form class="formValidate col s12" id="formValidate" method="post" action="routers/details-router.php" novalidate="novalidate">
              <div class="row">
                <div class="input-field col s12">
                  <label for="name">Họ và tên</label>
                  <input name="name" id="name" type="text" value="<?php echo $name; ?>" required>
                </div>
                <div class="input-field col s12">
                  <label for="username">Tên đăng nhập</label>
                  <input name="username" id="username" type="text" value="<?php echo $username; ?>" required>
                </div>
                <div class="input-field col s12">
                  <label for="email">Email</label>
                  <input name="email" id="email" type="email" value="<?php echo $email; ?>" required>
                </div>
                <div class="input-field col s12">
                  <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
                  <input name="password" id="password" type="password">
                </div>
                <div class="input-field col s12">
                  <label for="phone">Số điện thoại</label>
                  <input name="phone" id="phone" type="text" value="<?php echo $contact; ?>" required>
                </div>
                <div class="input-field col s12">
                  <label for="address">Địa chỉ</label>
                  <input name="address" id="address" type="text" value="<?php echo $address; ?>" required>
                </div>
              </div>
              <div class="row center">
                <button class="btn cyan waves-effect waves-light" type="submit">Lưu thay đổi</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- JS -->
  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="js/materialize.min.js"></script>
  <script src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script src="js/plugins.min.js"></script>
  <script src="js/custom-script.js"></script>

  <!-- Validate -->
  <script type="text/javascript">
    $("#formValidate").validate({
      rules: {
        name: { required: true, minlength: 5 },
        username: { required: true, minlength: 5 },
        email: { required: true, email: true },
        phone: { required: true, number: true, minlength: 10, maxlength: 11 },
        address: { required: true, minlength: 5 }
      },
      messages: {
        name: { required: "Vui lòng nhập tên", minlength: "Tên phải ít nhất 5 ký tự" },
        username: { required: "Vui lòng nhập tên đăng nhập", minlength: "Tối thiểu 5 ký tự" },
        email: { required: "Vui lòng nhập email hợp lệ" },
        phone: { required: "Vui lòng nhập số điện thoại hợp lệ" },
        address: { required: "Vui lòng nhập địa chỉ" }
      },
      errorElement: 'div',
      errorPlacement: function (error, element) {
        error.insertAfter(element);
      }
    });
  </script>

</body>
</html>

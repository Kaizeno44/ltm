<?php  
session_start(); 
if(isset($_SESSION['admin_sid']) || isset($_SESSION['customer_sid']))
{
	header("location:index.php");
}
else{
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Đăng ký tài khoản</title>

  <!-- Favicon -->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <!-- CSS -->
  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">

  <style type="text/css">
    .input-field div.error {
      position: relative;
      top: -1rem;
      left: 0rem;
      font-size: 0.8rem;
      color: #FF4081;
      transform: translateY(0%);
    }
    .input-field label.active {
      width:100%;
    }
  </style>
</head>

<body class="cyan">
  <!-- Hiệu ứng tải trang -->
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>

  <div id="login-page" class="row">
    <div class="col s12 z-depth-4 card-panel">
      <form class="formValidate" id="formValidate" method="post" action="routers/register-router.php" novalidate="novalidate" class="col s12">
        <div class="row">
          <div class="input-field col s12 center">
            <h4>Đăng ký tài khoản</h4>
            <p class="center">Tham gia cùng chúng tôi ngay hôm nay!</p>
          </div>
        </div>

        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input name="username" id="username" type="text" data-error=".errorTxt1">
            <label for="username" class="center-align">Tên đăng nhập</label>
            <div class="errorTxt1"></div>			
          </div>
        </div>

        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person prefix"></i>
            <input name="name" id="name" type="text" data-error=".errorTxt2">
            <label for="name" class="center-align">Họ và tên</label>
            <div class="errorTxt2"></div>			
          </div>
        </div>

        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input name="password" id="password" type="password" data-error=".errorTxt3">
            <label for="password">Mật khẩu</label>
            <div class="errorTxt3"></div>			
          </div>
        </div>

        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-communication-phone prefix"></i>
            <input name="phone" id="phone" type="number" data-error=".errorTxt4">
            <label for="phone">Số điện thoại</label>
            <div class="errorTxt4"></div>			
          </div>
        </div>		

        <div class="row">
          <div class="input-field col s12">
            <a href="javascript:void(0);" onclick="document.getElementById('formValidate').submit();" class="btn waves-effect waves-light col s12">Đăng ký</a>
          </div>
          <div class="input-field col s12">
            <p class="margin center medium-small sign-up">
              Đã có tài khoản? <a href="login.php">Đăng nhập</a>
            </p>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- JS -->
  <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript" src="js/custom-script.js"></script>

  <script type="text/javascript">
    $("#formValidate").validate({
        rules: {
            username: { required: true, minlength: 5 },
            name: { required: true, minlength: 5 },
            password: { required: true, minlength: 5 },
            phone: { required: true, minlength: 4 },
        },
        messages: {
            username: {
                required: "Vui lòng nhập tên đăng nhập",
                minlength: "Tên đăng nhập phải có ít nhất 5 ký tự"
            },
            name: {
                required: "Vui lòng nhập họ và tên",
                minlength: "Họ tên phải có ít nhất 5 ký tự"
            },
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải có ít nhất 5 ký tự"
            },
            phone: {
                required: "Vui lòng nhập số điện thoại",
                minlength: "Số điện thoại phải có ít nhất 4 ký tự"
            },
        },
        errorElement : 'div',
        errorPlacement: function(error, element) {
          var placement = $(element).data('error');
          if (placement) {
            $(placement).append(error);
          } else {
            error.insertAfter(element);
          }
        }
     });
  </script>
</body>
</html>
<?php
}
?>

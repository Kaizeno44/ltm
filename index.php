<?php
include 'includes/connect.php';
include 'includes/wallet.php';

if($_SESSION['customer_sid']==session_id())
{
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>Đặt món ăn</title>

  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">

  <link href="css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="css/custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="js/plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  
  <style type="text/css">
    .input-field div.error{
      position: relative;
      top: -1rem;
      left: 0rem;
      font-size: 0.8rem;
      color:#FF4081;
      transform: translateY(0%);
    }
    .input-field label.active{ width:100%; }
  </style> 
</head>

<body>
  <div id="loader-wrapper">
      <div id="loader"></div>        
      <div class="loader-section section-left"></div>
      <div class="loader-section section-right"></div>
  </div>

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
                <span class="logo-text">Logo</span>
              </h1>
            </li>
          </ul>
          <ul class="right hide-on-med-and-down">                        
            <li>
              <a href="#" class="waves-effect waves-block waves-light">
                <i class="mdi-editor-attach-money">Số dư: <?php echo $balance;?></i>
              </a>
            </li>
          </ul>					
        </div>
      </nav>
    </div>
  </header>

  <div id="main">
    <div class="wrapper">

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
          <li class="bold active">
            <a href="index.php" class="waves-effect waves-cyan"><i class="mdi-editor-border-color"></i> Đặt món ăn</a>
          </li>
          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan"><i class="mdi-editor-insert-invitation"></i> Đơn hàng</a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="orders.php">Tất cả đơn hàng</a></li>
                    <?php
                    $sql = mysqli_query($con, "SELECT DISTINCT status FROM orders WHERE customer_id = $user_id;");
                    while($row = mysqli_fetch_array($sql)){
                      echo '<li><a href="orders.php?status='.$row['status'].'">Đơn hàng '.$row['status'].'</a></li>';
                    }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </li>

          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
              <li class="bold">
                <a class="collapsible-header waves-effect waves-cyan"><i class="mdi-action-question-answer"></i> Hỗ trợ</a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="tickets.php">Tất cả yêu cầu</a></li>
                    <?php
                    $sql = mysqli_query($con, "SELECT DISTINCT status FROM tickets WHERE poster_id = $user_id AND not deleted;");
                    while($row = mysqli_fetch_array($sql)){
                      echo '<li><a href="tickets.php?status='.$row['status'].'">Trạng thái: '.$row['status'].'</a></li>';
                    }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </li>

          <li class="bold">
            <a href="details.php" class="waves-effect waves-cyan"><i class="mdi-social-person"></i> Chỉnh sửa thông tin</a>
          </li>
        </ul>
        <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan">
          <i class="mdi-navigation-menu"></i>
        </a>
      </aside>

      <section id="content">
        <div id="breadcrumbs-wrapper">
          <div class="container">
            <div class="row">
              <div class="col s12">
                <h5 class="breadcrumbs-title">Đặt món</h5>
              </div>
            </div>
          </div>
        </div>

        <div class="container">
          <p class="caption">Hãy chọn món ăn bạn muốn đặt tại đây.</p>
          <div class="divider"></div>

          <form class="formValidate" id="formValidate" method="post" action="place-order.php" novalidate="novalidate">
            <div class="row">
              <div class="col s12 m4 l3">
                <h4 class="header">Danh sách món ăn</h4>
              </div>
              <div>
                <table id="data-table-customer" class="responsive-table display" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Tên món</th>
                      <th>Giá / phần</th>
                      <th>Số lượng</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    $result = mysqli_query($con, "SELECT * FROM items where not deleted;");
                    while($row = mysqli_fetch_array($result))
                    {
                      echo '<tr><td>'.$row["name"].'</td><td>'.$row["price"].'</td>';                      
                      echo '<td><div class="input-field col s12"><label for='.$row["id"].' class="">Số lượng</label>';
                      echo '<input id="'.$row["id"].'" name="'.$row['id'].'" type="text" data-error=".errorTxt'.$row["id"].'"><div class="errorTxt'.$row["id"].'"></div></td></tr>';
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div class="input-field col s12">
                <i class="mdi-editor-mode-edit prefix"></i>
                <textarea id="description" name="description" class="materialize-textarea"></textarea>
                <label for="description" class="">Ghi chú (tùy chọn)</label>
              </div>
              <div class="input-field col s12">
                <button class="btn cyan waves-effect waves-light right" type="submit" name="action">
                  Đặt món
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

  <!-- Script -->
  <script src="https://code.jquery.com/jquery-1.11.2.min.js"></script>    
  <script type="text/javascript" src="js/plugins/angular.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <script type="text/javascript" src="js/plugins/data-tables/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript" src="js/plugins/data-tables/data-tables-script.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/jquery.validate.min.js"></script>
  <script type="text/javascript" src="js/plugins/jquery-validation/additional-methods.min.js"></script>
  <script type="text/javascript" src="js/plugins.min.js"></script>
  <script type="text/javascript" src="js/custom-script.js"></script>

  <script type="text/javascript">
    $("#formValidate").validate({
      rules: {
        <?php
        $result = mysqli_query($con, "SELECT * FROM items WHERE NOT deleted;");
        while($row = mysqli_fetch_array($result)) {
          $safe_id = 'item_' . $row["id"];
          echo '"' . $safe_id . '_name": { required: true, minlength: 5, maxlength: 20 },';
          echo '"' . $safe_id . '_price": { required: true, min: 0 },';
        }
        ?>
      },
      messages: {
        <?php
        $result = mysqli_query($con, "SELECT * FROM items WHERE NOT deleted;");
        while($row = mysqli_fetch_array($result)) {
          $safe_id = 'item_' . $row["id"];
          echo '"' . $safe_id . '_name": { required: "Vui lòng nhập tên món", minlength: "Tối thiểu 5 ký tự", maxlength: "Tối đa 20 ký tự" },';
          echo '"' . $safe_id . '_price": { required: "Vui lòng nhập giá món", min: "Giá phải lớn hơn 0" },';
        }
        ?>
      },
      errorElement : 'div',
      errorPlacement: function(error, element) {
        var placement = $(element).data('error');
        if (placement) {
          $(placement).append(error)
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
else
{
  if($_SESSION['admin_sid']==session_id())
  {
    header("location:admin-page.php");		
  }
  else{
    header("location:login.php");
  }
}
?>

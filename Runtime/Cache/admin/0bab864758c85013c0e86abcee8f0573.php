<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>信息管理系统界面</title>
  <meta content="<?php echo ($config["WEBSITE-KEYWORD"]); ?>" name="keywords">
  <meta content="<?php echo ($config["WEBSITE-DESCRIPTION"]); ?>" name="description">
  <link href="/favicon.ico" type="image/icon" rel="icon">
  <!-- Tell the browser to be responsive to screen width -->
  <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/Public/Admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<!--添加css-->
<style type="text/css">
  .user-image {
    float: left;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    margin-right: 10px;
    margin-top: -2px;
  }
  .navbar-nav>.user-menu>.dropdown-menu {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    padding: 1px 0 0 0;
    border-top-width: 0;
    width: 280px;
  }
  .navbar-nav>li>.dropdown-menu {
    position: absolute;
    right: 0;
    left: auto;
    top: 41px;
  }
  .navbar-nav>.user-menu>.dropdown-menu>li.user-header>img {
    z-index: 5;
    height: 90px;
    width: 90px;
    border: 3px solid;
    border-color: rgba(255,255,255,0.2);
  }
  .navbar-nav>.user-menu>.dropdown-menu>li.user-header {
    height: 175px;
    padding: 10px;
    text-align: center;
  }
  .navbar-nav>.user-menu>.dropdown-menu>.user-body {
    padding: 15px;
    border-bottom: 1px solid #f4f4f4;
    border-top: 1px solid #dddddd;
  }
  .col-xs-4 {
    width: 33.33333333%;
  }
  .text-center a {
    color: #007bff !important;
  }
  .user-footer a {
    color: #444 !important;
  }
  .glyphicon-transfer:before {
    content: "\e178";
  }
  :before {
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
  }
  .language-menu a{
    text-align: center;
  }
</style>
<!--/添加css-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-comments-o"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/Public/Admin/dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/Public/Admin/dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="/Public/Admin/dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fa fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="fa fa-clock-o mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fa fa-bell-o"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fa fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <!--中英文切换-->
      <li class="nav-item language-menu dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <span class="fa-exchange fa  nav-icon"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="<?php echo U('Common/changeLanguage?language=zh');?>" class="dropdown-item">
            <?php echo ($language["chinese"]); ?>
          </a>
          <div class="dropdown-divider"></div>
          <a href="<?php echo U('Common/changeLanguage?language=eh');?>" class="dropdown-item">
            <?php echo ($language["english"]); ?>
          </a>
        </div>
      </li>
      <!--用户-->
      <li class="nav-item dropdown user user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="<?php echo session('admin.image');?>" class="user-image" alt="User Image">
          <span class="hidden-xs"><?php echo session('admin.realname');?></span>
        </a>
        <ul class="dropdown-menu">
          <!-- User image -->
          <li class="user-header">
            <img src="<?php echo session('admin.image');?>" class="img-circle" alt="User Image">

            <p>
              <?php echo session('admin.realname');?>-<?php echo ($userInfo["groups"]); ?><br/>
              <small>login time:<?php echo ($userInfo["login_time"]); ?></small>
            </p>
          </li>
          <!-- Menu Body -->
          <li class="user-body">
            <div class="row">
              <div class="col-xs-4 text-center">
                <a href="#">Followers</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Sales</a>
              </div>
              <div class="col-xs-4 text-center">
                <a href="#">Friends</a>
              </div>
            </div>
            <!-- /.row -->
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <div class="pull-left">
              <a href="#" class="btn btn-default btn-flat">Profile</a>
            </div>
            <div class="pull-right">
              <a href="<?php echo U('Login/loginOut');?>" class="btn btn-default btn-flat">Sign out</a>
            </div>
          </li>
        </ul>
      </li>
      <!--/用户-->
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                class="fa fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo U('Index/index');?>" class="brand-link">
      <img src="<?php echo ($config["WEBSITE-LOG"]); ?>" alt="<?php echo ($config["WEBSITE-NAME"]); ?>" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light"><?php echo ($config["WEBSITE-NAME"]); ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo session('admin.image');?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo session('admin.realname');?></a>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          <?php if(is_array($menu)): $i = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i; switch($val["type"]): case "select": ?><li class="nav-item has-treeview">
                  <a href="<?php echo ($val["node_url"]); ?>" target="ifra" class="nav-link">
                    <i class="nav-icon fa <?php echo ($val["icon"]); ?>"></i>
                    <p>
                      <?php echo ($val["title"]); ?>
                      <i class="right fa fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview">
                    <?php if(is_array($val["child"])): $i = 0; $__LIST__ = $val["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$child): $mod = ($i % 2 );++$i;?><li class="nav-item">
                        <a href="<?php echo ($child["node_url"]); ?>" target="ifra" class="nav-link">
                          <i class="fa <?php echo ($child["icon"]); ?> nav-icon"></i>
                          <p><?php echo ($child["title"]); ?></p>
                        </a>
                      </li><?php endforeach; endif; else: echo "" ;endif; ?>
                  </ul>
                </li><?php break;?>
              <?php case "head": ?><li class="nav-item has-treeview">
                  <a href="<?php echo ($val["node_url"]); ?>" target="ifra" class="nav-link">
                    <i class="nav-icon fa <?php echo ($val["icon"]); ?>"></i>
                    <p>
                      <?php echo ($val["title"]); ?>
                    </p>
                  </a>
                </li><?php break;?>
              <?php default: ?>
                <li class="nav-item has-treeview">
                  <a href="<?php echo ($val["node_url"]); ?>" target="ifra" class="nav-link">
                    <i class="nav-icon fa <?php echo ($val["icon"]); ?>"></i>
                    <p>
                      <?php echo ($val["title"]); ?>
                    </p>
                  </a>
                </li><?php endswitch; endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <iframe id="ifra" name="ifra" width="100%" height="100%" src="<?php echo U('Menu/index');?>" style="min-height: 868px;"></iframe>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo ($config["WEBSITE-TIME"]); ?>-<?php echo date('Y')?> <a href="<?php echo U('Index/index');?>"><?php echo ($config["WEBSITE-NAME"]); ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0.0-alpha
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="/Public/Admin/AdminLTE/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/Public/Admin/AdminLTE/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="/Public/Admin/AdminLTE/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/Public/Admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/Public/Admin/dist/js/demo.js"></script>
<script type="application/javascript">
  $('.nav-link ').on('click',function(){
    $('.nav-treeview .nav-link').removeClass('active');  //去掉所有小标题选中状态
    $('.has-treeview>.nav-link').removeClass('active');  //去掉所有大标题选中状态
    $(this).addClass('active');  //当前选中子标题加active
    $(this).parent().parent().parent().children('.nav-link').addClass('active');    //当前选中子标题的父级的父级..加active
    $(this).parent('.nav-item').addClass('active');  //当前选中子标题加active
  })
</script>
</body>
</html>
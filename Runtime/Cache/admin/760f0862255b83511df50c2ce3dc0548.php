<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>登录页</title>
	<link href="/Public/Admin/css/login/login.css" type="text/css" rel="stylesheet" />
	<link href="/logincode.jpg" type="image/icon" rel="shortcut icon">
</head>
<body>
<!-- 提示信息 -->
 <?php
 $rel = $_GET['rel']; $msg = $_GET['msg']; ?>
         <?php echo ($rel); ?>
<!-- 提示信息 -->
<div class="msWidth registerPage" >
	<form id="login" action="<?php echo U('Login/login');?>" method="post">
		<div class="registerInfo">
			<ul>
				<li>欢迎使用系统</li>
				<li>
					<img src="/Public/Admin/images/login/bms-user.png" />
					<input type="text" name="username" placeholder="用户名" autocomplete="off" />
				</li>
				<li>
					<img src="/Public/Admin/images/login/bms-pass.png" />
					<input type="password" name="password" placeholder="密码" autocomplete="off" />
				</li>
				<li>
					<div class="checkbox checkbox-success nm-right">
						<input id="checkbox8" name="check" class="styled" value="on" type="checkbox">
						<label for="checkbox8">
							记住密码
						</label>
					</div>
				</li>
				<li>
					<button id="login-btn">登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录</button>
				</li>
			</ul>
		</div>
	</form>
</div>
</body>
<script src="/Public/Admin/js/jquery.min.js"></script>
<script type="text/javascript">
	$("#login-btn").click(function(){
		$("#login").submit();
	});
</script>
</html>
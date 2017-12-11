<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/Public/qh/css/common.css">
    <link rel="stylesheet" type="text/css" href="/Public/qh/css/login.css">
    <script src="/Public/qh/jquery/jquery-1.8.3.min.js"></script>
    <script src="/Public/qh/js/validate.js"></script>
    <script src="/Public/qh/js/login.js"></script>
	<title>管理后台</title>
</head>
<body>
	<!-- Artlets密码修改成功 -->
	<div id="loginTip" class="pop-layer" style="display: none;">
		<div class="pop-mask" style="display: none;"></div>
		<div class="pop-box">
			<header><h2 class="suc-box">登录成功...</h2></header>
		</div>
	</div>
<!-- 660 -->
	<div class="bg-img-box full-bg"></div>
	<header id="header" class="login-header"><h2 class="logo">管理后台</h2></header>
	<section class="login-section">
		<div class="login-box">
			<form id="loginForm"  method="POST"  name="login_form"  action="<?php echo U('manager/login/LoginHandle');?>" class="login-form form-box">
				<div class="ipt-box username">
					<input class="user ipt" type="text" placeholder="用户名" name="username" id="username" value=''><span class="err-tip">请输入用户名</span>
				</div>
				<div class="ipt-box mt22">
					<input class="pwd ipt" type="password" placeholder="密码" name="password" id="password" value=''><span class="err-tip">请输入密码</span>
				</div>
				<div class="login-ipt-box mt44"><input type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;录"></div>
			</form>
		</div>
	</section>
	<footer class="login-footer"><p class="copy-right">CopyRight 2017 管理后台</p></footer>
</body>
</html>
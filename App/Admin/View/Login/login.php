<!DOCTYPE HTML>
<html>
<head>
<meta name="renderer" content="webkit">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo C('WEBSITE_NAME');?>后台</title>
<link href="<?php echo __ROOT__ , C('STATIC_PATH');?>/css/login.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo __ROOT__ , C('STATIC_PATH');?>/js/login.js"></script>
<!--[if lt IE 10]><script type="text/javascript" src="<?php echo __ROOT__ , C('STATIC_PATH');?>/js/html5.js"></script><![endif]-->
</head>
<body>
<h1><?php echo C('WEBSITE_NAME');?>后台</h1>
<article>
	<span>请在下面输入用户名和密码登录</span>
	<form action="<?php echo U('loginSubmit');?>" method="post">
		<div><label for="username">用户名</label><input type="text" id="username" name="username" value="admin"></div>
		<div><label for="password">密码</label><input type="password" id="password" name="password" value="admin"></div>
		<div>
			<input type="checkbox" id="keep_pass_word" name="keep_pass_word" value="1">
			<label for="keep_password">记住密码(公用电脑别选)</label>
		</div>
		<div align="center">
			<input name="is_mtel" type="hidden" value="">
			<input type="submit" value="登录">
			<input type="reset" value="重置">
		</div>
	</form>
</article>
</body>
</html>
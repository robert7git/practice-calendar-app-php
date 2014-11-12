<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $page_title;?></title>
<meta name="description" content="">
<meta name="keywords" content="">
<?php foreach ($css_files as $css):?>
	<link href="assets/css/<?php echo $css; ?>" rel="stylesheet">
<?php endforeach?>
</head>
<body>

<div class="header">
	<a class="logo" href="/">R日历</a>
	<ul class="nav">
		<!-- <li><a href="/">返回日历</a></li> -->
	</ul>
	<!-- <ul class="userNav">
		<li><a href="login.php">登录</a></li>
		<li><a href="register.php">注册</a></li>
	</ul> -->
</div>
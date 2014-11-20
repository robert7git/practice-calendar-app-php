<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php echo $page_title;?></title>
<meta name="description" content="">
<meta name="keywords" content="">

<?php if (isset($css_files)):?>
	<?php foreach ($css_files as $css):?>
		<link href="<?php echo $css;?>" rel="stylesheet">
<?php endforeach?>
<?php endif?>

<?php if (isset($js_files)):?>
	<?php foreach ($js_files as $js):?>
		<script src="<?php echo $js;?>" type="text/javascript"></script>
<?php endforeach?>
<?php endif?>
</head>
<body>

<div class="header">
	<a class="logo" href="/">R日历</a>
	<ul class="nav">
		<li class="menu">
			<div class="menu-hd"><a href="#">项目</a></div>
			<div class="menu-bd">
				<ul>
					<li><a href="#">logo创意</a></li>
					<li><a href="#">我的搜藏精品</a></li>
					<li><a href="#">对工作中的一些问题的看法</a></li>
				</ul>
			</div>
		</li>
		<li class="menu">
			<div class="menu-hd"><span>视图</span></div>
			<div class="menu-bd">
				<ul>
					<li><a href="#">年</a></li>
					<li><a href="#">月</a></li>
					<li><a href="#">日</a></li>
				</ul>
			</div>
		</li>
		<!-- <li class="on"><a href="#">日</a></li>
		<li><a href="#">周</a></li>
		<li><a href="#">月</a></li>
		<li><a href="#">年</a></li>
		<li><a href="#">统计</a></li>
		<li><a href="#">分类</a></li> -->
	</ul>
	<!-- <ul class="userNav">
		<li><a href="/">年</a></li>
		<li><a href="/">月</a></li>
		<li><a href="/">星期</a></li>
		<li><a href="/">日</a></li>
	</ul> -->
</div>
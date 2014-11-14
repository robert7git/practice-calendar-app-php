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
		<link href="assets/css/<?php echo $css; ?>" rel="stylesheet">
	<?php endforeach?>
<?php endif?>

</head>
<body>

<div class="header">
	<a class="logo" href="/">R日历</a>
	<ul class="nav">
		<li class="on"><a href="#">日</a></li>
		<li><a href="#">周</a></li>
		<li><a href="#">月</a></li>
		<li><a href="#">年</a></li>
		<li><a href="#">统计</a></li>
		<li><a href="#">分类</a></li>
	</ul>
	<!-- <ul class="userNav">
		<li><a href="/">年</a></li>
		<li><a href="/">月</a></li>
		<li><a href="/">星期</a></li>
		<li><a href="/">日</a></li>
	</ul> -->
</div>
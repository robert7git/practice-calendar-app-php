<?php
include_once '../sys/core/init.inc.php';
$cal = new Calendar($dbo);
?>

<?php
$page_title = "日历首页";
$css_files = array(
	'assets/css/base.css',
	'assets/css/layout.css',
	'assets/css/header.css',
	'assets/css/style.css',
);
?>


<?php
$js_files = array(
	'assets/js/jquery-1.11.1.min.js',
	// 'assets/widget/pickadate/scripts/pickadate.js',
	'assets/js/init.js',
);
?>
<?php
include_once 'assets/common/header.inc.php';
?>
<!-- <link rel="stylesheet" href="assets/widget/pickadate/demo/styles/css/main.css"> -->
<link rel="stylesheet" href="assets/widget/pickadate/themes/default.css" id="theme_base">
<link rel="stylesheet" href="assets/widget/pickadate/themes/default.date.css" id="theme_date">
<link rel="stylesheet" href="assets/widget/pickadate/themes/default.time.css" id="theme_time">

<script src="assets/widget/pickadate/picker.js"></script>
<script src="assets/widget/pickadate/picker.date.js"></script>
<script src="assets/widget/pickadate/picker.time.js"></script>
<script src="assets/widget/pickadate/translations/zh_CN.js"></script>
<!-- <script src="assets/widget/pickadate/legacy.js"></script> -->
<!-- <script src="assets/widget/pickadate/demo/scripts/demo.js"></script> -->
<!-- <script src="assets/widget/pickadate/demo/scripts/rainbow.js"></script> -->

<div id="container">
	<div class="content">
		<div class="mod calendar">
			<!-- <div class="mod-hd">
				<h4 class="mod-tit"></h4>
			</div> -->
			<div class="mod-bd">
			<?php
			echo $cal->buildCalendar();
			?>
			</div>
		</div>
	</div>
</div>

<?php
include_once 'assets/common/footer.inc.php';
?>








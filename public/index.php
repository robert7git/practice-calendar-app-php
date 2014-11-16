<?php
	include_once '../sys/core/init.inc.php';
	$cal = new Calendar($dbo);
?>

<?php
	$page_title = "日历首页";
	$css_files = array(
		'base.css',
		'layout.css',
		'style.css'
	);
?>
<?php
	$js_files = array(
		'jquery-1.11.1.min.js',
		// 'jquery.js'
		'init.js'
	);
?>
<?php
	include_once 'assets/common/header.inc.php';
?>

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








<?php
	include_once '../sys/core/init.inc.php';
	$cal = new Calendar($dbo);
?>

<?php
	$page_title = "Event Calendar";
	$css_files = array(
		'base.css',
		'layout.css',
		'style.css'
	);
?>
<?php
	include_once 'assets/common/header.inc.php';
?>
<div id="container">
	<div class="content">
		<?php
			echo $cal->buildCalendar();
		?>
	</div>
</div>
<?php
	include_once 'assets/common/footer.inc.php';
?>
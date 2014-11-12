<?php
	include_once '../sys/core/init.inc.php';
if (!isset($_SESSION['user'])) {
	header('Location: ./');
	exit;
}
	$page_title = "Add/Edit Event";
	$css_files = array(
		'base.css',
		'layout.css',
		'style.css'
	);

	include_once 'assets/common/header.inc.php';
	$cal = new Calendar($dbo);
?>

<div id="container">
	<div class="content">
		<div class="event_form">
		<?php
			echo $cal->displayForm();
		?>
		</div>
	</div>
</div>
<?php
	include_once 'assets/common/footer.inc.php';
?>
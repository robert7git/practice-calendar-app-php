<?php
	include_once '../sys/core/init.inc.php';
if (!isset($_SESSION['user'])) {
	header('Location: ./');
	exit;
}
	$page_title = "Add/Edit Event";
	$css_files = array(
	'assets/com/css/base.css',
	'assets/com/css/layout.css',
	'assets/lib/bootstrap/css/bootstrap.min.css',
	'assets/com/css/header.css',
	'assets/com/css/style.css'
	);

	$cal = new Calendar($dbo);
?>
<?php
include_once 'inc/common/header.inc.php';
?>
<div id="container">
	<div class="content">
			<?php
				echo $cal->displayForm();
			?>
	</div>
</div>
<?php
include_once 'inc/common/footer.inc.php';
?>
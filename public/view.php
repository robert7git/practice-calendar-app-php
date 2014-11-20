<?php
	if (isset($_GET['event_id'])) {
		$id = preg_replace('/[^0-9]/', '', $_GET['event_id']);
		if (empty($id)) {
			header("Location: ./");
			exit;
		}
	} else {
		header("Location: ./");
		exit;
	}

	include_once '../sys/core/init.inc.php';
	$page_title = "查看事件";
	$css_files = array(
		'assets/css/base.css',
		'assets/css/layout.css',
		'assets/css/style.css',
	);


	$cal = new Calendar($dbo);
?>
<?php
	include_once 'assets/common/header.inc.php';
?>

<div id="container">
	<div class="content">
		<div class="mod event_view">
			<?php
				echo $cal->displayEvent($id);
			?>
		</div>
	</div>
</div>
<?php
	include_once 'assets/common/footer.inc.php';
?>
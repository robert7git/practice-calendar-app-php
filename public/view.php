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
	$page_title = "View Event";
	$css_files = array(
		'base.css',
		'layout.css',
		'style.css'
	);


	$cal = new Calendar($dbo);
?>
<?php
	include_once 'assets/common/header.inc.php';
?>

<div id="container">
	<div class="content">
		<div class="event_view">
		<?php
			echo $cal->displayEvent($id);
		?>
		</div>
	</div>
</div>
<?php
	include_once 'assets/common/footer.inc.php';
?>
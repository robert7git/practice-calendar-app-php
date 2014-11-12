<?php
include_once '../sys/core/init.inc.php';

	if (isset($_POST['event_id']) && isset($_SESSION['user'])) {
		// $id = preg_replace('/[^0-9]/', '', $_GET['event_id']);
		$id = (int)$_POST['event_id'];
	} else {
		echo 'confirmDelete else';
		header("Location: ./");
		exit;
	}
	
	$page_title = "Confirm Delete Event?";
	$css_files = array(
		'base.css',
		'layout.css',
		'style.css'
	);


	$cal = new Calendar($dbo);
	$markup = $cal->confirmDelete($id);
?>

<?php
	include_once 'assets/common/header.inc.php';
?>

<div id="container">
	<div class="content">
		<div>
			<?php
				echo $markup;
			?>
		</div>
	</div>
</div>
<?php
	include_once 'assets/common/footer.inc.php';
?>
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
	'assets/com/css/base.css',
	'assets/com/css/layout.css',
	'assets/lib/bootstrap/css/bootstrap.min.css',
	'assets/com/css/header.css',
	'assets/com/css/style.css'
	);


	$cal = new Calendar($dbo);
	$markup = $cal->confirmDelete($id);
?>

<?php
include_once 'inc/common/header.inc.php';
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
include_once 'inc/common/footer.inc.php';
?>
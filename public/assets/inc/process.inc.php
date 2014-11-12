<?php
/**
 * 
 * @authors R7 ()
 * @date    2014-11-10 21:12:44
 * @version $Id$
 */
	include_once '../../../sys/core/init.inc.php';

	$actions = array(
		'event_edit' => array(
			'object' => 'Calendar',
			'method' => 'processForm',
			'header' => 'Location: ../../'
		),
		'user_login' => array(
			'object' => 'Admin',
			'method' => 'processLoginForm',
			'header' => 'Location: ../../'
		),
		'user_logout' => array(
			'object' => 'Admin',
			'method' => 'processLogout',
			'header' => 'Location: ../../'
		)
	);
	if($_POST['token'] == $_SESSION['token'] 
		&& isset($actions[$_POST['action']])){
		$use_array = $actions[$_POST['action']];
		$obj = new $use_array['object']($dbo);
		if (true === $msg = $obj->$use_array['method']()) {
			header($use_array['header']);
			exit;
		} else {
			die($msg);
		}
	}else{
		header("Location: ../../");
	}
?>
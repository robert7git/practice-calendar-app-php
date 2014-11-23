<?php
/**
 * 
 * @authors R7 ()
 * @date    2014-11-13 22:40:17
 * @version $Id$
 */
include_once '../../../sys/core/init.inc.php';

$actions = array(
	'event_view' => array(
		'object' => 'Calendar',
		'method' => 'displayEvent'
	),
	'edit_event' => array(
		'object' => 'Calendar',
		'method' => 'displayForm'
	),
	'event_edit' => array(
		'object' => 'Calendar',
		'method' => 'processForm'
	),
	// 'delete_evnet' => array(
	// 	'object' => 'Calendar',
	// 	'method' => 'confirmDelete'
	// ),
	'confirm_delete' => array(
		'object' => 'Calendar',
		'method' => 'confirmDelete'
	)
);

// echo $_POST['action'];
if (isset($actions[$_POST['action']])) {
	$use_array = $actions[$_POST['action']];
	$obj = new $use_array["object"]($dbo);
	if (isset($_POST['event_id'])) {
		$id = (int) $_POST['event_id'];
	}else{
		$id = null;
	}
	// echo $_POST['action'];
	echo $obj->$use_array['method']($id);
}

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
	)/*,
	'event_edit' => array(
		'object' => 'Calendar',
		'method' => 'displayForm'
	)*/
);

if (isset($actions[$_POST['action']])) {
	$use_array = $actions[$_POST['action']];
	$obj = new $use_array["object"]($dbo);
	if (isset($_POST['event_id'])) {
		$id = (int) $_POST['event_id'];

	}else{
		$id = null;
	}
	echo $obj->$use_array['method']($id);
}

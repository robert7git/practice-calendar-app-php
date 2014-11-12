<?php
/**
 * 
 * @authors R7 ()
 * @date    2014-11-12 01:14:41
 * @version $Id$
 */

include_once '../sys/core/init.inc.php';

$obj = new Admin($dbo);

$hash1 = $obj->testSaltHash('12e8838fdccd2bad4cbc69c5ed370088ce064616aad116c');
echo $hash1 . "<br/>";

// sleep(1);

// $hash2 = $obj->testSaltHash('test');
// echo $hash2 . "<br/>";

sleep(1);

$hash3 = $obj->testSaltHash('12e8838fdccd2bad4cbc69c5ed370088ce064616aad116c', $hash1);
// $hash3 = $obj->testSaltHash( $hash1, '12e8838fdccd2bad4cbc69c5ed370088ce064616aad116c');
echo $hash3 . "<br/>";
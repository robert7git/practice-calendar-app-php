<?php
/**
 * 
 * @authors R7 ()
 * @d    2014-11-12 01:14:41
 * @version $Id$
 */

include_once '../sys/core/init.inc.php';

$obj = new Admin($dbo);

$hash1 = $obj->testSaltHash('12e8838fdccd2bad4cbc69c5ed370088ce064616aad116c');
echo $hash1 . "<br/>";

// sleep(1);

// $hash2 = $obj->testSaltHash('test');
// echo $hash2 . "<br/>";

// sleep(1);

$hash3 = $obj->testSaltHash('12e8838fdccd2bad4cbc69c5ed370088ce064616aad116c', $hash1);
// $hash3 = $obj->testSaltHash( $hash1, '12e8838fdccd2bad4cbc69c5ed370088ce064616aad116c');
echo $hash3 . "<br/>";

?>
<script>
	var d = new Date(NaN);
	d.setFullYear(1992,10,3);
	// var d = new d("Sat Dec 06 2014 00:00:00 GMT+0800 (CST)");
	console.log(d);

	// console.log(1,d);
	// console.log(d.getTimezoneOffset());
	// console.log(d.getTime());
	// d.setMinutes(d.getTimezoneOffset());
	d.setMinutes(100);
	console.log(d);


	// localTime = d.getTime();
	// localOffset=d.getTimezoneOffset()*60000; //获得当地时间偏移的毫秒数
	// utc = localTime + localOffset; //utc即GMT时间
	// offset =10; //以夏威夷时间为例，东10区
	// hawaii = utc + (3600000*offset);
	// nd = new Date(hawaii);

	// console.log(nd);
	// document.writeln("Hawaii time is " + nd.toLocaleString() + <br>");
	// Date.UTC(year, month, day, hours, minutes, seconds, ms) 


	// var d = new Date()
	// 	var gmtHours = d.getTimezoneOffset()/60 ;
	// 	document.write("The local time zone is: GMT " + gmtHours)
</script>

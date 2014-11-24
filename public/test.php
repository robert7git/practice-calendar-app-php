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


$tomorrow  = mktime(0, 0, 0, date("m")  , date("d")+1, date("Y"));
$lastmonth = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
$nextyear  = mktime(0, 0, 0, date("m"),   date("d"),   date("Y")+1);

echo $tomorrow;
echo "<br/>";
echo $lastmonth;
echo "<br/>";
echo $nextyear;
// 假设今天是 2001 年 3 月 10 日下午 5 点 16 分 18 秒，
// 并且位于山区标准时间（MST）时区

/*$today = date("F j, Y, g:i a");                 // March 10, 2001, 5:16 pm
echo "<br/>";
$today = date("m.d.y");                         // 03.10.01
echo "<br/>";
$today = date("j, n, Y");                       // 10, 3, 2001
echo "<br/>";
$today = date("Ymd");                           // 20010310
echo "<br/>";
$today = date('h-i-s, j-m-y, it is w Day');     // 05-16-18, 10-03-01, 1631 1618 6 Satpm01
echo "<br/>";
$today = date('\i\t \i\s \t\h\e jS \d\a\y.');   // it is the 10th day.
echo "<br/>";
$today = date("D M j G:i:s T Y");               // Sat Mar 10 17:16:18 MST 2001
echo "<br/>";
$today = date('H:m:s \m \i\s\ \m\o\n\t\h');     // 17:03:18 m is month
echo "<br/>";
$today = date("H:i:s");                         // 17:16:18
echo "<br/>";*/

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

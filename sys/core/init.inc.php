<?php
	// date_default_timezone_set('PRC');
	date_default_timezone_set("Asia/Shanghai");
	ini_set('display_errors', 'on');
	header("Content-Type:text/html;   charset=utf8"); 

	session_start();

	if (!isset($_SESSION['token'])) {
		$_SESSION['token'] = sha1(uniqid(mt_rand(), true));
	}

	define("DIR_SYS", dirname(dirname(__FILE__)));
	define("DIR_CONFIG", DIR_SYS . "/config");
	define("DIR_CORE", DIR_SYS . "/core");
	define("DIR_CLASS", DIR_SYS . "/class");
	// echo DIR_SYS;
	// echo "<br/>";
	// print_r(pathinfo(DIR_SYS));

	include_once DIR_CONFIG . '/db-cred.inc.php';

	foreach($C as $name => $val){
		define($name, $val);
	}
	$dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
	$dbo = new PDO($dsn, DB_USER, DB_PASS);

	function __autoload($class){
		$filename = DIR_CLASS . "/class." . $class . ".inc.php";
		if (file_exists($filename)) {
			include_once $filename;
		} else {
			echo "include错误：". $filename;
		}
		
	}
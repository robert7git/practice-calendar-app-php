<?php
/**
 * 
 * @authors R7 ()
 * @date    2014-11-12 00:25:54
 * @version $Id$
 */

class Admin extends DB_Connect {
    private $_saltLength = 7;
    public function __construct($db=null,$saltLength = null){
        parent :: __construct($db);
        if (is_int($saltLength)) {
        	$this->_saltLength = $saltLength;
        }
    }

    /*	
	用户登录
	@return 正确：返回true；错误：返回信息
    */
    public function processLoginForm(){
        if ($_POST['action'] != 'user_login') {
        	return "Invalid action supplied for processLoginForm.";
        }

        $user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
        $user_pass = htmlentities($_POST['user_pass'], ENT_QUOTES);

        $sql = "SELECT 
        	`user_id`, `user_name`, `user_pass`, `user_email`
        	FROM `users`
        	WHERE 
        	`user_name` = :uname
        	LIMIT 1;
        ";

        try {
        	$stmt = $this->db->prepare($sql);
        	$stmt->bindParam(":uname" ,  $user_name, PDO::PARAM_STR );
        	$stmt->execute();
        	$user = array_shift($stmt->fetchAll());
        	$stmt->closeCursor();
        } catch (Exception $e) {
        	die($e->getMessage());
        }

        if (!isset($user)) {
        	return "用户名/密码错误";
        }

        /*根据用户输入，生成散列后的密码*/
        $hash =  $this->_getSaltHash($user_pass, $user['user_pass']);

        if ($user['user_pass'] == $hash) {
        	$_SESSION['user'] = array(
        		'id' => $user['user_id'],
        		'name' => $user['user_name'],
        		'email' => $user['user_email']
        	);
        	return true;
        } else {
        	return "用户名/密码错误";
        }
    }

	/*	
	为给定的字符串生成加盐后的散列
	@param string $string 将被散列的字符串
	@param string $salt   从这个字符串中提取盐
	@return string 加盐之后的散列值
    */
    private function _getSaltHash($string, $salt=null){
    	if ($salt == null) {
    		$salt = substr(md5(time()),0,$this->_saltLength);
    	}else{
    		$salt = substr($salt,0,$this->_saltLength);
    	}
    	return $salt.sha1($salt.$string);
    }

    /*	
	用户登出
	@return string 加盐之后的散列值
    */
    public function processLogout(){
    	if ($_POST['action' != 'user_logout']) {
    		return "Invalid action supplied for processLogout.";
    	}

    	session_destroy();
    	return true;
    }
    public function testSaltHash($string, $salt=null){
    	return $this->_getSaltHash($string, $salt);
    }
}




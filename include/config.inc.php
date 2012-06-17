<?php
	//MYSQL login info. 
	define('DB_COLLATE', 'utf8_general_ci');
	define('DB_CHARSET', 'utf8'); 
	define('DB_NAME', 'warehouse'); 
	define('DB_USER', 'root');   
	define('DB_PASSWORD', ''); 	 
	define('DB_HOST', 'localhost'); 
	
	//server
	define('SERVER_TIME_DIFF','interval 0 hour');//北京时间与服务器时间的差值
	
	//status
	define('NOT_LOGIN',-1);
	define('MANAGER',0);
	define('WAREHOUSER',1);
	define('BUYER',2);
	define('TAKER',3);
	
	//commodity
	define('MIN_NUMBER',100);
	
	//mysql login
	function mysql_login()
	{
		$db=new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			return NULL;
		}
		return $db;
	} 
	
	//mysql login with utfs8
	function mysql_login_utfs8()
	{
		$db=mysql_login();
		if (!$db)
			return NULL;
		if(!$db->query("SET NAMES 'utf8'"))
			return NULL;
		return $db;
	}	
	
	//get db time
	function get_dbtime()
	{
		$db=mysql_login();
		$result=$db->query("select date_add(now(),".SERVER_TIME_DIFF.")");
		$row=$result->fetch_assoc(); 
		return $row['date_add(now(),'.SERVER_TIME_DIFF.')']; 
	} 
	
	//jump from one page to another, ATTENTION:$statement and $url must use single quotes(单引号)
	function jump_page($statement,$url)
	{
		echo '<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">	';
		echo '<font color="blue">如果较长时间未跳转，请<a href="'.$url.'">按此跳转</a>。</font>';
		echo '<script>alert("'.$statement.'");</script>';  
		echo '<script language="javascript" type="text/javascript">';  
		echo 'window.location.href="'.$url.'"';  
		echo '</script>';
		exit; 
	}
	
	//determine whether have been login
	function is_login()
	{
		if(!isset($_SESSION)){
			session_start();
		}
		return (isset($_SESSION['uid']));
	}
	
	//get status, if not login, return NOT_LOGIN ,else return uclass
	function get_status()
	{
		if(is_login() && isset($_SESSION['status']))
			return $_SESSION['status'];
		return NOT_LOGIN; 
	}
	
	function get_uid()
	{
		if(is_login() && isset($_SESSION['uid']))
			return $_SESSION['uid'];
		return NOT_LOGIN; 
	}
?>
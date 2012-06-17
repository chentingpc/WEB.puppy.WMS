<?php
	include_once('../include/config.inc.php'); 
	
	$uid=$_POST['uid'];
	$pw=$_POST['password'];
	@$rm=$_POST['remember'];
	if (isset($rm))
		$rm='ON';
	else 
		$rm='OFF'; 
		
	if( substr_count($uid,'"') || substr_count($uid,'\'') || substr_count($pw,'"') || substr_count($pw,'\'') )
		die ('Illegal info..');
	$db=mysql_login_utfs8();
	if ($db==NULL)
		die('<h1>Error: root ACCESS DENIED!</h1>');
	$result=$db->query("select * from user where uid='".$uid."'");
	if (!$result)
	{
		die ('<h1>check id error!</h1>');
		exit;
	} 
	$valid=false;
	if ($result->num_rows)
	{	   
		$row=$result->fetch_assoc();
		if ($pw==$row['pw'] )//&& $row['status']!=-1)
			$valid=true; 
	} 
	
	if ($valid==true)
	{			
		$time=get_dbtime();
		if (!$db->query("update user set last_login='".$time."' where uid='".$uid."'"))
			die ('<font color="red">update login info error!</font>');
		session_start(); 
		if ($rm=='OFF')
			setcookie(session_name(),session_id(),0,"/");
		else{
			$lifeTime = 30 * 24 * 3600 ; //seconds
			setcookie(session_name(), session_id(), time() + $lifeTime, "/"); 
		}
		$_SESSION['id']=$row['id'];
		$_SESSION['uid']=$row['uid'];
		$_SESSION['status']=$row['uclass']; 
		$statement='Login successfully!';
		$url = '../';  
	} 
	else
	{
		$statement='Login failed!';
		$url = '../';  
	}		
	$db->close();
	jump_page($statement,$url);
?>
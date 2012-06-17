<?php
	session_start(); 
	session_destroy();
	require_once('../include/config.inc.php');
	echo '<script>alert("Logout successfully!");</script>'; 
	$url = "../";  
	echo '<script language="javascript" type="text/javascript">';  
	echo 'window.location.href="'.$url.'"';  
	echo '</script>';  
?>
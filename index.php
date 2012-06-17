<?php
	require('./include/config.inc.php');
	$status=get_status();
	
	if ($status==MANAGER){
		require('manager/manager.php');
	}else if ($status==WAREHOUSER){
		require('warehouser/warehouser.php');
	}else if ($status==BUYER){
		require('buyer/buyer.php');
	}else if ($status==TAKER){
		require('taker/taker.php');
	}else{
		require('admin/login.php'); 
	}

?>
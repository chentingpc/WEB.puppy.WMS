<?php
	require('../include/config.inc.php');
	echo '<h1>Hello, Welcome to setup!</h1>';
	
	/****************link to the database or create one***************/
	$db=mysql_login_utfs8();
	$result=$db->query("show databases like '".DB_NAME."'");
	if ($result)
	{ 
		if($result->num_rows)
		{
			echo '<h1>database found, move on..</h1>'; 
		}
		else
		{
			echo '<h1>database not exist, we create it..</h1>';
			$query="create database ".DB_NAME." DEFAULT CHARACTER SET ".DB_CHARSET." COLLATE ".DB_COLLATE;
			$result=$db->query($query);
			if (!$result){
				echo '<font color="red">create database failure</font>';	 
			} 	
			/*************GRANT A NEW DB USER*******************
			$query="grant all on ".DB_NAME.".* to ".DB_USER." identified by ".DB_PASSWORD; 
			$result=$db->query($query);
			if (!$result){
				echo '<font color="red">grant authority failure</font>';	 
			} 	
			**************************************************/
		}
	}  
	else
	{ 
		die('<font color="red">query database existency failed!</font>');	
	}
	$db->close(); 
	$db= new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	if (mysqli_connect_errno())
	{
		die('<font color="red">Error: MYSQL ACCESS DENIED!</font>');	
	}	
	
	/***********create user table*************************/
	/*
	*	about uclass: 0,经理; 1,库管; 2,采购员; 3,提货人员
	*
	*/
	if (!$result=$db->query("show tables like 'user'")){ 
		die('<font color="red">query tables existency failed!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>table user is already exist, move on..</h1>';
		}
		else
		{
			echo '<h1>table user is not exist, we will create it..</h1>';
			$query="create table user(
						id bigint(20) unsigned not null auto_increment primary key,
						uid varchar(30) unique,
						pw varchar(100),
						uclass int(11),
						last_login datetime
					) ";
			$result=$db->query($query);
			if (!$result){
				die('<font color="red">create table user fail!</font>');
			}
		}
	}
	
	/***********create commodity table*************************/
	if (!$result=$db->query("show tables like 'commodity'")){ 
		die('<font color="red">query tables existency failed!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>table commodity is already exist, move on..</h1>';
		}
		else
		{
			echo '<h1>table commodity is not exist, we will create it..</h1>';
			$query="create table commodity(
						id bigint(20) unsigned not null primary key auto_increment,
						name varchar(1000) not null,
						number bigint(20) unsigned,
						price_in bigint(20) unsigned,
						price_out bigint(20) unsigned,
						price_out_patch bigint(20) unsigned,
						last_update datetime 
					) ";
			$result=$db->query($query);
			if (!$result){
				die('<font color="red">create table commodity fail!</font>');
			}
		}
	}
	
	/***********create authority table*************************/
	/* 	about mode: x, not authorized; r, read only; w, both read and write
	*	about uclass: 0,经理; 1,库管; 2,采购员; 3,提货人员
	*
	*/
	 if (!$result=$db->query("show tables like 'authority'")){ 
		die('<font color="red">query tables existency failed!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>table authority is already exist, move on..</h1>';
		}
		else
		{
			echo '<h1>table authority is not exist, we will create it..</h1>';
			$query="create table authority(
						uclass int(11) not null primary key ,
						id_moode char,
						name_moode char,
						number_moode char,
						price_in_moode char,
						price_out_moode char,
						price_out_patch_moode char,
						log char,
						last_update_moode char
					) ";
			$result=$db->query($query);
			if (!$result){
				die('<font color="red">create table authority fail!</font>');
			}
		}
	}
	
	/***********create buyer's list table*************************/
	if (!$result=$db->query("show tables like 'buy_list'")){ 
		die('<font color="red">query tables existency failed!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>table buy_list is already exist, move on..</h1>';
		}
		else
		{
			echo '<h1>table buy_list is not exist, we will create it..</h1>';
			$query="create table buy_list(
						id bigint(20) unsigned not null primary key auto_increment,
						pid bigint unsigned not null,
						pname varchar(1000) not null,
						number bigint(20) unsigned,
						time datetime,
						apply_name varchar(100),
						approve_name varchar(100)
					) ";
			$result=$db->query($query);
			if (!$result){
				die('<font color="red">create table buy_list fail!</font>');
			}
		}
	}
	
	/***********create taker's list table*************************/
	if (!$result=$db->query("show tables like 'take_list'")){ 
		die('<font color="red">query tables existency failed!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>table take_list is already exist, move on..</h1>';
		}
		else
		{
			echo '<h1>table take_list is not exist, we will create it..</h1>';
			$query="create table take_list(
						id bigint(20) unsigned not null primary key auto_increment,
						pid bigint unsigned not null,
						pname varchar(1000) not null,
						number bigint(20) unsigned,
						time datetime,
						apply_name varchar(100),
						approve_name varchar(100)
					) ";
			$result=$db->query($query);
			if (!$result){
				die('<font color="red">create table take_list fail!</font>');
			}
		}
	}
	
	/***********insert user manager and define manager's authority*************************/
	/*Warning: with futhure addding, the unseperation of user and authority would result in unconsistency*/
	$result=$db->query("select 'uid' from user where uid='chentingpc-ma'"); 
	if(!$result)
	{
		die('<font color="red">create user fail!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>The user is already exsit!</h1>'	;
		}
		else
		{
			echo '<h1>The user is not exsit, we will create it..</h1>'	;
			if(!$db->query("insert user values('','chentingpc-ma','bupt','0','0')") || !$db->query("insert authority values('0','w','w','r','w','w','w','r','r')"))
				echo '<font color="red">insert manager or define manager authority error!</font>';
		}
	}
	
	/***********insert user warehouser and define warehouser's authority*************************/
	/*Warning: with futhure addding, the unseperation of user and authority would result in unconsistency*/
	$result=$db->query("select 'uid' from user where uid='chentingpc-wh'"); 
	if(!$result)
	{
		die('<font color="red">create user fail!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>The user is already exsit!</h1>'	;
		}
		else
		{
			echo '<h1>The user is not exsit, we will create it..</h1>'	;
			if(!$db->query("insert user values('','chentingpc-wh','bupt','1','0')") || !$db->query("insert authority values('1','w','w','w','x','x','x','r','r')"))
				echo '<font color="red">insert warehouser or define warehouser authority error!</font>';
		}
	}
		
	/***********insert user buyer and define buyer's authority*************************/
	/*Warning: with futhure addding, the unseperation of user and authority would result in unconsistency*/
	$result=$db->query("select 'uid' from user where uid='chentingpc-by'"); 
	if(!$result)
	{
		die('<font color="red">create user fail!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>The user is already exsit!</h1>'	;
		}
		else
		{
			echo '<h1>The user is not exsit, we will create it..</h1>'	;
			if(!$db->query("insert user values('','chentingpc-by','bupt','2','0')") || !$db->query("insert authority values('2','r','r','r','r','x','x','r','r')"))
				echo '<font color="red">insert buyer or define buyer autority error!</font>';
		}
	}
	
	/***********insert user taker and define taker's authority*************************/
	/*Warning: with futhure addding, the unseperation of user and authority would result in unconsistency*/
	$result=$db->query("select 'uid' from user where uid='chentingpc-tk'"); 
	if(!$result)
	{
		die('<font color="red">create user fail!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>The user is already exsit!</h1>'	;
		}
		else
		{
			echo '<h1>The user is not exsit, we will create it..</h1>'	;
			if(!$db->query("insert user values('','chentingpc-tk','bupt','3','0')") || !$db->query("insert authority values('3','r','r','r','x','r','r','r','r')"))
				echo '<font color="red">insert taker or define taker authority error!</font>';
		}
	}
	
	/***********insert uclass: manager*************************/
	$result=$db->query("select 'uid' from user where uid='chentingpc-tk'"); 
	if(!$result)
	{
		die('<font color="red">create user fail!</font>');
	}
	else
	{
		if ($result->num_rows)
		{
			echo '<h1>The user is already exsit!</h1>'	;
		}
		else
		{
			echo '<h1>The user is not exsit, we will create it..</h1>'	;
			if(!$db->query("insert user values('','chentingpc-tk','bupt','3','0')"))
				echo '<font color="red">insert the user error!</font>';
		}
	}
	
	/***********unlink the database*************************/
	$db->close();
	echo '<h1>the database has been successfully setuped!</h1>';
	
?>
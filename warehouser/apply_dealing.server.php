<?php
	require('../include/config.inc.php');
	echo '<!DOCTYPE html><head> <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"></head>';
	@$id=$_GET['id'];
	@$type=$_GET['type'];
	@$approve=$_GET['approve']; 
	$uid=get_uid();
	if (get_status()!=WAREHOUSER)
		die('You are not warehouser!');
	
	if (isset($id) && isset($type) && isset($approve)){
		$db=mysql_login_utfs8();
		if ($db==null)
			die ('<font color="red">databse login error!</font>'); 
		if ($approve=='yes'){ 
			if ($type=='in'){ 
				$result=$db->query("select * from buy_list where id='$id'");
				if (!$result)
					die("mysql error!");
				$row=$result->fetch_assoc();
				$number=$row['number'];
				$pid=$row['pid']; 
				$result=$db->query("update commodity set number=number+$number where id=$pid"); 
				if ($result){
					$result=$db->query("update buy_list set approve_name='$uid' where id='$id'");
					if ($result)
						$statement="操作成功！";
					else
						$statement="操作失败！";
				}
				else
					$statement='操作失败！';
			}
			else if ($type=='out'){
				$result=$db->query("select * from take_list where id='$id'");
				if (!$result)
					die("mysql error!");
				$row=$result->fetch_assoc();
				$number=$row['number'];
				$pid=$row['pid']; 
				$result=$db->query("update commodity set number=number-$number where id=$pid and number>=$number"); 
				echo $db->affected_rows;
				if ($result and $db->affected_rows){
					$result=$db->query("update take_list set approve_name='$uid' where id='$id'"); 
				}
				else
					$statement='操作失败！库存数量不足！';	 
			}
			else
				$result=false;
		} 
		else{
			if ($type=='in')
				$result=$db->query("delete from buy_list where id='$id'");
			else if ($type=='out')
				$result=$db->query("delete from take_list where id='$id'");
			else
				$result=false;
		}
		if (!isset($statement))
			if ($result)
				$statement="操作成功！";
			else
				$statement="操作失败！";
				
		$url="..";
		jump_page($statement,$url);
	}
?>
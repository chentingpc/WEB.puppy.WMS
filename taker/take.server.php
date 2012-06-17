<?php
	require('../include/config.inc.php');
	echo '<!DOCTYPE html><head> <meta http-equiv="Content-Type" content="text/html"; charset="utf-8"></head>';
	@$id=$_POST['id'];
	@$name=$_POST['name'];
	@$number=$_POST['number'];
	$uid=get_uid();
	if (get_status()!=TAKER)
		die('You are not taker!');
	
	if (isset($id) && isset($name) && isset($number)){ 
		$db=mysql_login_utfs8();
		if ($db==null)
			die ('<font color="red">databse login error!</font>'); 
		$time=get_dbtime(); 
		$result=$db->query("select * from commodity where id='$id' and name='$name'");
		if (!$result || $result->num_rows==0)
			die('商品编号查询失败或商品不存在。<a href="..">返回主页</a>');
		$result=$db->query("insert take_list values('','$id','$name','$number','$time','$uid','')");
		if ($result){
			$statement="操作成功！";
		}else
			$statement="操作失败！";
		$url="..";
		jump_page($statement,$url);
	}
	else
		die('info not complete!');
?>
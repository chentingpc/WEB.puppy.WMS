<!DOCTYPE html>
<html>
<head> 
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<link rel = "Shortcut Icon" href="../" >
	<link href="../css/html.css" type="text/css" rel="stylesheet" />  
	<link href="../css/subsection.css" type="text/css" rel="stylesheet" />   
	<title>仓库管理系统</title>
</head>		
<body>
<?php
	require('../include/config.inc.php');
	$status=get_status();
	if ($status==NOT_LOGIN)
		die('<h3>You are not logined!</h3>');
	@$id=$_GET['id'];
	
	if (!isset($id) or $id==null)
		die("Not goods specified!"); 
	$db=mysql_login_utfs8();
	if (!$db)
		die('<font color="red">Mysql access denied!</font>');
	$result=$db->query("select * from commodity where id='$id'");  
	echo '<center><h1>修改</h1></center><form name="edit" action="./edit_goods.server.php?old_id='.$id.'" method="POST"><table class="table_type1"><tr class="first_row_type1"><th>商品编号</th><th>商品名称</th><th>商品库存</th><th>入库价格</th><th>零售价</th><th>批发价</th><th>最后更新时间</th></tr>';
	if ($result and $result->num_rows){ 
		$num=$result->num_rows;
		if (isset($status) and $result2=$db->query("select * from authority where uclass='$status'")){
			$auth=$result2->fetch_assoc(); 
			for ($i=0; $i<$num; $i++){
				$row=$result->fetch_assoc();
				if ($i%2==0)
					echo '<tr class="not_first_row_type1">';
				else 
					echo '<tr class="not_first_row_type2">';
			
				if ($auth['id_moode']=='x')
					$id_show='---';
				else 
					$id_show=$row['id'];
				if ($auth['name_moode']=='x')
					$name_show='---';
				else 
					$name_show=$row['name'];
				if ($auth['number_moode']=='x')
					$number_show='---';
				else
					$number_show=$row['number'];
				if ($auth['price_in_moode']=='x')
					$price_in_show='---';
				else 
					$price_in_show=$row['price_in'];
				if ($auth['price_out_moode']=='x')
					$price_out_show='---';
				else 
					$price_out_show=$row['price_out'];
				if ($auth['price_out_patch_moode']=='x')
					$price_out_patch_show='---';
				else 
					$price_out_patch_show=$row['price_out_patch'];
				if ($auth['last_update_moode']=='x')
					$last_update_show='---';
				else
					$last_update_show=$row['last_update'];
				echo '<td>'.$id_show.'</td><td>'.$name_show.'</td><td>'.$number_show.'</td><td>'.$price_in_show.'</td><td>'.$price_out_show.'</td><td>'.$price_out_patch_show.'</td><td>'.$last_update_show.'</td></tr>';
			}
		}
	}
	if (isset($status) and $result=$db->query("select * from authority where uclass='$status'")){
		$auth=$result->fetch_assoc(); 
		if ($auth['id_moode']!='w')
			$id_show='---';
		else 
			$id_show='<input type="text" name="id"/>';
		if ($auth['name_moode']!='w')
			$name_show='---';
		else 
			$name_show='<input type="text" name="name"/>';
		if ($auth['number_moode']!='w')
			$number_show='---';
		else
			$number_show='<input type="text" name="number"/>';
		if ($auth['price_in_moode']!='w')
			$price_in_show='---';
		else 
			$price_in_show='<input type="text" name="price_in"/>';
		if ($auth['price_out_moode']!='w')
			$price_out_show='---';
		else 
			$price_out_show='<input type="text" name="price_out"/>';
		if ($auth['price_out_patch_moode']!='w')
			$price_out_patch_show='---';
		else 
			$price_out_patch_show='<input type="text" name="price_out_patch"/>';
		if ($auth['last_update_moode']!='w')
			$last_update_show='---';
		else
			$last_update_show='<input type="text" name="last_update"/>';
					
		echo '<tr class=“not_first_row_type1”><td>'.$id_show.'</td><td>'.$name_show.'</td><td>'.$number_show.'</td><td>'.$price_in_show.'</td><td>'.$price_out_show.'</td><td>'.$price_out_patch_show.'</td><td>'.$last_update_show.'</td></tr>';
	}
	echo '</table><center><br/><input type="submit" value="确认修改"/></center></form><br/><center><a href="..">返回主页</a></center>';
?>
</body>
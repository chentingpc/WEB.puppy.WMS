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
	@$id=$_POST['id'];
	@$name=$_POST['name'];
	@$number=$_POST['number'];
	
	if (!isset($id) or $id==null)
		$id_st='';
	else
		$id_st="and id='$id' ";
	if (!isset($name) or $name==null)
		$name_st='';
	else 
		$name_st="and name='$name' ";
	if (!isset($number) or $number==null)
		$number_st='';
	else
		$number_st="and number='$number' ";
	$db=mysql_login_utfs8();
	if (!$db)
		die('<font color="red">Mysql access denied!</font>');
	$result=$db->query("select * from commodity where 1 ".$id_st.$name_st.$number_st);  
	echo '<center><h1>搜索结果</h1></center><table class="table_type1"><tr class="first_row_type1"><th>商品编号</th><th>商品名称</th><th>商品库存</th><th>入库价格</th><th>零售价</th><th>批发价</th><th>最后更新时间</th><th>修改信息</th></tr>';
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
				echo '<td>'.$id_show.'</td><td>'.$name_show.'</td><td>'.$number_show.'</td><td>'.$price_in_show.'</td><td>'.$price_out_show.'</td><td>'.$price_out_patch_show.'</td><td>'.$last_update_show.'</td><td><a href="../common/edit_goods.php?id='.$row['id'].'">edit</a></td></tr>';
			}
		}
	}
	echo '</table><br/><br/><center><a href="..">返回主页</a></center>';
?>
</body>
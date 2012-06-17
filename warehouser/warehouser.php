<!DOCTYPE html>
<html>
<head> 
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<link rel = "Shortcut Icon" href="./" >
	<link href="./css/html.css" type="text/css" rel="stylesheet" />  
	<link href="./css/subsection.css" type="text/css" rel="stylesheet" />  
	<link href="./css/footer.css" type="text/css" rel="stylesheet" />  
	<title>仓库管理系统</title>
</head>		
<body >	   
<div class="header"><div class="left"><img src="./css/image/title.png"/></div><div class="right"><img src="./css/image/logo.png"/></div></div>
<div id="framework_subsection">
<div class="nav"><a href="#allow">出入库批准*</a><a href="#inout">出入库信息</a><a href="#disp">商品信息显示</a><a href="#query">商品信息查询</a></div>
<div class="title"><div class="title_left"><b><?php echo $_SESSION['uid'];?></b> 库管</div> <div class="title_right"><a href="./admin/logout.php">登出</a></div></div>
<div class="sub_content">
<div class="title" id="allow"><b>出入库批准*</b></div>
<div class="entry_content">
<?php
	$db=mysql_login_utfs8();
	if ($db==null)
		echo '<font color="red">databse login error!</font>';
	else{
		echo '<table class="table_type1">';
		echo '<tr class="first_row_type1"><th>出/入库申请</th><th>商品编号</th><th>商品名称</th><th>商品数量</th><th>日期</th><th>申请人</th><th>批准/否决</th></tr>';
		$result1=$db->query("select * from buy_list where approve_name=''");
		$result2=$db->query("select * from take_list where approve_name=''");
		if ($result1 && $result2){   
			$num=$result1->num_rows;
			for ($i=0;$i<$num;$i++){
				$row=$result1->fetch_assoc();
				if ($i%2==0)
					echo '<tr class="not_first_row_type1">';
				else
					echo '<tr class="not_first_row_type2">';
				echo '<td>入库申请</td><td>'.$row['pid'].'</td><td>'.$row['pname'].'</td><td>'.$row['number'].'</td><td>'.$row['time'].'</td><td>'.$row['apply_name'].'</td><td><a href="./warehouser/apply_dealing.server.php?id='.$row['id'].'&type=in&approve=yes">批准</a>/<a href="./warehouser/apply_dealing.server.php?id='.$row['id'].'&type=in&approve=no">否决</a></td></tr>';
			}
			$num=$result2->num_rows;
			for ($i=0;$i<$num;$i++){
				$row=$result2->fetch_assoc();
				if ($i%2==0)
					echo '<tr class="not_first_row_type1">';
				else
					echo '<tr class="not_first_row_type2">';
				echo '<td>出库申请</td><td>'.$row['pid'].'</td><td>'.$row['pname'].'</td><td>'.$row['number'].'</td><td>'.$row['time'].'</td><td>'.$row['apply_name'].'</td><td><a href="./warehouser/apply_dealing.server.php?id='.$row['id'].'&type=out&approve=yes">批准</a>/<a href="./warehouser/apply_dealing.server.php?id='.$row['id'].'&type=out&approve=no">否决</a></td></tr>';
			}
		}
		echo '</table>';
	} 
?>
</div>
<br/><div class="title" id="inout"><b>出入库信息</b></div>
<div class="entry_content">
<?php
	echo '<table class="table_type1">'.
		'<tr class="first_row_type3"><th>出/入库</th><th>商品编号</th><th>商品名称</th><th>商品库存</th><th>提交时间</th><th>提交者</th><th>批准者</th></tr>';
	$result=$db->query("select * from buy_list where approve_name!='null'");
	if ($result and $result->num_rows){
		$num=$result->num_rows; 
		for ($i=0;$i<$num;$i++){
			$row=$result->fetch_assoc();
			if ($i%2==0)
				echo '<tr class="not_first_row_type1">';
			else
				echo '<tr class="not_first_row_type2">';
			echo '<td>入库</td><td>'.$row['pid'].'</td><td>'.$row['pname'].'</td><td>'.$row['number'].'</td><td>'.$row['time'].'</td><td>'.$row['apply_name'].'</td><td>'.$row['approve_name'].'</td></tr>';
		}
	}
	$result=$db->query("select * from take_list where approve_name!='null'");
	if ($result and $result->num_rows){
		$num=$result->num_rows; 
		for ($i=0;$i<$num;$i++){
			$row=$result->fetch_assoc();
			if ($i%2==0)
				echo '<tr class="not_first_row_type1">';
			else
				echo '<tr class="not_first_row_type2">';
			echo '<td>出库</td><td>'.$row['pid'].'</td><td>'.$row['pname'].'</td><td>'.$row['number'].'</td><td>'.$row['time'].'</td><td>'.$row['apply_name'].'</td><td>'.$row['approve_name'].'</td></tr>';
		}
	}
	echo '</table>';
?>
</div>
<br/><div class="title" id="disp"><b>商品信息显示</b></div>
<div class="entry_content">
<?php
	echo '<table class="table_type1">'.
		'<tr class="first_row_type4"><th>商品编号</th><th>商品名称</th><th>商品库存</th><th>入库价格</th><th>零售价</th><th>批发价</th><th>最后更新时间</th><th>编辑信息</th></tr>';
	$result=$db->query("select * from commodity");
	if ($result and $result->num_rows){
		$num=$result->num_rows;  
		if (isset($status) and $result2=$db->query("select * from authority where uclass='$status'")){
			$auth=$result2->fetch_assoc(); 
			for ($i=0;$i<$num;$i++){
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
				echo '<td>'.$id_show.'</td><td>'.$name_show.'</td><td>'.$number_show.'</td><td>'.$price_in_show.'</td><td>'.$price_out_show.'</td><td>'.$price_out_patch_show.'</td><td>'.$last_update_show.'</td><td><a href="./common/edit_goods.php?id='.$row['id'].'">edit</a></td></tr>';
			}
		}
	}
	echo '</table>';
?>
</div>
<br/><div class="title" id="query"><b>商品信息查询</b></div>
<div class="entry_content"> 
	<form name="search_goods" action="./common/search_goods.php" method=post> 
		<table class="table_type1">
		<tr class="first_row_type5"><th>商品编号</th><th>商品名称</th><th>商品库存</th></tr>
		<tr class="not_first_row_type1">
		<th><input type=text name=id /></th>
		<th><input type=text name=name /></th>
		<th><input type=text name=number /></th> 
		</tr>
		</table>
		<center><input type=submit name=search_goods value="查询"/></center>
	</form>
</div> 

</div>
</div>
<div class="footer">
<b>copyright@ct-team, 2012</b>
</div>
</body>
</html>
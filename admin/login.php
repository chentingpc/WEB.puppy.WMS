<!DOCTYPE html>
<html>
<head> 
	<meta http-equiv="Content-Type" content="text/html"; charset="utf-8">
	<link rel = "Shortcut Icon" href="./" >
	<link href="./css/html.css" type="text/css" rel="stylesheet" />  
	<link href="./css/login.css" type="text/css" rel="stylesheet" />  
	<link href="./css/footer.css" type="text/css" rel="stylesheet" />  
	<title>仓库管理系统</title>
</head>		
<body >	
<div id="framework_login">
<div class="header_login"><div class="left"><img src="./css/image/title.png"/></div><div class="right"><img src="./css/image/logo.png"/></div></div>
<div class="login_base_wrap">
<br/>
<div class="login_base">
	<form name="loginform" action="./admin/login.server.php" method=post> 
		<div class="login_table">
			<table >
				<tr>
					<th>UID</th>
					<th><input type=text name=uid></th>
				</tr>
				<tr>
					<th>Password</th>
					<th><input type=password name=password><br> </th>
				</tr>
				
			</table>
		</div>
		<div align="center"> 
			<h5><input id="remember" type="checkbox" name="remember" />Remember me</h5>
			<div class="submit"><input type=submit name=loginsubmit style="width:90px" value="登陆" onClick="return login_submit()" /></div>
		</div>
	</form> 
</div>
</div>
<div class="footer3">
<b>copyright@ct-team, 2012</b>
</div>
</div>
</div>
</body>
</html>
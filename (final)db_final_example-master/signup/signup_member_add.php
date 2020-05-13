<?php 
session_id(SID);
//启动session
session_start()
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//資料庫設定
//資料庫位置
$db_server = "localhost";
//資料庫名稱
$db_name = "final";
//資料庫管理者帳號
$db_user = "root";
//資料庫管理者密碼
$db_passwd = "root";
//對資料庫連線
if(!@mysqli_connect($db_server, $db_user, $db_passwd))
        die("無法對資料庫連線");
?>

<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
	
<style>
.tbl-qa{border-spacing:0px;border-radius:4px;border:#6ab5b9 1px solid;}
</style>
  <title>Add New Employee</title> 	
</head>
<body>
<?php if(!empty($success_message)) { ?>
<div class="success message"><?php echo $success_message; ?></div>
<?php } if(!empty($error_message)) { ?>
<div class="error message"><?php echo $error_message; ?></div>
<?php } ?>
<?php //$event_id = $_GET['id'];
if(empty($_GET['id'])){
	$event_id ='1';
}
else{
	$event_id =$_GET['id'];
}
	?>
<?php //echo $event_id; ?>
<?php $member_num = $_SESSION['member_num'];?>
<?php //echo $member_num; ?>
<form name="frmUser" method="post" action="http://localhost/signup/signup_member_add_finish.php"> <!--這什麼挖勾-->

<!--<div class="button_link"><a href="http://localhost/signup.php"> Back to List </a></div>-->
<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tbl-qa">
	<thead>
		<tr>
			<th colspan="2" class="table-header">Add New teammate</th>
		</tr>
	</thead>
	<tbody>
		<tr class="table-row">
			<td><label>user_id</label></td>
			<td><input type="text" name="user_id" class="txtField"></td>
		</tr>
		<!--
		<tr class="table-row">
			<td><label>Email</label></td>
			<td><input type="text" name="email" class="txtField"></td>
		</tr>-->
		
		<tr class="table-row">
			<td colspan="2"><input type="submit" name="submit" value="Submit" class="demo-form-submit"></td>
		</tr>
	</tbody>
</table>
</form>
</body>
</html>
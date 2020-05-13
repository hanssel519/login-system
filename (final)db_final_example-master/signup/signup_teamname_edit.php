<?php
session_id(SID);
session_start();
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
$conn =mysqli_connect($db_server, $db_user, $db_passwd,$db_name );
if(!$conn){
        die("無法對資料庫連線". mysqli_connect_error());
}
?>
<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<style>
.tbl-qa{border-spacing:0px;border-radius:4px;border:#6ab5b9 1px solid;}
</style>
<title>team member edit </title>
</head>
<body>
<?php if(!empty($success_message)) { ?>
<div class="success message"><?php echo $success_message; ?></div>
<?php } if(!empty($error_message)) { ?>
<div class="error message"><?php echo $error_message; ?></div>
<?php } ?>
<?php
$event_id = $_SESSION['event_id'];
$_SESSION['event_id'] = $event_id;
/*echo 'event_id	';
echo $event_id;
echo '<br>team_name_exist:';
echo $_SESSION['team_name_exist'];*/
//$team_id = $_GET['id'];
if(empty($_GET['id'])){
	$team_id ='1';
}
else{
	$team_id =$_GET['id'];
}
			    //$_SESSION['anncs_id'] = $anncs_id;
/*$dsn = "mysql:host=$db_server;dbname=$db_name";
$db = new PDO($dsn, $db_user, $db_passwd);
$sql="SELECT * FROM `$db_name`.`anncs` where `anncs`.anncs_id='$anncs_id'";
$people_rs=$db->prepare($sql);
$people_rs->bindValue(':anncs_id', $anncs_id, PDO::PARAM_INT);
$people_rs->execute();*/
?>
<form name="frmUser" method="post" action="http://localhost/signup/signup_teamname_edit_finish.php"> <!--這什麼挖勾-->

<!--<div class="button_link"><a href="http://localhost/signup.php" >Back to List </a></div>-->
<table border="0" cellpadding="10" cellspacing="0" width="500" align="center" class="tbl-qa">
	<thead>
		<tr>
			<th colspan="2" class="table-header">team member Edit</th>
		</tr>
	</thead>
	<tbody>
		<tr class="table-row">
			<td><label>team_name</label></td>
			<td><input type="text" name="team_name" class="txtField" value=""></td>
		</tr>
		<tr class="table-row">
			<td colspan="2"><input type="submit"  name="submit" value="Submit" class="demo-form-submit"></td>
		</tr>
	</tbody>	
</table>
</form>
</body>
</html>



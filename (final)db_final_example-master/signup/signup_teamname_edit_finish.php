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

<?php
//$register_id = $_SESSION['register_id'];
$_SESSION['event_id'] = $_SESSION['event_id'];
$team_name = $_POST['team_name'];
$event_id = $_SESSION['event_id'];
//echo 'event_id: ';
//echo $_SESSION['event_id'];
$team_id = $_SESSION['team_id'];
//echo 'team_id:';
//echo $_SESSION['team_id'];

$dsn = "mysql:host=$db_server;dbname=$db_name";
$db = new PDO($dsn, $db_user, $db_passwd);

/*
$sql = "SELECT * FROM `$db_name`.`register` where `register_id`='$register_id'";          
$result = $db->prepare($sql);
$result->execute();
$row = $result->fetchObject();
*/
$sql = "SELECT `$db_name`.`team`.team_name FROM `$db_name`.`event` JOIN `$db_name`.`team` ON `$db_name`.`event`.event_id = `$db_name`.`team`.event_id and `$db_name`.`team`.event_id = '$event_id' and `$db_name`.`team`.team_name = '$team_name' and `$db_name`.`team`.success = true and `$db_name`.`team`.cancel = false";						
$result = $db->prepare($sql);
$result->execute();					
$count = $result->rowCount();
if($count == 0){
	$sql_1 = "UPDATE `$db_name`.`team` SET `team_name`= '$team_name'  WHERE `team_id`= '$team_id'";
	$result_1 = $db->prepare($sql_1);
	if($result_1->execute())
	{
		$success_message = "Added Successfully";
		//如果team_name成功signup,把資料存進team並且找出(automatic increase的team_id)
		//team_id放進session,給之後register 的 member用
		
		//$_SESSION['team_id'] = $row->team_id;
		//echo '<br>team_name_exist:';
		//echo $_SESSION['team_name_exist'];
		echo "<script>alert('修改隊名成功')</script>";
		echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $_SESSION['event_id'] . '>';
	} 
	else {
		//echo 'ss';
		$error_message = "Problem in Adding New Record";
		echo "<script>alert('修改隊名失敗')</script>";
		echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $_SESSION['event_id'] . '>';
	}
	$sql->close();  
	//unset($_SESSION['register_id']);
	$conn->close();
	if(!empty($success_message)) { ?>
		<div class="success message"><?php echo $success_message; ?></div>
		<?php } 
	if(!empty($error_message)) { ?>
	<div class="error message"><?php echo $error_message; ?></div>
	<?php } 
}
else{
	$error_message = "Problem in Adding New Record";
	echo "<script>alert('此隊名已被使用過')</script>";
	echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $_SESSION['event_id'] . '>';

}

//$row_1 = $result_1->fetchObject();
	//require_once("database.php");
//wrong =======================	

       

  
?>
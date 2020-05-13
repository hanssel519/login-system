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
//if (isset($_POST['submit'])) {
	
	//require_once("database.php");

	$dsn = "mysql:host=$db_server;dbname=$db_name";
	$db = new PDO($dsn, $db_user, $db_passwd);
	$event_id = $_SESSION['event_id'];
	$team_name = $_POST['team_name'];
	/*echo '<br>event_id  ';
	echo $event_id;
	echo '<br>team_name  ';
	echo $team_name;*/
	//"SELECT * FROM `$db_name`.`house` join `$db_name`.`member_table` on `$db_name`.`house`.owner_id=`$db_name`.`member_table`.id LEFT JOIN `$db_name`.`loc` ON `$db_name`.`loc`.`house_id`=`$db_name`.`house`.`hid` LEFT JOIN `$db_name`.`loc_list` ON `$db_name`.`loc_list`.id=`$db_name`.`loc`.`loc_id` where `$db_name`.`member_table`.account='$account'"  ;
	
	//檢查在同一個活動是否有重複新增名字
	$sql = "SELECT `$db_name`.`team`.team_name FROM `$db_name`.`event` JOIN `$db_name`.`team` ON `$db_name`.`event`.event_id = '$event_id' and `$db_name`.`team`.event_id = '$event_id' and `$db_name`.`team`.team_name = '$team_name' and `$db_name`.`team`.success = true and `$db_name`.`team`.cancel = false";						
	$result = $db->prepare($sql);
	$result->execute();					
	$count = $result->rowCount();
	//echo '<br>count   ';
	//echo $count;

	//此名稱已被註冊
	if($count > 0){
		echo "<script>alert('此名稱已被註冊 新增隊伍名稱失敗')</script>";
		echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup/signup_team_add.php?id=' . $event_id . '>';
	}
	//成功
	else{
		$sql_1="INSERT INTO `$db_name`.`team` (`team_name`, `event_id`, `signup_id`) VALUES ('$team_name', '$event_id', 1)";
		if(mysqli_query($conn, $sql_1)){
			// echo "<script>alert('新增成功!')</script>";
			// echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/signup.php?id=' . $event_id . '>';
	//wrong =======================			
			//echo 'here1';
			$success_message = "Added Successfully";
			//echo 'here';
			//如果team_name成功signup,把資料存進team並且找出(automatic increase的team_id)
			//team_id放進session,給之後register 的 member用
			//$dsn = "mysql:host=$db_server;dbname=$db_name";
			//$db = new PDO($dsn, $db_user, $db_passwd);
			//抓team_id
			/*
			$sql_2="SELECT * FROM `$db_name`.`team` where `team_name`='$team_name' and `event_id` = '$event_id' and";
			$result_2 = $db->prepare($sql_2);
			$result_2->execute();
			$row_2 = $result_2->fetchObject();
			*/
			$_SESSION['team_name_exist'] = 'true';
			
			$sql_2 = "SELECT * FROM `$db_name`.`team` order by team_id desc limit 1";
			$result_2 = $db->prepare($sql_2);
			$result_2->execute();
			$row_2 = $result_2->fetchObject();
			//$sql = "SELECT * FROM team where team_name = $team_name and event_id = $event_id";
			//$result = mysqli_query($sql);
			//$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$_SESSION['team_id'] = $row_2->team_id;
			//echo $row_2->team_id;
			/*echo '<br>team_name_exist:  ';
			echo $_SESSION['team_name_exist'];
			echo '<br>team_id  ';
			echo $_SESSION['team_id'];*/

			echo "<script>alert('新增隊伍名稱成功')</script>";
			echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
		}
		//無故不成功 語法問題
		else {
			//echo 'ss';
			$error_message = "Problem in Adding New Record";
			echo "<script>alert('新增隊伍名稱失敗')</script>";
			echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
		}
	
	}
	//$sql->close();
	//$conn->close();
	if(!empty($success_message)) { ?>
		<div class="success message"><?php echo $success_message; ?></div>
		<?php } 
	if(!empty($error_message)) { ?>
	<div class="error message"><?php echo $error_message; ?></div>
	<?php 
	} 

//}
?>
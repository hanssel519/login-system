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
	
	
	$register_id = $_GET['id'];
	$event_id = $_SESSION['event_id'];
	/*if(empty($_GET['id'])){
		$register_id ='1';
	}
	else{
		$register_id =$_GET['id'];
	}
	$register_id =$_GET['id'];
	echo $register_id;
	echo '<br>';
	echo $event_id;
*/
	$sql="DELETE  FROM `$db_name`.`register` WHERE register_id = '$register_id'";
    
	if(mysqli_query($conn, $sql))
	{
		$_SESSION['member_num']--;
		$success_message = "Added Successfully";
		echo "<script>alert('刪除隊員稱成功')</script>";
		echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
	} 
	else {
		//echo 'ss';
		$error_message = "Problem in Adding New Record";
		echo "<script>alert('刪除隊員稱失敗')</script>";
		echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
	
	}
	$sql->close(); 
	$conn->close();

?>
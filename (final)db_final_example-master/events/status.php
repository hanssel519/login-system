<?php // 報名狀況 
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
if(!@mysqli_connect($db_server, $db_user, $db_passwd))
        die("無法對資料庫連線");

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Events status</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href="" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://localhost/css/home.css">
		<link rel="stylesheet" href="http://localhost/css/event.css">
	</head>
	<body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="http://localhost/admi_page.php">N C T U &nbsp;&nbsp; S p o r t s</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/admi_page.php">首頁 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/events/event_admin.php">活動報名 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li class="active"><a href="http://localhost/events/status.php">報名狀況 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/info/admi.php">admin <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/logout.php">登出 <span class="sr-only">(current)</span></a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container event-wrapper event-list">
			<h3 class="title">報名狀況</h3>
			<br>
			<?php
			
	
//if($_SESSION[user_id]!= null && $_SESSION['Admin'] == true){
$dsn = "mysql:host=$db_server;dbname=$db_name";
$db = new PDO($dsn, $db_user, $db_passwd);
$sql="SELECT * FROM `$db_name`.`event` where `event`.cancel = 'false'";
//檢查一下false/ true的寫法
$result = $db->prepare($sql);
$result->execute();

while($row = $result->fetchObject()){ //列出每個event
	$event_id = $row->event_id;
	?>
	<table class="table text-center"> 
	<!--這條放哪裡都怪怪的--><?php
	$today= date("Y-m-d");
	if($today > $row->event_date){?>
		<h4 class="title"><?php echo $row->event_name; ?><strong> (已過期)</strong></h4>
	<?php
	}
	else{?>
		<h3 class="title"><?php echo $row->event_name; ?></h3><?php
	}
	
	
	//檢查到底有沒有人真的報名

	$sql_1 = "SELECT * FROM `$db_name`.`team` where `team`.event_id = '$event_id' and `team`.success = true and `team`.cancel = false";
	$result_1 = $db->prepare($sql_1);
	$result_1->execute();
	$count_1 = $result_1->rowCount();
	//======
	$row_1 = $result_1->fetchObject();//找到team_id	
	$team_id = $row_1->team_id;
//	echo $team_id;
//	echo $row_1->team_name;
	//======
	//echo '<br>已報名的隊伍數: ';
	//echo $count_1;
	if(($count_1)==0){//這個event沒有人報名
		?>
		<tr><td><?php echo '尚無人報名' ?></td></tr>
		<?php
	}
	//這個event有人報名
	else{
		?>
		<tr>
		<th class="text-center">隊伍名稱</th>
		<th class="text-center">隊伍成員</th>
		</tr>
		<?php
		$sql_1 = "SELECT * FROM `$db_name`.`team` where `team`.event_id = '$event_id' and `team`.success = true and `team`.cancel = false";
		$result_1 = $db->prepare($sql_1);
		$result_1->execute();

		while($row_1 = $result_1->fetchObject()){//找到team_id		
			//$count_1 = $result_1->rowCount();
			//echo $team_id;
			?>
			<tr>
			<td><h4 class="title"><?php echo $row_1->team_name;?></h4></td>
			<?php

			$team_id = $row_1->team_id;
			//echo $team_id;
			?>
			<?php
			//找出有哪些成員
			$sql_2 = "SELECT * FROM `$db_name`.`register` where `register`.team_id = '$team_id'";
			$result_2 = $db->prepare($sql_2);
			$result_2->execute();
			?><td class="text-center"><?php
			while($row_2 = $result_2->fetchObject()){ //印出這個team內的所有成員
				$user_id = $row_2->user_id;
				$sql_3 = "SELECT * FROM `$db_name`.`user` where `user`.account = '$user_id'";
				$result_3 = $db->prepare($sql_3);
				$result_3->execute();
				$row_3 = $result_3->fetchObject();//找到team_id
				//還沒做
				//$user_name = $row_3->user_name; //印出使用者名稱
				echo $row_3->account;
				echo "        ";
				echo $row_3->user_name;
				?><br><?php
			}
		}
		?>
		</td>
		</tr>
		<?php
	}
	
}
?>
			</table>
			
		</div>
	</body>
</html>
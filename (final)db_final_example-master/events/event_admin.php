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
if(!@mysqli_connect($db_server, $db_user, $db_passwd))
        die("無法對資料庫連線");

//$dsn = "mysql:host=$db_server;dbname=$db_name";
//$db = new PDO($dsn, $db_user, $db_passwd);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Events admin</title>
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
				<!--
				problem :
				1. href of 活動報名
				-->
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/admi_page.php">首頁 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li class="active"><a href="http://localhost/events/event_admin.php">活動報名 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/events/status.php">報名狀況 <span class="sr-only">(current)</span></a></li>
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
			<h3 class="title">活動列表</h3>
			<br>
			<a href="http://localhost/events/add.php"><button class="btn btn-default btn-new">新增活動</button></a>
			<br><br>
			<table class="table text-center">
				<tr>
					<th class="text-center">項目</th>
					<th class="text-center">規則</th>
					<th class="text-center">報名</th>
					<th class="text-center">操作</th>
				</tr>

<?php
	$dsn = "mysql:host=$db_server;dbname=$db_name";
	$db = new PDO($dsn, $db_user, $db_passwd);
	$today= date("Y-m-d");

	$sql="SELECT * FROM `$db_name`.`event`where `event`.cancel = 'false'";
	//沒被cancel的活動 就印出來
	$people_rs = $db->prepare($sql);
	$people_rs->execute();
	$_SESSION['team_name_exist'] = 'false';
	$_SESSION['member_num'] = 0;
	//$sql = "select * from event";//查詢整個表單
	//$result = mysql_query($sql) ;
	
	while($row = $people_rs->fetchObject()){

	//while($row = mysql_fetch_array($result, MYSQL_ASSOC)){//印出資料
?>
	<tr>
		<td><?php echo $row->event_name?></td> <!--活動名稱 -->
		<td><?php echo $row->event_rule?></td> <!--活動規則 -->
		<?php

		if($today > $row->event_date){?>
			<td>已過期不可報名</td>
			<td>
				<a href="http://localhost/events/status.php?id=<?php echo $row->event_id; ?>"><button class="btn btn-default btn-eventstatus">報名狀態</button></a>
			</td>
			<?php
		}
		else{


			$user_id = $_SESSION['account'];

			//echo '<br>account: ';
			//echo $user_id;
			$event_id = $row->event_id;
			//echo '<br>event_id: ';
			//echo $event_id;

			$sql_1 = "SELECT `team`.team_id FROM `$db_name`.`register` JOIN `$db_name`.`team` ON `register`.`user_id` = '$user_id' and `register`.`team_id` = `team`.`team_id` and `team`.`event_id` = '$event_id' and `team`.cancel = false and `team`.success = true";						
			$result_1 = $db->prepare($sql_1);
			$result_1->execute();	
			//echo '<br> qq';				
			if($row_1 = $result_1->fetchObject()){
				//echo $row->event_id;
				?> 

				<td><a href="http://localhost/events/signup/delete.php?id=<?php echo $row->event_id; ?>"><button class="btn btn-default btn-event">刪除已報名活動</button></a> </td>
			<?php
			}
			else{?>
				<td><a href="http://localhost/signup.php?id=<?php echo $row->event_id; ?>"><button class="btn btn-default btn-event">報名</button></a></td>
			<?php
			}?>


		



			<td>
			<a href="http://localhost/events/edit.php?id=<?php echo $row->event_id; ?>"><button class="btn btn-default btn-new">修改</button></a>
			<a href="http://localhost/events/status.php?id=<?php echo $row->event_id; ?>"><button class="btn btn-default btn-eventstatus">報名狀態</button></a>
			<a href="http://localhost/events/delete.php?id=<?php echo $row->event_id; ?>" onclick="return confirm('是否確認刪除此活動');"><button class="btn btn-default btn-remove">移除</button></a>
			</td>

		</tr>		
	<?php
		}
	}
	?>

				<!--
				for loop
				{event_name, event_rule, sign up button,
				edit button, status button, delete button}
				-->
				<!--
				problem :
				1. connect to " signup.php ~ events/edit.php ~ events/status.php ~ events/delete.php "
				   with the "corresponding event" ?
				2. href of 報名狀態(connect to the website that display events status of "all events")
				   -> not "only this event" 
				   => is that we want ?
				-->
				
				<!-- platform 
				<tr>
					<td>泡泡足球</td>
					<td>像泡泡一樣的足球</td>
					<td><a href="signup.php"><button class="btn btn-default btn-event">報名</button></a></td>
					<td>
					<a href="events/edit.php"><button class="btn btn-default btn-editevent">修改</button></a>
					<a href="events/status.php"><button class="btn btn-default btn-eventstatus">報名狀態</button></a>
					&nbsp;&nbsp;
					<a href="events/delete.php"><button class="btn btn-default btn-deleteevent">移除</button></a>
					</td>
				</tr>
				-->

			</table>
		</div>
	</body>
</html>
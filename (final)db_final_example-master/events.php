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
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Events</title>
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
					<a class="navbar-brand" href="http://localhost/user_page.php">N C T U &nbsp;&nbsp; S p o r t s</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-link">
					<?php
					if($_SESSION['account'] == NULL){?>
						<ul class="nav navbar-nav navbar-link">
							<li><a href="http://localhost/index.php">首頁 <span class="sr-only">(current)</span></a></li>
						</ul>
					<?php
					}
					else{ ?>
						<ul class="nav navbar-nav navbar-link">
							<li><a href="http://localhost/user_page.php">首頁 <span class="sr-only">(current)</span></a></li>
						</ul>
						<?php
					}?>


					<ul class="nav navbar-nav navbar-link">
						<li class="active"><a href="http://localhost/events.php">活動報名 <span class="sr-only">(current)</span></a></li>
					</ul>
					
					<?php
					if($_SESSION['account'] == NULL){?>
						<ul class="nav navbar-nav navbar-link">
							<li><a href="http://localhost/register.php">註冊 <span class="sr-only">(current)</span></a></li>
						</ul>
					<?php
					}
					else{ ?>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/info/user.php">user <span class="sr-only">(current)</span></a></li>
					</ul><?php
				} 
					if($_SESSION['account'] == NULL){?>
						<ul class="nav navbar-nav navbar-link">
							<li><a href="http://localhost/login.php">登入 <span class="sr-only">(current)</span></a></li>
						</ul>
					<?php
					}
					else{ ?>
						<ul class="nav navbar-nav navbar-link">
							<li><a href="http://localhost/logout.php">登出 <span class="sr-only">(current)</span></a></li>
						</ul>
						<?php
					}?>
				</div>
			</div>
		</nav>
		<div class="container event-wrapper event-list">
			<h3 class="title">活動列表</h3>
			<br>
			<table class="table text-center">
				<tr>
					<th class="text-center">項目</th>
					<th class="text-center">規則</th>
					<th class="text-center">報名</th>
				</tr>
				<?php
				$dsn = "mysql:host=$db_server;dbname=$db_name";
				$db = new PDO($dsn, $db_user, $db_passwd);
				$today= date("Y-m-d");
				//echo $today;

				$_SESSION['member_num'] = 0; // 給signup_member_add紀錄已經有幾個隊員了
				$user_id = $_SESSION['account'];
				$_SESSION['team_name_exist'] = 'false';
				$sql="SELECT * FROM `$db_name`.`event`";
				$result = $db->prepare($sql);
				$result->execute();
				
				if($_SESSION['account'] == NULL){?>
					<h3 class="title"><mark>請先登入再報名</mark></h3>
					<br>
					<?php
					while($row = $result->fetchObject()){//印出資料
						// && ($today > $row->event_date)
						if($row->cancel == 0 && ($today < $row->event_date)){
				?>
						<tr>
							<td><?php echo $row->event_name;?></td> <!--活動名稱 -->
							<td><?php echo $row->event_rule;?></td> <!--活動規則 -->
							<!--<td><a href="signup.php?id=<?php //echo $row['id']; ?>">按鈕名稱（報名）</a></td>-->
							<td></td>
						</tr>	
							<?php
						}
					}			
				}
				else{
					while($row = $result->fetchObject()){//印出資料
						if($row->cancel == 0 && ($today < $row->event_date)){?>
						<tr>
							<td><?php echo $row->event_name;?></td> <!--活動名稱 -->
							<td><?php echo $row->event_rule;?></td> <!--活動規則 -->
							<!--<td><a href="signup.php?id=<?php //echo $row['id']; ?>">按鈕名稱（報名）</a></td>-->
							<?php
							//mysql_select_db($dbname);
							
							
							$event_id = $row->event_id;

							//may be wrong
							$sql_1 = "SELECT `team`.team_id FROM register JOIN team ON `register`.user_id = '$user_id' and `register`.team_id = `team`.team_id and `team`.event_id = '$event_id'";						
							$result_1 = $db->prepare($sql_1);
							$result_1->execute();					
							if($row_1 = $result_1->fetchObject()){
								?> <!--如果找到這個使用者有報名者個活動 ＝> -->
								<!--<td><a href="cancel_signup_event.php?id=<?php //echo $event_id; ?>"><button class="btn btn-default btn-event">取消報名</button></a></td>-->
								<td> <a href="http://localhost/events/signup/delete.php?id=<?php echo $event_id; ?>"><button class="btn btn-default btn-event">刪除已報名活動</button></a> </td>
							<?php
							}
							else{ ?>	
								<td><a href="http://localhost/signup.php?id=<?php echo $event_id; ?>"><button class="btn btn-default btn-event">報名</button></a></td>
							<?php
							}
							?>
						</tr>		
					<?php
						}
					}
				}
				?>
			
			</table>
		</div>
	</body>
</html>
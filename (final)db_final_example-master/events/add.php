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
		<title>Events add</title>
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
					<a class="navbar-brand" href="#">N C T U &nbsp;&nbsp; S p o r t s</a>
				</div>
				<!--
				problem :
				1. href of 活動報名 and 報名狀況
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
						<li><a href="http://localhost/anncs/add.php">admin <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/logout.php">登出 <span class="sr-only">(current)</span></a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container event-wrapper event-list">
			<h3 class="title">新增活動</h3>
			<!-- 
			do not understand :
			1. class="text-center"
			2. for="event_name"
			3. id="event_name"
			
			may have some mistakes :
			1. type=" "
			2. type="number" -> it will generate negative number
			   => how to avoid it?
			3. 活動規則 may have many characters
			   but 
			   type="text" : Default. Defines a single-line text field (default width is 20 characters)
			   how to extend the characters that it can contains more ? 
			--><form name="form" method="post" action="http://localhost/events/event_add_finish.php">
		
			
	
			<br>
			<label class="text-center" for="event_name">活動名稱</label>
			<input type="text" id="event_name" name="event_name" class="form-control">
			<br>
			<?php
			$today= date("Y-m-d");
			//echo $today;
			$today++;
			//echo $today;
			?>
			<label class="text-center" for="event_name">活動日期</label>
			<input type="date" id="event_name" name="event_date"   value="<?php echo $today?>" min="<?php echo $today?>" max="2050-08-31" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control">
			<span class="validity"></span>

	

			<br>
			<label class="text-center" for="event_name">隊伍數量限制</label>
			<input type="number" id="event_name" name="event_team_limit" class="form-control">
			<br>
			<label class="text-center" for="event_name">每隊最多人數限制</label>
			<input type="number" id="event_name" name="event_max_team_members" class="form-control">
			<br>
			<label class="text-center" for="event_name">每隊最少人數限制</label>
			<input type="number" id="event_name" name="event_min_team_members" class="form-control">
			<br>
			<label class="text-center" for="event_name">活動規則</label>
			<input type="text" id="event_name" name="event_rule" class="form-control">
			
			<br>
			<a href="http://localhost/events/event_add_finish.php"><button class="btn btn-default btn-new">發佈</button></a> <!--更改要傳入url-->
			<!--<a href="http://localhost/events/event_admin.php"><button class="btn btn-default btn-remove">取消</button></a>-->
			<input class="btn btn-default btn-remove" type="button" value="取消" onclick="location.href='http://localhost/events/event_admin.php'">
			
			</form>

			
			<!--
			problem :
			1. if click 發佈
			   save the input to the event table with  " Event_id "
			   input { Event_name , Event_date , Event_team_limit , Event_max_team_members 
			   , Event_min_team_members , Event_rule }
			   how to ? 
			2. if click 發佈 or 取消
			   jump back to "events/event_admin.php" ?
			-->
		</div>
	</body>
</html>
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
		<title>Events edit</title>
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
			<h3 class="title">修改活動</h3>
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
			-->
			<?php
			//if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
			/*$dsn = "mysql:host=$db_server;dbname=$db_name";
			$db = new PDO($dsn, $db_user, $db_passwd);

			$event_id = $_GET['id'];
			
			$sql="SELECT * FROM `$db_name`.`event` where event_id = '$event_id'";
			$people_rs = $db->prepare($sql);
			$people_rs->execute();*/

			if(empty($_GET['id'])){
			    $event_id ='1';
			}
			else{
			    $event_id =$_GET['id'];
			}
			    //$_SESSION['anncs_id'] = $anncs_id;
			$dsn = "mysql:host=$db_server;dbname=$db_name";
			$db = new PDO($dsn, $db_user, $db_passwd);
			$sql="SELECT * FROM `$db_name`.`event` where event_id = '$event_id'";
			$people_rs=$db->prepare($sql);
			$people_rs->bindValue(':id', $event_id, PDO::PARAM_INT);
			$people_rs->execute();

			?>
			<form name="form" method="post" action="http://localhost/events/event_edit_finish.php">
			<?php
			//$sql = "select * from event where event_id = '$event_id'";
			//$result = mysql_query($sql);
			$_SESSION['event_id'] = $event_id;
		//	echo '$event_id: ';
		//	echo $event_id;

			if($row = $people_rs->fetchObject()){
        		?>
				
				<!--檢查有沒有存到event_id-->
				
				<br>
				<label class="text-center" for="event_name">活動名稱</label>
				<input type="text" id="event_name" name="event_name" class="form-control" value= "<?php  echo $row->event_name;?>"> <!--列出 活動日期 “Date”-->
				<br>
				<?php
				$today= date("Y-m-d");
				$today++;
				?>
				<label class="text-center" for="event_name">活動日期</label>
				<input type="date" id="event_name" name="event_date"   value= "<?php echo $row->event_date;?>" min="<?php echo $today?>" max="2050-08-31" required pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" class="form-control">
				<span class="validity"></span>
				<br>
				<label class="text-center" for="event_name">隊伍數量限制</label>
				<input type="number" id="event_name" name="event_team_limit" class="form-control" value="<?php echo $row->team_limit;?>">
				<br>
				<label class="text-center" for="event_name">每隊最多人數限制</label>
				<input type="number" id="event_name" name="event_max_team_members" class="form-control" value="<?php echo $row->event_max_team_members;?>">
				<br>
				<label class="text-center" for="event_name">每隊最少人數限制</label>
				<input type="number" id="event_name" name="event_min_team_members" class="form-control" value="<?php echo $row->event_min_team_members;?>">
				<br>
				<label class="text-center" for="event_name">活動規則</label>
				<input type="text" id="event_name" name="event_rule" class="form-control" value="<?php echo $row->event_rule;?>">
				
			<?php
			}
			?>
			
			<!--
			problem :
			1. how to display the original event data into the blank box
			(especial 活動日期)
			-->
			
			<br>

			<!--<a href="http://localhost/events/event_edit_finish.php?>">-->
			<button class="btn btn-default btn-new">儲存</button>
			<!--</a>
			<a href="http://localhost/events/event_admin.php"><button class="btn btn-default btn-remove">取消</button></a>-->
			<input class="btn btn-default btn-remove" type="button" value="取消" onclick="location.href='http://localhost/events/event_admin.php'">
			</form>
			
			<!--
			problem :
			1. if click 儲存
			   save the input that is edited to the event table with  " Event_id "
			   input { Event_name , Event_date , Event_team_limit , Event_max_team_members 
			   , Event_min_team_members , Event_rule }
			   how to ? 
			2. if click 儲存 or 取消
			   jump back to "events/event_admin.php" ?
			-->
		</div>
	</body>
</html>
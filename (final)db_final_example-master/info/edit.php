<?php session_start(); ?>
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
$id = $_SESSION['id'];
$account = $_SESSION['account'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Home</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href="" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://localhost/css/home.css">
		<link rel="stylesheet" href="http://localhost/css/announce.css">
	</head>
	<body>
		<form name="form" method="post" action="http://localhost/info/edit_act.php">
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
						<li ><a href="http://localhost/admi_page.php">首頁 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/events/event_admin.php">活動報名 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/events/status.php">報名狀況 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li class="active"><a href="http://localhost/info/admi.php">admin <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/logout.php">登出 <span class="sr-only">(current)</span></a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container announce-wrapper">
			<!--<form action="info/edit_act.php?account=<?php echo $account; ?>" method="POST">-->
			<h3 class="title">修改會員資料</h3>

			<div class="row">
				<table class="table">
					<?php 
					$dsn = "mysql:host=$db_server;dbname=$db_name";
					$db = new PDO($dsn, $db_user, $db_passwd);
            
					$sql="SELECT * FROM `$db_name`.`user`where `user`.id='$id'" ;
					$people_rs = $db->prepare($sql);
					$person = $people_rs->fetchObject();
					$people_rs->execute();
					while($person = $people_rs->fetchObject()){
						//$iid = $person->id;
					?>	
					<br>
					<label class="text-center" for="account">學號</label>
					<input type="text" id="account" name="account" class="form-control" value="<?php echo $person->account;?>">
					<br>
					<label class="text-center" for="name">姓名</label>
					<input type="text" id="name" name="name" class="form-control" value="<?php echo $person->user_name;?>">
					<br>
					<br>
					<label class="text-center" for="pw">密碼</label>
					<input type="text" id="pw" name="pw" class="form-control" value="<?php echo base64_decode($person->pw);?>">
					<br>
					<br>
					<label class="text-center" for="mail">信箱</label>
					<input type="text" id="mail" name="mail" class="form-control" value="<?php echo $person->mail;?>">
					<br>
                	<?php
				        }
				    ?>
				</table>
				<br>
			
					<br>
					<div class="col-md-3 col-md-offset-3">
					<button class="btn btn-default btn-new" type="submit">儲存</button>
					<input class="btn btn-default btn-remove" type="button" value="取消" onclick="location.href='http://localhost/info/admi.php'">
					</div>
			</div>
		</div>
	</body>
</html>
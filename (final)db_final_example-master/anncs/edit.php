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

$account=$_SESSION['account'];
//$anncs_id=$_GET['anncs_id'];
if(empty($_GET['anncs_id'])){
	$anncs_id ='1';
}
else{
	$anncs_id =$_GET['anncs_id'];
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Anncs edit</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href="" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://localhost/css/home.css">
		<link rel="stylesheet" href="http://localhost/css/anncs_add.css">
	</head>
	<body>
		<form name="form" method="post" action="http://localhost/anncs/edit_act.php?anncs_id=<?php echo $anncs_id; ?>">
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
						<li class="active"><a href="http://localhost/admi_page.php">首頁 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li ><a href="http://localhost/events/event_admin.php">活動報名 <span class="sr-only">(current)</span></a></li>
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
			
		<div class="container anncs_add-wrapper event-list">
			<form action="auth/anncs_edit.php?anncs_id=<?php echo $anncs_id; ?>" method="POST">
			<h3 class="title">修改公告</h3>
			<?php
			/*$dsn = "mysql:host=$db_server;dbname=$db_name";
			$db = new PDO($dsn, $db_user, $db_passwd);
            
			$sql="SELECT * FROM `$db_name`.`anncs` where `anncs`.anncs_id='$anncs_id'";
			$people_rs = $db->prepare($sql);
			$people_rs->execute();
			$person = $people_rs->fetchObject();*/

			
			    //$_SESSION['anncs_id'] = $anncs_id;
			$dsn = "mysql:host=$db_server;dbname=$db_name";
			$db = new PDO($dsn, $db_user, $db_passwd);
			$sql="SELECT * FROM `$db_name`.`anncs` where `anncs`.anncs_id='$anncs_id'";
			$people_rs=$db->prepare($sql);
			$people_rs->bindValue(':anncs_id', $anncs_id, PDO::PARAM_INT);
			$people_rs->execute();
			$person = $people_rs->fetchObject();
			?>
			<br>
			<label class="text-center" for="anncs_title">公告標題</label>
			<input type="text" id="title" name="anncs_title" class="form-control" value="<?php echo $person->anncs_title;?>">
			<br>
			<label class="text-center" for="anncs_description">公告內容</label>
			<textarea name="anncs_description" style="width:1000px;height:500px;border-radius:5px;" wrap="physical"><?php echo htmlspecialchars($person->anncs_description);?></textarea>
			<br>
			
			<br>
			<div class="col-md-3 col-md-offset-3">
			<button class="btn btn-default btn-new" type="submit">儲存</button>
			<input class="btn btn-default btn-remove" type="button" value="取消" onclick="location.href='http://localhost/admi_page.php'">
			</div>
		</div>
	</body>
</html>
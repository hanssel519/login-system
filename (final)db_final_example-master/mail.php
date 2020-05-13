<?php
session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php

//if(!isset($_SESSION))$SEC = "";
//else 
$SEC1 = $_SESSION['chkNum'];
$account = $_SESSION['account'];
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>登入</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href="" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://localhost/css/home.css">
		<link rel="stylesheet" href="http://localhost/css/login.css">
	</head>
	<body>
		<form name="form" method="post" action="http://localhost/checkmail.php">
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
						<li><a href="http://localhost/index.php">首頁 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/events.php">活動報名 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li  class="active"><a href="http://localhost/register.php">註冊 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/login.php">登入 <span class="sr-only">(current)</span></a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container login-wrapper">
			<form action="auth/login.php" method="POST">
				<div class="row">
					<div class="col-md-9 col-md-offset-1">
						
					</div>
					<div class="col-md-5 col-md-offset-1">
					<?php
					//echo $account;
					//echo $SEC1;
					echo" <br>請至信箱認證信中取得認證碼<br>";?>
					<label>認證碼：</label>
					
					<input type="text" name="Captcha1" class="form-control">
				    </div>
					<div class="col-md-12">
						<br>
					</div>
					<div class="col-md-3 col-md-offset-3">
						<button class="btn btn-default btn-new" type="submit">確認</button>
					</div>
					</form>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>
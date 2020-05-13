<?php
session_start();
?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>忘記密碼</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href="" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="http://localhost/css/home.css">
		<link rel="stylesheet" href="http://localhost/css/register.css">
		<script>
        function refresh_code(){ 
            document.getElementById("imgcode").src="Captcha.php"; 
        } 
        </script>
	</head>
	<body>
		<form name="form" method="post" action="http://localhost/findpw.php">
			
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
						<li ><a href="http://localhost/register.php">註冊 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li class="active"><a href="http://localhost/login.php">登入 <span class="sr-only">(current)</span></a></li>
					</ul>
				</div>
			</div>
		</nav>
		<div class="container register-wrapper">
			<form action="auth/register.php" method="POST">
				<div class="row">
					<div class="col-md-9 col-md-offset-1">
						<br><br><br>
					</div>
					<div class="col-md-5 col-md-offset-1">
						<label>學號</label>
						<input type="text" name="account" class="form-control">
					</div>
					
					<div class="col-md-12">
						<br>
					</div>
					<div class="col-md-5 col-md-offset-1">	
						<label>問題：你最愛的人？</label>
						<input type="ques" name="ques" class="form-control">
					</div>
					<div class="col-md-12">
						<br>
					</div>
					
		        	<div class="col-md-12">
						<br>
					</div>
					<div class="col-md-5 col-md-offset-1">
						<label>驗證碼</label>
						<img id="imgcode" src="Captcha.php" onclick="refresh_code()" />
						<br />點擊圖片可以更換驗證碼
						<input type="text" name="Captcha" class="form-control">
					</div>
					<div class="col-md-12">
						<br>
					</div>
					<div class="col-md-3 col-md-offset-3">
						<button class="btn btn-default btn-new" type="submit">找回密碼</button>
						<input class="btn btn-default btn-remove" type="button" value="取消" onclick="location.href='http://localhost/login.php'">
						<!--<input class="btn btn-default btn-remove" type="reset" value="清除">-->
					</div>
					</form>

				</div>
			</form>
		</div>
	</body>
</html>
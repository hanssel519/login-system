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
						<!--<li><a href="http://localhost/events/event_admin.php">活動報名 <span class="sr-only">(current)</span></a></li>-->
						<li><a href="http://localhost/events/event_admin.php">活動報名 <span class="sr-only">(current)</span></a></li>
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
		<div class="container announce-wrapper">
			<h3 class="title">最新公告<a href="http://localhost/anncs/add.php"><button class="btn btn-default btn-remove">新增公告</button></a></h3>
			<form method="post" name="form1" id="form1" action="http://localhost/anncs/deletes_act.php">
			<div class="row">
				<table class="table">
					<?php 
					$dsn = "mysql:host=$db_server;dbname=$db_name";
					$db = new PDO($dsn, $db_user, $db_passwd);
            
					$sql="SELECT * FROM `$db_name`.`anncs`" ;
					$people_rs = $db->prepare($sql);

					$person = $people_rs->fetchObject();
					$people_rs->execute();
					while($person = $people_rs->fetchObject()){
						$title = $person->anncs_title;
					?>	
					<tr>
						
	                <td class="td-date"><?php echo date("Y/m/d",strtotime($person->anncs_posttime)); ?></td>
	                <td class="td-date"><INPUT TYPE="checkbox"  NAME="checkbox[]" value="<?php echo $person->anncs_title;?>">
	                <a href="http://localhost/anncs/admin.php?anncs_id=<?php echo $person->anncs_id; ?>""><?php echo $person->anncs_title;?></a>
	                </td>
                	</tr>
                	<?php
				        }
				    ?>
				  
				  	
				</table>
			</div>
			<!--<a href="http://localhost/anncs/deletes_act.php"><button class="btn btn-default btn-new">刪除公告</button></a>-->
			<!--<button class="btn btn-default btn-new">刪除公告</button>-->
			<a onclick="return confirm('是否確認刪除這些公告');"><button class="btn btn-default btn-new" >刪除公告</button></a>
			</form>
			
		</div>
	</body>
</html>
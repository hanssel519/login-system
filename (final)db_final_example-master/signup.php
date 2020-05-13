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
$link = mysqli_connect($db_server, $db_user, $db_passwd, $db_name);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Sign up</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<link href="" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/home.css">
		<link rel="stylesheet" href="css/event.css">
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
					
					<?php

					$dsn = "mysql:host=$db_server;dbname=$db_name";
					$db = new PDO($dsn, $db_user, $db_passwd);
					$user_id = $_SESSION['account'];
   	 				$sql_2 = "SELECT * FROM `$db_name`.`user` WHERE  `account`= '$user_id'";
    				$result_2 = $db->prepare($sql_2);
					$result_2->execute();
					$count2 = $result_2->rowCount();
					$row_2 = $result_2->fetchObject();
					if($row_2->identity == 'admi'){ /// 要判對是什麼身份回什麼地方
					?>
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
					<?php
					}
					else{?>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/user_page.php">首頁 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li class="active"><a href="http://localhost/events.php">活動報名 <span class="sr-only">(current)</span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/info/user.php">user <span class="sr-only">(current)</span></a></li>
					</ul>

					<?php
					}  
					?>

				

					<ul class="nav navbar-nav navbar-link">
						<li><a href="http://localhost/logout.php">登出 <span class="sr-only">(current)</span></a></li>
					</ul>
				</div>
				<!--
				problem :
				1. href of 活動報名(events/signup.php or events.php) ?
				-->
			</div>
		</nav>
		<div class="container event-wrapper">
			<div class="signup-form">
<!--
	
-->
		<?php

			$event_id = $_GET['id'];
			$_SESSION['event_id'] = $event_id;
			
			
			$dsn = "mysql:host=$db_server;dbname=$db_name";
			$db = new PDO($dsn, $db_user, $db_passwd);
			$sql="SELECT * FROM `$db_name`.`event` WHERE event_id=$event_id";
			$result = $db->prepare($sql);
			$result->execute();

			
			    /*if(empty($_GET['id'])){
			        $event_id ='1';
			    }
			    else{
			        $event_id =$_GET['id'];
				}
				$event_id =$_GET['id'];
			    $_SESSION['event_id'] = $event_id;
			    $dsn = "mysql:host=$db_server;dbname=$db_name";
				$db = new PDO($dsn, $db_user, $db_passwd);
				$sql="SELECT * FROM `$db_name`.`event` WHERE event_id=$event_id";
			    $result=$db->prepare($sql);
			    $result->bindValue(':id', $event_id, PDO::PARAM_INT);
			    $result->execute();
*/
			    //$result=$stmt->fetch();
    
			//更新資料庫資料語法
			//newlt add---
			$sql_6 = "SELECT * FROM `$db_name`.`team` WHERE `team`.event_id = '$event_id' and `team`.success = true and cancel = false";        
			$result_6 = $db->prepare($sql_6);
			$result_6->execute();
			$count_6 = $result_6->rowCount();
			$sql_5 = "UPDATE `$db_name`.`event` SET signup_team_num = $count_6 WHERE `event_id`='$event_id'";
			$result_5 = $db->prepare($sql_5);
			$result_5->execute();
			//----------
			//echo "string";
			$sql_7 = "SELECT * FROM `$db_name`.`team` join `$db_name`.`event` on `$db_name`.`team`.event_id = `$db_name`.`event`.event_id where `event`.event_id = '$event_id' and `team`.success = true and `team`.cancel = false";
			$result_7 = $db->prepare($sql_7);
			$result_7->execute();
			$count_7 = $result_7->rowCount();

			if($row = $result->fetchObject()){?>
			<h3 class="text-center">活動報名：<?php echo $row->event_name?></h3>
			<div class="description">
				<p>每隊最多人數限制：<?php echo $row->event_max_team_members;?></p>
				<p>每隊最少人數限制：<?php echo $row->event_min_team_members;?></p>
				<p>隊伍上限：<?php echo $row->team_limit;?></p>
				<p>已報名隊伍：<?php echo $count_7;?>隊</p> 
				<?php $temp = ($row->team_limit-$count_7)?>  <!--做一個減法 -->
				<p class="warning">尚可報名：<?php echo $temp?>隊</p> 
			</div>
			<?php
			}
			//如果還可以新增隊伍
			if($temp >0){
				//echo 'team_name_exist:	';
				//echo $_SESSION['team_name_exist'];
					
				//還沒有隊伍名稱
				if($_SESSION['team_name_exist'] == 'false'){ ?>
					<div class="button_link"><a href="http://localhost/signup/signup_team_add.php?id=<?php echo $event_id; ?>">新增隊伍名稱</a></div>
		<?php  	} 
				//有隊伍名稱了
				if($_SESSION['team_name_exist'] == 'true'){
					//印隊伍名稱
					$team_id = $_SESSION['team_id'];
					$sql_1="SELECT * FROM `$db_name`.`team` WHERE team_id = '$team_id'";
					$result_1 = $db->prepare($sql_1);
					$result_1->execute();
					$row_1 = $result_1->fetchObject();
					?>
					<div class="description">
					<p>隊伍名稱 :<?php echo $row_1->team_name; ?> </p>
					</div>
					<div class="button_link"><a href="http://localhost/signup/signup_teamname_edit.php?id=<?php echo $_SESSION['team_id']; ?>">修改隊伍名稱</a></div>
			
					<?php
					//找event的基本資料
					$sql_2="SELECT * FROM `$db_name`.`event` WHERE event_id=$event_id";
					$result_2 = $db->prepare($sql_2);
					$result_2->execute();
					$row_2 = $result_2->fetchObject();
					
					//$_SESSION['member_num'] 好像沒存到.....



					if($row_2->event_max_team_members == $_SESSION['member_num']){ ?>
						<div class="description">
						<p>已報名人數 :<?php echo $_SESSION['member_num']; ?> 人數已達上限</p>
						</div>
					<?php
					}
					else{ ?>
						<div class="description">
						<p>已報名人數 :<?php echo $_SESSION['member_num'];?></p>
						</div>
						<?php
					}
					?>
					<br>
					<label class="text-center" for="team_name">隊伍人員</label>
					<table class="table text-center">
						<tr>
							<!--<th class="student-id">隊員學號</th>
							<th>姓名</th>
							<th></th>-->
							<th class="text-center">隊員學號</th>
							<th class="text-center">姓名</th>
							<th class="text-center">       </th>
							<th class="text-center">       </th>
							
						</tr>
			
					<?php 
//echo $team_id;
					$sql_3 = "SELECT * FROM `$db_name`.`register` join `$db_name`.`user` on `$db_name`.`register`.user_id = `$db_name`.`user`.account where `register`.team_id = '$team_id'";
					//$stmt = mysqli_prepare($link, $sql);
					//mysqli_stmt_execute($stmt);
					$result_3 = $db->prepare($sql_3);
					$result_3->execute();
					//mysqli_stmt_store_result($stmt);
					//$result->store_result();
					$count = $result_3->rowCount();
					//$count = mysqli_stmt_num_rows($stmt);
					//echo '<br> 本隊人數	';
					//echo $count;
					?>

					<tr>
						<!--<form action="signup_find_member.php" method="post">-->
					<?php
					//如果此隊有人=>印出來
					if ($count > 0) {		
						while($row_3 = $result_3->fetchObject()) {
					?>
						<tr class="table-row" id="row-">
						<br>
						<td class="student-id"> <?php echo $row_3->account; ?></td>
						<td> <?php echo $row_3->user_name; ?></td>
						
					
						<?php
						//echo '<br>account';
						//echo $row_3->account;
						//echo '<br>team_id';
						//echo $team_id;
						$sql_4 = "SELECT * FROM `$db_name`.`register` where `$db_name`.`register`.user_id = $row_3->account and `register`.team_id = '$team_id'";
						$result_4 = $db->prepare($sql_4);
						$result_4->execute();
						$row_4 = $result_4->fetchObject();
						//echo 'register_id';
						//echo $row_4->register_id;
						?>
						<td>
						
						<a href="http://localhost/signup/signup_member_edit.php?id=<?php echo $row_4->register_id ?>"><button class="btn btn-default btn-new">修改</button></a>
						&nbsp;&nbsp;
						<a href="http://localhost/signup/signup_member_delete.php?id=<?php echo $row_4->register_id ?>"><button class="btn btn-default btn-remove">移除</button></a>
						</td><!--
						<td class="text-right">
						<div class="col-md-3 col-md-offset-3">
						<input class="btn btn-default btn-new" type="button" value="修改" onclick="location.href='http://localhost/signup/signup_member_edit.php?id=<?php echo $row_4->register_id ?>'">
						<input class="btn btn-default btn-remove" type="button" value="刪除" onclick="location.href='http://localhost/signup/signup_member_delete.php?id=<?php echo $row_4->register_id ?>'">-->
						</div>
						</td>
						</tr>

					<?php
						}
					}
					else{
						echo '尚無成員<br>';
					}
					?>

					<?php 
					// 如果人數額滿 則無法新增隊員
					$sql="SELECT * FROM `$db_name`.`event` WHERE event_id=$event_id";
					$people_rs = $db->prepare($sql);
					$people_rs->execute();
					//更新資料庫資料語法
					
					$row = $people_rs->fetchObject();
					
					if($row->event_max_team_members == $_SESSION['member_num']){ 
					?>
						<div class="description">
						<p>本隊已額滿</p>
						</div>
					<?php
					}
					else{ ?>
						<div class="button_link"><a href="signup/signup_member_add.php?id=<?php echo $_SESSION['team_id']; ?>">新增隊員</a></div>
						<?php
					}
					?>
					</table>
						<div class="text-left form-bottom">
						<a href="http://localhost/signup/signup_finish.php"><button class="btn btn-default btn-event">提交報名表</button></a>
						<!--<button class="btn btn-default">提交報名表</button>-->
						</div>
			<?php  	} //new add?> 
					
					<!--</form>-->
					
				</tr>

				</table>

				<!--<td class="table-row" colspan="2">-->

		<?php
			}
			else{
				echo "報名隊伍已額滿";
			}
		//}
		?>			
	
			</div>
		</div>
	</body>
</html>
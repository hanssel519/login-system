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

<?php

$event_id = $_SESSION['event_id'];
$team_id = $_SESSION['team_id'];

//echo 'event_id:';
//echo $event_id;

$dsn = "mysql:host=$db_server;dbname=$db_name";
$db = new PDO($dsn, $db_user, $db_passwd);

$sql = "SELECT * FROM `$db_name`.`event` WHERE  `event_id`= '$event_id'";
$result = $db->prepare($sql);
$result->execute();
$row = $result->fetchObject();
//echo '<br>member_num:';
//echo $_SESSION['member_num'];
//echo '<br>event_max_team_member:';

//echo $row->event_max_team_members;
if($row->event_min_team_members > $_SESSION['member_num']){
    echo "<script>alert('隊伍人數太少')</script>";
    echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
}
elseif($row->event_max_team_members < $_SESSION['member_num']){
    echo "<script>alert('隊伍人數太多')</script>";
    echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
}
else{
    //確定使用者有按下提交報表
    $sql_1 = "UPDATE `$db_name`.`team` SET success = true WHERE `team_id`='$team_id'";
    $result_1 = $db->prepare($sql_1);
    /*if($result_1->execute()){
        echo '<br>啊啊新增成功111111111';
        echo "<script>alert('報名活動成功')</script>";
    }*/
    $count = $row->signup_team_num;
    //echo'<br>報名隊伍數： ';
    //echo $count;
    $count++;
    //echo'<br>已報名隊伍數： ';
    //echo $count;
    //echo 'event_id';
    //echo $event_id;

    $sql_3 = "UPDATE `$db_name`.`event` SET signup_team_num = '$count' WHERE `event_id`='$event_id'";
    $result_3 = $db->prepare($sql_3);
    if($result_3->execute() && $result_1->execute()){
        echo "<script>alert('報名活動成功')</script>";
    }
    /*$sql = "SELECT * FROM `$db_name`.`event` WHERE  `event_id`= '$event_id'";
    $result = $db->prepare($sql);
    $result->execute();
    $row = $result->fetchObject();
    $row->signup_team_num++;*/
    ///$row->signup_team_num++ 不動





$sql_4 = "SELECT * FROM `$db_name`.`register` WHERE  `team_id`= '$team_id'";
$result_4 = $db->prepare($sql_4);
$result_4->execute();
$sql_6 = "SELECT * FROM `$db_name`.`team` WHERE  `team_id`= '$team_id'";
$result_6 = $db->prepare($sql_6);
$result_6->execute();
$row_6 = $result_6->fetchObject();
//echo "<br>~~~~~";
while($row_4 = $result_4->fetchObject()){

  //  echo $row_4->user_id;
    $sql_5 = "SELECT * FROM `$db_name`.`user` WHERE  `account`= '$row_4->user_id'";
    $result_5 = $db->prepare($sql_5);
    $result_5->execute();
    $row_5 = $result_5->fetchObject();
   // echo "<br>~~~~~~~";
    //echo $eventname;
    $mailto = $row_5->mail;

    
    $mailfrom = "winnie8751923@gmail.com";
    $subject = "You have been signup !!!";
    $txt = "You have received an email from NCTU Sports.

    You are signed up for event : $row->event_name.
    team name : $row_6->team_name";
    $headers = "from : ".$mailfrom;
    mail($mailto, $subject, $txt, $headers);
   // echo "send email~~~";
}

  //  echo '<br>event_name: ';
   // echo $row->event_name;

   // $row->signup_team_num++;
    //echo '<br>signup_team_num: ';
    //echo $row->signup_team_num;
    //echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/events/event_admin.php>';
    
    $user_id = $_SESSION['account'];
    //echo '<br>user_id: ';
   // echo $user_id;



    //好像有錯  -- 管理員會回到一般使用者誒...

    $sql_2 = "SELECT * FROM `$db_name`.`user` WHERE  `account`= '$user_id'";
    $result_2 = $db->prepare($sql_2);
    $result_2->execute();

    $count2 = $result_2->rowCount();
    $row_2 = $result_2->fetchObject();
   // echo '<br>count: ';
    //echo $count2;
    //echo '<br>id: ';
    echo $row_2->account;
    

    unset($_SESSION['event_id']);
    unset($_SESSION['team_id']);
    unset($_SESSION['team_name_exist']);
    unset($_SESSION['member_num']);
   // $sql->close();
    //$conn->close();

    //echo 'identity';
  //  echo '<br>使用者身份： ';
    echo $row_2->identity; 
    
    if($row_2->identity == 'admi'){ /// 要判對是什麼身份回什麼地方
        //echo '   ad';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/event_admin.php>';
    }
    else{
       // echo '  nor';
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events.php>';  
    }  
}

?>
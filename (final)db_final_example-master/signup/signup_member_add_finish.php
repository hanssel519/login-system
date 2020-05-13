<?php 
session_id(SID);
//启动session
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
$conn =mysqli_connect($db_server, $db_user, $db_passwd,$db_name );
if(!$conn){
        die("無法對資料庫連線". mysqli_connect_error());
}
?>

<?php
	$dsn = "mysql:host=$db_server;dbname=$db_name";
    $db = new PDO($dsn, $db_user, $db_passwd);
    $event_id = $_SESSION['event_id'];
    $user_id = $_POST['user_id'];
    $team_id = $_SESSION['team_id'];
    /*echo '<br>event_id';
    echo $event_id;
    echo '<br>user_id  ';
    echo $user_id;
    echo '<br>team_id';
    echo $team_id;*/
    //require_once("database.php");
    $sql = "SELECT * FROM `$db_name`.`user` WHERE  `account`= '$user_id'";
    $result = $db->prepare($sql);
    $result->execute();
    $count = $result->rowCount();
    
    //檢查有無重複新增的隊員 有 -> err = 1
    $err = 0;
    $sql_1 = "SELECT * FROM `$db_name`.`register` WHERE  `team_id`= '$team_id'";
    $result_1 = $db->prepare($sql_1);
    $result_1->execute();
    
    while($row_1 = $result_1->fetchObject()){
        if($row_1->user_id == $user_id){
            $err = 1;
        }
    }
    
    $event_id = $_SESSION['event_id'];
//先找user_id對應register 而且 沒有倍刪除
$sql_3 = "SELECT * FROM `$db_name`.`register` WHERE  `user_id`= '$user_id' and `cancel` = 'false'";
$result_3 = $db->prepare($sql_3);
$result_3->execute();
while($row_3 = $result_3->fetchObject()){
    //在team找register對應team_id 且隊伍沒被刪除
    $sql_4 = "SELECT * FROM `$db_name`.`team` WHERE  `team_id`= '$row_3->team_id' and `cancel` = 'false' and success = true";
    $result_4 = $db->prepare($sql_4);
    $result_4->execute();
    //在找team_id對應event_id 
    while($row_4 = $result_4->fetchObject()){
        //在找register對應team_id
        $sql_5 = "SELECT * FROM `$db_name`.`event` WHERE  `event_id`= '$row_4->event_id' and `event_id` = $event_id";
        $result_5 = $db->prepare($sql_5);
        $result_5->execute();
        $count_5 = $result_5->rowCount();
    }
}





   /* echo '<br>err  ';
    echo $err;
    echo '<br>count  ';
    echo $count;*/
   
    if($count == 0){
        echo "<script>alert('查無此人 新增隊員稱失敗')</script>";
        $error_message = "Problem in Adding New Record";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
    
    }
    elseif($err == 1){
        echo "<script>alert('重複新增此人 新增隊員稱失敗')</script>";
        $error_message = "Problem in Adding New Record";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
    }
    elseif($count_5 > 0){
        echo "<script>alert('此人已報名此活動 新增隊員稱失敗')</script>";
        $error_message = "Problem in Adding New Record";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
    }

    //有這個人 有inser到 沒有重複新增人
    elseif($count > 0 && $err==0){
        $sql_2 = "INSERT INTO `$db_name`.`register` ( `user_id`, `team_id`) VALUES ('$user_id', '$team_id')";
        if(mysqli_query($conn, $sql_2)){
            $_SESSION['member_num']++;
            //echo '<br>member_num: ';
            //echo $_SESSION['member_num'];
            $success_message = "Added Successfully";
            echo "<script>alert('新增隊員稱成功')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';    
        }      
    } 
    //不明原因新增失敗
    else {
        //echo 'ss';
        echo "<script>alert('新增隊員稱失敗')</script>";
        $error_message = "Problem in Adding New Record";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/signup.php?id=' . $event_id . '>';
    }
    //$sql = $conn->prepare("INSERT INTO register (user_id,team_id) VALUES (?, ?)");  
    //$sql->close();   
    //$conn->close();
	 
?>
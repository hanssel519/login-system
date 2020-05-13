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
$conn =mysqli_connect($db_server, $db_user, $db_passwd,$db_name );
if(!$conn){
        die("無法對資料庫連線". mysqli_connect_error());
}

$conn =mysqli_connect($db_server, $db_user, $db_passwd,$db_name );
if(!$conn){
        die("無法對資料庫連線". mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
//if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
    //$conn =mysqli_connect($db_server, $db_user, $db_passwd,$db_name );
    $event_id = $_SESSION['event_id'];

    //有問題
    //echo "=";
    //echo $_GET['id'];
    $event_name = addslashes($_POST['event_name']);
    $event_date = addslashes($_POST['event_date']);
    $event_rule = addslashes($_POST['event_rule']);
    $team_limit = addslashes($_POST['event_team_limit']);  
    $event_max_team_members = addslashes($_POST['event_max_team_members']);
    $event_min_team_members = addslashes($_POST['event_min_team_members']);
    $dsn = "mysql:host=$db_server;dbname=$db_name";
    $db = new PDO($dsn, $db_user, $db_passwd);
    //$sql="SELECT * FROM `$db_name`.`event`";
   // echo "+";
    /*echo $event_id;
    echo '<br>event_name';
    echo $event_name;echo '<br>event_date';
    echo $event_date;echo '<br>event_max_team_members';
    echo $event_max_team_members;echo '<br>event_min_team_members';
    echo $event_min_team_members;echo '<br>event_rule';
    echo $event_rule;echo '<br>team_limit';
    echo $team_limit;echo '<br>';*/

    $sql="SELECT * FROM `$db_name`.`event` where `event`.event_name = '$event_name' and `event`.event_id != '$event_id' and `event`.cancel = false and success = true";
    $result = $db->prepare($sql);
    $result->execute();
    $row = $result->fetchObject();
    //echo $row->event_name;
    $count = $result->rowCount();
    
    if($event_name == NULL  ){
        echo "<script>alert('活動名稱不得為空')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ($count > 0) {
        echo "<script>alert('活動已被註冊')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ($event_date == NULL  || strstr($event_date, ' ')) {
        echo "<script>alert('活動日期不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ($event_max_team_members < $event_min_team_members) {
        echo "<script>alert('人數最多限制 < 人數最少限制')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ($team_limit == NULL  || strstr($team_limit, ' ')) {
        echo "<script>alert('隊伍數限制不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ($event_max_team_members == NULL  || strstr($event_max_team_members, ' ')) {
        echo "<script>alert('人數最多限制不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ($event_min_team_members == NULL  || strstr($event_min_team_members, ' ')) {
        echo "<script>alert('人數最少限制不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ((is_int($team_limit))) {
        echo "<script>alert('隊伍數限制須為數字')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ((is_int($event_max_team_members))) {
        echo "<script>alert('人數最多限制須為數字')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif ((is_int($event_min_team_members))) {
        echo "<script>alert('人數最少限制須為數字')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    elseif($event_rule == NULL ){
        echo "<script>alert('活動規則不得為空')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
    }
    else{
        $sql_1 = "UPDATE `$db_name`.`event` SET event_name= '$event_name',event_date= '$event_date',team_limit= '$team_limit',event_max_team_members= '$event_max_team_members', event_min_team_members= '$event_min_team_members',event_rule= '$event_rule' where event_id = '$event_id'";
            //echo "sql success";
        //$sql = "update `$db_name`.`event` set cancel = true where event_id = $event_id";
            
        
    /* $sql = "UPDATE event SET `event_name`= `$event_name`,`event_date`= `$event_date`,`team_limit`= `$team_limit`,`event_max_team_members`= `$event_max_team_members`, `event_min_team_members`= `$event_min_team_members`,`event_rule`= `$event_rule` where $event_id=event_id";
        if(mysql_query($sql)){
                echo '升級會員成功!';
                echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/event_admin.php>';
        }*/
        //$people_rs = $db->prepare($sql);
        
        
        //$sql = "UPDATE  SET event_name ='aevent_name', event_date ='event_date', event_teamlimit = 'event_teamlimit', event_memberlimit = 'event_memberlimit' WHERE id=$id";
        //if($people_rs->execute()){
        if(mysqli_query($conn, $sql_1)){ 
            echo "<script>alert('修改成功!')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/event_admin.php>';
        }
        
        else{
            echo "<script>alert('修改活動失敗')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/edit.php?id=' . $event_id . '>';
            
        }
    }
//}
?>
</body>
</html>
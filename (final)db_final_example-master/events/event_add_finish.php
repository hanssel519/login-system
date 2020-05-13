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
</head>
<body>
<?php
//if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
    //$event_id = $_GET['id'];
    //$event_name = $_POST['event_name'];
    $event_name = addslashes($_POST['event_name']);
    $event_date = addslashes($_POST['event_date']);
    $event_rule = addslashes($_POST['event_rule']);
    $team_limit = addslashes($_POST['event_team_limit']);  
    $event_max_team_members = addslashes($_POST['event_max_team_members']);
    $event_min_team_members = addslashes($_POST['event_min_team_members']);

    $dsn = "mysql:host=$db_server;dbname=$db_name";
    $db = new PDO($dsn, $db_user, $db_passwd);
    $sql="SELECT * FROM `$db_name`.`event` where event_name = '$event_name' and cancel != true";
    //echo '<br> event_name: ';
    //echo $event_name;
    $result = $db->prepare($sql);
    $result->execute();
    $row = $result->fetchObject();
    
   // echo $row->event_name;
    
    $count = $result->rowCount();
   // echo '<br>活動名稱相同有幾個： ';
   // echo $count;
   // echo '<br>event_name: ';
   // echo $event_name;
    //$stmt = $dbConnection->prepare("select * from `$db_name`.`event` where event_name = ?");
    
    //$stmt->bind_param('s', $event_name);
    //$stmt->execute();
    //$result = $stmt->get_result();

  //補充 ： 活動日期為過去 日期不符格式 
    if($event_name == NULL  ){
        echo "<script>alert('活動名稱不得為空')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    //echo 'j1';
    //wrong

    elseif ($count > 0) {
        echo "<script>alert('活動已被註冊')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ($event_date == NULL  || strstr($event_date, ' ')) {
        echo "<script>alert('活動日期不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ($event_max_team_members < $event_min_team_members) {
        echo "<script>alert('人數最多限制 < 人數最少限制')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ($team_limit == NULL  || strstr($team_limit, ' ')) {
        echo "<script>alert('隊伍數限制不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ($event_max_team_members == NULL  || strstr($event_max_team_members, ' ')) {
        echo "<script>alert('人數最多限制不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ($event_min_team_members == NULL  || strstr($event_min_team_members, ' ')) {
        echo "<script>alert('人數最少限制不得為空或包含空格')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ((is_int($team_limit))) {
        echo "<script>alert('隊伍數限制須為數字')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ((is_int($event_max_team_members))) {
        echo "<script>alert('人數最多限制須為數字')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif ((is_int($event_min_team_members))) {
        echo "<script>alert('人數最少限制須為數字')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    elseif($event_rule == NULL ){
        echo "<script>alert('活動規則不得為空')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
    }
    else{
        //$sql="INSERT INTO `$db_name`.`event_table` (`event_id`, `event_name`, `event_date`, `team_limit`, `team_size_limit`, `is_delete`) VALUES (NULL, '$event_name', '$event_date', '$team_limit', '$team_size_limit', 'false')";
        $sql = "INSERT INTO `$db_name`.`event`(`event_name`, `event_date`, `team_limit`, `event_max_team_members`, `event_min_team_members`, `event_rule`) VALUES ('$event_name', '$event_date', '$team_limit' ,'$event_max_team_members', '$event_min_team_members', '$event_rule')";
        $result = $db->prepare($sql);
        
        //echo '<br>yoyo ';
        if($result->execute()){
            //echo ' 新增活動成功!';
            echo "<script>alert('新增活動成功!')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/event_admin.php>';    
            //回到event頁面
        }
        else{
            echo "<script>alert('新增活動失敗')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/add.php>';
            
        }
    }
    //mysql_close($conn);
//}
?>
</body>
</html>
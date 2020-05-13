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


?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php ///events/delete

//if($_SESSION['username'] != null && $_SESSION['Admin'] == true){
        $event_id = $_GET['id'];

        //echo 'event_id: ';
        //echo$event_id;

        $dsn = "mysql:host=$db_server;dbname=$db_name";
        $db = new PDO($dsn, $db_user, $db_passwd);
     
        //更新資料庫資料語法

        $sql = "update `$db_name`.`event` set `cancel` = true where `event_id` = '$event_id'";

        /*if(empty($_GET['id'])){
                $event_id ='1';
            }
            else{
                $event_id =$_GET['id'];
            }*/
            


        if(mysqli_query($conn,$sql)){//刪除event
                //echo "<script>alert('刪除活動成功!')</script>";
               // $sql = "SELECT * FROM register where event_id = $event_id";
                /*while($result = mysqli_query($dbConnection,$sql)){ //刪除register
                        $row = mysql_fetch_array($result, MYSQL_ASSOC);
                        $team_id = $row['team_id'];
                        $sql_1 = "UPDATE register SET cancel='true' WHERE team_id=$team_id";
                        $result_1 = mysqli_query($dbConnection,$sql_1);
                        //刪除register
                        $sql_2 = "UPDATE team SET cancel='true' WHERE team_id=$team_id";
                        $result_2 = mysqli_query($dbConnection,$sql_2);           
                }*/
                //echo '刪除活動成功!';
                echo "<script>alert('刪除活動成功!')</script>";
                echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/event_admin.php>';
        }
        else{
                //echo '刪除活動失敗!';
                echo "<script>alert('刪除活動失敗!')</script>";
                echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/event_admin.php>';      
        }
//}
/*
else{
        //echo '您無權限觀看此頁面!';
        echo "<script>alert('您無權限觀看此頁面!!')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/events/add.php>';
}
*/

?>

</body>
</html>
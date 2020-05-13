<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
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
//YWRtaW4=admin

$account=$_SESSION['account'];

//$anncs_id=$_GET['anncs_id'];
if(empty($_GET['anncs_id'])){
                $anncs_id ='1';
            }
            else{
                $anncs_id =$_GET['anncs_id'];
            }
        $dsn = "mysql:host=$db_server;dbname=$db_name";
        $db = new PDO($dsn, $db_user, $db_passwd);
        $sql="DELETE FROM `$db_name`.`anncs` where `anncs_id`='$anncs_id'";
        
        if(mysqli_query($conn, $sql))
        {
            echo "<script>alert('刪除成功!')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/admi_page.php>'; 
            
        }
         else{
            echo "<script>alert('刪除失敗!')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/anncs/admin.php?anncs_id='.$anncs_id.'>'; 
            
        }       


?>
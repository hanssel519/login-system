<?php 
session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php


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
$Captcha1 = $_POST['Captcha1'];
echo '$Captcha1' ;
//if(!isset($_SESSION))$SEC = "";
//else 
$SEC1 = $_SESSION['chkNum'];  

$account = $_SESSION['account'];
echo "noo!";
//如果驗證碼為空
if($Captcha1 == "")echo "<script type=\"text/javascript\">alert(\"驗證碼請勿空白\")</script>";
//如果驗證碼不是空白但輸入錯誤
else if($Captcha1 != $SEC1 && $Captcha1 !="")echo "<script type=\"text/javascript\">alert(\"驗證碼請錯誤，請重新輸入\")</script>";
else{//驗證碼輸入正確
    echo "<script type=\"text/javascript\">alert(\"驗證碼正確！\")</script>";
    $dsn = "mysql:host=$db_server;dbname=$db_name";
    $db = new PDO($dsn, $db_user, $db_passwd);
        
    $sql="UPDATE `$db_name`.`user` SET  `chk`=1 where `account`='$account'";
    
    if(mysqli_query($conn, $sql))
    {
            echo "<script>alert('請重新登入!')</script>";
            unset($_SESSION['account']);
            
        }
    echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/login.php>';
    //這邊可以做任何事情，像是寄信等等的東西
}
else{
	echo "nooooo!";
}
?>
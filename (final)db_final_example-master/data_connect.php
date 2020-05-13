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
if(!@mysqli_connect($db_server, $db_user, $db_passwd))
        die("無法對資料庫連線");
        
$account = addslashes($_POST['account']);
$pw = addslashes($_POST['pw']);
//$account = preg_replace('/\s+/','',$_POST['account']);
//$pw = preg_replace('/\s+/','',$_POST['pw']);

$dsn = "mysql:host=$db_server;dbname=$db_name";
$db = new PDO($dsn, $db_user, $db_passwd);
$hash=base64_encode($pw);
$sql="SELECT * FROM `$db_name`.`user` where `pw` = '$hash' AND `account` = '$account'";
//$result  = $db->query($sql);
$result  = $db->prepare($sql);
$result->execute();
$result = $result->fetchObject();

if($result!=NULL && $pw != null && $account != null && $result->account==$account && $result->pw==$hash &&$result->chk==1){
        
        $_SESSION['account'] = $account;
        $_SESSION['id'] = $result->id;
        echo "<script>alert('登入成功!')</script>";
        
        if($result->identity=='user')
                echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/user_page.php>';
        else
                echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/admi_page.php>';  
        }
else{
        echo "<script>alert('登入失敗!')</script>";
    	echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/login.php>'; 
 } 
?>
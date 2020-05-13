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

//$account=$_SESSION['account'];
$id = $_SESSION['id'];
$account = addslashes($_POST['account']);
$name = addslashes($_POST['name']);
$pw = addslashes($_POST['pw']);
$mail = addslashes($_POST['mail']);
//$id=$_GET['id'];
//$chk=NULL;
if($name!=null && $pw != null && $mail!=null){
    

        $dsn = "mysql:host=$db_server;dbname=$db_name";
        $db = new PDO($dsn, $db_user, $db_passwd);

        $isql="SELECT * FROM `$db_name`.`user` where `id`='$id'";
        $people_rs = $db->prepare($isql);
        $people_rs->execute();
        $person = $people_rs->fetchObject();
        //$id=$person->id;
        
        $sql="UPDATE `$db_name`.`user` SET  `account`='$aaccount', `user_name`='$name', `pw`='$pw', `mail`='$mail' where `id`='$id'";
        echo "yes";
        if(mysqli_query($conn, $sql))
        {
            echo "<script>alert('修改成功!')</script>";
            $_SESSION['account'] = $account;
            echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/info/admi.php>'; 
            
        }
         else{
            echo "<script>alert('修改zzz失敗!')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/info/admi.php>'; 
            
        }       
        

else
{
        echo "<script>alert('修改失敗!')</script>";
        echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/anncs/edit.php?anncs_id='.$anncs_id.'>';
        
}


?>
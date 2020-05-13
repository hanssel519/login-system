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

$account = addslashes($_POST['account']);
$user_name = addslashes($_POST['user_name']);
$pw = addslashes($_POST['pw']);
$pw2 = addslashes($_POST['pw2']);
$mail = addslashes($_POST['mail']);
$ques = addslashes($_POST['ques']);
$Captcha = $_POST['Captcha'];
$chk1=NULL;

if(!isset($_SESSION))$SEC = "";
else $SEC = $_SESSION['checkNum'];
//如果驗證碼為空
if($Captcha == ""){
    $chk1=1;
    echo "<script type=\"text/javascript\">alert(\"驗證碼請勿空白\")</script>";
    echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/register.php>';
}
//如果驗證碼不是空白但輸入錯誤
else if($Captcha != $SEC && $Captcha !=""){
    $chk1=1;
    echo "<script type=\"text/javascript\">alert(\"驗證碼請錯誤，請重新輸入\")</script>";
    echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/register.php>';
}
/*else{//驗證碼輸入正確    
    echo "<script type=\"text/javascript\">alert(\"驗證碼正確！\")</script>";    
    //這邊可以做任何事情，像是寄信等等的東西
}*/

if($chk1==NULL){

    $dsn = "mysql:host=$db_server;dbname=$db_name";
    $db = new PDO($dsn, $db_user, $db_passwd);
    $sql="SELECT * FROM `$db_name`.`user`";
    $people_rs = $db->prepare($sql);
    $people_rs->execute();
    $chk=NULL;
    /*
    if(empty($_GET['id'])){
        $id='1';
    }
    else{
        $id=$_GET['id'];
    }
    $conn= new PDO("mysql:host=$db_host;dbname=$db_name", $db_user);
    $stmt=$conn->prepare('SELECT * from demo where id=:id');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result=$stmt->fetch();
    
    */
    while($person = $people_rs->fetchObject()){
        if($person->account==$account){
            echo "<script>alert('你已經申請了')</script>";
            $chk=1;
            break;
        }
      } 
    if($account != null && $user_name!=null && $pw != null && $pw2 != null && $pw == $pw2&& $mail!=null && $ques!=null && $chk==NULL ){//&& !preg_match("/ /",$mail) && !preg_match("/ /",$account)
            mysqli_select_db($conn, '$db_name');
            //加密
            $hash=base64_encode($pw);
            $sql="INSERT INTO `$db_name`.`user` (`id`, `account`, `user_name`, `pw`, `mail`, `question`, `identity`) VALUES (NULL, '$account', '$user_name', '$hash', '$mail', '$ques', 'user')";
            //$sql="INSERT INTO `$db_name`.`member_table` (`id`, `account`, `pw`, `name`, `mail`, `identity`) VALUES (NULL, '$account', '$hash', '$theName', '$mail', 'admi')";
            if(strpos($mail,"@") && strpos($mail,".",strpos($mail,"@"))){
                if(mysqli_query($conn, $sql))
                {
                    echo "<script>alert('新增成功!')</script>";
                    $num="";           //驗證碼的數字
                     $num_max = 6;      //驗證碼數字的數量，目前設定6位數

                     for( $i=0; $i<$num_max; $i++ )//亂數產生數字
                     {
                         $num .= rand(0,9);
                     }

                     $_SESSION["chkNum"] = $num;
                     $_SESSION["account"] = $account; 

                    $mailto = $mail;
                    $mailfrom = "debby200822024@gmail.com";
                    $subject = "NCTU Sports Verification letter!!!";
                    $txt = "You have received an email from NCTU Sports.
                    Congratulations on successful registration!
                    The following is Verification code:
                    $num
                    You are registered : $account
                    user_name : $user_name";
                    $headers = "from : ".$mailfrom;
                    mail($mailto, $subject, $txt, $headers);

                    echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/mail.php>';
                }
                 else{
                    echo "<script>alert('新增失敗!')</script>";
                    echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/register.php>';
                }
            }
            else{
                echo "<script>alert('信箱格式錯誤！')</script>"; 
                echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/register.php>';           
            }
    }
    else
    {
            echo "<script>alert('新增失敗!')</script>";
            echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/register.php>';
    }
}

?>
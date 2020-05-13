<?php session_start(); ?>
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

$account = addslashes($_POST['account']);
$ques = addslashes($_POST['ques']);
$Captcha = $_POST['Captcha'];
$chk1=NULL;

if(!isset($_SESSION))$SEC = "";
else $SEC = $_SESSION['checkNum'];
//如果驗證碼為空
if($Captcha == ""){
    $chk1=1;
    echo "<script type=\"text/javascript\">alert(\"驗證碼請勿空白\")</script>";
    echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/forgetpassword.php>';
}
//如果驗證碼不是空白但輸入錯誤
else if($Captcha != $SEC && $Captcha !=""){
    $chk1=1;
    echo "<script type=\"text/javascript\">alert(\"驗證碼請錯誤，請重新輸入\")</script>";
    echo '<meta http-equiv=REFRESH CONTENT=2;url=http://localhost/forgetpassword.php>';
}


			if($chk1==NULL && $account!=NULL && $ques!=NULL){
			$dsn = "mysql:host=$db_server;dbname=$db_name";
			$db = new PDO($dsn, $db_user, $db_passwd);
            
			$sql="SELECT * FROM `$db_name`.`user` where `user`.account='$account'";
			$people_rs = $db->prepare($sql);
			$people_rs->execute();
			$person = $people_rs->fetchObject();
			if($person->account==NULL) {
				echo "<script>alert('你尚未申請！!')</script>";
    			echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/register.php>'; 
			}
			else if( $person->question!=$ques) {
				echo "<script>alert('你愛的人變了ＱＱ')</script>";
    			echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/forgetpassword.php>'; }
			else{
		
			$pw=base64_decode($person->pw);
			/*<h3 class="title">學號 ： <?php echo $person->account; ?></h3>
			<h3 class="title">密碼 ： <?php echo base64_decode($person->pw); ?></h3>*/
			$mailto = $person->mail;
            $mailfrom = "debby200822024@gmail.com";
            $subject = "NCTU Sports find your password!!!";
            $txt = "You have received an email from NCTU Sports.
                    
                    The following is your password:
                    $pw";
                    $headers = "from : ".$mailfrom;
                    mail($mailto, $subject, $txt, $headers);
            echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/login.php>';
			
			}
		}
		else{
			echo "<script>alert('請填滿填好')</script>";
    		echo '<meta http-equiv=REFRESH CONTENT=1;url=http://localhost/forgetpassword.php>';
			}
			 ?>

<?php 

session_start();

$Captcha = $_POST['Captcha'];
if(!isset($_SESSION))$SEC = "";
else $SEC = $_SESSION['checkNum'];  

//如果驗證碼為空
if($Captcha == "")echo "<script type=\"text/javascript\">alert(\"驗證碼請勿空白\")</script>";
//如果驗證碼不是空白但輸入錯誤
else if($Captcha != $SEC && $Captcha !="")echo "<script type=\"text/javascript\">alert(\"驗證碼請錯誤，請重新輸入\")</script>";
else{//驗證碼輸入正確
    echo "<script type=\"text/javascript\">alert(\"驗證碼正確！\")</script>";
    //這邊可以做任何事情，像是寄信等等的東西
}
?>
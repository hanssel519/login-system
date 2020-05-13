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
        //echo 'event_id: ';
      //  echo $event_id;

        $dsn = "mysql:host=$db_server;dbname=$db_name";
        $db = new PDO($dsn, $db_user, $db_passwd);
     
        //更新資料庫資料語法
         
        $user_id = $_SESSION['account'];
       // echo '<br>user_id: ';
       //echo $user_id;
        
        //先到team去找相等event_id的team_id
        $sql = "SELECT * FROM `$db_name`.`team` WHERE `team`.event_id = '$event_id' and `team`.success = true and `team`.cancel = false";
        $result = $db->prepare($sql);
        //$people_rs->bindValue(':id', $event_id, PDO::PARAM_INT);
        $result->execute();
        while($row = $result->fetchObject()){
                //到register 找相對應 team_id user_id的地方 並確認team_id
           // echo " pp";
                $sql_1 = "SELECT * FROM `$db_name`.`register` WHERE `register`.user_id = '$user_id' and `register`.team_id = '$row->team_id'";
                $result_1 = $db->prepare($sql_1);
                $result_1->execute();
                //到team把該team_id刪除
                if ($row_1 = $result_1->fetchObject()){

//echo $row_1->team_id;
                //$sql_2 = "DELETE FROM `$db_name`.`team` WHERE team_id = '$row_1->team_id'";
                    $sql_2 = "UPDATE `$db_name`.`team` SET cancel = true WHERE `team_id`='$row_1->team_id'";
                    $result_2 = $db->prepare($sql_2);
                                          
                    if($result_2->execute()){
                            
                            $sql_4 = "SELECT * FROM `$db_name`.`team` WHERE `team`.event_id = '$event_id'";        
                            $result_4 = $db->prepare($sql_4);
                            $result_4->execute();
                            $count_4 = $result_4->rowCount();
                           
                           
                            $sql_5 = "UPDATE `$db_name`.`event` SET signup_team_num = $count_4 WHERE `event_id`='$event_id'";
                            $result_5 = $db->prepare($sql_5);
                            $result_5->execute();

                            $sql_3 = "SELECT * FROM `$db_name`.`user` WHERE  `account`= '$user_id'";
                            $result_3 = $db->prepare($sql_3);
                            $result_3->execute();
                        
                            $row_3 = $result_3->fetchObject();
                            
                            //echo '<br>使用者身份： ';
                            //echo $row_3->identity; 
                            
                            if($row_3->identity == 'admi'){ /// 要判對是什麼身份回什麼地方
                                    //echo '   ad';
                                    echo "<script>alert('刪除已報名活動成功!')</script>";
                                    echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/event_admin.php>';
                            }
                            else{
                                //echo '  nor';
                                echo "<script>alert('刪除已報名活動成功!')</script>";
                                echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events.php>';  
                            }  

                    }
                    else{
                            //echo '刪除活動失敗!';
                            $sql_3 = "SELECT * FROM `$db_name`.`user` WHERE  `account`= '$user_id'";
                            $result_3 = $db->prepare($sql_3);
                            $result_3->execute();
                        
                            $row_3 = $result_3->fetchObject();
                            
                            //echo '<br>使用者身份： ';
                            //echo $row_3->identity; 
                            if($row_3->identity == 'admi'){ /// 要判對是什麼身份回什麼地方
                                   // echo '   ad';
                                    echo "<script>alert('刪除已報名活動失敗!')</script>";
                                    echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events/event_admin.php>';
                            }
                            else{
                                    //echo '  nor';
                                    echo "<script>alert('刪除已報名活動失敗!')</script>";
                                    echo '<meta http-equiv=REFRESH CONTENT=0;url=http://localhost/events.php>';   
                            }  
                           
                    }

                }
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
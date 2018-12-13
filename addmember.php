<?php
  require_once("dbtools.inc.php");
  //取得表單資料
  $account = $_POST["account"];
  $password = $_POST["password"]; 
  $name = $_POST["name"]; 
  $sex = $_POST["sex"];
  $year = $_POST["year"]; 
  $month = $_POST["month"]; 
  $day = $_POST["day"];
  $telephone = $_POST["telephone"]; 
  $cellphone = $_POST["cellphone"]; 	
  $address = $_POST["address"];
  $email = $_POST["email"]; 	
  $comment = $_POST["comment"];
  $position = $_POST["position"];
  $take_office_date = $_POST["take_office_date"];
  $leave_office_date = $_POST["leave_office_date"];     
  $open_account = $_POST["open_account"];   
  //建立資料連接
  $link = create_connection();
			
  //檢查帳號是否有人申請
  $sql = "SELECT * FROM users Where account = '$account'";
  $result = execute_sql($link, "member", $sql);

  //如果帳號已經有人使用
  if (mysqli_num_rows($result) != 0)
  {
    //釋放 $result 佔用的記憶體
    mysqli_free_result($result);
		
    //顯示訊息要求使用者更換帳號名稱
    echo "<script type='text/javascript'>";
    echo "alert('您所指定的帳號已經有人使用，請使用其它帳號');";
    echo "history.back();";
    echo "</script>";
  }
	
  //如果帳號沒人使用
  else
  {
    //釋放 $result 佔用的記憶體	
    mysqli_free_result($result);
		
    //執行 SQL 命令，新增此帳號
    $sql = "INSERT INTO 
    users 
    (account, password, name, sex,year, month, day, telephone, cellphone, address,email,comment,position,take_office_date,leave_office_date,open_account) 
 VALUES 
    ('$account','$password','$name','$sex', $year, $month, $day,'$telephone','$cellphone','$address','$email','$comment','$position','$take_office_date','$leave_office_date','$open_account')";

    $result = execute_sql($link, "member", $sql);
    echo"<script>alert('新增帳號成功');history.go(-1);</script>"; 
  }
	
  //關閉資料連接	
  mysqli_close($link);
  
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>新增帳號成功</title>
  </head>
</html>
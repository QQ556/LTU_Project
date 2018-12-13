<?php
  //檢查 cookie 中的 passed 變數是否等於 TRUE
  $passed = $_COOKIE["passed"];
	
  /* 如果 cookie 中的 passed 變數不等於 TRUE，
     表示尚未登入網站，將使用者導向首頁 index.html */
  if ($passed != "TRUE")
  {
    header("location:index.html");
    exit();
  }
	
  /* 如果 cookie 中的 passed 變數等於 TRUE，
     表示已經登入網站，則取得使用者資料 */
  else
  {
    require_once("dbtools.inc.php");
	
    //取得 modify.php 網頁的表單資料
    $id = $_COOKIE["id"];
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
    $open_account = $_POST["open_account"];
    $take_office_date = $_POST["take_office_date"];
    $leave_office_date = $_POST["leave_office_date"];
		$open_account = $_POST["open_account"];   
    //建立資料連接
    $link = create_connection();
				
    //執行 UPDATE 陳述式來更新使用者資料
    $sql = "UPDATE users SET 
            password = '$password',
            name = '$name', 
            sex = '$sex',
            year = $year,
            month = $month,
            day = $day, 
            telephone = '$telephone', 
            cellphone = '$cellphone', 
            address = '$address', 
            email = '$email',
            comment = '$comment',
            position = '$position',
            take_office_date = '$take_office_date',
            leave_office_date = '$leave_office_date',
            open_account ='$open_account'
            WHERE id = $id";
    $result = execute_sql($link, "member", $sql);
		
    //關閉資料連接
    mysqli_close($link);
  }		
  echo"<script>alert('新增修改成功');history.go(-1);</script>"; 
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>帳號修改成功</title>
  </head>
</html>
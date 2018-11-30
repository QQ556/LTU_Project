<?php
  //檢查 cookie 中的 passed 變數是否等於 TRUE 
  $passed = $_COOKIE{"passed"};
  
  //如果 cookie 中的 passed 變數不等於 TRUE
  //表示尚未登入網站，將使用者導向首頁 index.html
  if ($passed != "TRUE")
  {
    header("location:index.html");
    exit();
  }
  
  //如果 cookie 中的 passed 變數等於 TRUE
  //表示已經登入網站，取得使用者資料  
  else
  {
    require_once("dbtools.inc.php");
    
    $id = $_COOKIE{"id"};
  }
    //建立資料連接
    $link = create_connection();
        
    //執行 SELECT 陳述式取得使用者資料
    $sql = "SELECT * FROM users Where id = $id";
    $result = execute_sql($link, "member", $sql);
    $row = mysqli_fetch_assoc($result);
    
    //開啟第二組 punch card資料庫
    $sql_2 = "SELECT * FROM punch card";
    $result_2 = execute_sql($link, "member", $sql_2);
    //取得當下時間
    $date = new DateTime();
    $clock_in = "";
    $clock_out = $date->format('Y-m-d H:i:s');
    if (!empty($_SERVER["HTTP_CLIENT_IP"])){
    $ip = $_SERVER["HTTP_CLIENT_IP"];
}elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
}else{
    $ip = $_SERVER["REMOTE_ADDR"];
}

    //釋放 $result 佔用的記憶體 
    mysqli_free_result($result);
    
    //SQL語法 用INSERT INTO "資料表名稱(參數)" VALUES(值)
    //keypoint: 若欄位為varchar帶入的值必須加引號
    $sql ="INSERT INTO `punch card`(`id`,`clock_in`,`clock_out`,`Remarks`) VALUES ('$id',NULL,'$clock_out','$ip')";

    //執行SQL, 寫入
    $result = execute_sql($link, "member", $sql);

    

    //關閉資料庫
    mysqli_close($link);

?>
<?php
  // echo '<br>'; 
  // echo "系統時間  -  ".$date->format('Y-m-d H:i:s');
  // echo '<br>'; 
  // echo "目前使用者  -  ".$row{"name"};
  // echo '<br>'; 
  // echo "目前使用編號  -  ".$row{"id"};
  // echo '<br>'; 
  // echo "目前使用id  -  ".$id;
  // echo '<br>'; 
  // echo "目前使用clock_in  -  ".$clock_in;
  // echo '<br>'; 
  // echo "目前使用clock_out  -  ".$clock_out;
  // echo '<br>'; 
  // echo "目前使用sql  -  ".$sql;
  //echo "<script>alert('已完成打卡');location.href='main.php';</script>";
  echo "<script>location.href='main.php';</script>";
?>
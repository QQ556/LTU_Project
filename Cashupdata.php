
<?php 
// 開始 session 
session_start(); 



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
  	$id = $_COOKIE["id"];
  }	
    //取得 modify.php 網頁的表單資料
  $select_sex = $_GET['select_sex'];
  $select_old = $_GET['select_old'];
  $tab_num = $_GET['tab_num'];
  $total = $_GET['total'];

  
    //建立資料連接
  $link = create_connection();
  	//找最大訂單編號
  $sql = "SELECT MAX(`order_id`) FROM `orders` WHERE 1";
  $order_id = execute_sql($link, "member", $sql);
  $order_id_rs=mysqli_fetch_row($order_id);
  //抓最大訂單號 在加一
  $order_id_rs[0] +=1;
  $date = new DateTime();
  $date2 = $date->format('Y-m-d H:i:s');  
  echo $order_id_rs[0];

  // echo $date2;
    // 用迴圈走訪 session 陣列 
  foreach($_SESSION['num'] as $key=>$value) 
  { 
  	if($value == ''){
  		continue;
  	}
  	//陣列從0開始 所以要加1
  	$key +=1;

  	$sql = "SELECT * FROM `product_list` WHERE `meal_no` = $key "; //比對中文名稱
    $result = execute_sql($link, "member", $sql);
	$rs_meal_name=mysqli_fetch_row($result);
	echo $rs_meal_name[2];
  	
  	


  	$sql = "INSERT INTO orders 
  	(order_id, meal, quantity,tab_num, `date`,total_price, select_old,select_sex,pay,meals_name) 
  	VALUES 
  	('$order_id_rs[0]','$key','$value','$tab_num','$date2', $total, '$select_old','$select_sex','1','$rs_meal_name[2]')";
  	 // 執行 UPDATE 陳述式來更新使用者資料
  // $sql = "UPDATE `orders` SET 
  // `order_id` = '$order_id_rs[0]',
  // `meal` = '$key', 
  // `quantity` = '$value',
  // `tab_num` = $tab_num,
  // `date` = $date2,
  // `total_price` = $total, 
  // `select_old` = '$select_old' 
  // ";


  	echo $sql;
  	$result = execute_sql($link, "member", $sql);

  } 



    //關閉資料連接
  mysqli_close($link);

   echo"<script>alert('點餐成功');window.location = 'main.php';</script>"; 
  ?>
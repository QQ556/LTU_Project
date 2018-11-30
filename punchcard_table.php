<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>

<style type="text/css">
@import url(css.css);
tr:nth-child(even) {
    background: #CCC
}
tr:nth-child(odd) {
    background-color: #FAFAFA;
}
td:hover {
    background-color: #E6FBFF;
}
tr, td {
    border: 0px solid #666;
}
.post input[type=search]{
    padding: 10px;
    background: #fafafa;
    border: 1px solid #ddd;
    border-radius: 20px;
    font-size: 1rem;
    color: #111;
}
.post input[type=date]{
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 20px;
    font-size: 1rem;
    color: #111;
}
.post{
    padding: 5px;
    background: #cccccc;
    border: 1px solid #ddd;
    border-radius: 2px;
    font-size: 1rem;
    color: #111;
}
.body {
    margin: 0;
    padding: 0;
}
</style>
<script type="text/javascript">

</script>
<?php
  date_default_timezone_set('Etc/GMT-8');//使用台灣地區時間
  function getToday(){
  $today = getdate();
  date("Y/m/d H:i");  //日期格式化
  $year=$today["year"]; //年 
  $month=$today["mon"]; //月
  $day=$today["mday"];  //日
 
  if(strlen($month)=='1')$month='0'.$month;
  if(strlen($day)=='1')$day='0'.$day;
  $today="'".$year."-".$month."-".$day."%'";
  return $today;


}
  $passed=$_COOKIE["passed"];
  /*  如果 cookie 中的 passed 變數不等於 TRUE
      表示尚未登入網站，將使用者導向首頁 index.html  */
  if ($passed != "TRUE")
  {
    header("location:index.html");
    exit();
  }
  else
  {
    require_once("dbtools.inc.php");
    $id = $_COOKIE{"id"}; 
    }
    
    if(@$_GET['search']!=''){
    $search=$_GET['search'];
    $sql = "select `clock_in` 上班, `clock_out` 下班 FROM `punch card` WHERE `id`=".$id." "."AND (`clock_in` like '$search%' OR `clock_out` like '$search%')";
    }else{
    $sql = "select `clock_in` 上班, `clock_out` 下班 FROM `punch card` WHERE `id`=".$id." "."AND (`clock_in` like ".getToday()." OR `clock_out` like ".getToday().')';  
    }
    echo "測試用".$sql;  
    $link =  create_connection();   
    $result = execute_sql($link, "member", $sql);
    $total_fields=mysqli_num_fields($result); // 取得欄位數
    $total_records=mysqli_num_rows($result);  // 取得記錄數
    ?>


<!doctype html>
<html>
  <head>
    <title>會員管理</title>
    <meta charset="utf-8">
    <?php 
    header("Cache-control: private");
    ?>
  </head>
    <div id="Base_Visitor">
      <div class="Head">
        <a class="Logo" ></a>
      </div>
      <div class="Body">
           <div class="post">
              <form id="form1" name="form1" method="GET" action="">
               <font size="6">時間選擇：</font>
               <input id="search" name="search" type="date" value="<?php echo($search) ?>" placeholder="請輸入關鍵字">
               <button onclick="search() class="button">搜尋</button>
               </form>
          </div>
          <body>   
          <table width="40%" border="1" class="order-table" align="center">
          <br>
              <thead>
                <tr>
                  <td width="20%">上班</td>
                  <td width="20%">下班</td>
                </tr>
              </thead>
                <?php
                for($i=1;$i<=mysqli_num_rows($result);$i++){
                $rs=mysqli_fetch_row($result);
                ?>
                  <tr>
                    <td><?php echo $rs[0]?></td>
                    <td><?php echo $rs[1]?></td>
                  </tr>
                <?php
                }
                ?>
          </table>
          <input align="right" type="button" onclick="location.href='main.php'" value="回到上一頁" class="button" style="float: right;margin: 10px">
      </div>
      </div>
    </body>
</html>
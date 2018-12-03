<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous">
//時間間格換算
// public function get_time($from,$to){
//     if($to > $from){
//         $miao = $to - $from;
//     }else{
//         $miao = $from - $to;
//     }
//     $hour = floor($miao/3600);
//     $minute = floor(($miao-$hour*3600)/60);
//     $second = $miao - $hour * 3600 - $minute * 60 ;
//     $str = '';
//     if($hour > 0){
//         $str .= $hour.'時';
//     }
//     if($minute > 0){
//         $str .= $minute.'分';
//     }
//     if($second){
//         $str .= $second.'秒';
//     }
//     return $str;
// }
</script>
<style type="text/css">
@import url(css.css);
tr:nth-child(even) {
    background: #CCC
}
tr:nth-child(odd) {
    background-color: #FAFAFA;
}
tr, td {
    border: 0px solid #666;
}
.post input{
    padding: 10px;
    background: #fafafa;
    border: 1px solid #ddd;
    border-radius: 20px;
    font-size: 1rem;
    color: #111;
}

#DIV1{
width:562px;
padding:20px;
border:2px black solid;
float:left;
margin-right:10px;

}
#DIV2{
width:500px;
padding:20px;
border:2px black solid;
float:left;

}
</style>


<?php
  //使用台灣地區時間
  date_default_timezone_set('Etc/GMT-8');
  //抓今天日期
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
    $link =  create_connection(); 
    //取用戶資料
    $sql_user = "SELECT * FROM `users` WHERE `id`=1";
    $result_user = execute_sql($link, "member", $sql_user); 
    $rs_user = mysqli_fetch_row($result_user);
    //月打卡
    if(@$_GET['search_id']!='' or @$_GET['search_name']!='' or @$_GET['search_data']!='' or @$_GET['radio_sex']!='' or @$_GET['select_month']!='' or @$_GET['select_year']!=''){
    //有填值的選項資料
    @$search_id=$_GET['search_id'];
    @$search_name=$_GET['search_name'];
    @$search_data=$_GET['search_data'];
    @$radio_sex=$_GET['radio_sex'];
    @$select_month=$_GET['select_month'];
    @$select_year=$_GET['select_year'];
    //有填值的SQL

    // @$sql = "select `clock_in` 上班, `clock_out` 下班 FROM `punch card` WHERE `id`=".$search_id." "."AND (`clock_in` like '$search%' OR `clock_out` like '$search%')";
    

    }else{
    //未填值的選項資料
    @$search_id=$_GET['search_id'];
    @$search_name=$_GET['search_name'];
    @$search_data=$_GET['search_data'];
    @$radio_sex=$_GET['radio_sex'];
    @$select_month=$_GET['select_month'];
    //未填值的SQL

    //打卡最早
    $sql_last = "select MIN(`clock_in`)AS last from `punch card` where `clock_in` like ".getToday()." AND `id`=".$id;//首次打卡
    //打卡最晚
    $sql_fast = "select MAX(`clock_out`)AS fast from `punch card` where `clock_out` like ".getToday()." AND `id`=".$id;//末次打卡

    $result_last = execute_sql($link, "member", $sql_last);
    $row_last = mysqli_fetch_assoc($result_last);
    

    $result_fast = execute_sql($link, "member", $sql_fast);
    $row_fast = mysqli_fetch_assoc($result_fast);

    
    }
     
       

    //抓月天數
    $Y = date("Y");$M = date("m");
    $month_days  = cal_days_in_month(CAL_GREGORIAN, date($M), date($Y));
          
   
    //取select紀錄值
    $select_value = isset($_GET['select_month']) ? $_GET['select_month'] : '';
    $select_year = isset($_GET['select_year']) ? $_GET['select_year'] : '';
    

    
    ?>


<!doctype html>
<html>
  <head>
    <title>會員管理</title>
    <meta charset="utf-8">
  </head>
  <body>

    <div id="Base_Visitor">
      <div class="Head">
        <a class="Logo" ></a>
      </div>
    <div class="Body">
         <div>
          <form id="form1" name="form1" method="GET" action="">
            <font size="2">員工編號：</font><input type="search" name="search_id" placeholder="請輸入員工編號" value="<?php echo @$search_id ?>">
            <font size="2">員工姓名：</font><input type="search" name="search_name" placeholder="請輸入員工姓名" value="<?php echo @$search_name ?>">
             <font size="2">時間選擇：</font><input type="date" name="search_data" value="<?php echo @$search_data ?>">
             性別選擇：
             <input type="radio" name="radio_sex" value="%" checked="checked">不拘
             <input type="radio" name="radio_sex" value="男">男
             <input type="radio" name="radio_sex" value="女">女
             <button onclick="search() class="button">搜尋</button>
             <br>
             年份選擇：
                <select name="select_year">
                　<option value="2018"  <?php echo $select_year == '2018' ? 'selected' : '' ?>>2018</option>
                　<option value="2019" <?php echo $select_year == '2019' ? 'selected' : '' ?>>2019</option>
                　<option value="2020" <?php echo $select_year == '2020' ? 'selected' : '' ?>>2020</option>
                　<option value="2021" <?php echo $select_year == '2021' ? 'selected' : '' ?>>2021</option>
                 <option value="2022" <?php echo $select_year == '2022' ? 'selected' : '' ?>>2022</option>
                 <option value="2023" <?php echo $select_year == '2023' ? 'selected' : '' ?>>2023</option>
                 <option value="2024" <?php echo $select_year == '2024' ? 'selected' : '' ?>>2024</option>
                 <option value="2025" <?php echo $select_year == '2025' ? 'selected' : '' ?>>2025</option>
                </select>
             月份選擇：
                <select name="select_month">
                　<option value="1" <?php echo $select_month == '1' ? 'selected' : '' ?>>1月</option>
                　<option value="2" <?php echo $select_month == '2' ? 'selected' : '' ?>>2月</option>
                　<option value="3" <?php echo $select_month == '3' ? 'selected' : '' ?>>3月</option>
                　<option value="4" <?php echo $select_month == '4' ? 'selected' : '' ?>>4月</option>
                 <option value="5" <?php echo $select_month == '5' ? 'selected' : '' ?>>5月</option>
                 <option value="6" <?php echo $select_month == '6' ? 'selected' : '' ?>>6月</option>
                 <option value="7" <?php echo $select_month == '7' ? 'selected' : '' ?>>7月</option>
                 <option value="8" <?php echo $select_month == '8' ? 'selected' : '' ?>>8月</option>
                 <option value="9" <?php echo $select_month == '9' ? 'selected' : '' ?>>9月</option>
                 <option value="10" <?php echo $select_month == '10' ? 'selected' : '' ?>>10月</option>
                 <option value="11" <?php echo $select_month == '11' ? 'selected' : '' ?>>11月</option>
                 <option value="12" <?php echo $select_month == '12' ? 'selected' : '' ?>>12月</option>
                </select>
              



          <form>
        </div>
        <div  id="DIV1">
          <table width="100%" border="1" class="order-table" align="right">
            <h1 align="center">月打卡表</h1>
                <tr>
                  <td>年份</td>
                  <td>月份</td>
                  <td>日期</td>
                  <td>最早打卡</td>
                  <td>最晚打卡</td>
                  <td>時間間隔</td>
                  <td>打卡次數</td>
                </tr>
          <?php
    
    for($i=1;$i<=$month_days;$i++){
    //打卡最早
    $i = str_pad($i,2,'0',STR_PAD_LEFT);
    $sql_fast = "select MIN(`clock_in`)AS fast from `punch card` where `clock_in` LIKE '$select_year-$select_month-$i%'  AND `id`=".$id;//首次打卡
    //打卡最晚
    $sql_last = "select MAX(`clock_out`)AS last from `punch card` where `clock_out` LIKE '$select_year-$select_month-$i%'  AND `id`=".$id;//末次打卡
    $result_last = execute_sql($link, "member", $sql_last);
    $row_last = mysqli_fetch_assoc($result_last);
    $result_fast = execute_sql($link, "member", $sql_fast);
    $row_fast = mysqli_fetch_assoc($result_fast);   
    // date("d",strtotime($row_last["last"]))
          ?>
            <tr>
              <td><?php echo $select_year ?></td>
              <td><?php echo $select_month ?></td>
              <td><?php echo $i ?></td>
              <td>
                <?php IF($row_fast["fast"]!=""){
                echo date("H：i：s",strtotime($row_fast["fast"]));
                } 
                else{
                  echo "無資料";
                }

                  ?></td>
              <td>
                <?php IF($row_last["last"]!=""){
                echo date("H：i：s",strtotime($row_last["last"]));
                } 
                else{
                  echo "無資料";
                }

                  ?></td>
        <!-- echo (strtotime($time1) - strtotime($time2))/ (60*60); //計算相差之小時數 -->
        <!-- $a=round(傳數值,[位數]) -->
              <td><?php 
              if($row_last["last"] and $row_fast["fast"] !=""){
              $time=(strtotime($row_last["last"]) - strtotime($row_fast["fast"]))/ 60;
              $hour=round($time,2);
              echo  $hour."分鐘";
              }
              else{
              echo "資料不全";
             }

              ?>
              </td>
              <td></td>
            </tr>
          <?php
          }
          
          ?>
          </table>
        </div>
        <!-- 右方表格 -->
       <!--  <div  id="DIV2">
          <table width="100%" border="1" class="order-table" align="right">
            <h1 align="center">日打卡表</h1>
                <tr>
                  <td>ID</td>
                  <td>姓名</td>
                  <td>上班</td>
                  <td>下班</td>
                  <td>備註</td>
                </tr>
          <?php
          for($i=1;$i<=mysqli_num_rows($result_day);$i++){
          $rs=mysqli_fetch_row($result_day);
          ?>
            <tr>
              <td><?php echo $rs_user[0]?></td>
              <td><?php echo $rs_user[3]?></td>
              <td><?php echo $rs[0]?></td>
              <td><?php echo $rs[1]?></td>
              <td><?php echo $rs[2]?></td>
            </tr>
          <?php
          }
          ?>
          </table> -->
        </div>
        <div style="clear:both;">
          
        </div>
 


 

        </div>
          
    </div>
  </div>
    

    </body>
</html>


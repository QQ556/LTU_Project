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
  

    //月打卡
  if(@$_GET['search_id']!='' or @$_GET['search_name']!='' or @$_GET['search_data']!='' or @$_GET['select_month']!='' 
    or @$_GET['select_year']!='' or @$_GET['select_day']!='')
  {
    //有填值的選項資料
    // $search_id=$_GET['search_id'];
    // @$search_name=$_GET['search_name'];
    @$search_data=$_GET['search_data'];
    $select_month=$_GET['select_month'];
    $select_year=$_GET['select_year'];
    @$select_day=$_GET['select_day'];
  }else{
    //未填值的選項資料
    $search_id=$id;
    $select_month = date("m");
    $select_year = date("Y");   
    $select_day = date("d");
  }
  //抓月天數
  $month_days  = cal_days_in_month(CAL_GREGORIAN, $select_month, $select_year);
  ?>


  <!doctype html>
  <html>
  <head>
    <title>營業管理</title>
    <meta charset="utf-8">
  </head>
  <body>
    <div id="Base_Visitor">
      <div class="Head">
        <a class="Logo" href="main.php" ></a>
      </div>
      <div class="Body">
       <div>
        <form id="form1" name="form1" method="GET" action="">
          <!-- <font size="2">員工編號：</font>
          <input type="search" name="search_id" placeholder="請輸入員工編號" 
          value="<?php echo @$search_id ?>"> -->
          年份選擇：
          <select name="select_year">
            <option value="2018" <?php echo $select_year == '2018' ? 'selected' : '' ?>>2018</option>
            <option value="2019" <?php echo $select_year == '2019' ? 'selected' : '' ?>>2019</option>
            <option value="2020" <?php echo $select_year == '2020' ? 'selected' : '' ?>>2020</option>
            <option value="2021" <?php echo $select_year == '2021' ? 'selected' : '' ?>>2021</option>
            <option value="2022" <?php echo $select_year == '2022' ? 'selected' : '' ?>>2022</option>
            <option value="2023" <?php echo $select_year == '2023' ? 'selected' : '' ?>>2023</option>
            <!-- <option value="2023" <?php echo $select_year == '2023' ? 'scandir(directory)elected' : '' ?>>2023</option> -->
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
          <button onclick="search() class="button">搜尋</button>

          <form>
          </div>
          <div  id="DIV1" style="width: 650px">
            <table width="100%" border="1" class="order-table" align="right">
              <h1 align="center">營業總覽</h1>
              <tr>
                <td>年份</td>
                <td>月份</td>
                <td>日</td>
                <td>來客數</td>
                <td>客單價</td>
                <td>營業額</td>
                <td>詳細資料</td>
              </tr>
              <?php

              for($i=1;$i<=$month_days;$i++){
                //$i為日期 個位數補零
                $i = str_pad($i,2,'0',STR_PAD_LEFT);
                
                //客單量
                $sql_difference = "SELECT MAX(`order_id`)-MIN(`order_id`) difference FROM `orders` WHERE `date` LIKE '$select_year-$select_month-$i%'";
                $result_difference = execute_sql($link, "member", $sql_difference);
                $row_difference = mysqli_fetch_assoc($result_difference);

                
                //營業額
                $sql_turnover = 
                "SELECT `order_id` id, SUM(DISTINCT (`total_price`)) sum FROM orders WHERE `date` LIKE '$select_year-$select_month-$i%' 
                GROUP BY `order_id` 
                in(select SUM(DISTINCT (`total_price`)))";
                $result_turnover = execute_sql($link, "member", $sql_turnover);
                $row_turnover = mysqli_fetch_assoc($result_turnover);




              // $sql_fast = "select MIN(`clock_in`)AS fast from `punch card` 
              // where `clock_in` LIKE '$select_year-$select_month-$i%'  AND `id`=".$search_id;

              //首次打卡
              // //打卡最晚
              // $sql_last = "select MAX(`clock_out`)AS last from `punch card` 
              // where `clock_out` LIKE '$select_year-$select_month-$i%'  AND `id`=".$search_id;//末次打卡
              // $result_last = execute_sql($link, "member", $sql_last);
              // $row_last = mysqli_fetch_assoc($result_last);
              // $result_fast = execute_sql($link, "member", $sql_fast);
              // $row_fast = mysqli_fetch_assoc($result_fast);
                ?>
                <tr>
                  <td><?php echo $select_year ?></td>
                  <td><?php echo $select_month ?></td>
                  <td><?php echo $i ?></td>
                  <!--來客數-->
                  <td><?php 
                  if($row_difference["difference"] !=0){
                    echo $row_difference["difference"] +1 ;
                  } else{
                    echo "0";
                  }
                  ?></td>
                  <!-- 客單價 -->
                  <td>
                    <?php 
                    if($row_turnover["sum"]>0 and $row_difference["difference"]>0)
                      echo ($row_turnover["sum"]/$row_difference["difference"]);
                    else{
                      echo "0";
                    }
                    ?>
                  </td>
                  <td><?php echo $row_turnover["sum"] ?></td>
                  <td align="center">
                    <input type="submit" name="select_day" value=<?php echo $i ?>>查詢
                  </td>
                </tr>
                <?php


              }

              ?>
            </table>
          </div>
          <div id="DIV2" style="float: right;width: 410px">
            <table width="100%" border="1" class="order-table" align="center" style="font-size: 22px">
              <h1 align="center">當日銷售概況</h1>
              <thead>

                <tr>
                  <td width="20%">菜品</td>
                  <td width="20%">數量</td>
                </tr>
              </thead>
              <?php

              // echo "day:".$select_day;
              //查產品熱門商品
              $sql = "SELECT `meal`,sum(`quantity`)  sum FROM `orders` WHERE `date` LIKE '$select_year-$select_month-$select_day%'  GROUP BY `meal` ORDER BY `orders`.`quantity` DESC";
              $result = execute_sql($link, "member", $sql); 
              
              for($i=1;$i<=mysqli_num_rows($result);$i++){
               $rs=mysqli_fetch_row($result);

               $sql = "SELECT `meal_name` FROM `product_list` WHERE `meal_no` = $rs[0]";
               $result_name = execute_sql($link, "member", $sql);
               $rs_name = mysqli_fetch_row($result_name);
               $rs[0] = $rs_name[0];



               ?>
               <tr>
                <td><?php echo $rs[0]?></td>
                <td><?php echo $rs[1]?></td>
              </tr>
              <?php
            }
            ?> 
          </table>
          <table width="100%" border="1" class="order-table" align="center" style="font-size: 22px">
            <h1 align="center">顧客分析</h1>
            <thead>

              <tr>
                <td width="20%">年齡層比例</td>
                <td width="20%">數量</td>
              </tr>
            </thead>
            <?php
            for($i=1;$i<=4;$i++){
             $rs=mysqli_fetch_row($result);


               // $result_name = execute_sql($link, "member", $sql);
               // $rs_name = mysqli_fetch_row($result_name);
            
             $name1="20_old";
             $name2="20_25_old";
             $name3="25_30_old";
             $name4="30_40_old";
             $name5="40_old";

             $sql = "SELECT COUNT(`select_old`) FROM `orders` 
             WHERE `select_old` ='${"name".$i}' AND `date` LIKE '$select_year-$select_month-$select_day%'";
             $result = execute_sql($link, "member", $sql);
             $rs = mysqli_fetch_row($result);
              

             ?>
             <tr>
              <td><?php echo ${"name".$i} ?></td>
              <td><?php echo $rs[0]?></td>
            </tr>
            <?php
          }
          ?> 
        </table>
        <table width="100%" border="1" class="order-table" align="center" style="font-size: 22px">
            <h1 align="center">顧客分析</h1>
            <thead>

              <tr>
                <td width="20%">年齡層比例</td>
                <td width="20%">數量</td>
              </tr>
            </thead>
            <?php
            for($i=1;$i<=2;$i++){
             $rs=mysqli_fetch_row($result);


               // $result_name = execute_sql($link, "member", $sql);
               // $rs_name = mysqli_fetch_row($result_name);
            
             $name1="男性";
             $name2="女性";

             $sql = "SELECT COUNT(`select_sex`) FROM `orders` 
             WHERE `select_sex` ='${"name".$i}' AND `date` LIKE '$select_year-$select_month-$select_day%'";
             $result = execute_sql($link, "member", $sql);
             $rs = mysqli_fetch_row($result);
              

             ?>
             <tr>
              <td><?php echo ${"name".$i} ?></td>
              <td><?php echo $rs[0]?></td>
            </tr>
            <?php
          }
          ?> 
        </table>
      </div>
    </body>
    </html>


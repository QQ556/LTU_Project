<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>

<style type="text/css">
@import url(css.css);
</style>
<script type="text/javascript">   

//小鍵盤部分程式------

function myShow(obj) 

{  

 var BBBB=document.getElementById('BBBB');

 var i;

 var str = "";  

 //產生數字

 for(i = 0 ; i < 10 ; i++)   

 {

  str+="<input type='button' onclick='myAdd(this.value);' value='"+i+"' style='FONT-SIZE:16pt; HEIGHT:40px; WIDTH:40px; font-weight:bold;' />"; 

  if(i==4){str += "<br>";}

}

str += "<br><input type='button' onclick='myDelete()' value='刪 除' style='FONT-SIZE:11pt; HEIGHT:35px; WIDTH:65px;' /><input type='button' onclick='myClean()' value='清 除' style='FONT-SIZE:11pt; HEIGHT:35px; WIDTH:65px; ' /><input type='button' onclick='myClose()' value='關 閉' style='FONT-SIZE:11pt; HEIGHT:35px; WIDTH:65px; ' />";

if((event.clientY+1000)>'450'){BBBB.style.top=(event.clientY-130)+'px';}else{BBBB.style.top=(event.clientY+10)+'px';}

 //alert(event.clientY+10);

 BBBB.style.left=(event.clientX-120)+'px';

 //alert(obj.offsetParent);

 BBBB.innerHTML=str;

 BBBB.style.visibility="visible";

}   

function myClose()

{

  if(string.value==''){string.value = '';}

  BBBB.innerHTML="";

  BBBB.style.visibility="hidden";

  document.forms[0].submit();




}

function Setstring(obj)

{

  if((BBBB.style.visibility=="visible")&&(string.value=='')){string.value = '0';}

  if(obj.value=='0'){obj.value='';}

  string = obj;

}

function  myAdd(s)   

{

 //var txt=document.getElementById(obj.id);

 if(string.value.length<4){

   string.value += s;}

 } 

 function  myDelete()   

 {

 //var txt=document.getElementById(obj.id);

 string.value=string.value.substr(0,string.value.length-1);   

}  

function  myClean()   

{

 //var txt=document.getElementById(obj.id);

 string.value="";   

} 
function ChangeString()
{
  var NewStringValue=document.getElementById("StringTextBox").value;
  document.getElementById("NewStringBox").innerHTML=NewStringValue;
}


</script>
<?php
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
  $link = create_connection();      
    $sql = "SELECT * FROM product_list"; //執行 SELECT 陳述式取得使用者資料
    $result = execute_sql($link, "member", $sql);
    //$row = mysqli_fetch_assoc($result); //將陣列以數字排列索引
    $total_fields=mysqli_num_fields($result); // 取得欄位數
    $total_records=mysqli_num_rows($result);  // 取得記錄數


    $num = 0;

    if(@$_GET['select_sex']!='' 
      or @$_GET['select_old']!='' 
      or @$_GET['tab_num']!='' 
      or @$_GET['total']!='' 
      or @$_GET['nun']!='' 
    )
    {
      $select_sex = $_GET['select_sex'];
      $select_old = $_GET['select_old'];
      $tab_num = $_GET['tab_num'];
      @$total = $_GET['total'];
      @$num = $_GET['num'];
    }
    else
    {
      $num = 0;
    }
    $price =array();
    $meun = array();
    $meun_2 = array();
    // 開始 session 
    session_start(); 
    ?>

    <!doctype html>
    <html>
    <head>
      <title>會員管理</title>
      <meta charset="utf-8">
    </head>
    <body>
      <div id="Base_Visitor" style="width: 1400px;">
        <div class="Head">
         <a class="Logo" href="main.php"></a>
       </div>
       <div class="Body" style="width: 1400px;">


        <div style="float:left;width: 600px;height:550px;">
          <form  action="" method="GET" name="myForm">
            <table width="100%" border="1" class="order-table" style="font-size: 15" >
              <thead>
                <tr>
                  <td>類型</td>
                  <td>餐號</td>
                  <td>名稱</td>
                  <td>價錢</td>
                  <td>數量</td>
                  <td>小記</td>
                </tr>
              </thead>

              <?php            
              for($i=1;$i<=mysqli_num_rows($result);$i++){
                $rs=mysqli_fetch_row($result);
                ?>
                <tr>
                  <td><?php echo $rs[0]?></td>
                  <td><?php echo $rs[1]?></td>
                  <td><?php echo
                  $i.".  ".$rs[2]?></td>
                  <td><?php echo $rs[3]?></td>
                  <td>
                    <label>
                      <input type="number" id="<?php echo "quantity".$rs[1] ?>"  
                      style="float: left;text-align: left; font-weight: bold; border: 1px double #000; 
                      "onclick="Setstring(this);myShow(this);" 
                      name="<?php echo $rs[1] ?>" 
                      value="<?php echo $_GET[$i] ?>" size="3" maxlength="4" readonly="readonly" />
                    </label>
                  </td>
                  <td >
                    <!-- 小記 -->
                    <?php 
                    if(@$_GET[$i] >=1){

                      $money = $rs[3] * $_GET[$i];
                      array_push($price,$money);
                      echo $rs[3] * $_GET[$i];

                    }else{
                      echo "0";
                    }

                    ?></td>



                  </tr>

                  <?php

              //存陣列
                  if(@$_GET[$i] !="" ) {
                   @${"meun".$i} =$_GET[$i]."份".$rs[2]."<br>";
                 }

                 $food = @${"meun".$i};
                 array_push($meun, $food);
              //轉頁用陣列
                 if(@$_GET[$i] !="" ) {
                   @${"meun_2".$i} =$_GET[$i];
                 }

                 $food = @${"meun_2".$i};
                 array_push($meun_2, $food);
                 $_SESSION['num'] = $meun_2; 


               }


               ?>
               <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <?php  
                  echo "總價 " . array_sum($price) . "\n";
                  echo "<br>";


                  ?>

                </td>
              </tr>

            </table>
            <input type="hidden" name="select_sex" value =<?php echo $select_sex ?>>
            <input type="hidden" name="select_old" value =<?php echo $select_old ?>> 
            <input type="hidden" name="tab_num" value =<?php echo $tab_num ?>> 
            <!-- <input type="" name="total" value =<?php echo $total ?>>  -->
            <div class="keyto" id="BBBB" style="" ></div>
            
          </div>

          <div class="BOX" style="height: 550px;float: left">
            <h2>明細</h2>

            <?php echo "<br>" ?>
            <?php
            echo "消費金額 ： " . array_sum($price) . "\n"."<br>";
            echo "顧客座位 ： ".$tab_num;
            echo "<br>"."---餐點---"."<br>";

            foreach($meun as $key=>$value)
            {
              echo $value."\n";
            }
            echo "---餐點結束---";
            ?>
          </div>

          <div style="float: left;border: 1px solid #cccccc;">
            <h2>結帳</h2>
            顧客年齡:<?php echo $select_old ?>
            <?php echo " / "; ?>
            顧客性別:<?php echo $select_sex ?>
            <?php echo "<br>"; ?>

            <?php echo "消費金額 ： " . array_sum($price) . "\n"."<br>"; ?>

            <?php echo "現金支付 ： "?>

            <label>
              <input type="num" name="num" style="text-align: left; font-weight: bold; border: 1px double #000;"  
              onclick="Setstring(this);myShow(this);"  
              size="3" maxlength="4" readonly="readonly"
              value= <?php 

              if ($num>0) {
               echo $num;
             }
             else
             {
              $num=0;
              echo "0";
            };
            ?>>
          </label>
          <input type="submit" name="num" value=<?php echo array_sum($price);?>>
          <br>
          <?php echo "找零 ： "?>
          <?php echo ($num-array_sum($price)); ?>
          <?php echo "<br><br><br><br>"; ?> 
          <?php 
          
          $baseUrl = 'Cashupdata.php?';
          $queries = [
            'select_sex' =>$select_sex ,
            'select_old' =>$select_old,
            'tab_num' => $tab_num,
            'total' => array_sum($price),
          ];
          

          
          $url = $baseUrl . http_build_query($queries);
          $price_all= array_sum($price);
          ?>
          <script type="text/javascript">
            function check_data()
            {
              var a = <?php echo ($num-array_sum($price)); ?>;
              var b = <?php echo array_sum($price); ?>;

              if (a < 0) {

                console.log("找零為零");
                alert("請輸入正確的「現金支付」");
                return false;
              } 
              if (b == 0) {

                console.log("沒點餐");
                alert("您還未沒點餐");
                return false;
              } 

              else {
                location.href="<?php echo $url ?>";
               
             }

           }

         </script>

         <a class="Item5" 
         style="font-size: 140px;letter-spacing: 50px;background-color: #4caf50;" 
         align="center" 
         onClick="check_data()"
         >收銀</a>
         <br>
         <a class="Item5" style="font-size: 140px;letter-spacing: 50px;" align="center" href="Cash.php?">返回
         </a>


       </div>


     </form>
   </div>

 </div>
</body>
</html>


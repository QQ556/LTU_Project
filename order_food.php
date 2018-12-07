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
$(function()
 {
      $('.hTotal').each(function(i) {
          var hTotal = 0;
          $(this).parent().find('td:gt(0)')
            .each(function(i)
            {
                hTotal += parseInt($(this).text());
            });
          $(this).text(hTotal);
      });
      
      $('.vTotal').each(function(i) {
          var vTotal = 0;
          $(this).parent().parent()
            .find('td:nth-child(' + (i+2) +'),th:nth-child(' + (i+2) +')')
            .each(function(i)
            {
                vTotal += parseInt($(this).text());
            });
          $(this).text(vTotal);
      });
 });

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


    if(@$_GET['num']!=''){
      $num = $_GET['num'];

    }else{
      $num = "";
      echo "hi";
    }

    if(@$_GET['select_sex']!='' or @$_GET['select_old']!='' or @$_GET['tab_text']!='')
    {
      $select_sex = $_GET['select_sex'];
      $select_old = $_GET['select_old'];
      $tab_text = $_GET['tab_text'];
    }

    ?>

    <!doctype html>
    <html>
    <head>
      <title>會員管理</title>
      <meta charset="utf-8">
    </head>
    <body>
      <div id="Base_Visitor" style="width: 1400px">
        <div class="Head">
         <a class="Logo" href="main.php"></a>
       </div>
       <div class="Body" style="width: 550px;float:left">
        <form  action="" method="GET" name="myForm">
          顧客座位:<?php echo $tab_text ?>
          顧客年齡:<?php echo $select_old ?>
          顧客性別:<?php echo $select_sex ?>
          <br>

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
                <td><?php echo $rs[2]?></td>
                <td><?php echo $rs[3]?></td>
                <td>
                  <label>
                    <input type="number" id="<?php echo "quantity".$rs[1] ?>"  
                    style="text-align: left; font-weight: bold; border: 1px double #000; 
                    "onclick="Setstring(this);myShow(this);" 
                    name="<?php echo $rs[1] ?>" 
                    value="<?php echo $_GET[$i] ?>" size="3" maxlength="4" readonly="readonly" />
                  </label>
                </td>
                <td >
                  <!-- 小記 -->
                  <?php 
                  if(@$_GET[$i] >=1){
                    echo $rs[3] * $_GET[$i];
                  }else{
                    echo "0";
                  }

                  ?></td>



                </tr>

                <?php

              //印出餐點
                if(@$_GET[$i] !="" ) {
                 @${"meun".$i} =$_GET[$i]."份".$rs[2]."<br>";

               }
               echo @${"meun".$i};
             }

             ?>
             <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>

          </table>
          <input type="hidden" name="select_sex" value =<?php echo $select_sex ?>>
          <input type="hidden" name="select_old" value =<?php echo $select_old ?>> 
          <input type="hidden" name="tab_text" value =<?php echo $tab_text ?>> 
          <div class="keyto" id="BBBB" ></div>
          <button >下一步</button>
        </form>
      </div>
      <div>123123</div>

    </div>
  </body>
  </html>


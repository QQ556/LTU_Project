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

  if(string.value==''){string.value = '1';}

  BBBB.innerHTML="";

  BBBB.style.visibility="hidden";

}

function Setstring(obj)

{

  if((BBBB.style.visibility=="visible")&&(string.value=='')){string.value = '1';}

  if(obj.value=='1'){obj.value='';}

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
    $sql = "SELECT * FROM users"; //執行 SELECT 陳述式取得使用者資料
    $result = execute_sql($link, "member", $sql);
    //$row = mysqli_fetch_assoc($result); //將陣列以數字排列索引
    $total_fields=mysqli_num_fields($result); // 取得欄位數
    $total_records=mysqli_num_rows($result);  // 取得記錄數


    if(@$_GET['select_sex']!='' or @$_GET['select_old']!='' or @$_GET['tab_text']!=''){
    $select_sex = $_GET['select_sex'];
    $select_old = $_GET['select_old'];
    $tab_text = $_GET['tab_text'];
   }else{
    echo "hi";
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
        <div class="abgne-menu">
          
         <h2>來客分析</h2>
         
         <h3>性別</h3>
         
         <form id="form1" action="order_food.php" method="GET" name="myForm">
         <input type="radio" id="male" name="select_sex" value="男性" checked>
         <label for="male">男性</label>
 
         <input type="radio" id="female" name="select_sex" value="女性">
         <label for="female">女性</label>
         <hr/>
         
         <h3>年齡</h3>
  
         <input type="radio" id="20_old" name="select_old" value="20_old" checked>
         <label for="20_old">20歲以下</label>
         
 
         <input type="radio" id="20_25_old" name="select_old" value="20_25_old">
         <label for="20_25_old">20歲到25歲</label>

         <input type="radio" id="25_30_old" name="select_old" value="25_30_old">
         <label for="25_30_old">25歲到30歲</label>
 
         <input type="radio" id="30_40_old" name="select_old" value="30_40_old">
         <label for="30_40_old">30歲到40歲</label>

         <input type="radio" id="40_old" name="select_old" value="40_old">
         <label for="40_old">40歲以上</label>
         <hr/>


         </div>
       </div>
       <div class="Body" style="width: 550px;float:left">
         <h2>座位選擇</h2>
         <h3>請輸入座位</h3>
         <hr/>
         <label>
         <input type="number" name="tab_text" 
         value ="<?php echo @$tab_text ?>" 
         id="quantity1" 
         style="text-align: right; font-weight: bold; border: 1px double #000;
         "onclick="Setstring(this);myShow(this);" 
         value="1" size="3" maxlength="4" readonly="readonly" />

         </label>
         <div class="keyto" id="BBBB"></div>
         <br><br><br><br><br>
         <button onclick="search() class="item5">下一步</button>
       </div> 
     </form>




   </div>
 </div>

</div>
</body>
</html>


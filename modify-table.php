
<style type="text/css">
@import url(css.css);
tr:nth-child(even) {
  background: #CCC
}
tr:nth-child(odd) {
  background-color: #FAFAFA;
}
/*td:hover {
    background-color: #E6FBFF;
    }*/
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
    .post{
      padding: 5px;
      background: #cccccc;
      border: 1px solid #ddd;
      border-radius: 2px;
      font-size: 1rem;
      color: #111;
    }
  </style>
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

    //建立資料連接
    $link = create_connection();

    //執行 SELECT 陳述式取得使用者資料
    $code = $_GET["code"];

    $sql = "SELECT * FROM users Where id = $code";
    $result = execute_sql($link, "member", $sql);
    $row = mysqli_fetch_assoc($result);  
    $rs = $result->fetch_row();  
    ?>

    <!doctype html>
    <html>
    <head>
      <title>修改會員資料</title>
      <meta charset="utf-8">
      <script type="text/javascript">
        function check_data()
        {
          if (document.myForm.password.value.length == 0)
          {
            alert("「使用者密碼」一定要填寫哦...");
            return false;
          }
          if (document.myForm.password.value.length > 10)
          {
            alert("「使用者密碼」不可以超過 10 個字元哦...");
            return false;
          }
        // if (document.myForm.re_password.value.length == 0)
        // {
        //   alert("「密碼確認」欄位忘了填哦...");
        //   return false;
        // }
        // if (document.myForm.password.value != document.myForm.re_password.value)
        // {
        //   alert("「密碼確認」欄位與「使用者密碼」欄位一定要相同...");
        //   return false;
        // }
        if (document.myForm.name.value.length == 0)
        {
          alert("您一定要留下真實姓名哦！");
          return false;
        }	
        if (document.myForm.year.value.length == 0)
        {
          alert("您忘了填「出生年」欄位了...");
          return false;
        }
        if (document.myForm.month.value.length == 0)
        {
          alert("您忘了填「出生月」欄位了...");
          return false;
        }	
        if (document.myForm.month.value > 12 | document.myForm.month.value < 1)
        {
          alert("「出生月」應該介於 1-12 之間哦！");
          return false;
        }
        if (document.myForm.day.value.length == 0)
        {
          alert("您忘了填「出生日」欄位了...");
          return false;
        }
        if (document.myForm.month.value == 2 & document.myForm.day.value > 29)
        {
          alert("二月只有 28 天，最多 29 天");
          return false;
        }	
        if (document.myForm.month.value == 4 | document.myForm.month.value == 6
          | document.myForm.month.value == 9 | document.myForm.month.value == 11)
        {
          if (document.myForm.day.value > 30)
          {
            alert("4 月、6 月、9 月、11 月只有 30 天哦！");
            return false;					
          }
        }	
        else
        {
          if (document.myForm.day.value > 31)
          {
            alert("1 月、3 月、5 月、7 月、8 月、10 月、12 月只有 31 天哦！");
            return false;					
          }				
        }
        if (document.myForm.day.value > 31 | document.myForm.day.value < 1)
        {
          alert("出生日應該在 1-31 之間");
          return false;
        }	
        myForm.submit();					
      }
    </script>			
  </head>
  <body>
    <p align="center"><img src="modify.jpg"></p>
    <form name="myForm" method="post" action="update.php">
      <table border="2" align="center" bordercolor="#6666FF">
       <tr> 
        <td colspan="4" bgcolor="#6666FF" align="center"> 
          <font color="#FFFFFF">人資欄位</font>
        </td>
        <tr bgcolor="#99FF99"> 
          <td align="right">開通帳號</td>
          <td colspan="3">
            <select name="open_account" value="<?php echo $row{"open_account"} ?>">
             <option value="是">是</option>
             <option value="否">否</option>
           </select>
         </td>
       </tr>
       <tr bgcolor="#99FF99"> 
        <td align="right">員工職位</td>
        <td colspan="3">
         <select name="position"value="<?php  $row{"position"} ?>" >
           <option value="一般員工">一般員工</option>
           　            <option value="行政員工">行政員工</option>
         </select>
       </td>
     </tr>
     <tr bgcolor="#99FF99"> 
      <td align="right">到職日</td>
      <td>
        <input id="search" name="take_office_date" type="date" 
        placeholder="<?php echo $row{"take_office_date"} ?>"
        value="<?php echo $row{"take_office_date"} ?>" >
      </td>
      <td align="right">離職日</td>
      <td>
        <input id="search" name="leave_office_date" type="date" 
        placeholder="<?php echo $row{"leave_office_date"} ?>" 
        value="<?php echo $row{"leave_office_date"} ?>">
      </td>
    </tr>
    <tr> 
      <td colspan="4" bgcolor="#6666FF" align="center"> 
        <font color="#FFFFFF">員工欄位</font>
      </td>
    </tr>
    <tr bgcolor="#99FF99"> 
      <td align="right">員工編號：</td>
      <td colspan="3"><?php echo $row{"id"} ?></td>
    </tr>
    <tr bgcolor="#99FF99"> 
      <td align="right">*使用者帳號：</td>
      <td colspan="3"><?php echo $row{"account"} ?></td>
    </tr>
    <tr bgcolor="#99FF99"> 
      <td align="right" >*使用者密碼：</td>
      <td colspan="3"> 
        <input type="text" name="password" size="15" value="<?php echo $row{"password"} ?>">
        (請使用英文或數字鍵，勿使用特殊字元)
      </td>
    </tr>
    <tr bgcolor="#99FF99"> 
      <td align="right">*姓名：</td>
      <td colspan="3"><input type="text" name="name" size="8" value="<?php echo $row{"name"} ?>"></td>
    </tr>

    <tr bgcolor="#99FF99"> 
      <td align="right">*所在門市：</td>
      <td colspan="3"><input type="text" name="address" size="45" value="<?php echo $row{"Store"} ?>">(如果有調店，請聯絡資訊部)</td> 
    </td>
  </tr>
  <tr bgcolor="#99FF99"> 
    <td align="right">*性別：</td>
    <td colspan="3"> 
      <input type="radio" name="sex" value="男" checked>男 
      <input type="radio" name="sex" value="女">女
    </td >
  </tr>
  <tr bgcolor="#99FF99"> 
    <td align="right">*生日：</td>
    <td colspan="3">民國 
      <input type="text" name="year" size="2" value="<?php echo $row{"year"} ?>">年 
      <input type="text" name="month" size="2" value="<?php echo $row{"month"} ?>">月 
      <input type="text" name="day" size="2" value="<?php echo $row{"day"} ?>">日
    </td>
  </tr>
  <tr bgcolor="#99FF99"> 
    <td align="right">電話：</td>
    <td colspan="3"> 
      <input type="text" name="telephone" size="20" value="<?php echo $row{"telephone"} ?>">
      (依照 (02) 2311-3836 格式 or (04) 657-4587)
    </td>
  </tr>
  <tr bgcolor="#99FF99"> 
    <td align="right">行動電話：</td>
    <td colspan="3"> 
      <input type="text" name="cellphone" size="20" value="<?php echo $row{"cellphone"} ?>">
      (依照 (0922) 302-228 格式)
    </td>
  </tr>
  <tr bgcolor="#99FF99"> 
    <td align="right">地址：</td>
    <td colspan="3"><input type="text" name="address" size="45" value="<?php echo $row{"address"} ?>"></td>
  </tr>
  <tr bgcolor="#99FF99"> 
    <td align="right">E-mail 帳號：</td>
    <td colspan="3"><input type="text" name="email" size="30" value="<?php echo $row{"email"} ?>"></td>
  </tr>

  <tr bgcolor="#99FF99"> 
    <td align="right">備註：</td>
    <td colspan="3"><textarea name="comment" rows="4" cols="45"><?php echo $row{"comment"} ?></textarea></td>
  </tr>
  <tr bgcolor="#99FF99"> 
    <td colspan="4" align="CENTER"> 
      <input type="button" value="修改資料" onClick="check_data()" class="button">
      <input type="reset" value="重新填寫" class="button">
      <input align="right" type ="button" onclick="history.back()" value="回到上一頁" class="button" class="button">
    </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
    //釋放資源及關閉資料連接
mysqli_free_result($result);
mysqli_close($link);
}
?>
<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>

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
<script type="text/javascript">
    (function(document) {
  'use strict';

  // 建立 LightTableFilter
  var LightTableFilter = (function(Arr) {

    var _input;

    // 資料輸入事件處理函數
    function _onInputEvent(e) {
      _input = e.target;
      var tables = document.getElementsByClassName(_input.getAttribute('data-table'));
      Arr.forEach.call(tables, function(table) {
        Arr.forEach.call(table.tBodies, function(tbody) {
          Arr.forEach.call(tbody.rows, _filter);
        });
      });
    }

    // 資料篩選函數，顯示包含關鍵字的列，其餘隱藏
    function _filter(row) {
      var text = row.textContent.toLowerCase(), val = _input.value.toLowerCase();
      row.style.display = text.indexOf(val) === -1 ? 'none' : 'table-row';
    }

    return {
      // 初始化函數
      init: function() {
        var inputs = document.getElementsByClassName('light-table-filter');
        Arr.forEach.call(inputs, function(input) {
          input.oninput = _onInputEvent;
        });
      }
    };
  })(Array.prototype);

  // 網頁載入完成後，啟動 LightTableFilter
  document.addEventListener('readystatechange', function() {
    if (document.readyState === 'complete') {
      LightTableFilter.init();
    }
  });

})(document);
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
    ?>
    測試用總記錄數<?php echo "$total_fields"; ?>
    測試用總欄位數<?php echo "$total_records"; ?>

<!doctype html>
<html>
  <head>
    <title>會員管理</title>
    <meta charset="utf-8">
  </head>
  <body>
    <div id="Base_Visitor" style="width: 1400px">
      <div class="Head">
        <a class="Logo" ></a>
      </div>
    <div class="Body">
        <div class="NavPanel">
            <a class="Item" href="join.html" target="_top">新增員工</a>      
        </div>
         <div class="post">
            搜尋：<input type="search" class="light-table-filter" data-table="order-table" placeholder="請輸入關鍵字">  
        </div>
 <table width="100%" border="1" class="order-table" style="font-size: 15" >
    <thead>
      <tr>
        <td>員工號</td>
        <td>帳號</td>
        <td>密碼</td>
        <td>名字</td>
        <td>職稱</td>
        <td>所在門市</td>
        <td>性別</td>
        <td>出生日</td>
        <td>電話</td>
        <td>手機</td>
        <td>地址</td>
        <td>電子信箱</td>
        <td>備註</td>
        <td>修改</td>
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
    <td><?php echo $rs[4]?></td>
    <td><?php echo $rs[5]?></td>
    <td><?php echo $rs[6]?></td>
    <td><?php echo $rs[7]?>.<?php echo $rs[8]?>.<?php echo $rs[9]?></td>
    <td><?php echo $rs[10]?></td>
    <td><?php echo $rs[11]?></td>
    <td><?php echo $rs[12]?></td>
    <td><?php echo $rs[13]?></td>
    <td><?php echo $rs[14]?></td>
    <td><a href="modify-table.php?code=<?php echo $rs[0]?>" >修改</a>
        <a href='join.html'onclick="return confirm('確定刪除嗎')">刪除</a>
    </td>
  </tr>
<?php
}
?>
</table>

<table align="right">
  <tr><td>
  <input align="right" type ="button" onclick="history.back()" value="回到上一頁" style="background-color:#019e97;border-radius: 10px;width:100px;height: 40px;margin: 20px auto;font-size: 13px;letter-spacing: 1px;color: white;"></input></td></tr>

</table>
 

        </div>
          
    </div>
  </div>
    

    </body>
</html>


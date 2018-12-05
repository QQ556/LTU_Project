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
         <h2>來客分析</h2>
         <h3>性別</h3>
         <hr/>
         <input type="submit" name="select_day" class=item6 value = 男>
         <input type="submit" name="select_day" class=item6 value = 女>
         <h3>年齡</h3>
         <hr/>
         <input type="submit" name="select_day" class=item6 value = 20歲以下>
         <input type="submit" name="select_day" class=item6 value = 20歲到25歲>
         <input type="submit" name="select_day" class=item6 value = 25歲到30歲>
         <input type="submit" name="select_day" class=item6 value = 30歲到40歲>
         <input type="submit" name="select_day" class=item6 value = 40歲以上>
         
       </div>
       <div class="Body" style="float:left;width: 750px">
         <h2>點餐畫面</h2>
         <h3>搜尋點單</h3>
         <hr/>
         <br>
         <h3>櫃台點單</h3>
         <a class="Item5" align="center" href="Counter_meal.php?code=<?php echo $id ?>">點餐</a>
         <hr/>
       </div>



      
      </div>
    </div>

  </div>
</body>
</html>


<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>

<style type="text/css">
@import url(css.css);
</style>
<?php
date_default_timezone_set('Etc/GMT-8');//使用台灣地區時間
function getToday(){
	$today = getdate();
	date("Y/m/d H:i");  //日期格式化
	$year=$today["year"]; //年 
	$month=$today["mon"]; //月
	$day=$today["mday"];  //日
 	//若月或日為個位數 補零
	if(strlen($month)=='1')$month='0'.$month;
	if(strlen($day)=='1')$day='0'.$day;
	$today="'".$year."-".$month."-".$day."%'";
	//echo "今天日期 : ".$today;
	return $today;
}
$passed=$_COOKIE["passed"];
  /*  如果 cookie 中的 passed 變數不等於 TRUE
  表示尚未登入網站，將使用者導向首頁 index.html	*/
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

    //執行 SELECT 陳述式取得使用者資料
  $sql = "SELECT * FROM users Where id = $id";
  $result = execute_sql($link, "member", $sql);
  $row = mysqli_fetch_assoc($result);
    //開啟第二組 punch card資料庫

    $MAX = "select MAX(`clock_out`) from `punch card` where `clock_out` like ".getToday()." AND `id`=".$id;//末次打卡
    $MIN = "select MIN(`clock_in`) from `punch card` where `clock_in` like ".getToday()." AND `id`=".$id;//首次打卡
    $ALL = "select `clock_in` 上班, `clock_out` 下班 FROM `punch card` WHERE `id`=".$id." "." AND (`clock_in` like ".getToday()."OR`clock_out` like ".getToday().')';

    $result = execute_sql($link, "member", $MAX);
    $row2 = mysqli_fetch_assoc($result);

    $result2 = execute_sql($link, "member", $MIN);
    $row3 = mysqli_fetch_assoc($result2);

    $result3 = execute_sql($link, "member", $ALL);
    $row4 = mysqli_fetch_assoc($result3);
    $total_records=mysqli_num_rows($result3);  // 取得記錄數
    ?>
    列印值 <?PHP print_r ($ALL);?><br>
    資料數<?PHP print_r ($total_records);?>


    <!doctype html>

    <html>
    <head>
    	<title>會員管理</title>
    	<script language="JavaScript">
    		function ShowTime(){
    			var NowDate=new Date();
    			var y=NowDate.getFullYear();
    			var mon=NowDate.getMonth();
    			var d=NowDate.getDate();
    			var h=NowDate.getHours();
    			var m=NowDate.getMinutes();
    			var s=NowDate.getSeconds();
    			nowtime =y+'年'+mon+'月'+d+'日 - '+h+'時'+m+'分'+s+'秒';
    			document.getElementById('showbox').innerHTML =y+'年'+mon+'月'+d+'日 - '+h+'時'+m+'分'+s+'秒';
    			setTimeout('ShowTime()',1000);
    		}
    	</script>
    	<meta charset="utf-8">
    </head>
    <body onload="ShowTime()">
    	<div id="Base_Visitor">
    		<div class="Head">
    			<a class="Logo" href="main.php" ></a>
    			<div class="users">
    				<a class="user">
    					&emsp;歡迎光臨&emsp;&emsp;<font color="##0a4cff"><?php echo $row{"name"} ?></font>
    					<br>
    					&emsp;登入身分&emsp;&emsp;<font color="##0a4cff"><?php echo $row{"position"} ?></font>
    				</a>
    			</div>
    		</div>
    		<div align="right" style="background: #ffffff;height:20px;padding:8px">
    			<ul class="drop-down-menu">
    				<li><a href="#">管理功能<span class="arrow-indicator"><i class="fa fa-angle-down"></i></span></a>
    					<ul>
    						<li><a href="business.php" >營業管理</a>
    						</li>
    						<li><a href="Employee.php">員工管理</a>
    						</li>
    						<li><a href="Working_hours.php">工時管理</a>
    						</li>
    						<li><a href="/">公告管理</a>
    						</li>
    					</ul>
    				</li>
    				<li><a href="#">我的帳戶<span class="arrow-indicator"><i class="fa fa-angle-down"></i></span></a>
    					<ul>
    						<li><a href="modify.php" target="_top">修改我的資料</a>
    						</li>
    						<li><a href="punchcard_table.php?>">打卡明細</a>
    						</li>
    						<li><a href="logout.php">登出網站</a>
    						</li>
    					</ul>
    				</li>
    			</ul>
    		</div>

    		<div class="Body">
    			<hr/>
    			<div id="punchcard" style="float:left;">
    				<div>
    					<h3>線上打卡系統</h3>
    					<div id="showbox" >
    						<!-- 系統時間 -->	
    					</div>
    					<br>
    					<div style="float:left;">
    						<a class="Item2" href="clock_in.php?code=<?php echo $row{"id"} ?>">上班</a>
    						<a class="Item3" href="clock_out.php?code=<?php echo $row{"id"} ?>">下班</a>
    					</div>
    				</div>
    				<div style="clear:both;">
    					<a class="Item4" href="punchcard_table.php">打卡明細</a>
    				</div> 
    			</div>
    			<div style="margin-left: 30px;margin-top: 0px;font-style: 24px;float:left; ">
    				<?php 
    				echo "<h3>今天打卡紀錄</h3>";
    				echo("首次上班打卡 - ".$row3{"MIN(`clock_in`)"});
    				echo "<br>";
    				echo("末次下班打卡 - ".$row2{"MAX(`clock_out`)"});
    				echo("<hr/>");
    				echo "<h3>今天打卡明細</h3>";		
    				?>
    				<div class="box">
    					　　						<?php
    					mysqli_data_seek($result3, 0); 
    					echo "---共".$total_records."筆記錄---"; 
    					for($i=1;$i<=mysqli_num_rows($result3);$i++)
    					{
    						$rs=mysqli_fetch_row($result3);
    						if($rs[0] == NULL)
    						{
    							echo("<BR>");
    							echo "第".$i."筆 - ";
    							echo($rs[1])."下班卡";
    						} 
    						else
    						{
    							echo("<BR>");
    							echo "第".$i."筆 - ";
    							echo($rs[0])."上班卡";
    						}
    					}
    					?>
    				</div>    
    			</div>
    			<div  style="margin-left: 30px;margin-top: 0;float:left;background:#ffffff;width:540px;">
    				<h3>收銀功能</h3>
    				<a class="Item5" align="center" href="Cash.php?code=<?php echo $row{"id"} ?>">結帳</a>
					<a class="Item5" style="background-color:#0a4cff"align="center" href="Counter_meal.php?code=<?php echo $id ?>">點餐</a>

    			</div>
    		</div>
    	</body>
    	</html>
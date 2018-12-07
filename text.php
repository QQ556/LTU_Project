<?php
session_start();
$_SESSION[num]=0;
if($_POST['submit']){
$_SESSION[num] =$_POST[num]+1 ;
}
echo $_SESSION[num];
?>
<form action="" method="post">
<input type="hidden" name="num" value="<?php echo $_SESSION[num];?>" />
<input type="submit" name="submit" value="数字加1" />
</form>
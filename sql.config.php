<meta charset="utf-8">
<?php


  //此处使用Mysqli连接，在之后的开发也必须使用Mysqli。
  //设定变量conn，在之后的开发只需引入此文件，并使用$conn连接即可。
  $conn=@mysqli_connect("localhost","itdmoral","itdmoral","itdmoral","3306");

  //PHP内置函数（Errno为错误码）
  if(mysqli_connect_errno($conn)){
  	$error = mysqli_connect_errno($conn);
  	include("head.php");
  	for ($x = 0;$x<=500;$x++) echo "<b><font color = blue>嚴重錯誤,請聯繫管理部門,錯誤代碼為ITDMEMS_ERROR_SQL</font><font color = red>{$error}</font></b>";
  	die;
  }

  //设定为UTF-8
  mysqli_set_charset($conn,"utf8");
?>

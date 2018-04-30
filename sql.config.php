<?php

  $conn=@mysqli_connect("localhost","itdmoral","itdmoral","itdmoral","3306");

  //PHP内置函数（Errno为错误码）
  if(mysqli_connect_errno($conn)){
  	$error = mysqli_connect_errno($conn);
  	for ($x = 0;$x<=500;$x++) echo "<b><font color = blue>嚴重錯誤,請聯繫管理部門,錯誤代碼為ITDMEMS_ERROR_SQL</font><font color = red>{$error}</font></b>";
  	die;
  }

  mysqli_set_charset($conn,"utf8");
?>

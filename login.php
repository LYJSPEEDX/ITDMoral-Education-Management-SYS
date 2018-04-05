<?php


session_start();

if( isset($_SESSION['isLog']) &&  $_SESSION['isLog']==true){
  header("Location: scorechange.php");
}

require_once("sql.config.php");

if(isset($_POST) && $_POST){

  $sid=$_POST['sid'];

  $pw=($_POST['pw']);
  
  $sql="SELECT * FROM user WHERE sid='$sid'";

  $result=mysqli_fetch_assoc(mysqli_query($conn,$sql));

  //判断输入的密码是否与表内匹配
  if($pw== $result['pw'] && $result['status'] == "admin"){

    $_SESSION['name']=$result['usrname'];          //写入操作人姓名用于nav
    $_SESSION['isLog']=true;          //确定登录状态
    $_SESSION['sid']=$sid;              //写入操作人学号用于oper_re

    //跳转,"Location: www.baidu.com"
    header("Location: scorechange.php");
  }

  else{
    $_SESSION['isLog']=false;
    echo "<script>alert('学号或密码输出出错！\\n或你未验证成功，Access Denied！\\n[ITD公告]暂时未开放非部内权限访问')</script>";
  }
  
} 
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<title>登录ITD德育分管理系统</title>
<?php include("head.php");  ?>
</head>

<body>

  <table border="1" align="center" width="300">
    <form method="post">
  	<tr  align="center">
  		<th colspan="2">登录ITD德育分管理系统</th>
	</tr> 
  	<tr>
  		<td align="center">学号</td>
  		<td align="center"><input type="text" name="sid"></td>
	<tr/>
	<tr>
		<td align="center">密码</td>
		<td align="center"><input type="password" name="pw"></td>
	<tr/>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="登录"></form><button onclick="window.location.href='register.php'">部员验证</button></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><b>© 2018 ITD·LYJ .LLC</b></td>
	</tr>
</table>
<br>
<div align="center"><button onclick="window.location.href='index.php'"><b>查询德育分</b></button></div>
<!-- <?php include("footer.php"); ?> -->
</body>
</html>
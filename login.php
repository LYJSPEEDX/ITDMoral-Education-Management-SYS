<?php
//启用Session，必须在所有PHP代码前使用。
session_start();

require_once("sql.config.php");

//判断是否已提交数据，若没有则不处理
if(isset($_POST) && $_POST){

  //获取usr编辑框的内容（usr为编辑框的Name）
  $usr=$_POST['usr'];

  //先获取pw的内容，然后MD5
  //MD5为内置函数
  $pw=md5($_POST['pw']);
  
  //定义要执行的SQL语句，在适当位置插入变量↓↓↓。常用SQL语句看Wiki
  $sql="SELECT * FROM user WHERE usrid='{$usr}'";

  //执行语句，第一个参数为数据库连接（已配置），第二个为SQL语句
  $query=mysqli_query($conn,$sql);

  //略……（除了SELECT，其他都不用fetch_array）
  $result=mysqli_fetch_assoc($query);
  
  //获取表数据，$result['xx']的xx为表字段名
  $indb_pw=$result['pw'];

  //判断输入的密码是否与表内匹配
  if($pw==$indb_pw){
    //匹配，将Session-isLog定义为true
    $_SESSION['isLog']=true;

    //将表单的usr数据存入Session，可为中文
    $_SESSION['name']=$usr;

    //跳转,"Location: www.baidu.com"
    header("Location: scorechange.php");
  }

  else{
    $_SESSION['isLog']=false;
    echo "<script>alert('用户名或密码错！')</script>";
  }
  
} 
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>登录ITD德育分管理系统</title>
</head>

<body>
<form method="post">
  <table border="1" align="center" width="200">
  	<tr  align="center">
  		<th colspan="2">登录ITD德育分管理系统</th>
	</tr> 
  	<tr>
  		<td align="center">姓名</td>
  		<td align="center"><input type="text" name="usr"></td>
	<tr/>
	<tr>
		<td align="center">密码</td>
		<td align="center"><input type="text" name="pw"></td>
	<tr/>
	<tr>
		<td colspan="2" align="center"><input type="submit" value="登录"></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><b>© 2018 ITD·LD .LLC</b></td>
	</tr>
</table>
</form>
<div align="center"><button onclick="window.location.href='register.php'">验证注册入口</button></div>
</body>
</html>
<!doctype html>
<html>
	<head>
		<?php include('head.php'); ?>
		<link href="css/login.css" rel="stylesheet">
	</head>

<?php
session_start();

if( isset($_SESSION['isLog']) &&  $_SESSION['isLog']==true){
	header("Location:teacherindex.php");
}

require("sql.config.php");
require("base_utils.php");

if(isset($_POST) && $_POST){

	$name=$_POST['name'];

	$pw=($_POST['pw']);
	
	$sql="SELECT * FROM user WHERE usrname='$name'";

	$result=mysqli_fetch_assoc(mysqli_query($conn,$sql));

	//判断输入的密码是否与表内匹配
	if($pw== $result['pw'] && ($result['status'] == "teacher" || $result['status'] == "root")){

		$_SESSION['name']=$result['usrname'];          //写入操作人姓名用于nav
		$_SESSION['isLog']=true;          //确定登录状态
		$_SESSION['sid']=null;              //写入操作人学号用于oper_re
		$_SESSION['status'] = 'teacher';    //写入用户角色

		if ($result['status'] == "root") $_SESSION['status'] = 'root';

		//记录
		$operator = $_SESSION['name'];
		oper_re($operator,"login","登录");
		header("Location: teacherindex.php");
	}

	else{
		$_SESSION['isLog']=false;
		echo "<script>alert('Access forbidden');</script>";
	}
} 
?>

	<body class="text-center">

		<form class="form-signin" method="POST">
			<h1 class="h3">登陆ITD-MEMS管理系统</h1>
			<h6 class="h5">教师系统</h6>
			<label class="sr-only">学号</label>
			<input name="name" type="text" class="form-control" placeholder="教师姓名" required>
			<label for="inputPassword" class="sr-only">Password</label>
			<input name="pw" type="password" id="inputPassword" class="form-control" placeholder="密码" required>
			<button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
			<small class="form-text text-muted">一旦你选取登陆,即视为同意ITD<strong>权限监测</strong>协议</small>
			<p class="mt-5 mb-3 text-muted">&copy; 2018 ITD-MEMS V2.1</p>
		</form>
	</body>
</html>

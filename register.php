<?php
require("sql.config.php");
require("base_utils.php");

if(isset($_POST) && $_POST){

	$name = $_POST['name'];  
	$sid = $_POST['sid'];
	$pw = ($_POST['pw']);
	$_POST['admin'] = (isset($_POST['admin']))? $_POST['admin']:false;

	$admin = ($_POST['admin'] == true)? "选择了" : "未选择";  
	echo "<script>if(! confirm('确定数据无误？点击取消重新填写。\\n牢记你的密码！\\n你 $admin 信息部权限，虚假填报将导致你的账户验证失败！')) window.location.href='register.php'</script>";
 
 	$check = (checkstudent($sid));
 	if ($check['name'] != $name) die("<script>alert('学号与姓名绑定失败！\\n确保输入了正确的姓名和学号！'); window.location.href='register.php';</script>");
	if (checkreg($sid)) die("<script>alert('你已经注册，请勿重复操作！'); window.location.href='login.php';</script>");

	
	if (strlen($pw) >=8) {
		$status = ($_POST['admin'] == true)? "check" : "normal";
		$sql = "INSERT INTO user (usrname,sid,pw,status) VALUES ('$name','$sid','$pw','$status')";

		if (mysqli_query($conn,$sql)) die("<script>alert('操作成功，将自动跳转！'); window.location.href='login.php';</script>"); else die("<script>alert('严重错误！'); </script>");

	}else die("<script>alert('密码小于8位！'); window.location.href='register.php';</script>");

}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ITD德育分管理系统个人验证</title>
<?php include("head.php");  ?>
</head>

<body>
<form method="post">
  <table border="1" align="center" >
  	<tr  align="center">
  		<th colspan="2">ITD德育分管理系统个人验证(注册)</th>
	</tr>
  	<tr>
  		<td align="center">姓名</td>
  		<td align="center"><input type="text" name="name" required="required"></td>
	<tr/>
	<tr>
		<td align="center"><b>四位</b>学号</td>
		<td align="center"><input type="text" name="sid" required="required"></td>
	</tr>
	<tr>
		<td align="center">密码</td>
		<td align="center"><input type="password" name="pw" required="required"></td>
	<tr/>
	<tr>
		<td colspan="2" align="center"><input type="checkbox" name="admin" value="true" /> ITD·ERSD部员认证</td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input type="submit" onclick="_hmt.push(['_trackEvent','register','new','test'])" value="提交"></td>
	</tr>
	<tr>
		<td colspan="2" align="center">请在此处<b>如实</b>填写个人资料<br>完成德育分个人系统认证<br>来获取你的德育分管理权<br>核验工作日为一天<br>ITD仅受理高一级的验证请求<br>*ERSD部员请勾选复选框<br><b>涉嫌破解该系统将会受到纪律检控</b></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><b>© 2018 ITD·LD .LLC</b></td>
	</tr>
</table>
</form>
<div align="center"></dir><button onclick="window.location.href='login.php'"><b>返回登录</b></button></div>
<?php include("footer.php"); ?>
</body>
</html>
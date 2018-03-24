<?php

require_once("sql.config.php");
require_once("base_utils.php");

if(isset($_POST) && $_POST){
	$name= $_POST['name'];
	$sid = $_POST['sid'];

	if ((checkstudent($sid)) != $name) die ("<script>alert('资料出错！'); window.location.href='listscore.php';</script>");

	$sql = "SELECT * FROM detail WHERE sid='$sid'";
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>ITD德育分查询页面</title>
<?php include("head.php"); ?>
</head>

<body>
	<form method="post">
		<table border="1" align="center">
			<tr>
				<th colspan="2">ITD德育分个人查询入口</th>
			</tr>
			<tr>
				<td align="center"><b>姓名</b></td>
				<td align="center"><input type="text" name="name" required="required"></td>
			</tr>
			<tr>
				<td align="center"><b>学号</b></td>
				<td align="center"><input type="text" name="sid" required="required"></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="submit" value="查询"></td>
			</tr>
			<tr>
				<td colspan="2" align="center">请在此键入你的<b>真实个人资料</b>开始查询<br>© ITD·LYJ 2018</td>
			</tr>
		</table>
	</form>
</body>
<?php include("footer.php"); ?>
</html>
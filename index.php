<?php

session_start([
		'gc_maxlifetime' => '86400',
		'cookie_lifetime' => '86400',
			]);

if (!isset($_SESSION['time'])) $_SESSION['time'] = 3;
//$_SESSION['time'] = debug ;

require("sql.config.php");
require("base_utils.php");

//统计
$rows= mysqli_fetch_assoc(mysqli_query($conn,"SELECT count(*) FROM detail"));
$rows = $rows['count(*)'];
$avg = mysqli_fetch_assoc(mysqli_query($conn,"SELECT avg(score) FROM students"));
$avg = $avg['avg(score)'];
$last = mysqli_fetch_assoc(mysqli_query($conn,"SELECT time FROM oper_record ORDER BY id DESC LIMIT 1"));
$last = $last['time'];

if(isset($_POST) && $_POST){

	if ($_SESSION['time'] < 1 ) die ("<script>alert('本日查询次数已用完!'); window.location.href='index.php';</script>");

	$name= $_POST['name'];
	$sid = $_POST['sid'];

	if ((checkstudent($sid)) != $name) die ("<script>alert('键入姓名与学号不匹配！\\n请重新输入!'); window.location.href='index.php';</script>");

	$sql = "SELECT * FROM detail WHERE sid='$sid'";
	$query = mysqli_query($conn,$sql);
	$rsnum = mysqli_num_rows($query);

	$sqltotal = "SELECT score FROM students WHERE sid='$sid'";
	$total = mysqli_fetch_assoc(mysqli_query($conn,$sqltotal));
	$total = $total['score'];

	--$_SESSION['time'];         //次数限制
}

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<title>ITD德育分查询页面</title>
<?php include("head.php"); ?>
</head>

<body>
	<form method="post">
		<table border="1" align="center">
			<tr>
				<th colspan="2" width=90%>广州市第三中学高一级德育分个人查询入口</th>
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
				<td colspan="2" align="center"><input type="submit" value="查询" onclick="_hmt.push(['_trackEvent', '查询', '基本查询'])"><button onclick="window.location.href='login.php'">部员登录</button></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><b>防止滥用,你今天还剩<font color="blue">&nbsp<?php echo $_SESSION['time'] ?>&nbsp</font>次查询机会</b></td>
			</tr>
			<tr>
				<td colspan="2" align="center">请在此键入你的<b>个人资料</b>开始查询<br>ITD拥有该系统最终解释权<br><b><font color="blue">阁下操作正在被记录</font><br><font color="red">任何破解该系统的行为将受到纪律检控</b></font></td>
			</tr>
			<tr>
				<?php 
				echo <<<EOT
				<td colspan="2" align="center"><b>系统统计</b><br>全级共<b><font color="blue">{$rows}</font></b>条记录||级平均分<b><font color="blue">{$avg}</font></b><br>最后更新于{$last}</td>
EOT;
				?>
			</tr>
			<tr>
				<td colspan="2" align="center"><a href="https://github.com/LYJSPEEDX/ITDMoral-Education-Management-SYS" onclick="_hmt.push(['_trackEvent', '周边', '查看github'])">ITD-MEMS V1.1β</a>&nbsp&nbsp©LYJ Solutions</td>
			</tr>
		</table>
	</form>

	<?php
	if (isset($total)) {
		echo <<<EOT
		<table border="1" align="center">
			<tr>
				<td align="center" colspan="5">以下为<b>{$name}(学号:{$sid})</b>的德育分事件记录<br>目前你的<b>总分</b>为<b>{$total}</b>分&nbsp&nbsp共检索到<b>{$rsnum}</b>条记录</td>
			</tr>
			<tr>
				<th>序号</th>
				<th width=20%>日期</th>
				<th width=20%>原因</th>
				<th>分数变动</th>
				<th>受理编号</th>
			</tr>
EOT;

		$id = 1;
		while ($out = mysqli_fetch_assoc($query)) {
			$schange = $out['schange'];
			$eventid = $out['ID'];

			$reasonre = processreason(2,$out['reason']);
			$m = $reasonre[0];
			$d = $reasonre[1];
			$reason = $reasonre[2];

			echo <<<EOT
			<tr>
				<td align="center">$id</td>
				<td align="center">{$m}月{$d}日</td>
				<td align="center">$reason</td>
				<td align="center">$schange</td>
				<td align="center">#Ed$eventid.X</td>
			</tr>
EOT;
			$id++;
		}
		echo <<<EOT
		<tr>
			<td colspan="5" align="center">你正在使用由ITD研发并维护的德育分查询系统</td>
		</tr>
		</table>
EOT;
	}

	?>
</body>
<!-- <?php include("footer.php"); ?> -->
</html>
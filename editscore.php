<?php

require('ckLog.php'); 
include('head.php');
include('nav.php'); 
require('sql.config.php');
require('base_utils.php');

if (isset($_POST) && $_POST){
	$evenid = $_POST['evenid'];
	$originalinfo= mysqli_fetch_assoc(mysqli_query($conn,"SELECT * FROM detail WHERE ID='$evenid'"));
	if (!isset($originalinfo)) die("<script> alert('不存在该事件号!');window.location.href='editscore.php';</script>");
	$sid = $originalinfo['sid'];      $schange = -$originalinfo['schange'];  $notereason = $sid."号的".$originalinfo['reason']."事件";
	echo "<script>var msg = '即将对{$sid}号学生进行记录删除\\n删除{$evenid}号事件\\n并{$schange}分\\n确定?  该记录只会表征性删除'; if(! confirm(msg)) window.location.href='editscore.php';</script>";

	mysqli_query($conn,"DELETE from detail WHERE ID='$evenid'");
	if(mysqli_query($conn,"UPDATE students SET score = score + '$schange' WHERE sid='$sid'")) $return = true;

	$operator = $_SESSION['sid'].$_SESSION['name'];
	oper_re($operator,"delevent",$evenid,$notereason);
}
?>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<form method="post">
	<table align="center" border="10">
		<tr>
			<th colspan="2">ERSD权限级删分入口</th>
		</tr>
		<tr>
			<td align="center">事件号</td>
			<td align="center"><input type="text" name="evenid"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" onclick="_hmt.push(['_trackEvent', '分数', '录入'])" value="更改"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><b><font color="blue">你正在进行最高权限操作<br>MEMS监测机制已启动</font></b></td>
		</tr>
	</table>
</form>

<?php 
if (isset($return)) echo "<b>{$operator}刚刚删除了一个记录,事件已经记录!</b>";
?>
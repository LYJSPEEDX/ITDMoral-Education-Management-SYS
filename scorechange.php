<?php
/*
Process Score Change
Author : LD and U!
*/

require_once("ckLog.php");
require("sql.config.php");
require("base_utils.php");

if(isset($_POST) && $_POST ){
	$sid=$_POST['sid'];
	$s=$_POST['s'];
	$reason = $_POST['reason'];
	
	//对学号、操作、原因进行验证
	if (strlen($reason) <6 || !processreason(1,$reason))  die ("<script>alert('日期原因参数出错！');window.location.href='scorechange.php'</script>");
	if (isexist($sid)){
		$output = processinputstr($s);
		$action = $output[0];
		$number = $output[1];
		if ($action == 3 )
			die("<script>alert('分数参数出错！\\n不符合分数操作规则！');alert('分数参数出错！\\n不符合分数操作规则！');window.location.href='scorechange.php';</script>");
	}else{
		die("<script>alert('学号输入出错！\\n该学生不存在！');alert('学号输入出错！\\n该学生不存在！');window.location.href='scorechange.php';</script>");
	}

	//核对变量生成
	$check = checkstudent($sid);
	$action = ($action == 1)? "加" : "减";  
	$num = abs($number);

  	//最终核对
        echo "<script>
        var msg = '即将对 $check (学号:  $sid )的分数进行修改 \\n操作如下:\\n以 $reason 的原因\\n$action  $num 分\\n确定？\\n注:该操作将被记录！'; 
        if(!confirm(msg)) alert('请联系管理部门进行操作回滚!');</script>";
	

        //数据库操作
        $sqldetail= "INSERT INTO detail (sid,reason,schange) VALUES('$sid','$reason','$number')";
	$sqltotal = "UPDATE students SET score = score+'$number'  WHERE sid = '$sid'";
	if (mysqli_query($conn,$sqltotal) && mysqli_query($conn,$sqldetail)) {
		$action = $action."操作成功";
		$evenid = mysqli_fetch_array(mysqli_query($conn,"SELECT max(ID) from detail"),MYSQLI_NUM);      //获取evenid
		$evenid = $evenid[0];
	}else{
			die("<script>alert('严重错误!!');alert('严重错误,请联系管理部门!!');window.location.href='scorechange.php';</script>");
		}

	//记录操作
	$operator = $_SESSION['sid'].$_SESSION['name'];
	oper_re($operator,"scorechange",$evenid);
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<title>ITD德育分插入面板</title>
<?php include("head.php");  ?>
</head>
<body>
<form method="post">
	<table border="5" align="center">
		<th colspan="2">德育分更改入口</th>
		<tr>
			<th>学号</th>
			<td align="center"><input type="text" name="sid"></td>
		</tr>
		<tr>
			<th>分数修改</th>
			<td align="center"><input type="text" name="s"></td>
		</tr>
		<tr>
			<th>日期原因</th>
			<td align="center"><input type="text" name="reason"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" onclick="_hmt.push(['_trackEvent', '分数', '录入'])" value="确定"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><b>扣分输入'-'，单次变动≤20分</b></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><b><font color="blue">ITD权限监测系统：<br>阁下操作正在被记录，请自重！</font></b></td>
		</tr>
	</table>
</form>
<?php
 if (isset($action))echo " <font color='red'>DEBUG INFO: action: |$action|          number: |$number|</font>";    //debug
?>

</body>
</html>

<meta charset="utf-8">
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
	
	//对学号、操作、原因进行第一次验证
	if (strlen($reason) <6 || !processinputreason(1,$reason))  die ("<script>alert('日期原因参数出错！');window.location.href='scorechange.php'</script>");
	if (isexist($sid)){
		$output = processinputstr($s);
		$action = $output[0];
		$number = $output[1];
		if ($action == 3 )
			die("<script>alert('分数参数出错！\\n不符合分数操作规则！');window.location.href='scorechange.php';</script>");
	}else{
		die("<script>alert('学号输入出错！\\n该学生不存在！');window.location.href='scorechange.php';</script>");
	}

	//核对变量生成
        $check = checkstudent($sid);
  	$check = $check['name'];  
  	$action = ($action == 1)? "加" : "减";  
  	$num = abs($number);

  	//最终核对
        echo "<script>
        var msg = '即将对 $check (学号:  $sid )的分数进行修改 \\n操作如下:\\n以 $reason 的原因\\n$action  $num 分\\n确定？\\n注:该操作将被记录！'; 
        if(! confirm(msg)) window.location.href='scorechange.php';
        </script>";

        //数据库操作
        $sqldetail= "INSERT INTO detail (sid,reason,schange) VALUES('$sid','$reason','$number')";
	$sqltotal = "UPDATE students SET score = score+'$number'  WHERE sid = '$sid'";
	if (mysqli_query($conn,$sqltotal) && mysqli_query($conn,$sqldetail)) {
		$action = $action."操作成功";}else{
			$action = $action."最终操作失败";
		}
}
?>

<!DOCTYPE html>
<html>
<head>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>ITD德育分插入面板</title>
</head>
<body>
<?php 
	include("nav.php");
?>
<form method="post">
<table border="1" align="center">
<tr>
		<th>操作学号</th>
		<th>修改分数</th>
		<th>日期及原因</th>
</tr>
<tr>
		<td align="center"><input type="text" name="sid"></td>
		<td align="center"><input type="text" name="s"></td>
		<td align="center"><input type="text" name="reason"></td>
</tr>
<tr>
		<td colspan="3" align="center"><input type="submit" value="确定"></td>
</tr>
<tr>
	<td colspan="3" align="center"><b>注意：扣分请输入'-'，单次分数变动不可大于20分！</b></td>
</tr>
<tr>
	<td colspan="3" align="center"><b>警示：日期格式为mmdd，即1月1日为0101！日期只可占前四位！</b></td>
</table>
</form>
<?php
 if (isset($action))echo " DEBUG INFO: action: |$action|          number: |$number|<br>";    //debug
?>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
<?php include("head.php");  ?>  <!--引入必要css js-->
</head>

<body>
<?php
require("sql.config.php");
require("base_utils.php");
session_start();
islog('admin');
//初始化操作人
$operator = $_SESSION['sid'].$_SESSION['name'];

if(isset($_POST['sid']) && $_POST['sid'] ){
	$sid=$_POST['sid'];
	$score=$_POST['score'];
	$reason = $_POST['reason'];
	
   //数据库操作
  $sqldetail= "INSERT INTO detail (sid,reason,schange) VALUES('$sid','$reason','$score')";
	$sqltotal = "UPDATE students SET score = score+'$score'  WHERE sid = '$sid'";
	if (mysqli_query($conn,$sqltotal) && mysqli_query($conn,$sqldetail)) {
		$action = "操作成功";
		$evenid = mysqli_fetch_array(mysqli_query($conn,"SELECT max(ID) from detail"),MYSQLI_NUM);      //获取evenid
		$evenid = $evenid[0];
	}else{
			die("<script>alert('严重错误!!');alert('严重错误,请联系管理部门!!');window.location.href='index.php';</script>");
		}

	//记录操作
	oper_re($operator,"scorechange",$evenid);
	echo"<script>alert('操作完成，不要刷新！');</script>";
}

?>

<div class="container" style="max-width: 850px;">
	<h4>Staff Console</h4>
	<?php echo"<h6><span class='badge badge-success'>登入为：{$operator} 按照该身份计算回报</span></h6>";?>
	<div class="alert alert-danger" role="alert" style="font-size: 15px; padding: 8px" ><strong>请勿屏蔽提示框，否则你将无法录入<br>永远不要尝试刷新本页面包括F5键，否则将引发严重故障！</strong></div>
	<div class='alert alert-primary' role="alert" style="font-size: 15px; padding: 8px">此处为事件创建录入页面<br><strong>请仔细核对资料，错误可取消！<br>本页面有ITDMEMS权限记录</strong></div>
	<form method="POST" id="staffform" onsubmit="return staffsubmit()">	
		<fieldset class="form-group">
			<label>学号</label>
			<input type="text" class="form-control" name="sid" id="sid" placeholder="请务必反复核对">
		</fieldset>
		<fieldset class="form-group">
			<label>分数修改</label>
			<input type="text" class="form-control" name="score" id="score" placeholder="扣分加-减号前缀，加分无需">
		</fieldset>
		<fieldset class="form-group">
			<label>日期和原因</label>
			<input type="text" class="form-control" name="reason" id="reason" placeholder="四位日期+中文原因字符串">
		</fieldset>
		<button type="submit" class="btn btn-primary btn-block">提交执行</button>
	</form>
</div>


</body>
</html>

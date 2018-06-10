<head>
	<?php include('head.php'); ?>
</head>

<body>
	<?php 
	require('sql.config.php');
	require('base_utils.php');
	session_start();
	islog('admin');
	
	$operator = $_SESSION['sid'].$_SESSION['name'];
	if(isset($_POST['eventid']) && $_POST['eventid'] ){
		$post = explode("&",$_POST['eventid']);
		$eventid = $post[0];  $sid = $post[1];  $schange = $post[2]; $reason= $post[3];

		mysqli_query($conn,"DELETE from detail WHERE ID='$eventid'");
		if (mysqli_query($conn,"UPDATE students SET score = score + '{$schange}' WHERE sid='{$sid}'")) echo "<script>alert('删除成功，不要刷新！');</script>"; 

		oper_re($operator,"delevent",$eventid,$reason);
	} 
	?>

	<div class="container" style="max-width: 500">
		<h4>部员事件删除页面</h4>

		<?php echo"<h6><span class='badge badge-success'>登入为：{$operator} 激活权限监控</span></h6>";?>

		<div class="alert alert-danger" role="alert" style="font-size: 15px; padding: 8px" ><strong>请勿屏蔽提示框，否则你将无法录入<br>永远不要尝试刷新本页面包括F5键，否则将引发严重故障！</strong></div>

		<div class='alert alert-primary' role="alert" style="font-size: 15px; padding: 8px">此处为事件删除页面，适用于多扣/多加/回滚等操作<br><strong>请仔细核对资料，错误可取消！<br>本页面有ITDMEMS权限记录</strong></div>

		<form method="POST" id="staffdelevent" onsubmit="return staffdelsubmit()">	
			<fieldset class="form-group">
				<label>事件号 EVENTID</label>
				<input type="text" class="form-control" name="eventid" id="eventid" placeholder="1-4位，无需补0⃣">
				<small class="form-text text-muted">此处请打入纯数字事件号</small>
			</fieldset>
			<button type="submit" class="btn btn-primary btn-block">删除事件</button>
		</form>
	</div>
</body>
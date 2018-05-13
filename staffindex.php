<!DOCTYPE html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,user-scalable=no">
<title>ITD德育分插入面板</title>
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
	oper_re($operator,"scorechange",$evenid);
}
?>

<!-- 导航栏 -->
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="">三中高一ITD德育系统</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link" href="index.php">公众查询 <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="adlogin.php">部员系统</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="telogin.php">教师系统</a>
			</li>
			<li class="nav-item dropdown">
        			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多</a>
        			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
          				<a class="dropdown-item" href="https://github.com/LYJSPEEDX/ITDMoral-Education-Management-SYS">系统开源</a>
          				<a class="dropdown-item" href="#">关注我们</a>
        			</div>
      			</li>
      			<li class="nav-item">
        			<a class="nav-link disabled">ITD-MEMS V2.0α</a>
      			</li>
		</ul>
	</div>
</nav>
<!-- =============================================== -->
<div class="container" style="max-width: 850px;">
	<h4>Staff Console</h4>
	<?php echo"<h6><span class='badge badge-success'>登入为：{$operator} 已经通过权限认证</span></h6>";?>
	<div class='alert alert-danger' role="alert">此处为事件创建录入页面<br>你所触发的每次事件将会被<strong>立即执行并记录</strong></div>
	<form method="POST">	
		<fieldset class="form-group">
			<label>学号</label>
			<input type="text" class="form-control" name="sid" placeholder="请务必反复核对">
		</fieldset>
		<fieldset class="form-group">
			<label>分数修改</label>
			<input type="text" class="form-control" name="s" placeholder="扣分加-减号前缀，加分无需">
		</fieldset>
		<fieldset class="form-group">
			<label>日期和原因</label>
			<input type="text" class="form-control" name="reason" placeholder="四位日期+中文原因字符串">
		</fieldset>
		<button type="submit" class="btn btn-primary btn-block">提交执行</button>
	</form>
</div>

<?php
 if (isset($action))echo " <font color='red'>DEBUG INFO: action: |$action|          number: |$number|</font>";    //debug
?>

</body>
</html>

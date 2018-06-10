<!doctype html>
<html>
<head>
	<?php
	 include('head.php'); 
					//初始化查询
				if (!isset($_COOKIE['time'])) {
					setcookie("time", 3,time()+86400);
					echo  "<script>window.location='public.php';</script>";
				}
	?>

<!--modal-->
<div class="modal fade" id="inputerror" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">OOPS...</h5>
      </div>
      <div class="modal-body">
        输入有误，请核查你的个人资料！
      </div>
      <div class="modal-footer">
        <a class="btn btn-primary" href="index.php">重新输入</a>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="timeerror" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">OOPS...查询被阻止</h5>
      </div>
      <div class="modal-body">
       你今日查询次数已用完，明天再来吧！
      </div>
      <div class="modal-footer">
      	<a class="btn btn-secondary btn-sm" href="public.php">好的</a>
        <a class="btn btn-primary btn-sm" href="index.php">返回首页</a>
      </div>
    </div>
  </div>
</div>
<!-- ============================================================== -->
</head>

<body>
<?php
require("sql.config.php");
require("base_utils.php");


if(isset($_POST) && $_POST){

	if ($_COOKIE['time'] < 1 ) die ("<script>$('#timeerror').modal();</script>");  //次数超过限制

	$name= $_POST['name'];
	$sid = $_POST['sid'];

	if ((checkstudent($sid)) != $name) die ("<script>$('#inputerror').modal();</script>");  //输入错误

	$sql = "SELECT * FROM detail WHERE sid='$sid' ORDER BY ID DESC";
	$query = mysqli_query($conn,$sql);
	$rsnum = mysqli_num_rows($query);

	$sqltotal = "SELECT score FROM students WHERE sid='$sid'";
	$total = mysqli_fetch_assoc(mysqli_query($conn,$sqltotal));
	$total = $total['score'];

	--$_COOKIE['time'];
	setcookie("time", $_COOKIE['time']);       //次数限制
}
?>


<div class="container" style="max-width: 850px;">
<div class="container">
	<h4>公众德育分查询</h4>
	<?php echo"<div class='alert alert-warning' role='alert' style='font-size: 15px; padding: 8px'>你享有3次/天的查询机会<br>你今天还剩<strong>{$_COOKIE['time']}</strong>次机会<br><strong>请勿尝试破解该系统</strong></div>"; ?>	

	<form method="POST"  style="padding-bottom: 20px">	
		<fieldset class="form-group">
			<label>姓名</label>
			<input type="text" class="form-control" name="name" placeholder="请准确输入,用于隐私验证">
		</fieldset>
		<fieldset class="form-group">
			<label>学号</label>
			<input type="text" class="form-control" name="sid" placeholder="班级+学号四位形式">
		</fieldset>
		<button type="submit" class="btn btn-primary btn-block">查询</button>
	</form>
</div>

 <?php
	if (isset($total)) {
		echo <<<EOT
		<div class="container" style="padding-top: 20px">
		<div class="card border-dark text-center" >
  			<div class="card-body" style="padding: 0.5rem; font-size: 15px; ">
    				<p class="card-text">姓名: <strong>{$name}</strong>&nbsp&nbsp&nbsp学号: <strong>{$sid}</strong><br>总分: <strong>{$total}</strong>&nbsp&nbsp&nbsp记录数: <strong>{$rsnum}</strong></p>
  			</div>
		</div>

EOT;
		echo <<<EOT
		<div class="container" style="padding:4px"></div>
		<table class="table table-sm table-bordered table-striped" style="text-align: center; ">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>日期</th>
				<th>原因</th>
				<th>变动</th>
				<th>受理编号</th>
			</tr>
			</thead>
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
				<td>$id</td>
				<td>{$m}月{$d}日</td>
				<td>$reason</td>
				<td>$schange</td>
				<td>#Ed$eventid.X</td>
			</tr>
EOT;
			$id++;
		}
		echo <<<EOT
		</table>
		</div>
EOT;
	}
?>
<span id="donate"></span>

<div class="card text-white bg-primary" >
  <div class="card-body" style="padding:1rem">
    <h4 class="card-title">谢谢你！</h4>
    <p class="card-text" style="font-size: 15px">ITD研发的德育系统已经陪大家走过了大半个年头，我们兢兢业业、任劳任怨的部员也为同学们累计录入了超过3300+张表<br>然而，ITD每个月都要承担高昂的研发和服务器费用，如果你对ITD的服务感到满意，何不拿出你的小小心意，捐赠我们的运营费用呢～<br><br><strong>我们会随机给捐赠的小伙伴发送德育分礼包哦！</strong></p>
    <a href="Donate.JPG" class="btn btn-warning">*^O^*马上支持！</a>
  </div>
</div>
<br>
<p align="center">ITDEMEMS_V2.1 © 2018 ITD<br>ITD对所有访客及数据保留所有权限</p>
</div>
</body>
</html>
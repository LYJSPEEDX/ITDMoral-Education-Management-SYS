<!doctype html>
<html>
<head>
	<?php include('head.php'); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no,user-scalable=no">
	<title>ITD德育分系统</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
	body{padding-top: 70px;}
	</style>
</head>

<body>
<?php
require("sql.config.php");
require("base_utils.php");

if (!isset($_COOKIE['time'])) {
	setcookie("time", 3,time()+86400);
	echo  "<script>window.location='index.php';</script>";
}

//统计
$rows= mysqli_fetch_assoc(mysqli_query($conn,"SELECT count(*) FROM detail"));
$rows = $rows['count(*)'];
$avg = mysqli_fetch_assoc(mysqli_query($conn,"SELECT avg(score) FROM students"));
$avg = $avg['avg(score)'];
$last = mysqli_fetch_assoc(mysqli_query($conn,"SELECT time FROM oper_record ORDER BY id DESC LIMIT 1"));
$last = $last['time'];

if(isset($_POST) && $_POST){

	//if ($_COOKIE['time'] < 1 ) die ("<script>alert('本日查询次数已用完!'); window.location.href='index.php';</script>");

	$name= $_POST['name'];
	$sid = $_POST['sid'];

	if ((checkstudent($sid)) != $name) die ("<script>alert('键入姓名与学号不匹配！\\n请重新输入!'); window.location.href='index.php';</script>");

	$sql = "SELECT * FROM detail WHERE sid='$sid'";
	$query = mysqli_query($conn,$sql);
	$rsnum = mysqli_num_rows($query);

	$sqltotal = "SELECT score FROM students WHERE sid='$sid'";
	$total = mysqli_fetch_assoc(mysqli_query($conn,$sqltotal));
	$total = $total['score'];

	--$_COOKIE['time'];
	setcookie("time", $_COOKIE['time']);       //次数限制
}
?>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
	<a class="navbar-brand" href="#">ITD德育系统公众查询</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarCollapse">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="index.php">公众查询 <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">教师系统</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">部员系统</a>
			</li>
			<li class="nav-item dropdown">
        			<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">更多</a>
        			<div class="dropdown-menu" aria-labelledby="navbarDropdown">
          				<a class="dropdown-item" href="#">系统后台数据</a>
          				<div class="dropdown-divider"></div>
          				<a class="dropdown-item" href="#">系统开源</a>
          				<a class="dropdown-item" href="#">关注我们</a>
        			</div>
      			</li>
      			<li class="nav-item">
        			<a class="nav-link disabled" href="#">ITD-MEMS V2.0α</a>
      			</li>
		</ul>
	</div>
</nav>

<div class="container">
	<div class="alert alert-warning" role="alert">你享有3次/天的查询机会</div>	

	<form method="POST">
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
		<table class="table table-sm table-bordered table-striped" style="text-align: center">
		<thead class="thead-dark">
			<tr>
				<th>#</th>
				<th>日期</th>
				<th>原因</th>
				<th>分数变动</th>
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

</body>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
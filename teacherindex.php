<html>
	<head>
	<?php include('head.php'); ?>
  	</head>

<?php
require('base_utils.php');
require('sql.config.php');
session_start();
islog('teacher');
$operator = $_SESSION['name'];

if (isset($_SERVER["QUERY_STRING"]) && $_SERVER["QUERY_STRING"]){
	parse_str($_SERVER["QUERY_STRING"],$class);
	$class = sprintf("%02d",$class['c']);//补成两位数的整数形式
	$show = true;

	$sqldetail="SELECT * FROM detail WHERE sid LIKE '{$class}__' ORDER BY ID DESC";
	$rows = mysqli_num_rows(mysqli_query($conn,$sqldetail));
	$resultdetail = mysqli_query($conn,$sqldetail);

	$sqltotal = "SELECT * FROM students WHERE sid LIKE '{$class}__'";
	$resulttotal = mysqli_query($conn,$sqltotal);
	$num = 0;  $total=0;
	while ($value = mysqli_fetch_assoc($resulttotal)) {
		$total = $total + $value['score'];
		$num++;
	}
	$avg = $total / $num;
	$avg = sprintf("%.4F",$avg);
}
?>
	<body>
		
		<span id="top" ></span>
		<div class="container" style="max-width: 850px;">
			<h4>教师班级查询页面</h4>
			<?php echo"<h6><span class='badge badge-success'>欢迎您！尊敬的{$operator}教师 已通过权限认证</span></h6>";?>
			<div class="alert alert-primary" role="alert" style="font-size: 15px; padding: 8px">高一级ITD欢迎您的到访！<br>在这里，您可以以班级为单位查询德育分信息，并获取详细信息。<br>如需任何协助，请在高一级公众号内留言即可
			</div>
			<div class="alert alert-info" role="alert">
  			<strong>教师端因输出信息量大，建议使用电脑访问。我们已为您设计了上方的快捷跳跃按钮。<br>我们建议你使用搜索功能过滤特定数据</strong>
			</div>
			<div class="alert alert-danger" role="alert"><strong>提示：任何时候，请您切勿将阁下账号分享给任何人，包括级内任何学生。<br>此举出于系统安全之考虑，感谢您的配合！任何疑问，您可于公众号留言ITD。</strong>
			</div>

			<div class="dropdown show">
  			<a class="btn btn btn-primary btn-lg btn-block dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    			选择班级
 			 </a>

  			<div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="min-width: 100%;text-align: center;">
  			<div class="row">
  				<div class="col">
					<a class="dropdown-item" href="?c=1">1班</a>
				</div>
				<div class="col">
   					 <a class="dropdown-item" href="?c=2">2班</a>
				 </div>
				 <div class="col">
   			 		<a class="dropdown-item" href="?c=3">3班</a>
		 		</div>
	 		</div>
	 		<div class="row">
  				<div class="col">
					<a class="dropdown-item" href="?c=4">4班</a>
				</div>
				<div class="col">
   					 <a class="dropdown-item" href="?c=5">5班</a>
				 </div>
				 <div class="col">
   			 		<a class="dropdown-item" href="?c=6">6班</a>
		 		</div>
	 		</div><div class="row">
  				<div class="col">
					<a class="dropdown-item" href="?c=7">7班</a>
				</div>
				<div class="col">
   					 <a class="dropdown-item" href="?c=8">8班</a>
				 </div>
				 <div class="col">
   			 		<a class="dropdown-item" href="?c=9">9班</a>
		 		</div>
	 		</div><div class="row">
  				<div class="col">
					<a class="dropdown-item" href="?c=10">10班</a>
				</div>
				<div class="col">
   					 <a class="dropdown-item" href="?c=11">11班</a>
				 </div>
				 <div class="col">
   			 		<a class="dropdown-item" href="?c=12">12班</a>
		 		</div>
	 		</div>
	 		<div class="row">
	 			<div class="col"><a class="dropdown-item" href="teacherindex.php">清空</a>
				</div>
			</div>
  			</div>
			</div>

		<div class="container" style="padding: 10px;"></div>

		<div class="container" id="输出数据">
			<?php
			if (isset($show)){
				echo <<<EOT
				<div class="card border-dark text-center">
					<div class="card-body" style="padding:0.5rem;font-size=15px;">
						<p class="card-text">正在展示<font color="blue">{$class}班</font>的德育分详情&nbsp&nbsp班级有<font color="blue">{$num}</font>位学生<br>共有<font color="blue">{$rows}条</font>事件被记录&nbsp&nbsp<font color="blue">该班平均分：{$avg}</font></p>
					</div>
				</div>
				<table class="table table-sm table-bordered table-striped" style="text-align:center;">
				<thead class="thead-dark">
					<tr>
						<th colspan="3">班级总分一览表</th>
					</tr>
					<tr>
						<th>学号</th>
						<th>姓名</th>
						<th>总分</th>
					</tr>
				</thead>
EOT;
				mysqli_data_seek($resulttotal,0);
				while ($out = mysqli_fetch_assoc($resulttotal)) {
					$sid = $out['sid'];
					$name = $out['name'];
					$score=$out['score'];

					echo <<<EOT
					<tr>
						<td>$sid</td>
						<td>$name</td>
						<td>$score</td>
					</tr>
EOT;
				}
				echo <<<EOT
				</table>
				<span id="detail"></span>
				<table class="table table-sm table-bordered table-stiped" style="text-align:center;">
				<thead class="thead-dark">
					<tr>
						<th colspan="6">班级所有事件查看</th>
					</tr>
					<tr>
						<th>受理号</th>
						<th>学号</th>
						<th>姓名</th>
						<th>日期</th>
						<th>原因</th>
						<th>变动</th>
					</tr>
				</thead>
EOT;
				while ($out = mysqli_fetch_assoc($resultdetail)){
					$evenid = $out['ID'];
					$sid = $out['sid'];
					$name = checkstudent($sid);

					$reasonre = processreason(2,$out['reason']);
					$m = $reasonre[0];
					$d = $reasonre[1];
					$reason = $reasonre[2];

					$schange = $out['schange'];

					echo <<<EOT
					<tr>
						<td>#Ed$evenid.X</td>
						<td>$sid</td>
						<td>$name</td>
						<td>{$m}月{$d}日</td>
						<td>$reason</td>
						<td>$schange</td>
					</tr>
EOT;
				}
				echo "</table>";
			}
			?>
		</div id="输出数据">
		</div>
	</body>
</html>

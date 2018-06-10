<head>
    <?php include('head.php'); ?>
    <script src="https://cdn.bootcss.com/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <title>ITD德育系统™</title>
</head>

<body>
<div class="container" style="max-width: 850px;">
<h3>&nbspITDMEMS</h3>
<h5 align="right">三中高一德育分管理系统&nbsp&nbsp&nbsp</h5>
<div class="alert alert-info" role="alert" style="font-size: 15px; padding: 8px">
    欢迎造访由ITD研发的德育分系统<br>
  <?php 
   require("sql.config.php");
    $rows= mysqli_fetch_assoc(mysqli_query($conn,"SELECT count(*) FROM detail"));
    $rows = $rows['count(*)'];
    echo "系统运行至今，目前存表<strong>{$rows}</strong>份<br>";
    $last = mysqli_fetch_assoc(mysqli_query($conn,"SELECT time FROM oper_record ORDER BY id DESC LIMIT 1"));
    $last = $last['time'];
    echo "最新资料更新于<strong>{$last}</strong><br>";
    ?>
    <a href="public.php">点击我进行查分</a>
    <a href="public.php#donate"><strong>谢谢你专题活动</strong></a>
</div>
<canvas id="myChart" width="250" height="300"></canvas>
<script>
var avg = getavg();
var min = (Math.min.apply(null,avg)) - 5;
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
    type: 'horizontalBar',
    data: {
        labels: ["级平均", "一班", "二班", "三班", "四班", "五班","六班","七班","八班","九班","十班","十一班","十二班"],
        datasets: [{
            label: '高一级德育平均分统计',
            data: [avg[12], avg[0], avg[1], avg[2], avg[3], avg[4],avg[5],avg[6],avg[7],avg[8],avg[9],avg[10],avg[11]],
            backgroundColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 99, 132, 0.2)'          
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255,99,132,1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            xAxes: [{
                ticks: {
                    min: min
                }
            }]
        }
    }
});
</script>
<p align="center">ITDEMEMS_V2.1 © 2018 ITD<br>ITD对所有访客及数据保留所有权限</p>
</div>
</body>
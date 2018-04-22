<meta charset="utf-8">
<?php



session_start();

session_destroy();

echo "<script>alert('您已登出系统！');window.location.href='index.php';</script>";

?>
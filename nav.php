<style type="text/css">
.list1 ul{overflow: hidden;background-color: #66FFFF;}
.list1 li{float: left;list-style-type: none;font-weight: bold;font-size: 20px;}
.list1 a{
  display: block;
  padding: 0 12px;
  text-decoration: none;
  color: #9933cc;
}
.list1 li+li a{border-left: 1px solid #aaa;}
.list1 a:hover{color: red;}
</style>


<meta charset="utf-8">
<!--在HTML内嵌入PHP代码-->
  <nav class="list1">
    <ul>
      <li><?php echo  $_SESSION['name']." 用户";?></li>
      <li><a href="list.php">预览层</a></li>
      <li><a href="scorechange.php">操作分数</a></li>
      <li><a href="out.php">注销</a></li>
    </ul>
  </nav>
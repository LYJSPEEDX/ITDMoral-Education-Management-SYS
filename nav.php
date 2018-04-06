<style type="text/css">
.list1 ul{overflow: hidden;background-color: #0099FF;}
.list1 li{float: left;list-style-type: none;font-weight: bold;font-size: 16px;}
.list1 a{
  display: block;
  padding: 0 16px;
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
      <li><?php echo  $_SESSION['name']." 用户";?>&nbsp&nbsp</li>
      <li><a href="scorechange.php">录分</a></li>
      <li><a href="editscore.php">修改事件</a></li>
      <li><a href="out.php">注销</a></li>
    </ul>
  </nav>
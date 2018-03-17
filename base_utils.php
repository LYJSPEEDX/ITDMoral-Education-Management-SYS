<?php
/*Custom Function Repository of ITD
Author : LD and more
*/

//原因处理函数
function processinputreason($action,$reason){
	if ($action ==1){
	$month = substr($reason, 0,2);
	$day = substr($reason, 2,2);
	$check = substr($reason, 4,1);
	//die ("<script>alert(' $check ');</script>");
	if (1<= (int)$month && (int)$month<=12 && 1<=(int)$day && (int)$day<=31 && $check !=" ") return true; else return false;
	}else{
		return substr($reason,0,4);          //可返回日期
	}
}

//显示学生姓名  核对函数
function checkstudent($sid){
	require("sql.config.php");
	$sql = "SELECT name FROM students WHERE sid = '$sid'";
	return (mysqli_query($conn,$sql));
}


//判断学号对应的学生是否存在
function isexist($sid){
	require("sql.config.php");  //不可用once，否则会出错
	$sql = "SELECT  sid FROM students WHERE sid='$sid'";
	$query=mysqli_query($conn,$sql);
	if (mysqli_num_rows($query) == 0){
		return 0;
	}else{
		return 1;
	}
}


//对输入的分数字符串进行检验和处理 
function processinputstr($s){ 							
	if ( strlen($s)  ==  0 ){
		return array(3,null); 								//判断是否为空
	}
	$check = substr($s, 0,1);
   	switch ($check){ 
		case "-":
	    		$num = (int)$s;
	    		$action = 2;                               					 //2为做减法
	    		break;
    		case "+":
    		case (is_numeric($check)):
    			$num = (int)$s;
    			$action = 1;                               					//1为做加法
    			break;                                     
		default:
	    		$action = 3; 								//3为异常码
	    		$num = null;
	    		break;
    	}
    	if  (  $num == 0 || abs($num) >20 ){
    		$action = 3;			
    		$num = null;
    	}
    	return array($action,$num);               					 //输出操作代码和操作数
}


?>
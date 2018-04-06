<?php
/*Custom Function Repository of ITD
Author : LD and more
*/

//操作记录函数
function oper_re($operator,$action,$evenid,$note = null){
	require("sql.config.php");
	switch($action){
		case "scorechange":
			$sql = "INSERT INTO oper_record (operator,evenid) VALUES ('$operator','$evenid')";
			mysqli_query($conn,$sql);
			break;
		case "delevent":
			$evenid = "DEL".$evenid;
			$sql = "INSERT INTO oper_record(operator,evenid,note) VALUES ('$operator','$evenid','$note')";
			mysqli_query($conn,$sql);
			break;
	}
}

//是否已经注册检验
function checkreg($sid){
	require("sql.config.php");
	$sql = "SELECT * FROM user WHERE sid = '$sid'";
	if (mysqli_num_rows(mysqli_query($conn,$sql)) == 0) return false; 
		else return true;
}

//原因处理函数   1为格式检验布尔  2为日期分割
function processreason($action,$reason){
	if ($action ==1){
	$month = substr($reason, 0,2);
	$day = substr($reason, 2,2);
	$check = substr($reason, 4,1);           //不允许日期后紧贴一个空格,防止输出混乱
	if (1<= (int)$month && (int)$month<=12 && 1<=(int)$day && (int)$day<=31 && $check !=" ") return true; else return false;
	}

	if ($action == 2){
		$m = (int)substr($reason, 0,2);
		$d = (int)substr($reason, 2,2);
		$res = substr($reason, 4); 
		return array($m,$d,$res);
	}
}

//返回学生姓名  核对姓名与学号绑定关系函数
function checkstudent($sid){
	require("sql.config.php");
	$sql = "SELECT name FROM students WHERE sid = '$sid'";
	$result = mysqli_fetch_assoc(mysqli_query($conn,$sql));
	return $result['name'];
}


//判断学号对应的学生是否'存在'   适用于无姓名的时候
function isexist($sid){
	require("sql.config.php");  //不可用once，否则会出错
	$sql = "SELECT  sid FROM students WHERE sid='$sid'";
	$query=mysqli_query($conn,$sql);
	if (mysqli_num_rows($query) == 0){
		return false;
	}else{
		return true;
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
//删除事件-表单处理
function staffdelsubmit(){
	var eventid = document.getElementById('eventid').value;

	if (!(/^\d{1,4}$/.test(eventid))) {
		alert('事件号格式错误');
		return false;
	}

	//检查eventid
	var checkevent = new XMLHttpRequest();
	checkevent.open("GET","base_utils.php?mode=eventcheck&eventid=" + eventid,false);
	checkevent.send();

	var result = checkevent.responseText;
	if ( result== "false") {
		document.getElementById('eventid').value='';
		alert('事件不存在！\n请校对!');
		return false;
	}

	result = result.split("&");
	var msg = "你即将删除以下学生的事件\n姓名：" + result[0] + "\n学号：" + result[2] + "\n目前总分：" + result[1] + "\n要删除的事件号：" + eventid 
	+ "\n该事件详情为：" + result[3] + "\n即将发生的分数变动：" + result[4] + "\n确定吗？";
	var c=confirm(msg);

	if (c==false) {
		document.getElementById('eventid').value='';
		alert('已经取消');
		return false;
	} else {
		document.getElementById('eventid').value = eventid + "&" + result[2] + "&" + result[4] + "&" + result[3];   //通过表单将操作细节传给后端，简化sql
		return true;
	}
}

//首页 取得平均分于baseutils
function getavg(){
	var avg = new XMLHttpRequest();
	avg.open("GET","base_utils.php?mode=classavg",false);
	avg.send();

	var avgreturn = avg.responseText;
	avgreturn = avgreturn.split("&");
	return avgreturn;
}

//增加事件 表单错误清空函数
function formerror(mode,notice){
	switch(mode){
		case "sid":
			document.getElementById('sid').value='';
			break;
		default:
			document.getElementById('sid').value='';
			document.getElementById('score').value='';
			document.getElementById('reason').value='';
			break;
	}
	alert(notice);
	return false;
}

//增加事件-表单处理
function staffsubmit(){
	var sid = document.getElementById('sid').value;
	var score = document.getElementById('score').value;
	var reason = document.getElementById('reason').value;
	
 	check = true;

	if (sid.length != 4|| score.length == 0 || reason < 5 ) check=false; else
		if (Math.abs(score) > 20) check = false;  else
			if (reason.substr(0,2) > 12 || reason.substr(0,2) <0 || reason.substr(2,2) >31 || reason.substr(2,2) <0 ) check=false;

	if (!check) formerror("","参数格式错误！ \n请排查学号 分数修改 及日期原因三个格式！\n分数改动每次20分未上限"); else alert("格式审核通过\n下面开始录入审核程序，请仔细校对\n如资料有误，请按取消键取消提交！");

	//开始学号校对
	var studentname = new XMLHttpRequest();
	studentname.open("GET","base_utils.php?mode=check&sid=" + sid,false);
	studentname.send();

	var name  = studentname.responseText;
		if (name == "false") formerror("sid","学生不存在！请校对");

	//显示对话框
	var msg  = "你即将进行以下操作\n学号:" + sid + "\n姓名:" + name + "\n分数变动:" + score + "\n日期原因:" + reason + "\n请校对，正确则点击确定录入，不正确请按取消！\n已经纳入权限监测";
	var c=confirm(msg);
	if (c==false) formerror("","已取消操作"); else return true;
}


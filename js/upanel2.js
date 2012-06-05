﻿inittips();
function inittips(){
	document.getElementById('upanel-u-btn_home').addEventListener("click",go_home,false);
	document.getElementById('upanel-u-btn_info').addEventListener("click",go_info,false);
	document.getElementById('upanel-u-btn_group').addEventListener("click",go_group,false);
	document.getElementById('upanel-u-btn_project').addEventListener("click",go_project,false);
	document.getElementById('upanel-u-btn_center').addEventListener("click",go_center,false);
	document.getElementById('upanel-u-btn_back').addEventListener("click",go_back,false);	
	document.getElementById('gn_btn_pre_m').addEventListener("click",up_g_nocice_show_pre_m,false);	
	document.getElementById('gn_btn_pre').addEventListener("click",up_g_nocice_show_pre,false);	
	document.getElementById('gn_btn_next_m').addEventListener("click",up_g_nocice_show_next_m,false);	
	document.getElementById('gn_btn_next').addEventListener("click",up_g_nocice_show_next,false);	
	document.getElementById('gn_btn_del').addEventListener("click",up_g_nocice_del,false);
	document.getElementById('gn_btn_edit').addEventListener("click",up_g_nocice_edit,false);
	document.getElementById('gn_btn_add').addEventListener("click",up_g_nocice_add,false);
	document.getElementById('todo_btn_pre_m').addEventListener("click",up_u_mytodo_show_pre_m,false);	
	document.getElementById('todo_btn_pre').addEventListener("click",up_u_mytodo_show_pre,false);	
	document.getElementById('todo_btn_next_m').addEventListener("click",up_u_mytodo_show_next_m,false);	
	document.getElementById('todo_btn_next').addEventListener("click",up_u_mytodo_show_next,false);	
	document.getElementById('todo_btn_del').addEventListener("click",up_u_mytodo_del,false);
	document.getElementById('todo_btn_edit').addEventListener("click",up_u_mytodo_edit,false);
	document.getElementById('todo_btn_add').addEventListener("click",up_u_mytodo_add,false);
	document.getElementById('todo_btn_add').addEventListener("click",up_u_mytodo_add,false);
	gotourl();
	popschange=function (event) {
		up_lbtn_click(event.state.action);
	};
	window.addEventListener("popstate",popschange,false);
	get_u_basicinfo();
	inti_weibo();
}
function gotourl(){
	$tepa=window.location;
	$tepa=String($tepa).split("?");
	if($tepa[1]){
	up_lbtn_click($tepa[1]);
	}
}
function inti_weibo(){
	weibo_refresh();
	var $ccc=function(){weibo_refresh();};
	setInterval($ccc,120000);
}
function sentanimation($canvasid){
	var $tempi=document.getElementById($canvasid);
	$tempi.innerHTML="<canvas id=\"myCanvas\"><img src=\"img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\"></canvas>";
	var canvas = document.getElementById("myCanvas");
	var ctx = canvas.getContext("2d");
	var cyc = 100;
	ctx.fillStyle = "#fff";
	var loadingPosition = new Vector2(100, 60);
	var loadingRadius = 50;
	var intervalAngle = 45;
	var bigCircleRadius = 8;
	var bigCirclePosition = new Vector2(100, 20);
    bigCircleRadius = 10;
    ctx.clearRect(0, 0, canvas.width, canvas.height);
	var canvas = document.getElementById("myCanvas");
	function drawLoading() {
    	for (var i = 0; i < 11; i++) {
       	 	ctx.beginPath();
        	ctx.arc(bigCirclePosition.x, bigCirclePosition.y, bigCircleRadius, 0, Math.PI * 2, true);
        	ctx.closePath();
        	ctx.fill();
        	bigCircleRadius -= 1;
        	bigCirclePosition.rotateSelf(loadingPosition, 30);
    	}
	}
	var $aaa=function () {
    	bigCircleRadius = 10;
    	ctx.clearRect(0, 0, canvas.width, canvas.height);
   		drawLoading();000000000000
	}
	CANVASLOOP=setInterval($aaa, 50);
}
function weibo_refresh(){
	sentanimation('up_weibo_box');
	$.ajax({
                 type:"POST",
                 dataType:"html",
                 url:"api/sina/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"weibo"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 document.getElementById('up_weibo_box').innerHTML=data;
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						document.getElementById('up_weibo_box').innerHTML="请求超时，稍后继续查询";
	             }
                 
});
}
function get_u_basicinfo(){
	get_u_avata();
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"nowuser"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						$nowuser_id=data.id;
						$nowuser_name=data.username;
						$nowuser_tname=data.display_name;
						$nowuser_email=data.email;
						$nowuser_gid=data.gid;
						$nowuser_gname=data.gname;
						$nowuser_cid=data.cid;
						$nowuser_sid=data.sid;
						$nowuser_phone=data.phone;
						$nowuser_xy=data.xy;
						$nowuser_captain=data.captain;
						document.getElementById('up_i_uname').innerHTML=$nowuser_tname;
						document.getElementById('up_i_gname').innerHTML=$nowuser_gname;
						document.getElementById('up_i_xy').innerHTML=$nowuser_xy;
						document.getElementById('up_i_phone').innerHTML=$nowuser_phone;
						document.getElementById('up_i_sid').innerHTML=$nowuser_sid;
						document.getElementById('up_i_email').innerHTML=$nowuser_email;
						document.getElementById('up_i_login').innerHTML=$nowuser_name;
						document.getElementById('up_i_f_UNAME').innerHTML=$nowuser_tname;
						document.getElementById('up_i_f_SID').innerHTML=$nowuser_sid;
						document.getElementById('up_i_f_CID').innerHTML=$nowuser_cid;
						document.getElementById('up_i_f_gid').innerHTML=$nowuser_gid;
						document.getElementById('up_i_f_gname').innerHTML=$nowuser_gname;
						document.getElementById('up_i_f_captain').innerHTML=$nowuser_captain;
						document.getElementById('up_i_f_avata_change').innerHTML="<a href=\"http://contest.scie.in/usergruop/"+$nowuser_name+"/profile/change-avatar/\">修改头像</a>";
						$('#qrcode').qrcode($nowuser_cid);
						get_g_noice();
						get_u_todo();
						get_p_logo();
						get_p_info();
					 }
					 else{
						document.getElementById('up_i_uname').innerHTML="未登录";
						document.getElementById('up_i_gname').innerHTML="";
						$info="亲，要登录才可以使用哦~~";
						show_notice($info);
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						document.getElementById('up_i_uname').innerHTML="连接超时";
						//window.location.reload();
	             }
                 
});
	
}
function get_u_avata(){
	document.getElementById('upanel-uinfo_avata').src="img/loading.gif";
	document.getElementById('up-i_f_avata').src="img/loading.gif";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"uavata",size:64}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						document.getElementById('upanel-uinfo_avata').src=data.src;
						document.getElementById('up-i_f_avata').src=data.src;
					 }
					 else{
						document.getElementById('upanel-uinfo_avata').src="img/avatar_default.gif";
						document.getElementById('up-i_f_avata').src="img/avatar_default.gif";
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						document.getElementById('upanel-uinfo_avata').src="img/avatar_default.gif";
						document.getElementById('up-i_f_avata').src="img/avatar_default.gif";
						//window.location.reload();
	             }
                 
});
	
	
}
function get_p_logo(){
	document.getElementById('up-p_avata').src="img/loading.gif";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"plogo"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						document.getElementById('up-p_avata').src=data.src;
						if($pl_allow_add){
							$pm="<div onClick=\"javascript:up_p_logo_add();\">修改LOGO</div>";
							document.getElementById('p_logo_manage').innerHTML=$pm;
							
						}else{
							document.getElementById('p_logo_manage').innerHTML="";
						}
					 }
					 else{
						document.getElementById('up-p_avata').src="img/avatar_default.gif";
						if($pl_allow_add){
							document.getElementById('p_logo_manage').innerHTML="<div onClick=\"javascript:up_p_logo_add();\">还未上传LOGO哦~~</div>";
						}else{
							document.getElementById('p_logo_manage').innerHTML="还未上传LOGO哦~~";
						}
						
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						document.getElementById('up-p_avata').src="img/avatar_default.gif";
						//window.location.reload();
	             }
                 
});
	
	
}
function get_p_info(){
	document.getElementById('up-p_avata').src="img/loading.gif";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"pinfo"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						document.getElementById('up_p_name').innerHTML=data.pname;
						$nowuser_pid=data.pid;
						if(data.pdes!="NULL"){
							document.getElementById('up_p_des').innerHTML=data.pdes;
						}else{
							document.getElementById('up_p_des').innerHTML="亲还未设置简介哦";
						}
						if($pdes_allow_edit){
							document.getElementById('up_p_des').innerHTML+="&nbsp;<div onClick=\"javascript:up_p_des_edit();\">修改</div>";
						}
						if(data.wd_id!="NULL"){
							document.getElementById('up_p_wd').innerHTML+="文档 已上传&nbsp;<div onClick=\"javascript:up_p_wd_view();\">查看</div><a href=\"/uploader.html\">修改</a>";
						}else{
							document.getElementById('up_p_wd').innerHTML+="文档 未上传&nbsp;<a href=\"/uploader.html\">上传</a>";
						}
						if(data.sp_id!="NULL"){
							document.getElementById('up_p_v').innerHTML+="视频 已上传&nbsp;<div onClick=\"javascript:up_p_sp_view();\">查看</div><a href=\"/uploader.html\">修改</a>";
						}else{
							document.getElementById('up_p_v').innerHTML+="视频 未上传&nbsp;<a href=\"/uploader.html\">上传</a>";
						}
						document.getElementById('up_p_des').innerHTML=data.pdes;
						
					 }
					 else{
						document.getElementById('up-p_avata').src="img/avatar_default.gif";
						document.getElementById('up_p_des').innerHTML=data.info+"";
						$nowuser_pid=0;
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						document.getElementById('up-p_avata').src="img/avatar_default.gif";
						//window.location.reload();
	             }
                 
});
	
	
}
$dates=0;
$texts=0;
$gnotice_total=-1;
$gnotice_now=0;
$dates_u=0;
$texts_u=0;
$closeds_u=0;
$mytodo_total=-1;
$mytodo_now=0;

function get_g_noice(){
	document.getElementById('up_group_notice_box').innerHTML="<img src=\"img/loading.gif\">";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"gnotice"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						$dates=data.dates;
						$texts=data.texts;
						$gnotice_total=data.total;
						up_g_nocice_inti();
						return;
					 }
					 else{
						document.getElementById('up_group_notice_box').innerHTML="暂无团队公告！";
						$dates=0;
						$texts=0;
						$gnotice_total=-1;
					 }
					 up_g_nocice_inti();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
	
	
}

function get_u_todo(){
	document.getElementById('up_my_todo_box').innerHTML="<img src=\"img/loading.gif\">";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"mytodo"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						$dates_u=data.dates;
						$texts_u=data.texts;
						$closeds_u=data.closeds;
						$mytodo_total=data.total;
						up_u_mytodo_inti();
						return;
					 }
					 else{
						document.getElementById('up_my_todo_box').innerHTML="亲，你还没有TODO List哦，来添加一条吧！";
						$dates_u=0;
						$texts_u=0;
						$mytodo_total=-1;
					 }
					 up_u_mytodo_inti();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
	
	
}
function up_g_nocice_show($nid){
	document.getElementById('up_group_notice_box').innerHTML="<img src=\"img/loading.gif\">";
	if($gnotice_total==-1){
		document.getElementById('up_group_notice_box').innerHTML="暂无团队公告！";
		return;
	}
	$tempa=$dates[$nid]+"<br>"+$texts[$nid];
	document.getElementById('up_group_notice_box').innerHTML=$tempa;
}
function up_g_nocice_show_next(){
	if(!$gn_allow_next){
		return;
	}
	if($gnotice_now==$gnotice_total){
		document.getElementById('up_group_notice_box').innerHTML="暂无团队公告！";
	}
	if($gnotice_now==0){
		document.getElementById('gn_btn_pre').className="gn_btn_en";
		$gn_allow_pre=true;
	}
	if(($gnotice_now-1)==0){
		document.getElementById('gn_btn_pre').className="gn_btn_en";
		document.getElementById('gn_btn_pre_m').className="gn_btn_en";
		$gn_allow_pre=true;
		$gn_allow_pre_m=true;
	}
	if(($gnotice_now+1)!=$gnotice_total){
		$gnotice_now++;
		up_g_nocice_show($gnotice_now);
		document.getElementById('gn_btn_next').className="gn_btn_en";
		document.getElementById('gn_btn_next_m').className="gn_btn_en";
		$gn_allow_next=true;
		$gn_allow_next_m=true;
	}else if(($gnotice_now+1)==$gnotice_total){
		$gnotice_now++;
		up_g_nocice_show($gnotice_now);
		document.getElementById('gn_btn_next_m').className="gn_btn_dis";
		document.getElementById('gn_btn_next').className="gn_btn_dis";
		$gn_allow_next=false;
		$gn_allow_next_m=false;
	}
}
function up_g_nocice_show_next_m(){
	if(!$gn_allow_next_m){
		return;
	}
	if($gnotice_now==$gnotice_total){
		document.getElementById('up_group_notice_box').innerHTML="暂无团队公告！";
	}
	if($gnotice_now==0){
		document.getElementById('gn_btn_pre').className="gn_btn_en";
		$gn_allow_pre=true;
	}
	if(($gnotice_now-1)==0){
		document.getElementById('gn_btn_pre').className="gn_btn_en";
		document.getElementById('gn_btn_pre_m').className="gn_btn_en";
		$gn_allow_pre=true;
		$gn_allow_pre_m=true;
	}
		$gnotice_now=$gnotice_total;
		up_g_nocice_show($gnotice_now);
		document.getElementById('gn_btn_next').className="gn_btn_dis";
		document.getElementById('gn_btn_next_m').className="gn_btn_dis";
		$gn_allow_next=false;
		$gn_allow_next_m=false;
}
function up_g_nocice_show_pre(){
	if(!$gn_allow_pre){
		return;
	}
	if($gnotice_now==0){
		document.getElementById('up_group_notice_box').innerHTML="暂无团队公告！";
	}
	if($gnotice_now==$gnotice_total){
		document.getElementById('gn_btn_next').className="gn_btn_en";
		$gn_allow_next=true;
	}
	if(($gnotice_now+1)==$gnotice_total){
		document.getElementById('gn_btn_next').className="gn_btn_en";
		document.getElementById('gn_btn_next_m').className="gn_btn_en";
		$gn_allow_next=true;
		$gn_allow_next_m=true;
	}
	if(($gnotice_now-1)!=0){
		$gnotice_now--;
		up_g_nocice_show($gnotice_now);
		document.getElementById('gn_btn_pre').className="gn_btn_en";
		document.getElementById('gn_btn_pre_m').className="gn_btn_en";
		$gn_allow_pre=true;
		$gn_allow_pre_m=true;
	}else if(($gnotice_now-1)==0){
		$gnotice_now--;
		up_g_nocice_show($gnotice_now);
		document.getElementById('gn_btn_pre_m').className="gn_btn_dis";
		document.getElementById('gn_btn_pre').className="gn_btn_dis";
		$gn_allow_pre=false;
		$gn_allow_pre_m=false;
	}
}
function up_g_nocice_show_pre_m(){
	if(!$gn_allow_pre_m){
		return;
	}
	if($gnotice_now==0){
		document.getElementById('up_group_notice_box').innerHTML="暂无团队公告！";
	}
	if($gnotice_now==$gnotice_total){
		document.getElementById('gn_btn_next').className="gn_btn_en";
		$gn_allow_next=true;
	}
	if(($gnotice_now+1)==$gnotice_total){
		document.getElementById('gn_btn_next').className="gn_btn_en";
		document.getElementById('gn_btn_next_m').className="gn_btn_en";
		$gn_allow_next=true;
		$gn_allow_next_m=true;
	}
		$gnotice_now=0;
		up_g_nocice_show(0);
		document.getElementById('gn_btn_pre').className="gn_btn_dis";
		document.getElementById('gn_btn_pre_m').className="gn_btn_dis";
		$gn_allow_pre=false;
		$gn_allow_pre_m=false;
}
function up_g_nocice_inti(){
	$gnotice_now=0;
	if($gnotice_total==-1){
		document.getElementById('up_group_notice_box').innerHTML="暂无团队公告！";
		document.getElementById('gn_btn_pre_m').className="gn_btn_dis";
		document.getElementById('gn_btn_pre').className="gn_btn_dis";
		document.getElementById('gn_btn_next_m').className="gn_btn_dis";
		document.getElementById('gn_btn_next').className="gn_btn_dis";
	}else{
		up_g_nocice_show(0);
		if($gnotice_total==0){
			document.getElementById('gn_btn_pre_m').className="gn_btn_dis";
			document.getElementById('gn_btn_pre').className="gn_btn_dis";
			document.getElementById('gn_btn_next_m').className="gn_btn_dis";
			document.getElementById('gn_btn_next').className="gn_btn_dis";
			$gn_allow_pre=false;
			$gn_allow_pre_m=false;
			$gn_allow_next=false;
			$gn_allow_next_m=false;
		}else{
			document.getElementById('gn_btn_pre_m').className="gn_btn_dis";
			document.getElementById('gn_btn_pre').className="gn_btn_dis";
			document.getElementById('gn_btn_next_m').className="gn_btn_en";
			document.getElementById('gn_btn_next').className="gn_btn_en";
			$gn_allow_pre=false;
			$gn_allow_pre_m=false;
			$gn_allow_next=true;
			$gn_allow_next_m=true;
		}
	}
	if($nowuser_captain==$nowuser_tname){
		document.getElementById('gn_btn_add').className="gn_btn_en";
		document.getElementById('gn_btn_edit').className="gn_btn_en";
		document.getElementById('gn_btn_del').className="gn_btn_en";
		$gn_allow_add=true;
		$gn_allow_edit=true;
		$gn_allow_del=true;
		$pl_allow_add=true;
	}else{
		document.getElementById('gn_btn_add').className="gn_btn_none";
		document.getElementById('gn_btn_edit').className="gn_btn_none";
		document.getElementById('gn_btn_del').className="gn_btn_none";
		$pl_allow_add=false;
		$gn_allow_add=false;
		$gn_allow_edit=false;
		$gn_allow_del=false;
	}
}
function up_g_nocice_add(){
	if($gn_allow_add==true){
		$info="<table uptype=\"t_white\" width=\"200\" border=\"0\" cellspacing=\"10\ cellpadding=\"0\"><tr><td>添加公告</td></tr><tr><td>时间:</td></tr><tr><td>当前时间</td></tr><tr><td>内容：</td></tr><tr><td>"+$MPST_help+"<textarea id=\"up_g_n\" rows=\"10\" cols=\"90\"></textarea></td></tr><tr><td><div onClick=\"javascript:up_g_nocice_add_do();\">确认添加</div>  <div onClick=\"javascript:hide_notice();\">放弃添加</div></td></tr></table>";
		show_notice($info);
	}
}
function up_p_logo_add(){
	if($pl_allow_add==true){
		$info="<table uptype=\"t_white\" width=\"800\" border=\"0\" cellspacing=\"10\ cellpadding=\"0\"><tr><td>LOGO设定</td></tr><tr><td>上传png格式图片，大小64*64到256*256均可。</td></tr><tr><td><div width=\"800\" id=\"vault1\" class=\"cp_up_uploader_none\"></div></td></tr><tr><td><div onClick=\"javascript:hide_notice();\">关闭</div></td></tr></table>";
		show_notice($info);
		openlogoup();
		vault.setFormField("pid", $nowuser_pid);
		vault.setFormField("ftype", "5");
		get_p_logo();
	}
}
function up_g_nocice_edit(){
	if($gn_allow_edit==true){
		$texta=$texts[$gnotice_now].replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
		$info="<table uptype=\"t_white\"width=\"200\" border=\"0\" cellspacing=\"10\ cellpadding=\"0\"><tr><td>编辑公告</td></tr><tr><td>时间:</td></tr><tr><td>"+$dates[$gnotice_now]+"</td></tr><tr><td>内容：</td></tr><tr><td>"+$MPST_help+"<textarea id=\"up_g_n\" rows=\"10\" cols=\"90\">"+$texta+"</textarea></td></tr><tr><td><div onClick=\"javascript:up_g_nocice_edit_do(\'"+$dates[$gnotice_now]+"\',\'"+$texta+"\')\">确认修改</div>  <div onClick=\"javascript:hide_notice();\">放弃修改</div></td></tr></table>";
		show_notice($info);
	}
}
function up_g_nocice_del(){
	if($gn_allow_del==true){
		$texta=$texts[$gnotice_now].replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
		$info="<table uptype=\"t_white\" width=\"200\" border=\"0\" cellspacing=\"10\ cellpadding=\"0\"><tr><td>你确认删除这条公告吗？</td></tr><tr><td>时间:</td></tr><tr><td>"+$dates[$gnotice_now]+"</td></tr><tr><td>内容：</td></tr><tr><td>"+$texts[$gnotice_now]+"</td></tr><tr><td><div onClick=\"javascript:up_g_nocice_del_do('"+$dates[$gnotice_now]+"','"+$texta+"')\">是</div>  <div onClick=\"javascript:hide_notice();\">否</div></td></tr></table>";
		show_notice($info);
	}
	
}
function up_g_nocice_del_do($date,$text){
	document.getElementById('cp_reg_form_notice_inside').innerHTML="删除中~~~";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"gnotice_del",date:$date,text:$text}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 document.getElementById('cp_reg_form_notice_inside').innerHTML="已删除~~~";
						 hide_notice();
						get_g_noice();
						return;
					 }
					 else{
						document.getElementById('cp_reg_form_notice_inside').innerHTML="删除失败<br>"+data.info;
						$ccc=function(){
						 hide_notice();
					 };
					 setTimeout($ccc,3000);
					 }
					 up_g_nocice_inti();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
	
}
function up_g_nocice_edit_do($date,$text){
	$textn=(document.getElementById('up_g_n').value).replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
	$text=$text.replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
	document.getElementById('cp_reg_form_notice_inside').innerHTML="修改中~~~";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"gnotice_edit",date:$date,text:$text,textn:$textn}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 document.getElementById('cp_reg_form_notice_inside').innerHTML="已修改~~~";
						 hide_notice();
						get_g_noice();
						return;
					 }
					 else{
						document.getElementById('cp_reg_form_notice_inside').innerHTML="修改失败<br>"+data.info;
						$ccc=function(){
						 hide_notice();
					 };
					 setTimeout($ccc,3000);
					 }
					 up_g_nocice_inti();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
}
function up_g_nocice_add_do(){
	$text=(document.getElementById('up_g_n').value).replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");;
	document.getElementById('cp_reg_form_notice_inside').innerHTML="添加中~~~";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"gnotice_add",text:$text}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 document.getElementById('cp_reg_form_notice_inside').innerHTML="已添加~~~";
						 hide_notice();
						get_g_noice();
						return;
					 }
					 else{
						document.getElementById('cp_reg_form_notice_inside').innerHTML="添加失败<br>"+data.info;
						$ccc=function(){
						 hide_notice();
					 };
					 setTimeout($ccc,3000);
					 }
					 up_g_nocice_inti();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
	
}
function up_u_mytodo_show($nid){
	document.getElementById('up_my_todo_box').innerHTML="<img src=\"img/loading.gif\">";
	if($mytodo_total==-1){
		document.getElementById('up_my_todo_box').innerHTML="亲，你还没有TODO List哦，来添加一条吧！";
		return;
	}
	$statue="未知";
		if($closeds_u[$nid]==0){
			$statue="未完成";
		}else if($closeds_u[$nid]==1){
			$statue="已完成";
		}else if($closeds_u[$nid]==2){
			$statue="已关闭";
	}
	$tempa=$statue+$dates_u[$nid]+"<br>"+$texts_u[$nid];
	document.getElementById('up_my_todo_box').innerHTML=$tempa;
}
function up_u_mytodo_show_next(){
	if(!$todo_allow_next){
		return;
	}
	if($mytodo_now==$mytodo_total){
		document.getElementById('up_my_todo_box').innerHTML="亲，你还没有TODO List哦，来添加一条吧！";
	}
	if($mytodo_now==0){
		document.getElementById('todo_btn_pre').className="gn_btn_en";
		$todo_allow_pre=true;
	}
	if(($mytodo_now-1)==0){
		document.getElementById('todo_btn_pre').className="gn_btn_en";
		document.getElementById('todo_btn_pre_m').className="gn_btn_en";
		$todo_allow_pre==true;
		$todo_allow_pre_m=true;
	}
	if(($mytodo_now+1)!=$mytodo_total){
		$mytodo_now++;
		up_u_mytodo_show($mytodo_now);
		document.getElementById('todo_btn_next').className="gn_btn_en";
		document.getElementById('todo_btn_next_m').className="gn_btn_en";
		$todo_allow_next=true;
		$todo_allow_next_m=true;
	}else if(($mytodo_now+1)==$mytodo_total){
		$mytodo_now++;
		up_u_mytodo_show($mytodo_now);
		document.getElementById('todo_btn_next_m').className="gn_btn_dis";
		document.getElementById('todo_btn_next').className="gn_btn_dis";
		$todo_allow_next=false;
		$todo_allow_next_m=false;
	}
}
function up_u_mytodo_show_next_m(){
	if(!$todo_allow_next_m){
		return;
	}
	if($mytodo_now==$mytodo_total){
		document.getElementById('todo_my_todo_box').innerHTML="亲，你还没有TODO List哦，来添加一条吧！";
	}
	if($mytodo_now==0){
		document.getElementById('todo_btn_pre').className="gn_btn_en";
		$gn_allow_pre=true;
	}
	if(($mytodo_now-1)==0){
		document.getElementById('todo_btn_pre').className="gn_btn_en";
		document.getElementById('todo_btn_pre_m').className="gn_btn_en";
		$todo_allow_pre=true;
		$todo_allow_pre_m=true;
	}
		$mytodo_now=$mytodo_total;
		up_u_mytodo_show($mytodo_now);
		document.getElementById('todo_btn_next').className="gn_btn_dis";
		document.getElementById('todo_btn_next_m').className="gn_btn_dis";
		$todo_allow_next=false;
		$todo_allow_next_m=false;
}
function up_u_mytodo_show_pre(){
	if(!$todo_allow_pre){
		return;
	}
	if($mytodo_now==0){
		document.getElementById('up_my_todo_box').innerHTML="亲，你还没有TODO List哦，来添加一条吧！";
	}
	if($mytodo_now==$mytodo_total){
		document.getElementById('todo_btn_next').className="gn_btn_en";
		$todo_allow_next=true;
	}
	if(($mytodo_now+1)==$mytodo_total){
		document.getElementById('todo_btn_next').className="gn_btn_en";
		document.getElementById('todo_btn_next_m').className="gn_btn_en";
		$todo_allow_next=true;
		$todo_allow_next_m=true;
	}
	if(($mytodo_now-1)!=0){
		$mytodo_now--;
		up_u_mytodo_show($mytodo_now);
		document.getElementById('todo_btn_pre').className="gn_btn_en";
		document.getElementById('todo_btn_pre_m').className="gn_btn_en";
		$todo_allow_pre=true;
		$todo_allow_pre_m=true;
	}else if(($mytodo_now-1)==0){
		$mytodo_now--;
		up_u_mytodo_show($mytodo_now);
		document.getElementById('todo_btn_pre_m').className="gn_btn_dis";
		document.getElementById('todo_btn_pre').className="gn_btn_dis";
		$todo_allow_pre=false;
		$todo_allow_pre_m=false;
	}
}
function up_u_mytodo_show_pre_m(){
	if(!$todo_allow_pre_m){
		return;
	}
	if($mytodo_now==0){
		document.getElementById('up_my_todo_box').innerHTML="亲，你还没有TODO List哦，来添加一条吧！";
	}
	if($mytodo_now==$mytodo_total){
		document.getElementById('todo_btn_next').className="gn_btn_en";
		$todo_allow_next=true;
	}
	if(($mytodo_now+1)==$mytodo_total){
		document.getElementById('todo_btn_next').className="gn_btn_en";
		document.getElementById('todo_btn_next_m').className="gn_btn_en";
		$todo_allow_next=true;
		$todo_allow_next_m=true;
	}
		$mytodo_now=0;
		up_u_mytodo_show(0);
		document.getElementById('todo_btn_pre').className="gn_btn_dis";
		document.getElementById('todo_btn_pre_m').className="gn_btn_dis";
		$todo_allow_pre=false;
		$todo_allow_pre_m=false;
}
function up_u_mytodo_inti(){
	$mytodo_now=0;
	if($mytodo_total==-1){
		document.getElementById('up_my_todo_box').innerHTML="亲，你还没有TODO List哦，来添加一条吧！";
		document.getElementById('todo_btn_pre_m').className="gn_btn_dis";
		document.getElementById('todo_btn_pre').className="gn_btn_dis";
		document.getElementById('todo_btn_next_m').className="gn_btn_dis";
		document.getElementById('todo_btn_next').className="gn_btn_dis";
	}else{
		up_u_mytodo_show(0);
		if($mytodo_total==0){
			document.getElementById('todo_btn_pre_m').className="gn_btn_dis";
			document.getElementById('todo_btn_pre').className="gn_btn_dis";
			document.getElementById('todo_btn_next_m').className="gn_btn_dis";
			document.getElementById('todo_btn_next').className="gn_btn_dis";
			$todo_allow_pre=false;
			$todo_allow_pre_m=false;
			$todo_allow_next=false;
			$todo_allow_next_m=false;
		}else{
			document.getElementById('todo_btn_pre_m').className="gn_btn_dis";
			document.getElementById('todo_btn_pre').className="gn_btn_dis";
			document.getElementById('todo_btn_next_m').className="gn_btn_en";
			document.getElementById('todo_btn_next').className="gn_btn_en";
			$todo_allow_pre=false;
			$todo_allow_pre_m=false;
			$todo_allow_next=true;
			$todo_allow_next_m=true;
		}
	}
}
function up_u_mytodo_add(){
		$info="<table uptype=\"t_white\" width=\"200\" border=\"0\" cellspacing=\"10\ cellpadding=\"0\"><tr><td>添加TODO</td></tr><tr><td>时间:</td></tr><tr><td>当前时间</td></tr><tr><td>内容：</td></tr><tr><td>"+$MPST_help+"<textarea id=\"up_g_n\" rows=\"10\" cols=\"90\"></textarea></td></tr><tr><td><div onClick=\"javascript:up_u_mytodo_add_do();\">确认添加</div>  <div onClick=\"javascript:hide_notice();\">放弃添加</div></td></tr></table>";
		show_notice($info);
}
function up_u_mytodo_edit(){
		$texta=$texts_u[$mytodo_now].replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
		$info="<table uptype=\"t_white\"width=\"200\" border=\"0\" cellspacing=\"10\ cellpadding=\"0\"><tr><td>编辑TODO</td></tr><tr><td>时间:</td></tr><tr><td>"+$dates_u[$mytodo_now]+"</td></tr><tr><td>内容：</td></tr><tr><td>状态：<input name=\"up_u_t_s\" id=\"up_u_t_s1\" type=\"radio\" value=\"0\">未完成<input name=\"up_u_t_s\" id=\"up_u_t_s2\" type=\"radio\" value=\"1\">已完成<input name=\"up_u_t_s\" id=\"up_u_t_s3\" type=\"radio\" value=\"2\">已关闭</td></tr><tr><td>"+$MPST_help+"<textarea id=\"up_g_n\" rows=\"10\" cols=\"90\">"+$texta+"</textarea></td></tr><tr><td><div onClick=\"javascript:up_u_mytodo_edit_do('"+$dates_u[$mytodo_now]+"','"+$texta+"')\">确认修改</div>  <div onClick=\"javascript:hide_notice();\">放弃修改</div></td></tr></table>";
		show_notice($info);
}
function up_u_mytodo_del(){
		$statue="未知";
		if($closeds_u[$mytodo_now]==0){
			$statue="未完成";
		}else if($closeds_u[$mytodo_now]==1){
			$statue="已完成";
		}else if($closeds_u[$mytodo_now]==2){
			$statue="已关闭";
		}
		$texta=$texts_u[$mytodo_now].replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
		$info="<table uptype=\"t_white\" width=\"200\" border=\"0\" cellspacing=\"10\ cellpadding=\"0\"><tr><td>你确认删除这条TODO吗？</td></tr><tr><td>时间:</td></tr><tr><td>"+$dates_u[$mytodo_now]+"</td></tr><tr><td>内容：</td></tr><tr><td>状态："+$statue+"</td></tr><tr><td>"+$texts[$mytodo_now]+"</td></tr><tr><td><div onClick=\"javascript:up_u_mytodo_del_do('"+$dates_u[$mytodo_now]+"','"+$texta+"')\">是</div>  <div onClick=\"javascript:hide_notice();\">否</div></td></tr></table>";
		show_notice($info);
}
function up_u_mytodo_del_do($date,$text){
	document.getElementById('cp_reg_form_notice_inside').innerHTML="删除中~~~";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"mytodo_del",date:$date,text:$texts}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 document.getElementById('cp_reg_form_notice_inside').innerHTML="已删除~~~";
						 hide_notice();
						get_u_todo();
						return;
					 }
					 else{
						document.getElementById('cp_reg_form_notice_inside').innerHTML="删除失败<br>"+data.info;
						$ccc=function(){
						 hide_notice();
					 };
					 setTimeout($ccc,3000);
					 }
					 up_u_mytodo_inti();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
	
}
function up_u_mytodo_edit_do($date,$text){
	$textn=(document.getElementById('up_g_n').value).replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
	$text=$text.replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
	$closed=0;
	if(document.getElementById('up_u_t_s1').checked){
		$closed=0;
	}
	if(document.getElementById('up_u_t_s2').checked){
		$closed=1;
	}
	if(document.getElementById('up_u_t_s3').checked){
		$closed=2;
	}
	document.getElementById('cp_reg_form_notice_inside').innerHTML="修改中~~~";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"mytodo_edit",date:$date,text:$text,textn:$textn,closed:$closed}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 document.getElementById('cp_reg_form_notice_inside').innerHTML="已修改~~~";
						 hide_notice();
						get_u_todo();
						return;
					 }
					 else{
						document.getElementById('cp_reg_form_notice_inside').innerHTML="修改失败<br>"+data.info;
						$ccc=function(){
						 hide_notice();
					 };
					 setTimeout($ccc,3000);
					 }
					 up_u_mytodo_inti();
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
}
function up_u_mytodo_add_do(){
	$text=(document.getElementById('up_g_n').value).replace(/<b>/g,"|b|").replace(/<\/b>/g,"|/b|").replace(/\" target=\"_blank\">链接<\/a>/g,"|/url|").replace(/<br>/g,"|br|").replace(/<a href=\"/g,"|url|").replace(/<img src=\"/g,"|img|").replace(/\">/g,"|/img|");
	document.getElementById('cp_reg_form_notice_inside').innerHTML="添加中~~~";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"mytodo_add",text:$text}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 document.getElementById('cp_reg_form_notice_inside').innerHTML="已添加~~~";
						 hide_notice();
						get_u_todo();
						return;
					 }
					 else{
						document.getElementById('cp_reg_form_notice_inside').innerHTML="添加失败<br>"+data.info;
					 }
					 up_u_mytodo_inti();
					 $ccc=function(){
						 hide_notice();
					 };
					 setTimeout($ccc,3000);
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						//window.location.reload();
	             }
                 
});
	
}
function show_notice($info){
	document.getElementById('cp_reg_form_notice_inside').innerHTML=$info;
	document.getElementById('cp_reg_form_notice').className="reg_notice_now";
	document.getElementById('cp_reg_form_notice_shadow').className="reg_notice_shadow_now";
}
function hide_notice(){
	document.getElementById('cp_reg_form_notice_inside').innerHTML="";
	document.getElementById('cp_reg_form_notice').className="reg_notice_none";
	document.getElementById('cp_reg_form_notice_shadow').className="reg_notice_shadow_none";
}
function pg_goto($id){
	$maxid=4;
	document.getElementById('progress-bar-gradient_img').className="progress_"+$id;
	document.getElementById('progress-bar-gradient-afters').className="progress_a_"+$id;
	if($id>0){
		$tempa="pg_box_"+$id;
		document.getElementById($tempa).className="pg_box_now";
		$tempa="pg_box_"+$maxid;
		if($id==1&&document.getElementById($tempa).className=="pg_box_now"){
			document.getElementById($tempa).className="pg_box_over";
		}
		$id--;
		if($id>0){
			$tempa="pg_box_"+$id;
			document.getElementById($tempa).className="pg_box_over";
		}
	}
}
pg_goto(0);
var $a=function(){
	pg_goto(1);
	var $b=function(){
		pg_goto(2);
		var $c=function(){
			pg_goto(3);
			var $d=function(){
				pg_goto(4);
				var $e=function(){
					pg_goto(1);
				};
				setTimeout($e,2000);
			};
			setTimeout($d,2000);
		};
		setTimeout($c,2000);
	};
	setTimeout($b,2000);
};
setTimeout($a,2000);
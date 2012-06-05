inittips();
function inittips(){
	if($nowstep==1){
		document.getElementById('cp_reg_form_ugroup-g').addEventListener("click",setgroup_g,false);
		document.getElementById('cp_reg_form_ugroup-ng').addEventListener("click",setgroup_ng,false);
		isregclosed();
		allclean();
		
	}
	if($nowstep==2){
		show_btnl();
		document.getElementById('cp_reg_lbtn_y').addEventListener("click",liense_ok,false);
		document.getElementById('cp_reg_lbtn_y').addEventListener("click",liense_nok,false);
		
	}
	if($nowstep==3){
	var $tempa='cp_reg_form_uname';
	var $aaa=document.getElementById($tempa);
	$aaa.addEventListener("focus",showtip_tip_uname,false);
	$aaa.addEventListener("blur",hidetip_tip_uname,false);
	$aaa.addEventListener("click",clearthis,false);
	$tempa='cp_reg_form_upass';
	$aaa=document.getElementById($tempa);
	$aaa.addEventListener("focus",showtip_tip_upass,false);
	$aaa.addEventListener("blur",hidetip_tip_upass,false);
	$aaa.addEventListener("click",clearthis,false);
	$tempa='cp_reg_form_upass2';
	$aaa=document.getElementById($tempa);
	$aaa.addEventListener("focus",showtip_tip_upass2,false);
	$aaa.addEventListener("blur",hidetip_tip_upass2,false);
	$aaa.addEventListener("click",clearthis,false);
	}
	if($nowstep==4){
	var $tempa='cp_reg_form_urname';
	var $aaa=document.getElementById($tempa);
	$aaa.addEventListener("focus",showtip_tip_urname,false);
	$aaa.addEventListener("blur",hidetip_tip_urname,false);
	$aaa.addEventListener("click",clearthis,false);
	$tempa='cp_reg_form_usid';
	$aaa=document.getElementById($tempa);
	$aaa.addEventListener("focus",showtip_tip_usid,false);
	$aaa.addEventListener("blur",hidetip_tip_usid,false);
	$aaa.addEventListener("click",clearthis,false);
	$tempa='cp_reg_form_uiid';
	$aaa=document.getElementById($tempa);
	$aaa.addEventListener("focus",showtip_tip_uiid,false);
	$aaa.addEventListener("blur",hidetip_tip_uiid,false);
	$aaa.addEventListener("click",clearthis,false);
	}
	if($nowstep==5){
		var $tempa='cp_reg_form_uemail';
		var $aaa=document.getElementById($tempa);
		$aaa.addEventListener("focus",showtip_tip_uemail,false);
		$aaa.addEventListener("blur",hidetip_tip_uemail,false);
		$aaa.addEventListener("click",clearthis,false);
		$tempa='cp_reg_form_uphone';
		$aaa=document.getElementById($tempa);
		$aaa.addEventListener("focus",showtip_tip_uphone,false);
		$aaa.addEventListener("blur",hidetip_tip_uphone,false);
		$aaa.addEventListener("click",clearthis,false);
	}
	if($nowstep==6){
		document.getElementById('cp_reg_form_ugroup_tittles_j').addEventListener("click",cp_reg_group_join,false);
		document.getElementById('cp_reg_form_ugroup_tittles_n').addEventListener("click",cp_reg_group_new,false);
		document.getElementById('cp_reg_form_ugroup_tittles_p').addEventListener("click",cp_reg_group_jump,false);
		var $aaa=document.getElementById('cp_reg_form_searchn');
		$aaa.addEventListener("click",clearthis,false);
		var $aaa=document.getElementById('cp_reg_form_ucgroup');
		$aaa.addEventListener("click",clearthis,false);
		$aaa.addEventListener("blur",check_ucgroup,false);
		if(!$isgroup){
			next_step();
		}
	}
	if($nowstep==7){
		var $ccc=function(){shownext();};
		setTimeout($ccc,3000);
	}
	if($nowstep==8){
		sentanimation();
		var $ddd=function(){sendmyreg();};
		setTimeout($ddd,3000);
	}
}
function closetips(){
	if($nowstep==1){
		document.getElementById('cp_reg_form_ugroup-g').removeEventListener("click",setgroup_g,false);
		document.getElementById('cp_reg_form_ugroup-ng').removeEventListener("click",setgroup_ng,false);
	}
	if($nowstep==2){
		hide_btnl();
		document.getElementById('cp_reg_lbtn_y').removeEventListener("click",liense_ok,false);
		document.getElementById('cp_reg_lbtn_y').removeEventListener("click",liense_nok,false);
	}
	if($nowstep==3){
	var $tempa='cp_reg_form_uname';
	var $aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_uname,false);
	$aaa.removeEventListener("blur",hidetip_tip_uname,false);
	$aaa.removeEventListener("click",clearthis,false);
	document.getElementById('cp_reg_resultform_uname').innerHTML=$aaa.value;
	$tuname=$aaa.value;
	$tempa='cp_reg_form_upass';
	$aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_upass,false);
	$aaa.removeEventListener("blur",hidetip_tip_upass,false);
	$aaa.removeEventListener("click",clearthis,false);
	$tupass=$aaa.value;
	$tempa='cp_reg_form_upass2';
	$aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_upass2,false);
	$aaa.removeEventListener("blur",hidetip_tip_upass2,false);
	$aaa.removeEventListener("click",clearthis,false);
	document.getElementById('cp_reg_resultform_uname').innerHTML;
	$tupass2=$aaa.value;
	}
	if($nowstep==4){
	var $tempa='cp_reg_form_urname';
	var $aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_urname,false);
	$aaa.removeEventListener("blur",hidetip_tip_urname,false);
	$aaa.removeEventListener("click",clearthis,false);
	document.getElementById('cp_reg_resultform_urname').innerHTML=$aaa.value;
	$turname=$aaa.value;
	$tempa='cp_reg_form_usid';
	$aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_usid,false);
	$aaa.removeEventListener("blur",hidetip_tip_usid,false);
	$aaa.removeEventListener("click",clearthis,false);
	document.getElementById('cp_reg_resultform_usid').innerHTML=$aaa.value;
	$tusid=$aaa.value;
	$tempa='cp_reg_form_uiid';
	$aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_uiid,false);
	$aaa.removeEventListener("blur",hidetip_tip_uiid,false);
	$aaa.removeEventListener("click",clearthis,false);
	document.getElementById('cp_reg_resultform_uiid').innerHTML=$aaa.value;
	document.getElementById('cp_reg_resultform_ucollege').innerHTML=$uxy+"学院";
	$tucollege=$uxy+"学院";
	}
	if($nowstep==5){
		var $tempb='cp_reg_uinfo_check_rr';
		var $tempc=document.getElementById($tempb);
		var $tempa='cp_reg_form_uemail';
		var $aaa=document.getElementById($tempa);
		$aaa.removeEventListener("focus",showtip_tip_uemail,false);
		$aaa.removeEventListener("blur",hidetip_tip_uemail,false);
		$aaa.removeEventListener("click",clearthis,false);
		document.getElementById('cp_reg_resultform_uemail').innerHTML=$aaa.value;
		$tuemail=$aaa.value;
		$tempa='cp_reg_form_uphone';
		$aaa=document.getElementById($tempa);
		$aaa.removeEventListener("focus",showtip_tip_uphone,false);
		$aaa.removeEventListener("blur",hidetip_tip_uphone,false);
		$aaa.removeEventListener("click",clearthis,false);
		document.getElementById('cp_reg_resultform_uphone').innerHTML=$aaa.value;
		$tuphone=$aaa.value;
	}
	if($nowstep==6){
		document.getElementById('cp_reg_group_n').className="cp_reg_group_new_over";
		document.getElementById('cp_reg_group_j').className="cp_reg_group_join_over";
		document.getElementById('cp_reg_form_ugroup_tittles_j').removeEventListener("click",cp_reg_group_join,false);
		document.getElementById('cp_reg_form_ugroup_tittles_n').removeEventListener("click",cp_reg_group_new,false);
		document.getElementById('cp_reg_form_ugroup_tittles_p').removeEventListener("click",cp_reg_group_jump,false);
		document.getElementById('cp_reg_resultform_ugroup').innerHTML=$umgroupname+" ID:"+$umgroupid;
		if($need_c_g==1){
			$umgroupname=document.getElementById('cp_reg_form_ucgroup').value;
			document.getElementById('cp_reg_resultform_ugroup').innerHTML=$umgroupname+" --准备创建";
		}else{
			document.getElementById('cp_reg_resultform_ugroup').innerHTML=$umgroupname+" ID:"+$umgroupid;
		}
		$tugroupname=$umgroupname;
		$tugroupid=$umgroupid;
	}
}
function allclean(){
	document.getElementById('cp_reg_form_uname').value="";
	document.getElementById('cp_reg_form_upass').value="";
	document.getElementById('cp_reg_form_upass2').value="";
	document.getElementById('cp_reg_form_urname').value="";
	document.getElementById('cp_reg_form_usid').value="";
	document.getElementById('cp_reg_form_uiid').value="";
	document.getElementById('cp_reg_form_uemail').value="";
	document.getElementById('cp_reg_form_uphone').value="";
	document.getElementById('cp_reg_form_searchn').value="";
	document.getElementById('cp_reg_form_ucgroup').value="";
}
function checkclear(){
	if($nowstep==3)
	{
		if(document.getElementById('cp_reg_form_upass').value!=""&&document.getElementById('cp_reg_form_upass').value!=""&&document.getElementById('cp_reg_form_upass2').value!=""&&$haveerror==false&&$unameok==true&&$upassok==true&&$upass2ok==true)
		{
			shownext();
		}
	}
	else if($nowstep==4){
		if(document.getElementById('cp_reg_form_urname').value!=""&&document.getElementById('cp_reg_form_usid').value!=""&&document.getElementById('cp_reg_form_uiid').value!=""&&document.getElementById('cp_reg_form_uiid').value!="请输入身份证"&&$urnameok==true&&$usidok==true&&$uiidok==true){
			var $checkres=checkuser(document.getElementById('cp_reg_form_urname').value,document.getElementById('cp_reg_form_usid').value,document.getElementById('cp_reg_form_uiid').value);
			
		}
	}
	else if($nowstep==5){
			if(document.getElementById('cp_reg_form_uemail').value!=""&&document.getElementById('cp_reg_form_uphone').value!=""&&$uemailok==true&&$uphoneok==true){
			$haveerror=false;
			shownext();
			}else{
				$haveerror=true;
			}
		
	}
}
function shownext(){
	var $tempa='cp_reg_next_btn';
	document.getElementById('cp_reg_next_btn').className="reg_btn_next_now";
}
function showpre(){
	if($nowstep>1){
		document.getElementById('cp_reg_pre_btn').className="reg_btn_pre_now";
	}
}
Vector2 = function (x, y) {
            this.x = x || 0;
            this.y = y || 0;
        };
        Vector2.prototype = {
            sub: function (v1, v2) {
                this.x = v1.x - v2.x;
                this.y = v1.y - v2.y;
                return this;
            },
       rotateSelf: function (p, theta) {
		var v = new Vector2();
v.sub(this, p);
theta *= Math.PI / 180;
 var R = [[Math.cos(theta), -Math.sin(theta)], [Math.sin(theta), Math.cos(theta)]];
this.x = p.x + R[0][0] * v.x + R[0][1] * v.y;
this.y = p.y + R[1][0] * v.x + R[1][1] * v.y;
}
};
function sendmyreg(){
	sentanimation();
    sendmyreg2cp($tuname,$tuemail,$tupass,$tupass2,$turname,$tusid,$tucollege,$tugroupid,$tuphone);
}
function sentanimation(){
	var $tempi=document.getElementById('cp_reg_result');
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
function sendmyreg2cp($getuname,$getuemail,$getupass,$getupass2,$geturname,$getusid,$getucollege,$getugroupid,$getuphone){
	var $tempi=document.getElementById('cp_reg_result');
$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/reg.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{signup_username:$getuname,signup_email:$getuemail,signup_password:$getupass,signup_password_confirm:$getupass2,signup_realname:$geturname,signup_stuid:$getusid,signup_college:$getucollege,signup_groupid:$getugroupid,signup_phone:$getuphone,is_group_admin:$is_g_admin,need_group_creation:$need_c_g,group_name:$umgroupname}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 
					$tempi.innerHTML=data.info;
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$tempi.innerHTML="请求超时,<br></br>亲，请<div onclick=\"javascript:sendmyreg();\">点击重试</div>~~"
	             }
                 
});
};
function regok(){
	//alert("ok");
}
function regerror(){
	//alert("not ok");
}
function cp_reg_group_join(){
	//alert(document.getElementById('cp_reg_group_join').className);
	//alert(document.getElementById('cp_reg_group_new').className);
	document.getElementById('cp_reg_group_j').className="cp_reg_group_join_now";
	document.getElementById('cp_reg_group_n').className="cp_reg_group_new_none";
	$is_g_admin=0;
	$need_c_g=0;
	//alert(document.getElementById('cp_reg_group_join').className);
	//alert(document.getElementById('cp_reg_group_new').className);
}
function cp_reg_group_new(){
	document.getElementById('cp_reg_group_n').className="cp_reg_group_new_now";
	document.getElementById('cp_reg_group_j').className="cp_reg_group_join_none";
	$is_g_admin=1;
	$need_c_g=1;
	
}
function cp_reg_group_jump(){
	$umgroupid=0;
	$is_g_admin=0;
	$need_c_g=0;
	shownext();
}
function checkuname(){
	var $objuname=document.getElementById('cp_reg_form_uname');
	$uname=$objuname.value;
	$haveerror=true;
	if($uname==""){return;}
	var $objuname_tip=document.getElementById('cp_reg_form_uname_tip');
	$objuname.className="input_no";
	$objuname_tip.innerHTML="<img src=\"img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\">查询用户名中```";
	$nowtip="cp_reg_form_uname_tip";
	hidetip_now("base");
	showtip_now("base");
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"uname",uname:$uname}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
					$objuname.className="input_ok";
					$unameok=true;
					$haveerror=false;
					$objuname_tip.innerHTML="登录名由6~18位英文大小写字母，数字组成。";
					$nowtip="cp_reg_form_uname_tip";
					hidetip_now("base");
					checkclear();
					 }
					 else{
						 $objuname.className="input_error";
						 $unameok=false;
						 $haveerror=true;
						 $nowtip="cp_reg_form_uname_tip";
						 hidetip_now("base");
						 showtip_now("error");
						 $objuname_tip.innerHTML=data.info;
						 
					 }
					 
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$objuname_tip.innerHTML="请求超时";
	             }
                 
});

}
function checkuemail(){
	$haveerror=true;
	var $objemail=document.getElementById('cp_reg_form_uemail');
	$email=$objemail.value;
	if($email==""){return;}
	var $objemail_tip=document.getElementById('cp_reg_form_uemail_tip');
	$objemail.className="input_no";
	var CheckMail = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
 	if (!CheckMail.test($email))
 	{
		 $objemail.className="input_error";
 		 $objemail_tip.innerHTML="邮箱格式不正确";
		 $nowtip="cp_reg_form_uemail_tip";
		 hidetip_now("base");
		 showtip_now("error");
		 $haveerror=true;
		 return;
 	}
	$objemail_tip.innerHTML="<img src=\"img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\">查询email中```";
	$nowtip="cp_reg_form_uemail_tip";
	hidetip_now("base");
	showtip_now("base");
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"uemail",email:$email}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
					$objemail.className="input_ok";
					$uemailok=true;
					$objemail_tip.innerHTML="请输入邮箱。";
					$nowtip="cp_reg_form_uemail_tip";
					hidetip_now("base");
					$haveerror=false;
					checkclear();
					 }
					 else{
						 $objemail.className="input_error";
						 $uemailok=false;
						 $haveerror=true;
						 $objemail_tip.innerHTML=data.info;
						 $nowtip="cp_reg_form_uemail_tip";
						 hidetip_now("base");
						 showtip_now("error");
						 checkclear();
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$objemail_tip.innerHTML="请求超时";
	             }
                 
});

}
function checkuser($realname,$realid,$idcardid){
	$uxy="信软";
	$haveerror=true;
	var $objugroup_tip=document.getElementById('cp_reg_form_ugroup_notice');
	$objugroup_tip.innerHTML="查询用户信息中```";
	
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"urname",rname:$realname,sid:$realid,iid:$idcardid}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						$haveerror=false;
						showtip_tip_u2();
						shownext();
						return "ok";
					 }
					 else{
						 $objugroup_tip.innerHTML=data.info;
						 $haveerror=true;
						 showtip_tip_u2();
						 return data.info;
						 
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$objugroup_tip.innerHTML="请求超时";
	             }
                 
});
}
function check_ucgroup(){
	$haveerror=true;
	var $objugroupa=document.getElementById('cp_reg_form_ucgroup');
	var $objugroupa_tip=document.getElementById('cp_reg_form_creat_g_result');
	$objugroupa.className="input_no";
	$objugroupa_tip.innerHTML="<canvas id=\"creat_canvas\"><img src=\"img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\"></canvas>";
	var canvas = document.getElementById("creat_canvas");
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
   		drawLoading();
	}
	CANVASLOOP=setInterval($aaa, 50);
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"ckgroup",group:$objugroupa.value}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						$objugroupa.className="input_ok";
						$objugroupa_tip.innerHTML="亲，团队名可用~";
						$haveerror=false;
						shownext();
					 }
					 else{
						$objugroupa.className="input_error";
						 $objugroupa_tip.innerHTML=data.info;
						 $haveerror=true;
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$objugroupa_tip.innerHTML="请求超时";
	             }
                 
});
}
function searchnow(){
	var $objugroupa=document.getElementById('cp_reg_form_searchn');
	var $objugroupa_tip=document.getElementById('cp_reg_search_result');
	$objugroupa_tip.innerHTML="<canvas id=\"search_canvas\"><img src=\"img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\"></canvas>";
	var canvas = document.getElementById("search_canvas");
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
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"searchgroup",group:$objugroupa.value}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						var $ii=1;
						var $jj=0;
						$objugroupa_tip.innerHTML="ok!";
						var $temp="<table width=\"200\" border=\"0\" cellspacing=\"10\" cellpadding=\"0\">\n";
						for($ii=0;$ii<data.total;$ii++){
							if(($ii+1)%4==3){$temp=$temp+"<tr>\n"}
							if(data.total=="1"||data.total==1){
							$temp=$temp+"<td><div cpregtype=\"cp_reg_res\" class=\"alittleright\" onclick=\"javascript:selectgroup('"+data.gname+"',"+data.gid+");\">&nbsp;"+data.gname+"&nbsp;by:&nbsp;"+data.cname+"&nbsp;</div></td>\n";
							}else{
								$temp=$temp+"<td><div cpregtype=\"cp_reg_res\"  onclick=\"javascript:selectgroup('"+data.gname[$ii]+"',"+data.gid[$ii]+");\">&nbsp;"+data.gname[$ii]+"&nbsp;by:&nbsp;"+data.cname[$ii]+"&nbsp;</div></td>\n";
								}

							
							if(($ii+1)%4==0){$temp=$temp+"</tr>\n"}
						}
						$temp=$temp+"</table>\n";
						$objugroupa_tip.innerHTML=$temp;
					 }
					 else{
						 $objugroupa_tip.innerHTML=data.info;
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$objugroupa_tip.innerHTML="请求超时";
	             }
                 
});
}
function selectgroup($gname,$gid){
	$umgroupname=$gname;
	$umgroupid=$gid;
	$haveerror=false;
	shownext();
}

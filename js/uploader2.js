inittips();
function inittips(){
	if($nowstep==1){
		document.getElementById('cp_reg_form_ugroup-g').addEventListener("click",shownext,false);
		isregclosed();
		document.getElementById('cp_reg_form_pname').disabled=0;
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
	}
	if($nowstep==4){
	var $tempa='cp_reg_form_pname';
	var $aaa=document.getElementById($tempa);
	$aaa.addEventListener("focus",showtip_tip_pname,false);
	$aaa.addEventListener("blur",hidetip_tip_pname,false);
	$aaa.addEventListener("click",clearthis,false);
	}
	if($nowstep==5){
		var $aaa=document.getElementById('pdfpreview');
		$aaa.innerHTML="<iframe src=\"http://api.scie.in/reader/index.php?pid="+$pid+"&type=1\" class=\"pdfpreview\"></iframe>";
		var $ccc=function(){shownext();};
			setTimeout($ccc,3000);
	}
	if($nowstep==6){
		sentanimation();
		var $ddd=function(){upok();};
		setTimeout($ddd,3000);
	}
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
function closetips(){
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
	$tempa='cp_reg_form_upass';
	$aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_upass,false);
	$aaa.removeEventListener("blur",hidetip_tip_upass,false);
	$aaa.removeEventListener("click",clearthis,false);
	}
	if($nowstep==4){
	hideup();
	var $tempa='cp_reg_form_pname';
	var $aaa=document.getElementById($tempa);
	$aaa.removeEventListener("focus",showtip_tip_pname,false);
	$aaa.removeEventListener("blur",hidetip_tip_pname,false);
	$aaa.removeEventListener("click",clearthis,false);
	}
	if($nowstep==5){
	var $aaa=document.getElementById('pdfpreview');
	$aaa.innerHTML="";
	}
}
function allclean(){
	document.getElementById('cp_reg_form_uname').value="";
	document.getElementById('cp_reg_form_upass').value="";
	document.getElementById('cp_reg_form_pname').value="";
}
function checkclear(){
	if($nowstep==3)
	{
		if(document.getElementById('cp_reg_form_upass').value!=""&&document.getElementById('cp_reg_form_upass').value!=""&&$haveerror==false&&$uok==true){
			shownext();
		}
	}
	else if($nowstep==4){
		if(document.getElementById('cp_reg_form_pname').value!=""&&$pok==true&&$upok==true&&$haveerror==false){
			shownext();
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
function showup(){
	document.getElementById('vault1').className="cp_up_uploader_now";
}
function hideup(){
	document.getElementById('vault1').className="cp_up_uploader_over";
	$ccc=function(){document.getElementById('vault1').className="cp_up_uploader_none";}
	setTimeout($ccc,2000);
}
function upok(){
	var $tempi=document.getElementById('cp_reg_result');
	$tempi.innerHTML="亲~~恭喜你，文件上传成功~~";
}
function checku(){
	var $objuname=document.getElementById('cp_reg_form_uname');
	$uname=$objuname.value;
	var $objupass=document.getElementById('cp_reg_form_upass');
	$upass=$objupass.value;
	if($upass==""||$uname==""){return;}
	var $objutip=document.getElementById('cp_reg_form_upass_tip');
	$objuname.className="input_no";
	$objutip.innerHTML="<img src=\"img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\">查询用户中```";
	$nowtip="cp_reg_form_upass_tip";
	hidetip_now("base");
	showtip_now("base");
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api//index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"u",uname:$uname,uiid:$upass}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 $is_g_admin=1; 
						 $is_g_admin=data.isgadmin;
						if($is_g_admin!=1){
							$objuname.className="input_error";
							$objupass.className="input_error";
							$objutip.innerHTML="只能由小组组长上传。";
							$uok=false;
							$nowtip="cp_reg_form_upass_tip";
							hidetip_now("base");
							showtip_now("error");
							$ccc=function(){gotomainsite();return;};
							setTimeout($ccc,3000);
						}
						else{$objuname.className="input_ok";
							$objupass.className="input_ok";
							$objutip.innerHTML="检测成功。";
							$nowtip="cp_reg_form_upass_tip";
							hidetip_now("base");
							shownext();
						}
					 }
					 else{
						$objuname.className="input_error";
						$objupass.className="input_error";
						$objutip.innerHTML=data.info;
						$uok=false;
						 $nowtip="cp_reg_form_upass_tip";
						 hidetip_now("base");
						 showtip_now("error");
					 }
					 
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$objutip.innerHTML="请求超时";
	             }
                 
});
}
function checkp(){
	var $objpname=document.getElementById('cp_reg_form_pname');
	$pname=$objpname.value;
	var $objuname=document.getElementById('cp_reg_form_uname');
	$uname=$objuname.value;
	var $objupass=document.getElementById('cp_reg_form_upass');
	$upass=$objupass.value;
	if($pname==""||$upass==""||$uname==""||$ucdisabled==1){return;}
	var $objutip=document.getElementById('cp_reg_form_pname_tip');
	$objuname.className="input_no";
	$objutip.innerHTML="<img src=\"img/loading.gif\" width=\"20\" height=\"20\" alt=\"loading\">查询项目中```";
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api//index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"p",pname:$pname,uname:$uname,upass:$upass}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
				 if(data.flag=="ok"){
					$objpname.className="input_ok";
					$pid=data.pid;
					$objutip.innerHTML="检测成功。";
					$nowtip="cp_reg_form_pname_tip";
					hidetip_now("base");
					$ucdisabled=1;
					$objpname.disabled=1;
					doOnLoad();
					showup();
					vault.setFormField("pid", $pid);
					vault.setFormField("ftype", "1");
					return;
					}
				else if(data.flag=="ok2"){
					$objpname.className="input_ok";
					$pid=data.pid;
					$objutip.innerHTML="已创建项目:"+$pname;
					$nowtip="cp_reg_form_pname_tip";
					$ucdisabled=1;
					$objpname.disabled=1;
					hidetip_now("base");
					showtip_now("base");
					doOnLoad();
					showup();
					vault.setFormField("pid", $pid);
					vault.setFormField("ftype", "1");
					$ccc=function(){hidetip_now("base");return;};
						setTimeout($ccc,3000);
					 }
				else if(data.flag=="error1"){
					$objpname.className="input_ok";
					$pid=data.pid;
					$objutip.innerHTML="小组已存在项目:"+data.pname;
					$objpname.value=data.pname;
					$nowtip="cp_reg_form_pname_tip";
					$ucdisabled=1;
					$objpname.disabled=1;
					hidetip_now("base");
					showtip_now("base");
					doOnLoad();
					showup();
					vault.setFormField("pid", $pid);
					vault.setFormField("ftype", "1");
					$ccc=function(){hidetip_now("base");return;};
						setTimeout($ccc,3000);
				}else{
						$objpname.className="input_error";
						$objutip.innerHTML=data.info;
						$uok=false;
						 $nowtip="cp_reg_form_pname_tip";
						 hideup();
						 hidetip_now("base");
						 showtip_now("error");
					 }
					 
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						$objutip.innerHTML="请求超时";
	             }
                 
});
}
function gotomainsite(){
	window.location="/";
}

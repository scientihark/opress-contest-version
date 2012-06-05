$choosed_id=0;
$vo_parent=0;
$(document).ready(function(){
		$('.boxgrid.slideright').hover(function(){
			$(".cover", this).stop().animate({left:'325px'},{queue:false,duration:300});
		}, function() {
			$(".cover", this).stop().animate({left:'0px'},{queue:false,duration:300});
		});
});
$(function() {
	$(".vote").click(
	function(){
		$choosed_id = $(this).attr("rel");
		$vo_parent = $(this);
		showup_votes();
	});
});
function sentanimation(){
	var $tempi=document.getElementById('vo_content');
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
function vo_step_v(){
	sentanimation();
	document.getElementById('vo_steptitle').innerHTML="投票中~~~小等一下吧，亲~~";
	$u_iid=document.getElementById('vo_uiid').value;
	$u_sid=document.getElementById('vo_usid').value;
	document.getElementById('vo_bt_l_ok').className="vo_none";
	document.getElementById('vo_bt_l_nok').className="vo_none";
	document.getElementById('vo_uiid').className="vo_none";
	document.getElementById('vo_usid').className="vo_none";
	if($u_iid==""||$u_sid==""){return;}
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"../api/vote.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{usid:$u_sid,uiid:$u_iid,pid:$choosed_id}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					 if(data.flag=="ok"){
						 document.getElementById('vo_steptitle').innerHTML="";
						 document.getElementById('vo_content').innerHTML="投票成功~~~"+data.info;
						 $vo_parent.html(data.p_num);
						 $ccc=function(){hide_notice();}
						setTimeout($ccc,5000);
						return;
					 }
					 else{
						document.getElementById('vo_steptitle').innerHTML="";
						document.getElementById('vo_content').innerHTML="投票失败<br>"+data.info;
						$ccc=function(){hide_notice();}
						setTimeout($ccc,5000);
					 }
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						document.getElementById('vo_content').innerHTML="请求超时";
						$ccc=function(){hide_notice();}
						setTimeout($ccc,2000);
	             }
                 
});	
}
function showup_votes(){
	$info="<div width=\"100%\"><div id=\"vo_atitle\">大赛投票</div><div id=\"vo_steptitle\" class=\"vo_now\">即将为XXX投票 请仔细阅读投票须知</div></div><div class=\"vo_now\" id=\"vo_content\"><textarea rows=\"12\" cols=\"90\" readonly=\"readonly\" id=\"vo_ulicense_words\" >要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求要求</textarea></div><input id=\"vo_uiid\" vo=\"input\" placeholder=\"请输入身份证号\"  value=\"\" class=\"input_no\"><input id=\"vo_usid\" vo=\"input\" placeholder=\"请输入学号\"  value=\"\" class=\"input_no\"><br><div id=\"vo_bt_l_ok\" vo=\"btn\" onclick=\"javascript:vo_step_v();\" class=\"vo_now\">同意</div>&nbsp;&nbsp;&nbsp;<div id=\"vo_bt_l_nok\" vo=\"btn\" onclick=\"javascript:hide_notice();\" class=\"vo_now\">不同意</div>";
		show_notice($info);
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
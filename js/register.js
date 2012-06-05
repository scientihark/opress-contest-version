$nowstep=1;
$haveerror=false;
$isgroup=false;
$liense=false;
$uxy="XXX";
$umgroupid=0;
$is_g_admin=0;
$need_c_g=0;
$umgroupname="未加入";
$umgroupid=0;
$tuname="NULL";
$tupass="NULL";
$tupass2="NULL";
$tuemail="NULL";
$turname="NULL";
$tusid="NULL";
$tucollege="NULL";
$tugroupname="NULL";
$tugroupid="NULL";
$tuphone="NULL";


function setgroup_g(){
	$isgroup=true;
	next_step();
}
function setgroup_ng(){
	$isgroup=false;
	next_step();
}
function next_step(){
	if($haveerror||$nowstep>7){return;}
	var $tempa='cp_reg_step_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_steps_over";
	$tempa='cp_reg_step'+$nowstep;
	document.getElementById($tempa).className="reg_step_over";
	$tempa='cp_reg_form_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_forms_over";
	closetips();
	$nowstep++;
	$tempa='cp_reg_step_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_steps_now";
	$tempa='cp_reg_step'+$nowstep;
	document.getElementById($tempa).className="reg_step_now";
	$tempa='cp_reg_form_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_forms_now";
	var $bbb=function nextbtnreset(){document.getElementById('cp_reg_next_btn').className="reg_btn_next_none";}
	var $aaa=function nextbtnfadeout(){document.getElementById('cp_reg_next_btn').className="reg_btn_next_over";setTimeout($bbb,1000);}
	setTimeout($aaa,500);
	showpre();
	inittips();
		//document.getElementById('upanel_panelct').innerHTML="<b>◎</b>";
		//document.getElementById('upanel_panel').style.opacity=0;
		//document.getElementById('upanel_panel').style.top="10px";
		//var $tempstr2="document.getElementById('upanel_panel').style.opacity=1;";
		//var $tempstr1="document.getElementById('upanel_panel').style.top=\"50px\";";
		//setTimeout($tempstr2,100);
		//setTimeout($tempstr1,100);
}
function pre_step(){
	if($haveerror){return;}
	var $tempa='cp_reg_step_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_steps_none";
	$tempa='cp_reg_step'+$nowstep;
	document.getElementById($tempa).className="reg_step_none";
	$tempa='cp_reg_form_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_forms_none";
	closetips();
	$nowstep--;
	$tempa='cp_reg_step_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_steps_now";
	$tempa='cp_reg_step'+$nowstep;
	document.getElementById($tempa).className="reg_step_now";
	$tempa='cp_reg_form_'+$nowstep;
	document.getElementById($tempa).className="cp_reg_forms_now";
	document.getElementById('cp_reg_pre_btn').className="reg_btn_pre_over";
	var $aaa=function prebtnfadein(){document.getElementById('cp_reg_pre_btn').className="reg_btn_next_none";setTimeout(showpre,500);}
	setTimeout($aaa,500);
	inittips();
		//document.getElementById('upanel_panelct').innerHTML="<b>◎</b>";
		//document.getElementById('upanel_panel').style.opacity=0;
		//document.getElementById('upanel_panel').style.top="10px";
		//var $tempstr2="document.getElementById('upanel_panel').style.opacity=1;";
		//var $tempstr1="document.getElementById('upanel_panel').style.top=\"50px\";";
		//setTimeout($tempstr2,100);
		//setTimeout($tempstr1,100);
}
$nowtip="";
$unameok=false;
$upassok=false;
$upass2ok=false;
$urnameok=true;
$usidok=true;
$uiidok=true;
$uemailok=false;
$uphoneok=false;
$uinfook=true;
$unameoka=false;
$upassoka=false;
$upass2oka=false;
$urnameoka=false;
$usidoka=false;
$uiidoka=false;
$uemailoka=false;
$uphoneoka=false;
$uinfooka=false;
function checkupass(){
	$upassok=true;
	}
function checkuphone(){
	var $tempa=/^((\(\d{3}\))|(\d{3}\-))?13\d{9}|15\d{9}$/;
	if(document.getElementById('cp_reg_form_uphone').value==""){return;}
	var $tempb=document.getElementById('cp_reg_form_uphone').value;
	if( $tempb.length!=11||!$tempb.match($tempa) ){  
		document.getElementById('cp_reg_form_uphone_tip').innerHTML="请输入正确的手机号码";
		document.getElementById('cp_reg_form_uphone').className="input_error";
		$nowtip="cp_reg_form_uphone_tip";
		hidetip_now("base");
		showtip_now("error");
		$uphoneok=false;
	}else{
		document.getElementById('cp_reg_form_uphone_tip').innerHTML="请输入手机号。";
		document.getElementById('cp_reg_form_uphone').className="input_ok";
		$nowtip="cp_reg_form_uphone_tip";
		hidetip_now("base");
		$uphoneok=true;
	}
	}
function checkuinfo(){
	$uinfook=true;
	}
function checkupass2(){
	if(document.getElementById('cp_reg_form_upass').value==document.getElementById('cp_reg_form_upass2').value){
	$upass2ok=true;
	$haveerror=false;
	}else{$upass2ok=false;$haveerror=true;}
	}
function checkurname(){
	$urnameok=true;
	}
function checkusid(){
	$usidok=true;
	}
function checkuiid(){
	$haveerror=true;
	var $tempa=checkIdcard(document.getElementById('cp_reg_form_uiid').value);
	if($tempa!="验证通过!"){
		document.getElementById('cp_reg_form_uiid_tip').innerHTML=$tempa;
		document.getElementById('cp_reg_form_uiid').className="input_error";
		$nowtip="cp_reg_form_uiid_tip";
		$uiidok=false;
		$haveerror=true;
		hidetip_now("base");
		showtip_now("error");
	}else{
		document.getElementById('cp_reg_form_uiid_tip').innerHTML="请输入身份证号，我们将查询教务处数据库，以核对身份信息。";
		document.getElementById('cp_reg_form_uiid').className="input_ok";
		$nowtip="cp_reg_form_uiid_tip";
		hidetip_now("base");
		$haveerror=false;
		checkclear();
	}
	}
function showtip_tip_uname(){
	if($unameok!=false||$unameoka==false){
	$nowtip="cp_reg_form_uname_tip";
	showtip_now("base");
	$unameoka=true;
	}
}
function hidetip_tip_uname(){
	$haveerror=true;
	checkuname();
}
function showtip_tip_upass(){
	if($upassok==false){
	$nowtip="cp_reg_form_upass_tip";
	}else{
	$nowtip="cp_reg_form_upass_tip";
	}
	showtip_now("base");
}
function hidetip_tip_upass(){
	checkupass();
	if($upassok!=false||$upassoka==false){
	$nowtip="cp_reg_form_upass_tip";
	hidetip_now("base");
	$upassoka=true;
	}else{
	}
	if(document.getElementById('cp_reg_form_upass2').value!=""){
		hidetip_tip_upass2();
		
	}
	checkclear();
}
function showtip_tip_upass2(){
	
	if($upass2ok==false){
		$nowtip="cp_reg_form_upass2_tip";
	}else{
	$nowtip="cp_reg_form_upass2_tip";
	}
	showtip_now("base");
	checkclear();
}
function hidetip_tip_upass2(){
	checkupass2();
	if($upass2ok==false){
	$nowtip="cp_reg_form_upass2_tip";
	hidetip_now("base");
	//alert(0);
	showtip_now("error");
	}else{
	$nowtip="cp_reg_form_upass2_tip";
	hidetip_now("base");
	checkclear();
	}
}
function showtip_tip_urname(){
	if($urnameok==false){
		
	}else{
	$nowtip="cp_reg_form_urname_tip";
	}
	showtip_now("base");
}
function hidetip_tip_urname(){
	checkurname();
	if($urnameok==false){
		
	}else{
	$nowtip="cp_reg_form_urname_tip";
	hidetip_now("base");
	}
}
function showtip_tip_usid(){
	if($usidok==false){
		
	}else{
	$nowtip="cp_reg_form_usid_tip";
	}
	showtip_now("base");
}
function hidetip_tip_usid(){
	checkusid();
	if($upassok==false){
		
	}else{
	$nowtip="cp_reg_form_usid_tip";
	hidetip_now("base");
	}
	checkclear();
}
function showtip_tip_uiid(){
	
	if($uiidok!=false){
		$nowtip="cp_reg_form_uiid_tip";
		showtip_now("base");
		checkclear();
	}
}
function hidetip_tip_uiid(){
	checkuiid();
}
function showtip_tip_uemail(){
	if($uemailok!=false||$uemailoka==false){
		$nowtip="cp_reg_form_uemail_tip";
		showtip_now("base");
		$uemailoka=true;
	}
}
function hidetip_tip_uemail(){
	checkuemail();
}
function showtip_tip_uinfo(){
	
	if($uphoneok==false){
		$nowtip="cp_reg_form_uinfo_tip";
	}else{
	$nowtip="cp_reg_form_uinfo_tip";
	}
	showtip_now("base");
	checkclear();
}
function hidetip_tip_uinfo(){
	checkuphone();
	if($uiidok==false){
	$nowtip="cp_reg_form_uinfotip";
	hidetip_now("base");
	//alert(0);
	showtip_now("error");
	}else{
	$nowtip="cp_reg_form_uinfo_tip";
	hidetip_now("base");
	checkclear();
	}
}
function showtip_tip_uphone(){
	
	if($uphoneok!=false||$uphoneoka==false){
		$nowtip="cp_reg_form_uphone_tip";
		showtip_now("base");
		$uphoneoka=true;
	}
}
function hidetip_tip_uphone(){
	checkuphone();
	if($uphoneok!=false){
	$nowtip="cp_reg_form_uphone_tip";
	hidetip_now("base");
	checkclear();
	}
}
function showtip_tip_u2(){
	document.getElementById('cp_reg_form_ugroup_notice').innerHTML="所在学院： "+$uxy+"学院";
}
function hidetip_tip_u2(){
	document.getElementById('cp_reg_form_ugroup_notice').innerHTML="";
}
function showtip_now($aa){
	document.getElementById($nowtip).className="reg_tip_now reg_tip_type_"+$aa;
}
function hidetip_now($aa){
	document.getElementById($nowtip).className="reg_tip_none reg_tip_type_"+$aa;
}
function clearthis(){
	this.value="";
}
function show_btnl(){
	document.getElementById('cp_reg_lbtn_say').className="reg_lbtn_now";
}
function hide_btnl(){
	document.getElementById('cp_reg_lbtn_say').className="reg_lbtn_none";
}
function show_btnlb(){
	document.getElementById('cp_reg_lbtn_say').className="reg_lbtn_none";
	document.getElementById('cp_reg_lbtn_read').className="reg_lbtnb_now";
}
function liense_ok(){
	$liense=true;
	document.getElementById('cp_reg_lbtn_read').className="reg_lbtnb_none";
	next_step();
}
function liense_nok(){
	window.location="/";
}
function isregclosed(){
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"regopen"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					if(data.flag!="ok"){
					document.getElementById('cp_reg_form_notice_inside').innerHTML=data.info;
					document.getElementById('cp_reg_form_notice').className="reg_notice_now";
					document.getElementById('cp_reg_form_notice_shadow').className="reg_notice_shadow_now";
					$haveerror=true;
					}
					return false;
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						
	             }
                 
});
}
<!--
function checkIdcard(idcard){
var Errors=new Array(
"验证通过!",
"身份证号码位数不对!",
"身份证号码出生日期超出范围或含有非法字符!",
"身份证号码校验错误!",
"身份证地区非法!"
);
var area={11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古",21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏",33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南",42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆",51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃",63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"}

var idcard,Y,JYM;
var S,M;
var idcard_array = new Array();
idcard_array = idcard.split("");
//地区检验
if(area[parseInt(idcard.substr(0,2))]==null) return Errors[4];
//身份号码位数及格式检验
switch(idcard.length){
case 15:
if ( (parseInt(idcard.substr(6,2))+1900) % 4 == 0 || ((parseInt(idcard.substr(6,2))+1900) % 100 == 0 && (parseInt(idcard.substr(6,2))+1900) % 4 == 0 )){
ereg=/^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}$/;//测试出生日期的合法性
} else {
ereg=/^[1-9][0-9]{5}[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}$/;//测试出生日期的合法性
}
if(ereg.test(idcard)) {
	$uiidok=true;
	return Errors[0];
}
else return Errors[2];
break;
case 18:
//18位身份号码检测
//出生日期的合法性检查
//闰年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))
//平年月日:((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))
if ( parseInt(idcard.substr(6,4)) % 4 == 0 || (parseInt(idcard.substr(6,4)) % 100 == 0 && parseInt(idcard.substr(6,4))%4 == 0 )){
ereg=/^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|[1-2][0-9]))[0-9]{3}[0-9Xx]$/;//闰年出生日期的合法性正则表达式
} else {
ereg=/^[1-9][0-9]{5}19[0-9]{2}((01|03|05|07|08|10|12)(0[1-9]|[1-2][0-9]|3[0-1])|(04|06|09|11)(0[1-9]|[1-2][0-9]|30)|02(0[1-9]|1[0-9]|2[0-8]))[0-9]{3}[0-9Xx]$/;//平年出生日期的合法性正则表达式
}
if(ereg.test(idcard)){//测试出生日期的合法性
//计算校验位
S = (parseInt(idcard_array[0]) + parseInt(idcard_array[10])) * 7
+ (parseInt(idcard_array[1]) + parseInt(idcard_array[11])) * 9
+ (parseInt(idcard_array[2]) + parseInt(idcard_array[12])) * 10
+ (parseInt(idcard_array[3]) + parseInt(idcard_array[13])) * 5
+ (parseInt(idcard_array[4]) + parseInt(idcard_array[14])) * 8
+ (parseInt(idcard_array[5]) + parseInt(idcard_array[15])) * 4
+ (parseInt(idcard_array[6]) + parseInt(idcard_array[16])) * 2
+ parseInt(idcard_array[7]) * 1
+ parseInt(idcard_array[8]) * 6
+ parseInt(idcard_array[9]) * 3 ;
Y = S % 11;
M = "F";
JYM = "10X98765432";
M = JYM.substr(Y,1);//判断校验位
if(M == idcard_array[17]) {
	$uiidok=true;
	return Errors[0];
}//检测ID的校验位
else return Errors[3];
}
else return Errors[2];
break;
default:
return Errors[1];
break;
}

}
//-->

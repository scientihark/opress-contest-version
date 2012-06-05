var vault = null;
$pid=1;
$nowstep=1;
$haveerror=false;
$isgroup=false;
$liense=false;
$is_g_admin=0;
$need_c_g=0;
$ucdisabled=0;
$nowtip="";
$uok=true;
function checkuok(){
	$uok=true;
	}
function next_step(){
	if($haveerror||$nowstep>5){return;}
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
        function doOnLoad() {
            vault = new dhtmlXVaultObject();
            vault.setImagePath("img/");
            vault.setServerHandlers("/api/uploader/UploadHandler.php", "/api/uploader/GetInfoHandler.php", "/api/uploader/GetIdHandler.php");
	    	vault.isDemo = true;
			vault.setFilesLimit(1);
			vault.onAddFile = function(fileName) { 
			var ext = this.getFileExtension(fileName); 
			if (ext != "pdf"&&ext != "doc"&&ext != "docx"&&ext != "ppt"&&ext != "pptx" ) 
			{ 
				alert("亲，目前只允许上传(pdf/doc/docx/ppt/pptx)~~"); 
				return false; 
			} 
			else 
			{
				return true;
			}
			};
			vault.onFileUploaded = function(file) { 
				shownext();
			};
			vault.strings = { 
			remove: "删除", done: "完成", error: "错误", btnAdd: "添加文件", btnUpload: "上传", btnClean: "清空" 
			};
			vault.strings.errors = { 
			"TooBig": "文件太大了亲， (它有{0} bytes).\n目前最大允许上传 {1} 哦.", 
			"PostSize": "亲~你有麻烦咯~ :\n"+ "- 如果你是第一次看到这个，请确保文件名不包含中文、空格和符号;\n"+ "- 如果反复出现这个错误，请联系管理员亲." 
			};
            vault.create("vault1");
			//vault.setFormField("upass", "1");
	}
function showtip_now($aa){
	document.getElementById($nowtip).className="reg_tip_now reg_tip_type_"+$aa;
}
function hidetip_now($aa){
	document.getElementById($nowtip).className="reg_tip_none reg_tip_type_"+$aa;
}
function showtip_tip_uname(){
	$nowtip="cp_reg_form_uname_tip";
	showtip_now("base");
}
function hidetip_tip_uname(){
	$nowtip="cp_reg_form_uname_tip";
	hidetip_now("base");
}
function showtip_tip_upass(){
	$nowtip="cp_reg_form_upass_tip";
	showtip_now("base");
}
function hidetip_tip_upass(){
	checku();
}
function clearthis(){
	this.value="";
}
function showtip_tip_pname(){
	$nowtip="cp_reg_form_pname_tip";
	showtip_now("base");
}
function hidetip_tip_pname(){
	checkp();
}
function isregclosed(){
	$.ajax({
                 type:"POST",
                 dataType:"json",
                 url:"api/index.php",
                 timeout:80000,	   //ajax请求超时时间80秒
                 data:{checktype:"upopen"}, //40秒后无论结果服务器都返回数据
                 success:function(data,textStatus){
                     //从服务器得到数据，显示数据并继续查询
					if(data.flag!="ok"){
					document.getElementById('cp_reg_form_notice_inside').innerHTML=data.info;
					document.getElementById('cp_reg_form_notice').className="reg_notice_now";
					document.getElementById('cp_reg_form_notice_shadow').className="reg_notice_shadow_now";
					}
					return false;
	             },
				 //Ajax请求超时，继续查询
	             error:function(XMLHttpRequest,textStatus,errorThrown){
						
	             }
                 
});
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

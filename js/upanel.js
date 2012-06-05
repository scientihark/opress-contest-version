$nowclick="home";
$nowuser_id=0;
$nowuser_name=0;
$nowuser_tname=0;
$nowuser_gname=0;
$nowuser_gid=0;
$nowuser_cid=0;
$nowuser_sid=0;
$nowuser_xy=0;
$nowuser_pid=0;
$nowuser_email=0;
$nowuser_phone=0;
$nowuser_captain=0;
$gn_allow_pre=false;
$gn_allow_pre_m=false;
$gn_allow_add=false;
$gn_allow_edit=false;
$gn_allow_del=false;
$gn_allow_next=false;
$gn_allow_next_m=false;
$todo_allow_pre=false;
$todo_allow_pre_m=false;
$todo_allow_next=false;
$todo_allow_next_m=false;
$pl_allow_add=false;
$pdes_allow_edit=false;

$MPST_help="不支持BBcode/Html/Js等,请使用MPST(Members' Panel Simple Text)<br>[简易说明：输入<b>|br|</b>代表换行符,<b>|b|xxx|/b|</b>代表加粗xxx,<b>|url|xxx地址|/url|</b>代表添加到xxx的链接,<b>|img|图片地址|/img|</b>代表添加图片]<br>";
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

function up_lbtn_click($id){
	document.getElementById('upanel-u-btn_now').className="up_lbtn_n_"+$id;
	var $tempa='upanel-u-btn_'+$nowclick;
	document.getElementById($tempa).className="up_lbtn_none";
	$tempa='upanel-u-btn_'+$id;
	document.getElementById($tempa).className="up_lbtn_now";
	document.getElementById('up_right_content').className="up_r_"+$id;
	$nowclick=$id;
	var $title_name={"home":"面板首页","info":"我的信息","group":"我的团队","project":"我的项目","center":"大赛中心"};
	var $state={
		tittle:$title_name[$id]+"_参赛者面板_长虹杯--电子设计大赛--2012软件设计竞赛--电子科技大学信息与软件工程学院--Powered by countpress",
		url:"http://contest.scie.in/mpanel.html?"+$id,
		action:$id
	}
	history.pushState($state,$state['tittle'],$state['url']);
	document.title=$state['tittle'];
}
function go_home(){
	up_lbtn_click("home");
	//this.className="up_lbtn_now";
}
function go_info(){
	up_lbtn_click("info");
	//this.className="up_lbtn_now";
}
function go_group(){
	up_lbtn_click("group");
	//this.className="up_lbtn_now";
}
function go_project(){
	up_lbtn_click("project");
	//this.className="up_lbtn_now";
}
function go_center(){
	up_lbtn_click("center");
	//this.className="up_lbtn_now";
}
function go_back(){
	window.location="/";
}
function openlogoup() {
            vault = new dhtmlXVaultObject();
            vault.setImagePath("img/");
            vault.setServerHandlers("/api/uploader/pic_UploadHandler.php", "/api/uploader/GetInfoHandler.php", "/api/uploader/GetIdHandler.php");
	    	vault.isDemo = true;
			vault.setFilesLimit(1);
			vault.onAddFile = function(fileName) { 
			var ext = this.getFileExtension(fileName); 
			if (ext != "png") 
			{ 
				alert("亲，目前只允许上传(png)~~"); 
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
	}
<?php
header("Content-Type:text/html;charset=utf8"); 
date_default_timezone_set('PRC');
include( "conf.php" );
$con = mysql_connect($dbserver,$dbuser,$dbpass);
$db_selected = mysql_select_db($dbs, $con);
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
set_time_limit(0);//无限请求超时时间
function myempty($myinput){
	if(empty($myinput)&&$myinput!=0)
	{
		return false;
	}
}
function getsafeinfo($inputinfo){
$tpa=explode(";",$inputinfo);
$tpa=explode(" ",$tpa[0]);
$tpa=explode(",",$tpa[0]);
$tpa=explode("+",$tpa[0]);
$tpa=explode("?",$tpa[0]);
$tpa=explode("*",$tpa[0]);
$tpa=explode("=",$tpa[0]);
$okinfo="";
return $tpa[0];
}
	if(myempty($_POST['signup_username'])){
		echo 'signup_username';
		}
		if(myempty($_POST['signup_username'])){
		echo 'signup_username';
		}
		if(myempty($_POST['signup_email'])){
		echo 'signup_email';
		}
		if(myempty($_POST['signup_password'])){
		echo 'signup_password';
		}
		if(myempty($_POST['signup_password_confirm'])){
		echo 'signup_password_confirm';
		}
		if(myempty($_POST['signup_realname'])){
		echo 'signup_realname';
		}
		if(myempty($_POST['signup_stuid'])){
		echo 'signup_stuid';
		}
		if(myempty($_POST['signup_college'])){
		echo 'signup_college';
		}
		if(myempty($_POST['signup_groupid'])){
		echo 'signup_groupid';
		}if(myempty($_POST['signup_phone'])){
		echo 'signup_phone';
		}if(myempty($_POST['is_group_admin'])){
		echo 'is_group_admin';
		}if(myempty($_POST['need_group_creation'])){
		echo 'need_group_creation';
		}
	if(myempty($_POST['signup_username'])||myempty($_POST['signup_email'])||myempty($_POST['signup_password'])||myempty($_POST['signup_password_confirm'])||myempty($_POST['signup_realname'])||myempty($_POST['signup_stuid'])||myempty($_POST['signup_college'])||myempty($_POST['signup_groupid'])||myempty($_POST['signup_phone'])||myempty($_POST['is_group_admin'])||myempty($_POST['need_group_creation'])||myempty($_POST['group_name'])){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}

$user_login=getsafeinfo($_POST['signup_username']);
$user_name=getsafeinfo($_POST['signup_realname']);
$user_pass=getsafeinfo($_POST['signup_password']);
$user_pass2=getsafeinfo($_POST['signup_password_confirm']);
$user_email=getsafeinfo($_POST['signup_email']);
$user_stuid=getsafeinfo($_POST['signup_stuid']);
$user_groupid=getsafeinfo($_POST['signup_groupid']);
$user_college=getsafeinfo($_POST['signup_college']);
$user_phone=getsafeinfo($_POST['signup_phone']);
$tnow="'".date('Y-m-d H:i:s')."'";
$user_is_group_admin=getsafeinfo($_POST['is_group_admin']);
$user_need_group_creation=getsafeinfo($_POST['need_group_creation']);
$user_group_name=getsafeinfo($_POST['group_name']);

if(myempty($user_login)||myempty($user_pass)||myempty($user_pass2)||myempty($user_email)||myempty($user_stuid)||myempty($user_groupid)||myempty($user_college)||myempty($user_phone)||myempty($user_name)||myempty($user_is_group_admin)||myempty($user_need_group_creation)||myempty($user_group_name)||$user_login==" "||$user_pass==" "||$user_pass2==" "||$user_email==" "||$user_stuid==" "||$user_groupid==$judegsgid||$user_groupid==" "||$user_college==" "||$user_phone==" "||$user_name==" "||$user_is_group_admin==" "||$user_need_group_creation==" "||$user_group_name==" "){
		$info="数据缺失，<br></br>亲，请联系管理员吧~~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
}
$nowtime=time();
$endtime_baomin_s = strtotime($endtime_baomin);
$starttime_baomin_s = strtotime($starttime_baomin);
if($nowtime<$starttime_baomin_s){
		$info="还没开始报名哦~~亲，<br></br>大赛定于".$starttime_baomin."开始哦~~<br></br>亲，不着急的~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
}
if($nowtime>$endtime_baomin_s){
		$info="报名已经结束咯~~亲，<br></br>大赛定于".$starttime_baomin."结束的~~<br></br>亲，别灰心，下次下次再来吧~~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
}
if(($user_is_group_admin!=1&&$user_is_group_admin!=0)||($user_need_group_creation!=1&&$user_need_group_creation!=0)){
	$info="参数错误，<br></br>亲，请联系管理员吧~~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
}
if($user_pass!=$user_pass2){
		$info="两次密码不相等，<br></br>亲，请<div onclick=\"javascript:pre_step();pre_step();pre_step();pre_step();pre_step();\">点击返回第3步</div>~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
foreach($name_not_allowed as $tvalue){
	if($user_name==$tvalue){
		$info="禁止的用户名，<br></br>亲，请<div onclick=\"javascript:pre_step();pre_step();pre_step();pre_step();pre_step();\">点击返回第3步</div>~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
}
$sql1 = "SELECT display_name FROM contest_wp_users WHERE user_email='$user_email'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)!=0){
	$tempresult=mysql_fetch_assoc($result);
	$hisname=$tempresult['display_name'];
	$info="邮箱 $user_email 已被 $hisname 注册，<br></br>亲，请<div onclick=\"javascript:pre_step();pre_step();pre_step();\">点击返回第5步</div>~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
}
$cid=getcid($user_stuid);
$PIN=getPIN($user_stuid);
$sql1 = "INSERT INTO contest_wp_users(user_login,user_pass,user_nicename,user_email,user_registered,user_status,display_name,spam,deleted,PIN,cid)VALUES('$user_login',MD5('$user_pass'),'$user_name','$user_email',$tnow,0,'$user_name',0,0,'$PIN','$cid')";
$result=mysql_query($sql1,$con);
$sql1 = "SELECT ID FROM contest_wp_users WHERE user_email='$user_email'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)==0){
	$info="数据库写入错误，<br></br>亲，请<div onclick=\"javascript:sendmyreg();\">点击重试</div>~~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
}
$okinfo="账号：$user_login 已创建<br>您的大赛报名编号为<br><b>$cid</b><br>您的个人PIN为<br><b>$PIN</b><br>,个人PIN用于提交大赛数据时验证身份，由系统生成，不得修改，请妥善保管。";
$tempresult=mysql_fetch_assoc($result);
$user_wpid=$tempresult['ID'];

if($user_need_group_creation==1){
	foreach($group_not_allowed as $tvalue){
		if($user_group_name==$tvalue){
			$info="禁止的团队名，<br></br>亲，请<div onclick=\"javascript:pre_step();pre_step();\">点击返回第5步</div>~~";
			$err=array('flag'=>"error1",'info'=>$info);
			echo json_encode($err);
			exit();
		}
	}
	$sql1 = "SELECT id,creator_id FROM contest_wp_bp_groups WHERE name='$user_group_name'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)!=0){
		$tempresult=mysql_fetch_assoc($result);
		$tempuser=$tempresult['creator_id'];
		$sql1 = "SELECT display_name FROM contest_wp_users WHERE ID=$tempuser";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$info="数据库读取错误，<br></br>亲，请联系管理员吧~~";
			$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
		}
		$tempresult=mysql_fetch_assoc($result);
		$tempuser=$tempresult['display_name'];
		$info="团队 $user_group_name 已存在<br></br>由 $tempuser 创建，<br></br>亲，请<div onclick=\"javascript:pre_step();pre_step();\">点击返回第5步</div>~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$sql1 = "INSERT INTO contest_wp_bp_groups(creator_id,name,slug,description,status,enable_forum,date_created)VALUES($user_wpid,'$user_group_name','$user_group_name','$user_group_name','private',1,$tnow)";
	//echo $sql1;
	$result=mysql_query($sql1,$con);
	$sql1 = "SELECT id FROM contest_wp_bp_groups WHERE creator_id=$user_wpid and name='$user_group_name' and slug='$user_group_name' and description='$user_group_name' and status='private' and enable_forum=1 and date_created=$tnow";
	//echo $sql1;
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
			$info="创建团队失败，<br></br>亲，请联系管理员吧~";
			$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
	}
	$tempresult=mysql_fetch_assoc($result);
	$user_groupid=$tempresult['id'];
	$sql1 = "INSERT INTO contest_wp_bp_groups_groupmeta(group_id,meta_key,meta_value)VALUES('$user_groupid','last_activity',$tnow)";
	//echo $sql1;
	$result=mysql_query($sql1,$con);
	$sql1 = "INSERT INTO contest_wp_bp_groups_groupmeta(group_id,meta_key,meta_value)VALUES('$user_groupid','total_member_count',1)";
	$result=mysql_query($sql1,$con);
	$okinfo=$okinfo."<br></br>团队：$user_group_name 已创建";
	
}

if($user_groupid!=0&&$user_groupid!=$judegsgid){
	$sql1 = "SELECT name,creator_id FROM contest_wp_bp_groups WHERE id=$user_groupid";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$info="未找到团队 ID:$user_groupid，<br></br>亲，请联系管理员~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$tempresult=mysql_fetch_assoc($result);
	$user_groupname=$tempresult['name'];
	$user_groupadmin_id=$tempresult['creator_id'];
	$sql1 = "INSERT INTO contest_wp_bp_groups_members(group_id,user_id,inviter_id,is_admin,is_mod,date_modified,is_confirmed,is_banned,invite_sent)VALUES($user_groupid,$user_wpid,$user_groupadmin_id,$user_is_group_admin,0,$tnow,1,0,0)";
	$result=mysql_query($sql1,$con);
	$sql1 = "SELECT id  FROM contest_wp_bp_groups_members WHERE group_id=$user_groupid and user_id=$user_wpid and inviter_id=$user_groupadmin_id and is_admin=$user_is_group_admin and is_mod=0 and date_modified=$tnow and is_confirmed=1 and is_banned=0 and invite_sent=0";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
			$info="加入团队失败，<br></br>亲，请联系管理员吧~";
			$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
	}
	$okinfo=$okinfo."<br></br>团队：$user_groupname 已加入";
}
else{
	$user_groupname="未分组";
	$user_groupadmin_id=0;
}

$tpa=array(1,2,3,4,8,11);//真实姓名,学号,所在学院,所属团队name,Email,手机
$tpb=array($user_name,$user_stuid,$user_college,$user_groupname,$user_email,$user_phone);
$ii=0;
for($ii=0;$ii<6;$ii++){
	$now_fileid=$tpa[$ii];
	//if(is_numeric($tpb[$ii])&&$tpb[$ii]>-999999&&$tpb[$ii]<999999){
	//	$myvalue=$tpb[$ii];
	//	}
	//else{
		$myvalue="'".$tpb[$ii]."'";
	//	}
	
	$sql1 = "INSERT INTO contest_wp_bp_xprofile_data(field_id,user_id,value,last_updated)VALUES('$now_fileid','$user_wpid',$myvalue,$tnow)";
	//echo $sql1."||";
	$result=mysql_query($sql1,$con);
	$sql1 = "SELECT id FROM contest_wp_bp_xprofile_data WHERE field_id=$now_fileid and user_id=$user_wpid and value=$myvalue";
	//echo $sql1."||";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
	$info="数据库写入错误 ，<br></br>亲，请联系管理员~~";
		$err=array('flag'=>"error",'info'=>$info."||".$ii);
		echo json_encode($err);
		exit();
	}
}
$sql1 = "INSERT INTO contest_members_info(mid,name,sid,cid,gname,winnership,email,phone)VALUES('$user_wpid','$user_name','$user_stuid','$cid','$user_groupname','0','$user_email','$user_phone')";
//echo $sql1."||";
$result=mysql_query($sql1,$con);
$okinfo="大赛报名成功！<br></br>".$okinfo;
$err=array('flag'=>"ok",'info'=>$okinfo);
echo json_encode($err);


function getcid($user_stuid){
	include("conf.php");
	$shaa=sha1($user_stuid);
	$lentha=strlen($cidfore)+strlen($user_stuid);
	$lenthdeta=32-$lentha;
	return $cidfore.$user_stuid.substr($shaa,5,$lenthdeta);
}
function getPIN($user_stuid){
	return myrandom(6, $user_stuid);
}
function myrandom($length, $type = "") {
    $chars = !$type ? "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz" : "0123456789abcdef";
    $max = strlen($chars) - 1;
    mt_srand((double)microtime() * 1000000);
	$string="";
    for($i = 0; $i < $length; $i++) {
        $string .= $chars[mt_rand(0, $max)];
    }
    return $string;
}
?>
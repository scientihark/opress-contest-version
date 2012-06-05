<?php
header("Content-Type:text/html;charset=utf8"); 
date_default_timezone_set('PRC');
function myempty($myinput){
	if(empty($myinput)&&$myinput!=0)
	{
		return false;
	}
}
function getsafeinfo($inputinfo){
	if(myempty($inputinfo)){return " ";}
$tpa=explode(";",$inputinfo);
$tpa=explode(" ",$tpa[0]);
$tpa=explode(",",$tpa[0]);
$tpa=explode("+",$tpa[0]);
$tpa=explode("?",$tpa[0]);
$tpa=explode("*",$tpa[0]);
$tpa=explode("=",$tpa[0]);
return $tpa[0];
}
$okinfo="";
$tnow="'".date('Y-m-d H:i:s')."'";
function getsafeinfo2($inputinfo){
	if(myempty($inputinfo)){return " ";}
	$tpa=str_replace(";", "；", $inputinfo);
	$tpa=str_replace("<", "&lt;", $tpa);
	$tpa=str_replace(">", "&gt;", $tpa);
	$tpa=str_replace("%", "％", $tpa);
	$tpa=str_replace("&", "&amp;", $tpa);
	$tpa=str_replace(",", "，", $tpa);
	$tpa=str_replace("'", "&apos; ", $tpa);
	$tpa=str_replace("\"", "&quot;", $tpa);
	$tpa=str_replace("?", "&cedil;", $tpa);
	//up_simpele_text
	$tpa=str_replace("|br|", "<br>", $tpa);
	$tpa=str_replace("|b|", "<b>", $tpa);
	$tpa=str_replace("|/b|", "</b>", $tpa);
	$tpa=str_replace("|url|", "<a href=\"", $tpa);
	$tpa=str_replace("|/url|", "\" target=\"_blank\">链接</a>", $tpa);
	$tpa=str_replace("|img|", "<img src=\"", $tpa);
	$tpa=str_replace("|/img|", "\">", $tpa);
	$tpa=str_replace("|||", "http://", $tpa);
return $tpa;
}
function getsafeinfo3($tpa){
	$tpa=str_replace("http://", "|||", $tpa);
}
function SpHtml2Text($str)
{
 $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU","",$str);
 $alltext = "";
 $start = 1;
 for($i=0;$i<strlen($str);$i++)
 {
  if($start==0 && $str[$i]==">")
  {
   $start = 1;
  }
  else if($start==1)
  {
   if($str[$i]=="<")
   {
    $start = 0;
    $alltext .= " ";
   }
   else if(ord($str[$i])>31)
   {
    $alltext .= $str[$i];
   }
  }
 }
 $alltext = str_replace("　"," ",$alltext);
 $alltext = preg_replace("/&([^;&]*)(;|&)/","",$alltext);
 $alltext = preg_replace("/[ ]+/s"," ",$alltext);
 return $alltext;
}
function Html2Text($str,$r=0)
{
 if($r==0)
 {
  return SpHtml2Text($str);
 }
 else
 {
  $str = SpHtml2Text(stripslashes($str));
  return addslashes($str);
 }
}
	if(empty($_POST['checktype'])||myempty($_POST['checktype'])){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
include( "conf.php" );
$con = mysql_connect($dbserver,$dbuser,$dbpass);
$db_selected = mysql_select_db($dbs, $con);
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
set_time_limit(0);//无限请求超时时间
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
if($_POST['checktype']=="regopen"){
	$nowtime=time();
	$endtime_baomin_s = strtotime($endtime_baomin);
	$starttime_baomin_s = strtotime($starttime_baomin);
	if($nowtime<$starttime_baomin_s){
		$deta=$starttime_baomin_s-$nowtime;
		
		$info="还没开始报名哦~~亲，<br></br>大赛定于".$starttime_baomin."开始哦~~<br></br>亲，不着急的~<br>";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	if($nowtime>$endtime_baomin_s){
		
		$info="报名已经结束咯~~亲，<br></br>大赛定于".$endtime_baomin."报名结束的~~<br></br>亲，别灰心，下次下次再来吧~~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$err=array('flag'=>"ok");
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="upopen"){
	require( '../wp-load.php' );
	$nowtime=time();
	$endtime_up_s = strtotime($endtime_up);
	$starttime_up_s = strtotime($starttime_up);
	if(!is_user_logged_in()) {
        $info="上传需要登录哦~~亲，登录后再来吧的~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
      }
	if($nowtime<$starttime_up_s){
		
		$info="还没开始上传".$uptittle."哦~~亲，<br></br>大赛定于".$starttime_up."开始上传".$uptittle."哦~~<br></br>亲，不着急的~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	if($nowtime>$endtime_up_s){
		
		$info=$uptittle."上传已经结束咯~~亲，<br></br>大赛定于".$endtime_up."上传结束的~~<br></br>亲，别灰心，下次下次再来吧~~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$err=array('flag'=>"ok");
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="uname"){
	$user_name=getsafeinfo($_POST['uname']);
	if(myempty($user_name)||$user_name==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	foreach($name_not_allowed as $tvalue){
		if($user_name==$tvalue){
			$info="禁止的用户名";
			$err=array('flag'=>"error1",'info'=>$info);
			echo json_encode($err);
			exit();
		}
	}
	$sql1 = "SELECT display_name FROM contest_wp_users WHERE user_login='$user_name'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)!=0){
		$tempresult=mysql_fetch_assoc($result);
		$hisname=$tempresult['display_name'];
		$info="登录名 $user_name 已被 $hisname 注册了~~亲，重新选个吧~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$err=array('flag'=>"ok");
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="uinfo"){
	$user_id=getsafeinfo($_POST['uid']);
	if(myempty($user_id)||$user_id==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	$sql1 = "SELECT * FROM contest_members_info WHERE mid='$user_id'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$info="未找到用户,请点击同步数据，如果依然错误，请联系组委会~~亲";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$tempresult=mysql_fetch_assoc($result);
	$u_name=$tempresult['name'];
	$u_sid=$tempresult['sid'];
	$u_cid=$tempresult['cid'];
	$u_gname=$tempresult['gname'];
	$u_email=$tempresult['email'];
	$u_phone=$tempresult['phone'];
	$u_winnership=$tempresult['winnership'];
	$err=array('flag'=>"ok",'uname'=>$u_name,'uname'=>$u_name,'sid'=>$u_sid,'cid'=>$u_cid,'gname'=>$u_gname,'email'=>$u_email,'phone'=>$u_phone,'winnership'=>$u_winnership);
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="update_uinfo"){
	$user_id=getsafeinfo($_POST['uid']);
	if(myempty($user_id)||$user_id==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	$tpa=array(1,2,4,8,11);//真实姓名,学号,所属团队name,Email,手机
	$tpb=array(1);
	$ii=0;
	for($ii=0;$ii<5;$ii++){
		$now_fileid=$tpa[$ii];
		$sql1 = "SELECT value FROM contest_wp_bp_xprofile_data WHERE field_id=$now_fileid and user_id=$user_wpid";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$info="数据库错误 ，<br></br>亲，请联系管理员~~";
			$err=array('flag'=>"error",'info'=>$info."||".$ii);
			echo json_encode($err);
			exit();
		}
		$tempresult=mysql_fetch_assoc($result);
		$tpb[$ii]=$tempresult['value'];
	}
	$u_name=$tpb[0];
	$u_sid=$tpb[1];
	$u_gname=$tpb[2];
	$u_email=$tpb[3];
	$u_phone=$tpb[4];
	$sql1 = "SELECT cid FROM contest_wp_users WHERE ID='$user_id'";
	$result=mysql_query($sql1,$con);
	$tempresult=mysql_fetch_assoc($result);
	$u_cid=$tempresult['cid'];
	$sql1 = "SELECT * FROM contest_members_info WHERE mid='$user_id'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$sql1 = "INSERT INTO contest_members_info(mid,name,sid,cid,gname,winnership,email,phone)VALUES('$user_id','$u_name','$u_sid','$u_cid','$u_gname','0','$u_email','$u_phone')";
	}else{
		$sql1 = "UPDATE contest_members_info SET name = '$u_name',sid = '$u_sid', gname='$u_gname',cid='$u_cid',email='$u_email',phone='$u_phone' WHERE mid ='$user_id'";
	}
	$result=mysql_query($sql1,$con);
	
	$err=array('flag'=>"ok");
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="u"){
	$user_name=getsafeinfo($_POST['uname']);
	$PIN=getsafeinfo($_POST['uiid']);
	if(myempty($user_name)||$user_name==" "||myempty($PIN)||$PIN==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	$sql1 = "SELECT ID FROM contest_wp_users WHERE user_login='$user_name' and PIN='$PIN'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$info="未找到用户,或PIN错误~~亲";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$tempresult=mysql_fetch_assoc($result);
	$user_id=$tempresult['ID'];
	$sql1 = "SELECT id,is_admin FROM contest_wp_bp_groups_members WHERE user_id='$user_id'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$is_g_admin=1;
	}else{
		$tempresult=mysql_fetch_assoc($result);
		$is_g_admin=$tempresult['is_admin'];
	}
	$err=array('flag'=>"ok",'isgadmin'=>$is_g_admin);
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="p"){
	$p_name=getsafeinfo($_POST['pname']);
	$u_name=getsafeinfo($_POST['uname']);
	$u_pass=getsafeinfo($_POST['upass']);
	if(myempty($p_name)||$p_name==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	$sql1 = "SELECT pid FROM contest_project_info WHERE pname='$p_name'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)!=0){
		$tempresult=mysql_fetch_assoc($result);
		$hispid=$tempresult['pid'];
		$sql1 = "SELECT gid FROM contest_project_gid WHERE pid='$hispid'";
		$result=mysql_query($sql1,$con);
		$tempresult=mysql_fetch_assoc($result);
		$hisgid=$tempresult['gid'];
		$is_g=1;
		if($hisgid<0){
			$is_g=0;
			$hisgid=0-$hisgid;
			$utag="个人";
			$sql1 = "SELECT display_name,user_login FROM contest_wp_users WHERE ID='$hisgid'";
			$result=mysql_query($sql1,$con);
			$tempresult=mysql_fetch_assoc($result);
			$hisname=$tempresult['display_name'];
			if($tempresult['user_login']==$u_name){
				$err=array('flag'=>"ok",'pid'=>$hispid);
				echo json_encode($err);
				exit();
			}
		}else{
			$utag="团队";
			$sql1 = "SELECT name FROM contest_wp_bp_groups WHERE id='$hisgid'";
			$result=mysql_query($sql1,$con);
			$tempresult=mysql_fetch_assoc($result);
			$hisname=$tempresult['name'];
			$sql1 = "SELECT ID FROM contest_wp_users WHERE user_login='$u_name'";
			$result=mysql_query($sql1,$con);
			$tempresult=mysql_fetch_assoc($result);
			$tid=$tempresult['ID'];
			$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$tid'";
			$result=mysql_query($sql1,$con);
			$tempresult=mysql_fetch_assoc($result);
			$tgid=$tempresult['group_id'];
			if($hisgid==$tgid){
				$err=array('flag'=>"ok",'pid'=>$hispid);
				echo json_encode($err);
				exit();
			}
			$sql1 = "SELECT name FROM contest_wp_bp_groups WHERE id='$hisgid'";
			$result=mysql_query($sql1,$con);
			$tempresult=mysql_fetch_assoc($result);
			$hisname=$tempresult['name'];
		}
		$info="项目名$p_name 已被 $hisname 注册了~~亲，重新选个吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$sql1 = "SELECT ID FROM contest_wp_users WHERE user_login='$u_name'";
	$result=mysql_query($sql1,$con);
	$tempresult=mysql_fetch_assoc($result);
	$u_id=$tempresult['ID'];
	$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$u_id'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){//用户不是团队成员
	$ida=0-$u_id;
	}else{
	$tempresult=mysql_fetch_assoc($result);
	$ida=$tempresult['group_id'];
	}
		$sql1 = "SELECT pid FROM contest_project_gid WHERE gid='$ida'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){//用户没有项目
			$sql1 = "INSERT INTO contest_project_info(pname,ptype)VALUES('$p_name','1')";
			$result=mysql_query($sql1,$con);
			$sql1 = "SELECT pid FROM contest_project_info WHERE pname='$p_name'";
			$result=mysql_query($sql1,$con);
			if(mysql_num_rows($result)==0){
				$info="创建项目失败，<br></br>亲，请联系管理员吧~";
				$err=array('flag'=>"error0",'info'=>$info);
				echo json_encode($err);
				exit();
			}
			$tempresult=mysql_fetch_assoc($result);
			$p_id=$tempresult['pid'];
			$sql1 = "INSERT INTO contest_project_gid(pid,gid)VALUES('$p_id','$ida')";
			$result=mysql_query($sql1,$con);
			$info="创建项目成功~";
			$err=array('flag'=>"ok2",'pid'=>$p_id);
			echo json_encode($err);
			exit();
		}
		$tempresult=mysql_fetch_assoc($result);
		$p_id=$tempresult['pid'];
		$sql1 = "SELECT pname FROM contest_project_info WHERE pid='$p_id'";
		$result=mysql_query($sql1,$con);
		$tempresult=mysql_fetch_assoc($result);
		$p_namea=$tempresult['pname'];
		$info="找到已有项目~";
		$err=array('flag'=>"error1",'pid'=>$p_id,'pname'=>$p_namea);
		echo json_encode($err);
		exit();
}
if($_POST['checktype']=="uemail"){
	$user_email=getsafeinfo($_POST['email']);
	if(myempty($user_email)||$user_email==" "){
	$info="数据缺失，亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	$sql1 = "SELECT display_name FROM contest_wp_users WHERE user_email='$user_email'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)!=0){
		$tempresult=mysql_fetch_assoc($result);
		$hisname=$tempresult['display_name'];
		$info="邮箱 $user_email 已被 $hisname 注册了~~亲，重新选个吧~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$err=array('flag'=>"ok");
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="urname"){
	$user_rname=getsafeinfo($_POST['rname']);
	$user_sid=getsafeinfo($_POST['sid']);
	$user_iid=getsafeinfo($_POST['iid']);
	
	if(myempty($user_rname)||$user_rname==" "||myempty($user_sid)||$user_sid==" "||myempty($user_iid)||$user_iid==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	/*$sql1 = "SELECT display_name FROM contest_wp_users WHERE user_login=$user_name";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)!=0){
		$tempresult=mysql_fetch_assoc($result);
		$hisname=$tempresult['display_name'];
		$info="登录名 $user_name 已被 $hisname 注册了~~亲，重新选个吧~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}*/
	$info="信软";
	$err=array('flag'=>"ok",'info'=>$info);
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="searchgroup"){
	$user_group_keyw=getsafeinfo($_POST['group']);
	
	if(myempty($user_group_keyw)||$user_group_keyw==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	$user_group_keyw="%$user_group_keyw%";
	$sql1 = "SELECT id,creator_id,name FROM contest_wp_bp_groups WHERE name LIKE '$user_group_keyw'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$info="未找到团队~~亲";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$aaa=mysql_num_rows($result);
	$gname=array("1");
	$hisid=array("1");
	$gid=array("1");
	$hisnames=array("1");
	$iii=0;
	if($aaa==2){
		$tempresult=mysql_fetch_assoc($result);
		$ta=$tempresult['id'];
		$tempresult=mysql_fetch_assoc($result);
		$tb=$tempresult['id'];
		if($ta!=$judegsgid&&$tb!=$judegsgid){
			$result=mysql_query($sql1,$con);
			for($iii=0;$iii<2;$iii++){
				$tempresult=mysql_fetch_assoc($result);
				$gname[$iii]=$tempresult['name'];
				$hisid[$iii]=$tempresult['creator_id'];
				$gid[$iii]=$tempresult['id'];
				$tempa=$hisid[$iii];
				$sql1 = "SELECT display_name FROM contest_wp_users WHERE id='$tempa'";
				$result2=mysql_query($sql1,$con);
				if(mysql_num_rows($result2)==0){
					$hisnames[$iii]="NULL";
				}else{
					$tempresult2=mysql_fetch_assoc($result2);
					$hisnames[$iii]=$tempresult2['display_name'];
				}
			}
		}else{
			$result=mysql_query($sql1,$con);
			$iii=1;
			$tempresult=mysql_fetch_assoc($result);
			if($tempresult['id']!=$judegsgid){
				$gname=$tempresult['name'];
				$hisid=$tempresult['creator_id'];
				$gid=$tempresult['id'];
				$sql1 = "SELECT display_name FROM contest_wp_users WHERE id='$hisid'";
				$result=mysql_query($sql1,$con);
				if(mysql_num_rows($result)==0){
					$hisnames="NULL";
				}else{
					$tempresult=mysql_fetch_assoc($result);
					$hisnames=$tempresult['display_name'];
				}
			}
		}
	}else if($aaa>=3){
		$iii=0;
		for($iiii=0;$iiii<$aaa;$iiii++){
				$tempresult=mysql_fetch_assoc($result);
				if($tempresult['id']!=$judegsgid){
					$gname[$iii]=$tempresult['name'];
					$hisid[$iii]=$tempresult['creator_id'];
					$gid[$iii]=$tempresult['id'];
					$tempa=$hisid[$iii];
					$sql1 = "SELECT display_name FROM contest_wp_users WHERE id='$tempa'";
					$result2=mysql_query($sql1,$con);
					if(mysql_num_rows($result2)==0){
						$hisnames[$iii]="NULL";
					}else{
						$tempresult2=mysql_fetch_assoc($result2);
						$hisnames[$iii]=$tempresult2['display_name'];
					}
					$iii++;
				}
			}
	}else{
		$iii=1;
		$tempresult=mysql_fetch_assoc($result);
		$gname=$tempresult['name'];
		$hisid=$tempresult['creator_id'];
		$gid=$tempresult['id'];
		$sql1 = "SELECT display_name FROM contest_wp_users WHERE id='$hisid'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$hisnames="NULL";
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$hisnames=$tempresult['display_name'];
		}
	}
	$err=array('flag'=>"ok",'gname'=>$gname,'gid'=>$gid,'cname'=>$hisnames,'total'=>$iii);
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="ckgroup"){
	$user_group=getsafeinfo($_POST['group']);
	
	if(myempty($user_group)||$user_group==" "){
	$info="数据缺失，<br></br>亲，请联系管理员吧~";
	$err=array('flag'=>"error0",'info'=>$info);
	echo json_encode($err);
	exit();
	}
	foreach($group_not_allowed as $tvalue){
		if($user_group==$tvalue){
			$info="禁止的团队名";
			$err=array('flag'=>"error1",'info'=>$info);
			echo json_encode($err);
			exit();
		}
	}
	$sql1 = "SELECT creator_id FROM contest_wp_bp_groups WHERE name='$user_group'";
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
		$info="团队 $user_group 已存在   由 $tempuser 创建";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$err=array('flag'=>"ok");
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="islogin"){
	require( '../wp-load.php' );
	 if(!is_user_logged_in()) {
         	$err=array('flag'=>"no");
			echo json_encode($err);
			exit();
      	}
		$err=array('flag'=>"ok");
			echo json_encode($err);
			exit();
}
if($_POST['checktype']=="nowuser"){
	require( '../wp-load.php' );
		 if(!is_user_logged_in()) {
         	$err=array('flag'=>"no");
			echo json_encode($err);
			exit();
      	}
		$current_user = wp_get_current_user();
		$uid=$current_user->ID;
		$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$uid'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$gid=0;
			$gname="未加入";
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$gid=$tempresult['group_id'];
			$sql1 = "SELECT name FROM contest_wp_bp_groups WHERE id='$gid'";
			$result=mysql_query($sql1,$con);
			if(mysql_num_rows($result)==0){
				$gid=0;
				$gname="未加入";
				$captain="无";
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$gname=$tempresult['name'];
				$sql1 = "SELECT creator_id FROM contest_wp_bp_groups WHERE id='$gid'";
				$result=mysql_query($sql1,$con);
				if(mysql_num_rows($result)==0){
						$captain="无";
				}else{
						$tempresult=mysql_fetch_assoc($result);
						$captainid=$tempresult['creator_id'];
						$sql1 = "SELECT display_name FROM contest_wp_users WHERE ID='$captainid'";
						$result=mysql_query($sql1,$con);
						if(mysql_num_rows($result)==0){
							$captain="无";
						}else{
							$tempresult=mysql_fetch_assoc($result);
							$captain=$tempresult['display_name'];
						}
				}
			}
			
		}
		$sql1 = "SELECT value FROM contest_wp_bp_xprofile_data WHERE user_id='$uid' and field_id=2";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
				$sid=0;
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$sid=$tempresult['value'];
		}
		$sql1 = "SELECT value FROM contest_wp_bp_xprofile_data WHERE user_id='$uid' and field_id=3";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
				$xy="未知学院";
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$xy=$tempresult['value'];
		}
		$sql1 = "SELECT value FROM contest_wp_bp_xprofile_data WHERE user_id='$uid' and field_id=11";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
				$phone=0;
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$phone=$tempresult['value'];
		}
		$sql1 = "SELECT cid FROM contest_wp_users WHERE ID='$uid'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
				$cid="error";
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$cid=$tempresult['cid'];
		}
		$err=array('flag'=>"ok",'id'=>$current_user->ID,'username'=>$current_user->user_login,'email'=>$current_user->user_email,'display_name'=>$current_user->display_name,'gid'=>$gid,'gname'=>$gname,'sid'=>$sid,'xy'=>$xy,'phone'=>$phone,'cid'=>$cid,'captain'=>$captain);
		echo json_encode($err);
		exit();
}
if($_POST['checktype']=="uavata"){
	require( '../wp-load.php' );
	if(empty($_POST['size'])){
		$size=32;
	}else{
		$size=getsafeinfo($_POST['size']);
	}
	$err=array('flag'=>"ok",'src'=>get_avatar_scientihark( wp_get_current_user()->ID, $size ));
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="gnotice"){
	require( '../wp-load.php' );
	$uid=wp_get_current_user()->ID;
	$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$uid'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$err=array('flag'=>"no");
			echo json_encode($err);
			exit();
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$gid=$tempresult['group_id'];
			$sql1 = "SELECT text,date FROM contest_group_notice WHERE gid='$gid' ORDER BY date DESC";
			$result=mysql_query($sql1,$con);
			if(mysql_num_rows($result)==0){
				$err=array('flag'=>"no");
				echo json_encode($err);
				exit();
			}else{
				$totalnum=mysql_num_rows($result);
				$ii=0;
				$dates=array(0);
				$texts=array(0);
				for($ii=0;$ii<$totalnum;$ii++){
					$tempresult=mysql_fetch_assoc($result);
					$dates[$ii]=$tempresult['date'];
					$texts[$ii]=$tempresult['text'];
				}
				$err=array('flag'=>"ok",'dates'=>$dates,'texts'=>$texts,'total'=>$ii-1);
				echo json_encode($err);
				exit();
			}
			
		}
}
if($_POST['checktype']=="gnotice_add"){
	require( '../wp-load.php' );
	if(!is_user_logged_in()) {
			$info="亲，只有队长可以发公告哦~~";
         	$err=array('flag'=>"error0");
			echo json_encode($err);
			exit();
     }
	 $text=getsafeinfo2(Html2Text($_POST['text']));
	if(myempty($text)||$text==" "){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	
	$uid=wp_get_current_user()->ID;
	$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$uid'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$info="哦，<br></br>亲，你是肿么添加到别人的公告的~";
			$err=array('flag'=>"error0");
			echo json_encode($err);
			exit();
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$gid=$tempresult['group_id'];
			$sql1 = "SELECT creator_id FROM contest_wp_bp_groups WHERE id='$gid'";
			$result=mysql_query($sql1,$con);
			if(mysql_num_rows($result)==0){
				$info=" ";
				$err=array('flag'=>"error");
				echo json_encode($err);
				exit();
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$crid=$tempresult['creator_id'];
				if($crid!=$uid){
					$info="亲，只有队长可以发公告哦~~";
         			$err=array('flag'=>"error0",'info'=>$info);
					echo json_encode($err);
					exit();
				}
				$sql1 = "INSERT INTO contest_group_notice(gid,date,text)VALUES('$gid',$tnow,'$text')";
				$result=mysql_query($sql1,$con);
				$err=array('flag'=>"ok");
				echo json_encode($err);
				exit();
			}
			
		}
}
if($_POST['checktype']=="gnotice_del"){
	require( '../wp-load.php' );
	if(!is_user_logged_in()) {
			$info="亲，只有队长可以发公告哦~~";
         	$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
     }
	 $text=getsafeinfo2(Html2Text($_POST['text']));
	 $tpa=explode(";",$_POST['date']);
	 $date=$tpa[0];
	if(myempty($text)||$text==" "||myempty($date)||$date==" "){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	
	$uid=wp_get_current_user()->ID;
	$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$uid'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$info="哦，<br></br>亲，你是肿么删到别人的公告的~";
			$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$gid=$tempresult['group_id'];
			$sql1 = "SELECT id FROM contest_group_notice WHERE gid='$gid' and date='$date' and text='$text'";
			$result=mysql_query($sql1,$con);
			if(mysql_num_rows($result)==0){
				$info="哦，<br></br>亲，那条公告早就删咯~";
				$err=array('flag'=>"error0",'info'=>$info);
				echo json_encode($err);
				exit();
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$nid=$tempresult['id'];
				$sql1 = "DELETE FROM contest_group_notice WHERE id ='$nid'";
				$result=mysql_query($sql1,$con);
				$err=array('flag'=>"ok");
				echo json_encode($err);
				exit();
			}
			
		}
}
if($_POST['checktype']=="gnotice_edit"){
	require( '../wp-load.php' );
	if(!is_user_logged_in()) {
			$info="亲，只有队长可以发公告哦~~";
         	$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
     }
	 $text=getsafeinfo2(Html2Text(getsafeinfo3($_POST['text'])));
	 $textn=getsafeinfo2(Html2Text(getsafeinfo3($_POST['textn'])));
	 $tpa=explode(";",$_POST['date']);
	 $date=$tpa[0];
	if(myempty($text)||$text==" "||myempty($date)||$date==" "||myempty($textn)||$textn==" "){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	
	$uid=wp_get_current_user()->ID;
	$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$uid'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$info="哦，<br></br>亲，你是肿么改到别人的公告的~";
			$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$gid=$tempresult['group_id'];
			$sql1 = "SELECT id FROM contest_group_notice WHERE gid='$gid' and date='$date' and text='$text'";
			$result=mysql_query($sql1,$con);
			if(mysql_num_rows($result)==0){
				$info="哦，<br></br>亲，那条公告早就删咯~";
				$err=array('flag'=>"error0",'info'=>$info);
				echo json_encode($err);
				exit();
			}else{
				$tempresult=mysql_fetch_assoc($result);
				$nid=$tempresult['id'];
				$sql1 = "UPDATE contest_group_notice SET date = $tnow,text='$textn' WHERE id ='$nid'";
				//echo $sql1;
				$result=mysql_query($sql1,$con);
				$err=array('flag'=>"ok");
				echo json_encode($err);
				exit();
			}
			
		}
}
if($_POST['checktype']=="mytodo"){
	require( '../wp-load.php' );
	$uid=wp_get_current_user()->ID;
	$sql1 = "SELECT text,date,closed FROM contest_user_todo WHERE uid='$uid' ORDER BY date DESC";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$err=array('flag'=>"no");
		echo json_encode($err);
		exit();
	}else{
		$totalnum=mysql_num_rows($result);
		$ii=0;
		$dates=array(0);
		$texts=array(0);
		$closeds=array(0);
		for($ii=0;$ii<$totalnum;$ii++){
			$tempresult=mysql_fetch_assoc($result);
			$dates[$ii]=$tempresult['date'];
			$texts[$ii]=$tempresult['text'];
			$closeds[$ii]=$tempresult['closed'];
		}
		$err=array('flag'=>"ok",'dates'=>$dates,'texts'=>$texts,'closeds'=>$closeds,'total'=>$ii-1);
		echo json_encode($err);
		exit();
	}
}
if($_POST['checktype']=="mytodo_add"){
	require( '../wp-load.php' );
	if(!is_user_logged_in()) {
			$info="亲，只有登陆后才可以发TODO哦~~";
         	$err=array('flag'=>"error0");
			echo json_encode($err);
			exit();
     }
	 $text=getsafeinfo2(Html2Text($_POST['text']));
	if(myempty($text)||$text==" "){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	
	$uid=wp_get_current_user()->ID;
	$sql1 = "INSERT INTO contest_user_todo(uid,date,text,closed)VALUES('$uid',$tnow,'$text','0')";
	$result=mysql_query($sql1,$con);
	$err=array('flag'=>"ok");
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="mytodo_del"){
	require( '../wp-load.php' );
	if(!is_user_logged_in()) {
			$info="亲，只有登陆后才可以发TODO哦~~";
         	$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
     }
	 $text=getsafeinfo2(Html2Text($_POST['text']));
	 $tpa=explode(";",$_POST['date']);
	 $date=$tpa[0];
	if(myempty($text)||$text==" "||myempty($date)||$date==" "){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	
	$uid=wp_get_current_user()->ID;
	$sql1 = "SELECT id FROM contest_user_todo WHERE uid='$uid' and date='$date' and text='$text'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$info="哦，<br></br>亲，那条TODO早就删咯~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}else{
		$tempresult=mysql_fetch_assoc($result);
		$nid=$tempresult['id'];
		$sql1 = "DELETE FROM contest_user_todo WHERE id ='$nid'";
		$result=mysql_query($sql1,$con);
		$err=array('flag'=>"ok");
		echo json_encode($err);
		exit();
	}
}
if($_POST['checktype']=="mytodo_edit"){
	require( '../wp-load.php' );
	if(!is_user_logged_in()) {
			$info="亲，只有登陆后才可以发TODO哦~~";
         	$err=array('flag'=>"error0",'info'=>$info);
			echo json_encode($err);
			exit();
     }
	 $text=getsafeinfo2(Html2Text(getsafeinfo3($_POST['text'])));
	 $textn=getsafeinfo2(Html2Text(getsafeinfo3($_POST['textn'])));
	 $closed=getsafeinfo($_POST['closed']);
	 $tpa=explode(";",$_POST['date']);
	 $date=$tpa[0];
	if(myempty($text)||$text==" "||myempty($date)||$date==" "||myempty($textn)||$textn==" "||myempty($closed)||$closed==" "){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	
	$uid=wp_get_current_user()->ID;
	$sql1 = "SELECT id FROM contest_user_todo WHERE uid='$uid' and date='$date' and text='$text'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		$info="哦，<br></br>亲，那条TODO早就删咯~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}else{
		$tempresult=mysql_fetch_assoc($result);
		$nid=$tempresult['id'];
		$sql1 = "UPDATE contest_user_todo SET date = $tnow,text='$textn',closed=$closed WHERE id ='$nid'";
		//echo $sql1;
		$result=mysql_query($sql1,$con);
		$err=array('flag'=>"ok");
		echo json_encode($err);
		exit();
	}
}
if($_POST['checktype']=="plogo"){
	require( '../wp-load.php' );
	if(!empty($_POST['pid'])){
		$pid=getsafeinfo($_POST['pid']);
		if(!empty($pid)&&$pid!=" "){
			include( "conf.php" );
			$con = mysql_connect($dbserver,$dbuser,$dbpass);
			$db_selected = mysql_select_db($dbs, $con);
			mysql_query("SET NAMES utf8");
			mysql_query("SET CHARACTER SET utf8");
			mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
			if ((!$con)||(!$pid)||($pid<0)||($pid>999999))
			{
				$err=array('flag'=>"error1");
				echo json_encode($err);
				exit();
			}
			$sql = "SELECT fid FROM contest_project_files WHERE pid='$pid' and ftype='5'";
			$result=mysql_query($sql,$con);
			if(mysql_num_rows($result)==0){
				$err=array('flag'=>"error0");
				echo json_encode($err);
				exit();
			}
			$tempresult=mysql_fetch_assoc($result);
			$fileid=$tempresult['fid'];
			$sql = "SELECT fname FROM contest_reader_files where fid='$fileid'";
			$result=mysql_query($sql,$con);
			if(mysql_num_rows($result)==0){
				$err=array('flag'=>"error0");
				echo json_encode($err);
				exit();
			}
			$tempresult=mysql_fetch_assoc($result);
			$err=array('flag'=>"ok",'src'=>"http://api.scie.in/files/".$tempresult['fid']);
			echo json_encode($err);
			exit();
		}
	}else{
		$err=array('flag'=>"error0");
		echo json_encode($err);
		exit();
	}
}
if($_POST['checktype']=="pinfo"){
	require( '../wp-load.php' );
	$uid=wp_get_current_user()->ID;
	$sql = "SELECT group_id FROM contest_wp_bp_groups_members where user_id='$uid'";
	$result=mysql_query($sql,$con);
	if(mysql_num_rows($result)==0){
		$gid=0-$uid;
	}else{
		$tempresult=mysql_fetch_assoc($result);
		$gid=$tempresult['group_id'];
	}
	$sql = "SELECT pid FROM contest_project_gid where gid='$gid'";
	$result=mysql_query($sql,$con);
	if(mysql_num_rows($result)==0){
		$info="亲，还未创建项目哦~~上传文档时即可创建项目";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
	}
	$tempresult=mysql_fetch_assoc($result);
	$pid=$tempresult['pid'];
	$sql = "SELECT pname FROM contest_project_info where pid='$pid'";
	$result=mysql_query($sql,$con);
	if(mysql_num_rows($result)==0){
		$pname="NULL";
	}else{
	$tempresult=mysql_fetch_assoc($result);
	$pname=$tempresult['pname'];
	}
	$sql = "SELECT des FROM contest_project_des where pid='$pid'";
	$result=mysql_query($sql,$con);
	if(mysql_num_rows($result)==0){
		$pdes="NULL";
	}else{
	$tempresult=mysql_fetch_assoc($result);
	$pdes=$tempresult['des'];
	}
	$sql = "SELECT fid FROM contest_project_files where pid='$pid' and ftype='1'";
	$result=mysql_query($sql,$con);
	if(mysql_num_rows($result)==0){
		$wd_id="NULL";
	}else{
	$tempresult=mysql_fetch_assoc($result);
	$wd_id=$tempresult['fid'];
	}
	$sql = "SELECT fid FROM contest_project_files where pid='$pid' and ftype='2'";
	$result=mysql_query($sql,$con);
	if(mysql_num_rows($result)==0){
		$sp_id="NULL";
	}else{
	$tempresult=mysql_fetch_assoc($result);
	$sp_id=$tempresult['fid'];
	}
	$err=array('flag'=>"ok",'pname'=>$pname,'pdes'=>$pdes,'wd_id'=>$wd_id,'sp_id'=>$sp_id,'pid'=>$pid);
	echo json_encode($err);
	exit();
	
}
if($_POST['checktype']=="get_news"){
	if(empty($_POST['page'])){
		$p=1;
	}
	require( '../wp-load.php' );
	global $post;
	//$count=100*($p+1)+1;
	$args = array(
    'numberposts'     => 1000,
    'offset'          => 0,
    'category'        => 3,
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'post_type'       => 'post',
    'post_status'     => 'publish' );
	$dates=array("");
	$titles=array("");
	$ids=array(0);
	$images=array("");
	$num=0;
	$myposts = get_posts( $args );
foreach( $myposts as $post ) :	
	$num++;
	if($num>(100*($page-1))){
		$dates[$num-1]=$post->post_date;
		$titles[$num-1]=$post->post_title;
		$ids[$num-1]=$post->ID;
		if ( get_post_meta($post->ID, 'thumbnail', true) ){
			$images[$num-1]= get_post_meta($post->ID, 'thumbnail', true);
		}else if(has_post_thumbnail($post->ID)){
				$post_thumbnail_id=get_post_thumbnail_id($post->ID);
				$tempa=wp_get_attachment_image_src( $post_thumbnail_id, 'post-thumbnail', false,'' );
				$images[$num-1]=$tempa[0];
		}else{
			$images[$num]="http://contest.scie.in/p/pimg/none.jpg";
		}
	}
endforeach;
$nextp=false;
if($num>=21){
	$nextp=true;
}
	$err=array('flag'=>"ok",'date'=>$dates,'titles'=>$titles,'count'=>$num,'img'=>$images,'isnextp'=>$nextp,'id'=>$ids);
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="get_notice"){
	if(empty($_POST['page'])){
		$page=1;
	}
	require( '../wp-load.php' );
	global $post;
	$args = array(
    'numberposts'     => ((100*$page)+1),
    'offset'          => 0,
    'category'        => 4,
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'post_type'       => 'post',
    'post_status'     => 'publish' );
	$dates=array("");
	$titles=array("");
	$ids=array(0);
	$images=array("");
	$num=0;
	$myposts = get_posts( $args );
foreach( $myposts as $post ) :	
	if($num>=(100*($page-1))){
		$dates[$num]=$post->post_date;
		$titles[$num]=$post->post_title;
		$ids[$num]=$post->ID;
		if ( get_post_meta($post->ID, 'thumbnail', true) ){
			$images[$num]= get_post_meta($post->ID, 'thumbnail', true);
		}else if(has_post_thumbnail($post->ID)){
				$post_thumbnail_id=get_post_thumbnail_id($post->ID);
				$tempa=wp_get_attachment_image_src( $post_thumbnail_id, 'post-thumbnail', false,'' );
				$images[$num]=$tempa[0];
		}else{
			$images[$num]="http://contest.scie.in/p/pimg/none.jpg";
		}
	}
	$num++;
endforeach;
$nextp=false;
if($num>=101){
	$nextp=true;
}
	$err=array('flag'=>"ok",'date'=>$dates,'titles'=>$titles,'count'=>$num,'img'=>$images,'isnextp'=>$nextp);
	echo json_encode($err);
	exit();
}
if($_POST['checktype']=="get_posts"){
	require( '../wp-load.php' );
	global $post;
	
	if(!empty($_POST['id'])&&$_POST['id']!=" "){
		$id=getsafeinfo($_POST['id']);
	}else{
		$info="亲，error~~";
		echo $info;
		exit();
	}
	$tpost = get_post($id); 
	//$err=array('flag'=>"ok",'date'=>$tpost->post_date,'content'=>$tpost->post_content);
	//echo json_encode($err);
	if(!$tpost||$tpost==NULL||$tpost->post_content==""||!$tpost->post_content){
		$res="error";
	}else{
		$res=$tpost->post_content;
		$sql1="SELECT viewnum FROM contest_post_views WHERE post_id='$id'";
		//echo $sql1;
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$sql1 = "INSERT INTO contest_post_views(post_id,viewnum)VALUES('$id','1')";
			//echo $sql1;
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$num=$tempresult['viewnum']+1;
			$sql1 = "UPDATE contest_post_views SET viewnum = '$num' WHERE post_id ='$id'";
			//echo $sql1;
		}
		$result=mysql_query($sql1,$con);
	}
	echo $res;
	exit();
}
if($_POST['checktype']=="like_posts"){
	require( '../wp-load.php' );
	global $post;
	
	if(!empty($_POST['id'])&&$_POST['id']!=" "){
		$id=getsafeinfo($_POST['id']);
	}else{
		$info="亲，error~~";
		echo $info;
		exit();
	}
	$tpost = get_post($id); 
	//$err=array('flag'=>"ok",'date'=>$tpost->post_date,'content'=>$tpost->post_content);
	//echo json_encode($err);
	if(!$tpost||$tpost==NULL||$tpost->post_content==""||!$tpost->post_content){
		$res="error";
	}else{
		$res=$tpost->post_content;
		$sql1="SELECT like_num FROM contest_post_like WHERE post_id='$id'";
		//echo $sql1;
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$num=1;
			$sql1 = "INSERT INTO contest_post_like(post_id,	like_num)VALUES('$id','1')";
			//echo $sql1;
		}else{
			$tempresult=mysql_fetch_assoc($result);
			$num=$tempresult['like_num']+1;
			$sql1 = "UPDATE contest_post_like SET like_num = '$num' WHERE post_id ='$id'";
			//echo $sql1;
		}
		$result=mysql_query($sql1,$con);
		$err=array('flag'=>"ok",'num'=>$num);
		echo json_encode($err);
		exit();
	}
}
?>
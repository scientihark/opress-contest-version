<?php
header("Content-Type:text/html;charset=utf8"); 
date_default_timezone_set('PRC');
include( "conf.php" );
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
$con = mysql_connect($dbserver,$dbuser,$dbpass);
$db_selected = mysql_select_db($dbs, $con);
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
set_time_limit(0);//无限请求超时时间
$info="";
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
if(myempty($_POST['pid'])||myempty($_POST['uiid'])||myempty($_POST['usid'])){
		$info="数据缺失，<br></br>亲，请联系管理员吧~";
		$err=array('flag'=>"error",'info'=>$info);
		echo json_encode($err);
		exit();
}
//todo:验证用户``
$sid=getsafeinfo($_POST['usid']);
$iid=getsafeinfo($_POST['uiid']);
$pid=getsafeinfo($_POST['pid']);
$nowtime=time();
$endtime_vote_s = strtotime($endtime_vote);
$starttime_vote_s = strtotime($starttime_vote);
if($nowtime<$starttime_vote_s){
		$info="还没开始投票哦~~亲，<br><br>大赛投票定于.$starttime_vote.开始哦~~<br><br>亲，不着急的~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
}
if($nowtime>$endtime_vote_s){
		$info="投票已经结束咯~~亲，<br><br>大赛投票定于.$starttime_vote.结束的~~<br><br>亲，别灰心，下次下次再来吧~~~";
		$err=array('flag'=>"error0",'info'=>$info);
		echo json_encode($err);
		exit();
}
$sql1 = "SELECT id FROM contest_p_vote WHERE sid='$sid'";
$result=mysql_query($sql1,$con);
$ii=mysql_num_rows($result);
if($ii>=$max_vote_num){
		$info="每人只可投".$max_vote_num."票~~<br><br>亲，你已经投过".$max_vote_num."票咯，<br><br>亲，别灰心，下次下次再来吧~~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
}
$sql1 = "SELECT id FROM contest_p_vote WHERE sid='$sid' and pid='$pid'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)!=0){
		$info="~~亲，你已经投过这个项目的票咯，<br><br>不要重复投票哦，<br><br>亲，别灰心，下次下次再来吧~~~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
}
$sql1 = "INSERT INTO contest_p_vote(sid,pid,vote_time)VALUES('$sid','$pid',$tnow)";
$result=mysql_query($sql1,$con);
$sql1 = "SELECT vote_times FROM contest_project_votes WHERE pid='$pid'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)==0){
		$sql1 = "INSERT INTO contest_project_votes(pid,vote_times)VALUES('$pid','1')";
		$p_num=1;
}else{
		$tempresult=mysql_fetch_assoc($result);
		$p_num=$tempresult['vote_times'];
		$sql1 = "UPDATE contest_project_votes SET vote_times='$p_num' WHERE pid ='$pid'";
		$p_num++;
}
$result=mysql_query($sql1,$con);
$info="每人可投".$max_vote_num."票~~亲，<br><br>你已经投过".($ii+1)."票咯";
$err=array('flag'=>"ok",'p_num'=>$p_num,'info'=>$info);
echo json_encode($err);
exit();
?>
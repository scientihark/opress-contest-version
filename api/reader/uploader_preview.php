<?php
if(myempty($_GET['uid'])||myempty($GET['type'])){
		exit();
}
	$uid=getsafeinfo($_GET['uid']);
	$typea=getsafeinfo($_GET['type']);
if($uid=" "||$typea=" "||myempty($uid)||myempty($typea)){
		exit();
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
function myempty($myinput){
	if(empty($myinput)&&$myinput!=0)
	{
		return false;
	}
}
include( "../conf.php" );
		$con = mysql_connect($dbserver,$dbuser,$dbpass);
		$db_selected = mysql_select_db($dbs, $con);
		mysql_query("SET NAMES utf8");
		mysql_query("SET CHARACTER SET utf8");
		mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
		if (!$con)
		{
  			die('Could not connect: ' . mysql_error());
		}
$sql1 = "SELECT fid FROM contest_reader_files WHERE fname='$fileNamea' and ftype=$itype";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)==0){
		$info="文件处理中~";
		$err=array('flag'=>"error1",'info'=>$info);
		echo json_encode($err);
		exit();
}
$tempresult=mysql_fetch_assoc($result);
$file_fid=$tempresult['fid'];

?>
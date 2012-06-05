<?php 
include( "../conf.php" );
if(!empty($_GET['pid'])&&!empty($_GET['type']))
	{
		$nowpid=getsafeinfo($_GET['pid']);
		$nowtype=getsafeinfo($_GET['type']);
		$nowfileid=findfile($nowpid,$nowtype);
	}
else if(!empty($_GET['fid']))
	{
		$nowfileid=getsafeinfo($_GET['fid']);
	}
else{
		$nowfileid=0;
	}
$con = mysql_connect($dbserver,$dbuser,$dbpass);
	$db_selected = mysql_select_db($dbs, $con);
	mysql_query("SET NAMES utf8");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");

$fid=$nowfileid;
if ((!$con)||(!$fid)||($fid<0)||($fid>999999))
{
	$or_file_name='0';
	$or_dl_file_name='0';
	$or_dl_file_type='webm';
	echo "<!-- dberror !-->";
}
else
{
	$sql = "SELECT fname,ftype FROM contest_reader_files where fid='".$fid."'";
	$result=mysql_query($sql,$con);
	//echo $sql;
	//echo "<!-- sql1".$sql." !-->";
	if(mysql_num_rows($result)==0)
	{
		$or_file_name='0';
		$or_dl_file_name='0';
		$or_dl_file_type='webm';
		//echo "<!-- mysql_num_rows(result)==0 !-->";
	}else if(mysql_num_rows($result)==2){
		$tempresult=mysql_fetch_assoc($result);
		$filea=$tempresult['fname'];
		$filea_type=$tempresult['ftype'];
		if($filea_type=="webm"){
			$or_file_name=$filea;
		}else{
			$or_dl_file_name=$filea;
			$or_dl_file_type=$filea_type;
		}
	}else
	{
		$tempresult=mysql_fetch_assoc($result);
		if(!empty($tempresult['fname']))
		{
			$or_file_name=$tempresult['fname'];
			$or_dl_file_name=$or_file_name;
			//echo "<!-- or_file_name=tempresult['name']=".$tempresult['name']." !-->";
		}
		else
		{
			$or_file_name='Oreader';
			//echo "<!-- or_file_name=Oreader !-->";
		}
		if(!empty($tempresult['ftype']))
		{
			$or_dl_file_type=$tempresult['ftype'];
		}
		else
		{
			$or_dl_file_type='webm';
			//echo "<!-- empty or_file_typename='Unclassified'; !-->";
		}
	}
}
$or_return_value->webmname=$or_file_name;
$or_return_value->dlfiletype=$or_dl_file_type;
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
function findfile($pid,$ftype){
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
	$sql1 = "SELECT fid FROM contest_project_files WHERE pid='$pid' and ftype='$ftype'";
	$result=mysql_query($sql1,$con);
	if(mysql_num_rows($result)==0){
		return 0;
	}
	$tempresult=mysql_fetch_assoc($result);
	return $tempresult['fid'];
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  <title>Video | Video.js HTML5 Video Player</title>

  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="video-js.min.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
  <script src="video.min.js"></script>

  <!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->
  <script>
    _V_.options.flash.swf = "video-js.swf";
  </script>


</head>
<body>

  <video id="video_1" class="video-js vjs-default-skin" controls preload="none" width="660" height="340"
      data-setup="{}">
    <source src="files/<?php echo $or_file_name; ?>.webm" type='video/webm' />
  </video>

</body>
</html>

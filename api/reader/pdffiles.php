<?php 
function pdffile($fileid)
{
include( "../conf.php" );
	$con = mysql_connect($dbserver,$dbuser,$dbpass);
	$db_selected = mysql_select_db($dbs, $con);
	mysql_query("SET NAMES utf8");
	mysql_query("SET CHARACTER SET utf8");
	mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
if ((!$con)||(!$fileid)||($fileid<0)||($fileid>999999))
{
	$or_file_name='0';
	$or_dl_file_name='0';
	$or_dl_file_type='pdf';
	echo "<!-- dberror !-->";
}
else
{
	$sql = "SELECT fname,ftype FROM contest_reader_files where fid='".$fileid."'";
	$result=mysql_query($sql,$con);
	//echo $sql;
	//echo "<!-- sql1".$sql." !-->";
	if(mysql_num_rows($result)==0)
	{
		$or_file_name='0';
		$or_dl_file_name='0';
		$or_dl_file_type='pdf';
		//echo "<!-- mysql_num_rows(result)==0 !-->";
	}else if(mysql_num_rows($result)==2){
		$tempresult=mysql_fetch_assoc($result);
		$filea=$tempresult['fname'];
		$filea_type=$tempresult['ftype'];
		if($filea_type=="pdf"){
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
			$or_dl_file_type='pdf';
			//echo "<!-- empty or_file_typename='Unclassified'; !-->";
		}
	}
}
$or_return_value->filepath='files/'.$or_file_name.'.pdf';
$or_return_value->dlfilepath='files/'.$or_dl_file_name.'.'.$or_dl_file_type;
return $or_return_value;
}
?>

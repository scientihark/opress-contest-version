<?php
set_time_limit(0);
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
	if(myempty($_POST['uid'])||myempty($_POST['type'])){
		exit();
	}
	$uid=getsafeinfo($_POST['pid']);
	$typea=getsafeinfo($_POST['ftype']);
    $id  = $_GET['sessionId'];
    $id = trim($id);

    session_name($id);
    session_start();
    $inputName = $_GET['userfile'];
	
    $tempLoc   = $_FILES[$inputName]['tmp_name'];
	$itype=getfiletype($tempLoc);
	$isdocs=1;	
	$ismedia=1;

	if($itype!="pdf"&&$itype!="doc"&&$itype!="docx"&&$itype!="ppt"&&$itype!="pptx")
	{$isdocs=0;}
	if($itype!="avi"&&$itype!="rmvb"&&$itype!="3gp"&&$itype!="flv"&&$itype!="mp4"&&$itype!="webm"&&$itype!="ogv"&&$itype!="mpg")
	{$ismedia=0;}
	if($ismedia==0&&$isdocs==0){exit();}
	$fileNamea = time().myrandom(32, $_FILES[$inputName]['name']);
	$fileName  =$fileNamea.".".$itype;
    echo $_FILES[$inputName]['error'];
    $target_path = '/media/data/contest/api/uploader/files/';
    $target_path = $target_path .$fileName;
    if(move_uploaded_file($tempLoc,$target_path))
    {
		if($isdocs==1&&$itype!="pdf"){
			$aa="java -jar pdfplg/jodconverter-core-3.0-beta-4.jar files/".$fileName." files/".$fileNamea.".pdf";
			echo exec($aa);
		}
		if($ismedia==1&&$itype!="webm"){
			$aa="java -jar pdfplg/jodconverter-core-3.0-beta-4.jar files/".$fileName." files/".$fileNamea.".pdf";
			echo exec($aa);
		}
		$sql1 = "INSERT INTO contest_reader_files(fname,ftype)VALUES('$fileNamea','$itype')";
		$result=mysql_query($sql1,$con);
		$sql1 = "SELECT fid FROM contest_reader_files WHERE fname='$fileNamea' and ftype='$itype'";
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
		$info="数据库写入错误~~";
		echo $info;
		exit();
		}
		$tempresult=mysql_fetch_assoc($result);
		$file_fid=$tempresult['fid'];
		$sql1 = "SELECT fid FROM contest_project_files WHERE pid='$uid' and ftype='$typea'";
		echo $sql1;
		$result=mysql_query($sql1,$con);
		if(mysql_num_rows($result)==0){
			$sql1 = "INSERT INTO contest_project_files(pid,ftype,fid)VALUES('$uid','$typea','$file_fid')";
		}else{
			$sql1 = "UPDATE contest_project_files SET fid = '$file_fid' WHERE pid ='$uid' and ftype='$typea';";
		}
		$result=mysql_query($sql1,$con);
        $_SESSION['value'] = -1;
    }

function myrandom($length, $type = "") {
    $chars = !$type ? "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz" : "0123456789abcdef";
    $max = strlen($chars) - 1;
    mt_srand((double)microtime() * 1000000);
	$string="-chc-";
    for($i = 0; $i < $length; $i++) {
        $string .= $chars[mt_rand(0, $max)];
    }
    return $string;
}
/*文件扩展名说明
*7173 gif
*255216 jpg
*13780 png
*6677 bmp
*239187 txt,aspx,asp,sql
*208207 xls.doc.ppt
*6063 xml
*6033 htm,html
*4742 js
*8075 xlsx,zip,pptx,mmap,zip
*8297 rar
*01 accdb,mdb
*7790 exe,dll
*5666 psd
*255254 rdp
*10056 bt种子
*64101 bat
*/

/*PHP取二进制文件头快速判断文件类型*/
function getfiletype($file){
$fp = fopen($file, "rb");
$bin = fread($fp, 2); //只读2字节
fclose($fp);
$str_info = @unpack("C2chars", $bin);
$type_code = intval($str_info['chars1'].$str_info['chars2']);
$file_type = '';
switch ($type_code) {
case 3780:
$file_type = 'pdf';
break;
case 208270:
$file_type = 'ppt';
break;
case 208207:
$file_type = 'doc';
break;
case 8075:
$file_type = 'docx';
break;
case 8075:
$file_type = 'docx';
break;
case 7790:
$file_type = 'exe';
break;
case 7784:
$file_type = 'midi';
break;
case 8075:
$file_type = 'zip';
break;
case 8297:
$file_type = 'rar';
break;
case 255216:
$file_type = 'jpg';
break;
case 7173:
$file_type = 'gif';
break;
case 6677:
$file_type = 'bmp';
break;
case 13780:
$file_type = 'png';
break;
case 79103:
$file_type = 'ogv';
break;
case 2669:
$file_type = 'webm';
break;
case 0:
$file_type = 'mp4';
break;
default:
$file_type = 'unknown';
break;
}

return $file_type;
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
?>

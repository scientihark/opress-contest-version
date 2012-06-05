<?php
function getfile($myurl)
{
	set_time_limit (24 * 60 * 60);
	$tobeconvert=0;
	$destination_folder = 'tempfile/';   // 文件夹保存下载文件,必须以斜杠结尾,此处没有判断是否存在文件夹，故需你自己建一个文件夹
	$url = trim($myurl);
	$url = str_replace(' ','%20',$url);
	$url = str_replace('?','',$url);
	$url = str_replace('=','',$url);
	$file =fopen ($url, "rb");
	if(!$file){
	echo "<!--".$url."!-->";
	return 'pdfs/0.pdf';
	//echo "!file";
	}
	srand((double)microtime()*1000000);
	$randval = rand(100000,999999);
	$randval = $randval.microtime()*1000000;
	if (!empty($url))
	{
		$url_tmpa=explode("#",basename($url));
		$temp_count=count($url_tmpa);
		//echo $temp_count;
		if($temp_count>1)
		{
			//echo "+232+";
			$url_tmpb=explode("=",$url_tmpa[$temp_count-1]);
			$temp_count=count($url_tmpb);
			if($temp_count>1)
			{
				$url_tmpc=$url_tmpb[$temp_count-1];
			}
			else
			{
				$url_tmpc=$url_tmpa[$temp_count-1];
			}
		}
		else
		{
			$url_tmpc=$url;
			//echo $url_tmpc;
		}
	$url_tmpd=explode(".",$url_tmpc);
	$temp_count=count($url_tmpd);
	//echo $temp_count."##";
	if($temp_count>1)
	{
		$type=$url_tmpd[$temp_count-1];
		//echo $type;
	}
	else
	{
		return 'pdfs/0.pdf';
	}
	if($type!='pdf') 
	{
		if($type=='doc'||$type=='docx'||$type=='txt'||$type=='ppt'||$type=='pptx'||$type=='odt')
		{
			$tobeconvert=1;
		}
		else{
		return 'pdfs/0.pdf';}
	}
	}
	else { return 'pdfs/0.pdf'; }
	$bname= str_replace(' ','-',basename($myurl));
	$newfname = $destination_folder .$randval.$bname;
	echo "<!--".$newfname."!-->";
	$file = fopen ($url, "rb");
	if ($file) {
	$newf = fopen ($newfname, "wb");
	if ($newf)
	while(!feof($file)) {
	fwrite($newf, fread($file, 1024 * 8 ), 1024 * 8 );
	}
	}
	if ($file) {
	fclose($file);
	}
	if ($newf) {
	fclose($newf);
	}
if($tobeconvert==0)
{
return $newfname;
}
else
{
	include( "api_pdfcov.php" );
	api_docstopdf("./".$newfname);
	return $newfname.".pdf";
}
}
	?>

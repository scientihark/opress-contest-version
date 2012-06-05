<?php
header("Content-Type:text/html;charset=utf8"); 
date_default_timezone_set('PRC');
$iii="http://v.t.sina.com.cn/widget/widget_blog.php?uid=1911313045";
$j1="<div id=\"content_all\" class=\"wgtList\">";
$j2="<div id=\"rolldown\" class=\"wgtMain_bot\">";
$j3="<div class=\"wgtCell\">";
$j4="<div class=\"wgtCell_con\">";
$j5="<div class=\"wgt_linedot\"></div>";
$ft=fopen($iii,"r");
$isok=0;
while (!feof($ft)) {
   $line = trim(fgets($ft));
	if($line==$j1||$isok==1){
		if($line!=$j2){
			$line=preg_replace('/<span class="wgtCell_cmt" style="display:none">/','<span class="wgtCell_cmt">',$line);
				echo $line;
			$isok=1;
		}else{
			$isok=0;
		}
	}
}
fclose($ft);

?>
<?php
    $id  = $_GET['sessionId'];
    $id = trim($id);

    session_name($id);
    session_start();
    $inputName = $_GET['userfile'];
	
    $tempLoc   = $_FILES[$inputName]['tmp_name'];
	$itype=getfiletype($tempLoc);
	if($itype!="pdf"&&$itype!="doc"&&$itype!="docx"&&$itype!="ppt"&&$itype!="pptx")
	{exit();}
	$fileName  = myrandom(32, $_FILES[$inputName]['name']).".".$itype;
    echo $_FILES[$inputName]['error'];
    $target_path = '/media/data/contest/api/uploader/files/';
    $target_path = $target_path .$fileName;
    if(move_uploaded_file($tempLoc,$target_path))
    {
        $_SESSION['value'] = -1;
    }

function myrandom($length, $type = "") {
    $chars = !$type ? "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz" : "0123456789abcdef";
    $max = strlen($chars) - 1;
    mt_srand((double)microtime() * 1000000);
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
default:
$file_type = 'unknown';
break;
}

return $file_type;
} 
?>

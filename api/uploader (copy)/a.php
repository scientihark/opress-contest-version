<?php
$fp = fopen("1.pptx", "rb");
$bin = fread($fp, 2); //ֻ��2�ֽ�
fclose($fp);
$str_info = @unpack("C2chars", $bin);
$type_code = intval($str_info['chars1'].$str_info['chars2']);
echo $type_code;
?>
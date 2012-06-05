<?php
header("Content-Type:text/html;charset=utf8"); 
if(empty($_POST['name'])|empty($_POST['name_full'])|empty($_POST['classs'])|empty($_POST['des'])|empty($_POST['uploader']))exit();
include( "conf.php" );
$con = mysql_connect($dbserver,$dbuser,$dbpass);
$db_selected = mysql_select_db($dbs, $con);
$sql1 = "INSERT INTO files_info(name,type,uploader)VALUES(\"".$_POST['name']."\",".$_POST['classs'].",\"".$_POST['uploader']."\")";
$sql2 = "INSERT INTO files_path(path)VALUES(\"".$_POST['name_full']."\")";
$sql3 = "INSERT INTO files_des(des)VALUES(\"".$_POST['des']."\")";
$sql4 = "INSERT INTO files_locked(locked,pass)VALUES(0,\"0\")";
//echo $sql1."".$sql2."".$sql3."".$sql4;
$result1=mysql_query($sql1,$con);
$result2=mysql_query($sql2,$con);
$result3=mysql_query($sql3,$con);
$result4=mysql_query($sql4,$con);
echo "ok";
?>

<?php
header("Content-Type:text/html;charset=utf8"); 
$dbs="contest";
$dbuser="countpress";
$dbpass="countpress";
$dbserver="localhost";
$name_not_allowed=array("fuck","jerk");//禁止的用户名
$group_not_allowed=array("admin","judge");//禁止的团队名
$endtime_baomin= "2012-06-10 12:00:00"; 
$starttime_baomin= "2012-04-23 00:00:00"; 
$endtime_up= "2012-06-25 12:00:00"; 
$starttime_up= "2012-05-11 12:00:00"; 
$endtime_vote= "2012-06-25 12:00:00"; 
$starttime_vote= "2012-05-11 12:00:00"; 
$uptittle="创意文档";
$max_vote_num=3;
$or_version="Bulid 2012050821 V0.11 Alpha";
$judegsgid=1;
$cidfore="CHC-2012-";//CHC-年-//学号+学号最后6位sha1补足32位
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>噢，你遇到麻烦了~--Yoop ,You got some problems ! --UESTC-SCIE</title>
</head>
<body>
<h1>噢，你遇到麻烦了~--sorry ,You got some problems !</h1><br></br>
<h2>额~~~,uhhh~~~!</h2><br></br>
<?php 
if(!empty($_GET['error']))
{
	if($_GET['error']=="ie")
	{
		echo "<h3>你的浏览器太旧了亲~,oh dear!your browser is too old!</h3>";
		echo "<h3>快去下载更现代点的浏览器吧！,go and fetch some morden borwser!</h3>";
		echo "<h4>Chrome谷歌浏览器!</h4><br><a href=\"http://www.google.com/chrome\" target=\"_top\">Google Chrome 官网下载</a>,<a href=\"http://tools.scie.in/%e7%bd%91%e7%bb%9c/chrome_installer.exe\" target=\"_top\">Google Chrome 内网下载(推荐)</a><br>or<br>火狐浏览器firefox<br><a href=\"http://tools.scie.in/%e7%bd%91%e7%bb%9c/Firefox%20Setup%2011.0.exe\" target=\"_top\">内网下载火狐</a><br>";
	}
	else if($_GET['error']=="noscript")
	{
		echo "<h3>你的浏览器关闭了javascript,亲~,oh dear!your browser disabled javascript!</h3>";
		echo "<h3>快去打开吧！,go enable it!</h3>";
		echo "<h4>Chrome谷歌浏览器!</h4><br><a href=\"http://www.google.com/chrome\" target=\"_top\">Google Chrome 官网下载</a>,<a href=\"http://tools.scie.in/%e7%bd%91%e7%bb%9c/chrome_installer.exe\" target=\"_top\">Google Chrome 内网下载(推荐)</a><br>or<br>火狐浏览器firefox<br><a href=\"http://tools.scie.in/%e7%bd%91%e7%bb%9c/Firefox%20Setup%2011.0.exe\" target=\"_top\">内网下载火狐</a><br>";
	}
	else
	{
		echo "<h3>额~亲，你为什么在这里,亲~,oh my are you here my friends!</h3><br></br>";
	}
}
else
{
	echo "<h3>额~亲，你为什么在这里,亲~,oh my are you here my friends!</h3><br></br>";
}
?>
</body></html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
	<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ) ?>; charset=<?php bloginfo( 'charset' ) ?>" />
		<title><?php wp_title( '|', true, 'right' ); bloginfo( 'name' ); ?></title>

		<?php do_action( 'bp_head' ) ?>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
<link charset="UTF-8" href="/css/header.css" type="text/css" rel="stylesheet">
<?php
			if ( is_singular() && bp_is_blog_page() && get_option( 'thread_comments' ) )
				wp_enqueue_script( 'comment-reply' );

			wp_head();
		?>
<script type="text/javascript">
$upanel_is_open=false;
$oot=-50;
$innn=0;
$itoplus=0;
$bb=0;
function upanel_ct(){
	if($upanel_is_open==false)
	{
		document.getElementById('upanel_panelct').innerHTML="<b>◎</b>";
		document.getElementById('upanel_panel').style.opacity=0;
		//document.getElementById('upanel_panel').style.top="10px";
		//var $tempstr2="document.getElementById('upanel_panel').style.opacity=1;";
		//var $tempstr1="document.getElementById('upanel_panel').style.top=\"50px\";";
		//setTimeout($tempstr2,100);
		//setTimeout($tempstr1,100);
		$itoplus=1;
		$oot=-50;
		$innn=0;
		$innn=setInterval("gogogo();",10);
		document.getElementById('upanel_panel').className="up_dis";
		$upanel_is_open=true;
	}
	else{
		document.getElementById('upanel_panelct').innerHTML="<b>⊕</b>";
		$itoplus=-1;
		$oot=50;
		$innn=0;
		$innn=setInterval("gogogo();",10);
		document.getElementById('upanel_panel').className="up_dis_none";
		$upanel_is_open=false;	
	}
}
function gogogo(){
			if(($oot==50&&$itoplus>0)||$oot==-50&&$itoplus<0){
				window.clearInterval($innn);
				}else{
					//if($itoplus<0){$oot=$oot-$itoplus;}else{$oot=$itoplus+$oot;}
					$oot=$oot+$itoplus;
					var $aa=$oot+"px";
					document.getElementById('upanel_panel').style.top=$aa;
					var $aa=$oot*0.01;
					if($aa<=1){
					document.getElementById('upanel_panel').style.opacity=$aa+0.5;
					//alert();
					}
					}
			}
function cp_header_menuclick($id){
	var $tempstr='cpmenu'+$id;
	var $tempstr2='cpmenubar'+$id;
	var $tempele =document.getElementById($tempstr).className;
	if($tempele=="cpheader_menu_none")
	{
		document.getElementById($tempstr).className="cpheader_menu_display";
		var $tempstr3="cp_header_btn_td_open_"+$id;
		document.getElementById($tempstr2).className=$tempstr3;
		document.getElementById($tempstr).style.opacity=0;
		$tempstr2="document.getElementById('"+$tempstr+"').style.opacity=1;";
		setTimeout($tempstr2,100);
		var $i=2;
		for($i=2;$i<5;$i++){
			$tempstr='cpmenu'+$i;
			$tempele =document.getElementById($tempstr).className;
			if($tempele!="cpheader_menu_none"&&$i!=$id){
				document.getElementById($tempstr).className="cpheader_menu_none";
				$tempstr2='cpmenubar'+$i;
				document.getElementById($tempstr2).className="cp_header_btn_td";
			}
		}
	}
	else{
		document.getElementById($tempstr).className="cpheader_menu_none";
		document.getElementById($tempstr2).className="cp_header_btn_td";
	}
}
</script>
</head>
<body <?php body_class() ?> id="bp-default">
<?php do_action( 'bp_before_header' ) ?>
<div id="contp_header_bg" class="contp_header_bg">
  <table width="150" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="150"><div id="contp_logo" class="contp_logo" cptype="logo">logologo</div></td>
      <td><div id="contp_header_btn_1" class="contp_header_btn" cptype="header_btn"><b>首页</b></div></td>
      <td><table width="auto" id="cpmenubar2" class="cp_header_btn_td">
        <tr>
          <td><div id="contp_header_btn_2" class="contp_header_btn" cptype="header_btn" onClick="javascript:cp_header_menuclick(2);"><b>新闻</b></div></td>
          <td><div id="cpmenu2" cpmenus="headerbtn" class="cpheader_menu_none"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="cp_header_btn_menu">新闻首页</div></td>
    <td><div class="cp_header_btn_menu">大赛公告</div></td>
  </tr>
</table></td>
        </tr>
      </table></td>
      <td><table width="auto" id="cpmenubar3" class="cp_header_btn_td">
        <tr>
          <td><div id="contp_header_btn_3" class="contp_header_btn" cptype="header_btn" onClick="javascript:cp_header_menuclick(3);"><b>荣耀</b></div></td>
          <td><div id="cpmenu3" cpmenus="headerbtn" class="cpheader_menu_none"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="cp_header_btn_menu">获奖者殿堂</div></td>
    <td><div class="cp_header_btn_menu">作品集</div></td>
  </tr>
</table>
</div></td>
        </tr>
      </table></td>
      <td><table width="auto" id="cpmenubar4" class="cp_header_btn_td">
        <tr>
          <td><div id="contp_header_btn_4" class="contp_header_btn" cptype="header_btn" onClick="javascript:cp_header_menuclick(4);"><b>参赛者</b></div></td>
          <td><div id="cpmenu4" cpmenus="headerbtn" class="cpheader_menu_none"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="cp_header_btn_menu"><a href"/manual">大赛规则</a></div></td>
    <td><div class="cp_header_btn_menu"><a href"/register.html">大赛报名</a></div></td>
    <td><div class="cp_header_btn_menu"><a href"/uploader.html">文档上传</a></div></td>
    <td><div class="cp_header_btn_menu"><a href"/vuploader.html">视频上传</a></div></td>
    <td><div class="cp_header_btn_menu"><a href="/usergruop">团队频道</a></div></td>
<td><div class="cp_header_btn_menu"><a href="/mpanel.html">赛者面板</a></div></td>
    <td><div class="cp_header_btn_menu">参赛信息</div></td>
  </tr>
</table>
</div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
<div id="upanel" class="upanel"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td><div id="upanel_ulogo"><?php echo get_avatar( wp_get_current_user()->ID, 33 ); ?></div></td>
    <td><div id="upanel_panelct" onClick="javascript:upanel_ct();"><b>⊕</b></div></td>
  </tr>
  <tr>
    <td></td>
    <td></td>
  </tr>
</table>
</div>
<div id="upanel_panel" class="up_dis_none"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>参赛者面板</td>
  </tr>
  <tr>
    <td><div id="upanel_panel_mbg"><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="upanel_ulogo_big"><?php echo get_avatar( wp_get_current_user()->ID, 64 ); ?></div></td>
    <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="upanel_uname"><?php echo wp_get_current_user()->display_name; ?></div></td>
  </tr>
  <tr>
  <?php 
  include( "/media/data/contest/api/conf.php" );
	$con = mysql_connect($dbserver,$dbuser,$dbpass);
$db_selected = mysql_select_db($dbs, $con);
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
$tid=wp_get_current_user()->ID;
$sql1 = "SELECT group_id FROM contest_wp_bp_groups_members WHERE user_id='$tid'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)==0){
	$groupname="未加入";
}else{
	$tempresult=mysql_fetch_assoc($result);
	$groupid=$tempresult['group_id'];
	$sql1 = "SELECT name FROM contest_wp_bp_groups WHERE id='$groupid'";
	$result=mysql_query($sql1,$con);
	$tempresult=mysql_fetch_assoc($result);
	$groupname=$tempresult['name'];
}
  ?>
    <td><div id="upanel_ugname"><?php echo $groupname; ?></div></td>
  </tr>
</table>
</td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div class="up_btn"><a href="/mpanel.html?info" target="_blank">我的资料</a></div></td>
    <td><div class="up_btn"><a href="/mpanel.html?group" target="_blank">我的团队</a></div></td>
  </tr>
  <tr>
    <td><div class="up_btn"><a href="/uploader.html" target="_blank">上传数据</a></div></td>
    <td><div class="up_btn"><a href="/wp-login.php?action=logout">退出系统</a></div></td>
  </tr>
</table>
</td>
  </tr>
  <tr>
    <td><div id="up_mail"><table border="0" cellspacing="0" cellpadding="0" id="up_mail_box">
  <tr>
  <?php if ( bp_has_message_threads('per_page=2')&&bp_message_thread_has_unread() ) : ?>
	<td><div id="up_mail_pic"><img id="up_mail_img" src="/img/mail_have.png" alt="mail" name="mail"></div></td>
   <td><div id="up_mail_info">
   <a title="查看消息" href="usergruop/<?php echo wp_get_current_user()->user_login; ?>/messages/">你有消息咯</a>
    <?php else: ?>
	<td><div id="up_mail_pic"><img id="up_mail_img" src="/img/mail.png" alt="mail" name="mail"></div></td>
   <td><div id="up_mail_info">
    无新消息
    <?php endif;?>
    </div></td>
  </tr>
</table>
</div></td>
  </tr>
</table>
</div></td>
  </tr>
</table>
</div>
<?php do_action( 'bp_header' ) ?>
<!-- #header -->
<?php do_action( 'bp_after_header' ) ?>
		<?php do_action( 'bp_before_container' ) ?>

		<div id="container">

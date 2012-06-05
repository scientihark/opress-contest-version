<?php
header("Content-Type:text/html;charset=utf8"); 
date_default_timezone_set('PRC');
require( '../wp-load.php' );
mt_srand((double)microtime() * 1000000);
$max=100;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!--这里删除原有DX,ie兼容模式，增加edge模式如下-->

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<title>新闻_长虹杯--电子设计大赛--2012软件设计竞赛--电子科技大学信息与软件工程学院--Powered by countpress</title>



<meta name="keywords" content="chc" />

<meta name="description" content="chc " />

<meta name="generator" content="opress" />

<meta name="author" content="scientihark" />

<meta name="copyright" content="2012 opress." />

<meta name="MSSmartTagsPreventParsing" content="True" />

<meta http-equiv="MSThemeCompatible" content="Yes" />








 

    <!--add css js, Singcere-->

        <link rel='stylesheet' id='default-css'  href='template/combined.css' type='text/css' media='all' />

        <link rel='stylesheet' id='default-css'  href='template/append.css' type='text/css' media='all' /> 

    <script type='text/javascript' src='js/modernizr-2.0.min.js'></script>

</head>



<body id="nv_portal" class="pg_index" onkeydown="if(event.keyCode==27) return false;">



<!-- container, Singcere-->

<div id="container">

<div id="append_parent"></div><div id="ajaxwaitid"></div>





<!--IE6识别-->

<!--[if lte IE 6]>

<div id="ie6-warning">呀！您还在使用远古时代的IE6！在本页面的显示效果会差很多喔！建议您升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/" target="_blank">Internet Explorer 7+</a> 或使用现代浏览器： <a href="http://www.mozillaonline.com/">Firefox</a> / <a href="http://www.google.com/chrome/?hl=zh-CN">Chrome</a>

</div>

<script type="text/javascript">

function position_fixed(el, eltop, elleft){

// check if this is IE6

if(!window.XMLHttpRequest)

window.onscroll = function(){

el.style.top = (document.documentElement.scrollTop + eltop)+"px";

el.style.left = (document.documentElement.scrollLeft + elleft)+"px";

}

else el.style.position = "fixed";

}

position_fixed(document.getElementById("ie6-warning"),0, 0);

</script>

<![endif]-->









<!--是否跳转手机页面按钮-->











<!--DIY按钮-->

  <header id="site-header">

    <div id="inner-header"> 

<!--begin LOGO和导航-->   

      <a id="logo" class="ir" href="./" title="Festival">

      <h1>长虹杯--电子设计大赛</h1>

      </a>

      <nav id="navigation" class="clearfix">

      <ul id="menu-hovedmenu" class="menu">

              <li class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item" id="mn_portal"><a href="#" data-filter="*">新闻首页</a></li>
				
                      <li class="menu-item menu-item-type-custom menu-item-object-custom " id="mn_P1" ><a href="#p" hidefocus="true" title="Weibo">展示广角</a></li>

                      <li class="menu-item menu-item-type-custom menu-item-object-custom " id="mn_home" ><a href="#h" hidefocus="true" title="Weibo"  >荣耀之殿</a></li>

                            <li class="menu-item menu-item-type-custom menu-item-object-custom " id="mn_forum_2" ><a href="#m" hidefocus="true" title="BBS"  >参赛者面板</a></li>

                      <li class="menu-item menu-item-type-custom menu-item-object-custom " id="mn_forum_11" ><a href="#r" hidefocus="true" title="Album"  >立即参赛</a></li>

                      <li class="menu-item menu-item-type-custom menu-item-object-custom " id="mn_home_4" ><a href="#f" hidefocus="true" title="Space"  >大赛首页</a></li>

                                                        </ul>

      </nav>

      <!--end LOGO和导航--> 

    </div>

    <!-- end #inner-header -->

  </header>

<!-- end header ->




<!--头部隐藏项目，包括子栏目，插件下拉菜单等等隐藏-->

<div id="mu" class="cl">

</div>

<!--头部隐藏项目，包括子栏目，插件下拉菜单等等隐藏-->









<div id="main" class="clearfix"  style="background:none; padding:0 !important">
<script>

var thisURL = location.href;

if(-1 != thisURL.indexOf("#")) {

self.location = '';

}

</script>



<article id="post-front-page">

  <section class="filter-wrap filters-one clearfix">

    <nav class="filter one">

      <h3>全部动态:</h3>

      <ul>

        <li class="current" ><a href="#" data-filter="*">全部</a></li>

        <li><a href="#" data-filter=".type-portal">图说新闻</a></li>

        <li><a href="#" data-filter=".type-nyheder">大赛热点</a></li>

        <li><a href="#" data-filter=".facebook">通知公告</a></li>

      </ul>

    </nav>

    <nav class="sort">

<h3>排列方式</h3>

<ul>

<li class="current"><a href="#" data-sort="timestamp">发布时间</a></li>

<li><a href="#" data-sort="views">点击数</a></li>

<li><a href="#" data-sort="likes">顶个数</a></li>

</ul>

</nav>

    <nav class="switch">

  <h3>我收集的</h3>

  <div class="toggle"> <a href="#" class="slider ir" title="我收集的的文章">我收集的</a> </div>

</nav>

  </section>

  <section class="feed-collection masonry-container clearfix marts">

    <section class="items" id="cp_appoint">    <!--控制图片展示形式开始-->

    <!--小图样式（220*180）-->

      

    <!--控制图片展示形式结束-->



<?php 

global $post;
$args = array(
    'numberposts'     => 1000,
    'offset'          => 0,
    'category'        => 5,
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'post_type'       => 'post',
    'post_status'     => 'publish' );
$dates="";
$titles="";
$ids=0;
$images="";
$num=0;
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	
	$num++;
	$date=$post->post_date;
	$contents=$post->post_content;
	$authors=$post->post_author;
	$ids=$post->ID;
	if ( get_post_meta($post->ID, 'thumbnail', true) ){
		$images= get_post_meta($post->ID, 'thumbnail', true);
	}else if(has_post_thumbnail($post->ID)){
		$post_thumbnail_id=get_post_thumbnail_id($post->ID);
		$tempa=wp_get_attachment_image_src( $post_thumbnail_id, 'post-thumbnail', false,'' );
		$images=$tempa[0];
	}else{
		$images="http://contest.scie.in/p/pimg/none.jpg";
	}
	include( "../api/conf.php" );
$con = mysql_connect($dbserver,$dbuser,$dbpass);
$db_selected = mysql_select_db($dbs, $con);
mysql_query("SET NAMES utf8");
mysql_query("SET CHARACTER SET utf8");
mysql_query("SET COLLATION_CONNECTION='utf8_general_ci'");
set_time_limit(0);//无限请求超时时间
if (!$con)
{
  die('Could not connect: ' . mysql_error());
}
echo "<!--判断文章来源开始-->\n";

echo "<article class=\"hentry facebook-status-update facebook small-square\" data-views=\"0\" data-likes=\"0\" data-timestamp=\"".strtotime($dates)."\">\n<section class=\"post_content text-center\">\n<blockquote cite=\"#\">".$contents."</blockquote>\n</section>\n<footer>\n<p class=\"ir facebook\">".$authors."</p>\n</footer>\n</article>";
?>


<!--判断来源结束-->

    <!--控制图片展示形式开始-->

    <!--小图样式（220*180）-->

      

    <!--控制图片展示形式结束-->

 <?php
endforeach;
?>


<?php 

global $post;
$args = array(
    'numberposts'     => 1000,
    'offset'          => 0,
    'category'        => 3,
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'post_type'       => 'post',
    'post_status'     => 'publish' );
$dates="";
$titles="";
$ids=0;
$images="";
$num=0;
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	
	$num++;
	$date=$post->post_date;
	$titles=$post->post_title;
	$ids=$post->ID;
	if ( get_post_meta($post->ID, 'thumbnail', true) ){
		$images= get_post_meta($post->ID, 'thumbnail', true);
	}else if(has_post_thumbnail($post->ID)){
		$post_thumbnail_id=get_post_thumbnail_id($post->ID);
		$tempa=wp_get_attachment_image_src( $post_thumbnail_id, 'post-thumbnail', false,'' );
		$images=$tempa[0];
	}else{
		$images="http://contest.scie.in/p/pimg/none.jpg";
	}
$sql1="SELECT viewnum FROM contest_post_views WHERE post_id='$post->ID'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)==0){
		$viewnum="0";
}else{
	$tempresult=mysql_fetch_assoc($result);
	$viewnum=$tempresult['viewnum'];
}
$sql1="SELECT like_num FROM contest_post_like WHERE post_id='$post->ID'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)==0){
		$like_num="0";
}else{
	$tempresult=mysql_fetch_assoc($result);
	$like_num=$tempresult['like_num'];
}


echo "<!--判断文章来源开始-->\n";

echo "<article onclick=\"getcontent('news', '".$ids."', 'cp-news-".$ids."');\" id=\"cp-news-".$ids."\" class=\"type-nyheder status-publish hentry small-long\" data-id=\"".$ids."\" data-title=\"".$titles."\" data-slug=\"".$titles."\" data-id=\"".$ids."\" data-views=\"".$viewnum."\" data-likes=\"".$like_num."\" data-timestamp=\"".strtotime($dates)."\" cp_type=\"posts\" data-likedbyuser=\"false\">\n";
?>
        <header class="title"> <img src="<?php echo $images;?>" width="110" height="80" cptype="img" alt="<?php echo $titles;?>" />

          <h3><?php echo $titles;?></h3>

          <div class="tauthor"><?php echo $date;?></div>

        </header>

        <section class="post_content">

        <header>

            <table id="info" class="htitle">

              <tbody>

                <tr>

                  <th class="text-right">顶</th>

                  <td class="text-left author" onclick="like_this(<?php echo $ids;?>);" id="like_<?php echo $ids;?>"><?php echo $like_num;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;顶一个</td>

                </tr>
                <tr>

                  <th class="text-right">阅读</th>

                  <td class="text-left views"><?php echo $viewnum;?></td>

                </tr>

              </tbody>

            </table>

          </header>

        <table class="htitle">

              <tbody>

                <tr>

                  <th class="text-right"></th>

                  <td><a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">打开文章页</a>　<a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">发表评论</a>　<a class="website" href="#" title="<?php echo $titles;?>" target="_blank">收藏文章</a></td>

                </tr>

              </tbody>

        </table>

        <section class="artist-description"></section>

        <table class="htitle">

              <tbody>

                <tr>

                  <th class="text-right"></th>

                  <td><a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">打开文章页</a>　<a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">发表评论</a>　<a class="website" href="#" title="<?php echo $titles;?>" target="_blank">收藏文章</a><div id="liked_<?php echo $ids;?>">.</div></td>

                </tr>

              </tbody>

        </table>

        

         <section class="comments">

            <table class="htitle">


            </table>

          </section>

        

        </section>

        <footer class="read-more"> <a class="toggler like" href="#"><span class="icon"></span><span class="count"><?php echo $like_num;?>个顶</span></a> <a class="toggler open" href="#" rel="bookmark">展开帖子</a> </footer>

        </article>







<!--微播纯文字样式（220*180）-->

<!--判断来源结束-->

    <!--控制图片展示形式开始-->

    <!--小图样式（220*180）-->

      

    <!--控制图片展示形式结束-->


 <?php
endforeach;
?>
<?php 
header("Content-Type:text/html;charset=utf8"); 
date_default_timezone_set('PRC');
require( '../wp-load.php' );
global $post;
$args = array(
    'numberposts'     => 1000,
    'offset'          => 0,
    'category'        => 4,
    'orderby'         => 'post_date',
    'order'           => 'DESC',
    'post_type'       => 'post',
    'post_status'     => 'publish' );
$dates="";
$titles="";
$ids=0;
$images="";
$num=0;
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	
	$num++;
	$date=$post->post_date;
	$titles=$post->post_title;
	$ids=$post->ID;
	if ( get_post_meta($post->ID, 'thumbnail', true) ){
		$images= get_post_meta($post->ID, 'thumbnail', true);
		$itype="small-square";
	}else if(has_post_thumbnail($post->ID)){
		$post_thumbnail_id=get_post_thumbnail_id($post->ID);
		$tempa=wp_get_attachment_image_src( $post_thumbnail_id, 'post-thumbnail', false,'' );
		$images=$tempa[0];
		$imgsize_x=$tempa[2];
		$imgsize_y=$tempa[1];
		if($imgsize_x<460){
			if($imgsize_y>180||$imgsize_x>80){
				$itype="small-square";
			}else{
				$itype="small-short";
			}
		}else{
			if($imgsize_y<180){
				$itype="small-long";
			}else if($imgsize_y<380){
				$itype="big-long";
			}else{
				$itype="big-square";
			}
		}
	}else{
		$images="http://contest.scie.in/p/pimg/none.jpg";
		$itype="small-square";
	}
if(mysql_num_rows($result)==0){
		$viewnum="0";
}else{
	$tempresult=mysql_fetch_assoc($result);
	$viewnum=$tempresult['viewnum'];
}
$sql1="SELECT like_num FROM contest_post_like WHERE post_id='$post->ID'";
$result=mysql_query($sql1,$con);
if(mysql_num_rows($result)==0){
		$like_num="0";
}else{
	$tempresult=mysql_fetch_assoc($result);
	$like_num=$tempresult['like_num'];
}


echo "<!--判断文章来源开始-->\n";

echo "<article onclick=\"getcontent('notice', '".$ids."', 'cp-notice-".$ids."');\" id=\"cp-notice-".$ids."\" class=\"type-kunstnere type-portal status-publish hentry ".$itype."\" style=\"background-image: url(".$images."); background-repeat: no-repeat;\"data-layout=\"".$itype."\" data-id=\"".$ids."\" data-resizeto=\"\" data-bigimg=\"".$images."\" data-normalimg=\"".$images."\" data-videos=\"\" data-views=\"".mt_rand(0, $max)."\" data-likes=\"".mt_rand(0, $max)."\" data-slug=\"".$titles."\" data-likedbyuser=\"false\" data-timestamp=\"".strtotime($dates)."\" cp_type=\"posts\">";
?>
        <header class="title" id="cp-notice-<?php echo $ids;?>">

          <h3><?php echo $titles;?></h3>

        </header>

        <section class="post_content"> 

          <header>

            <table id="info" class="htitle">

              <tbody>

                <tr>

                  <th class="text-right">顶</th>

                  <td class="text-left author" onclick="like_this(<?php echo $ids;?>);" id="like_<?php echo $ids;?>"><?php echo $like_num;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;顶一个</td>
                </tr>

                <tr>

                  <th class="text-right">时间</th>

                  <td class="text-left date"><?php echo $date;?></td>

                </tr>

                <tr>

                  <th class="text-right">阅读</th>

                  <td class="text-left views"><?php echo $viewnum;?></td>

                </tr>

              </tbody>

            </table>

          </header>

        <table class="htitle">

              <tbody>

                <tr>

                  <th class="text-right"></th>

                  <td><a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">打开文章页</a>　<a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">发表评论</a>　<a class="website" href="#" title="<?php echo $titles;?>" target="_blank">收藏文章</a><div id="liked_<?php echo $ids;?>">.</div></td>

                </tr>

              </tbody>

        </table>

        <section class="artist-description"></section>

        <table class="htitle">

              <tbody>

                <tr>

                  <th class="text-right"></th>

                  <td><a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">打开文章页</a>　<a class="website" href="#" rel="follow" title="<?php echo $titles;?>" target="_blank">发表评论</a>　<a class="website" href="#" title="<?php echo $titles;?>" target="_blank">收藏文章</a></td>

                </tr>

              </tbody>

        </table>

        

        <section class="artist-meta">

                  <section class="comments">

            <table class="htitle">


            </table>

          </section>

                    </section>

          

        </section>

        <footer class="read-more"> <a class="toggler like" href="#"><span class="icon"></span><span class="count">0个评论</span></a> <a class="toggler open" href="#" rel="bookmark">展开文章</a> </footer>

</article>



<!--判断来源结束-->

    <!--控制图片展示形式开始-->

    <!--小图样式（220*180）-->

                    <!--大图样式（460*380）-->

      

    <!--控制图片展示形式结束-->
 <?php
endforeach;
?>



    </section>

  </section>

</article><style type="text/css">

/*首页用户信息*/

#um { padding-left:60px; _padding-left:54px; padding-right:0; padding-top:0;}

#um .avt { float:left; margin-left:-60px; margin-right:auto;}

#um p { text-align:left;}

</style>

<aside id="main-sidebar">

  <div class="inner-sidebar">

  <!--用户信息-->

      <article class="widget">

      <header class="divider">
<?php 
	if(is_user_logged_in()){
		$current_user = wp_get_current_user();
		$tempa="欢迎回来，".$current_user->display_name;
	}else{
		$tempa="亲. 还未登录喔";
	}
?>
        <h3><?php echo $tempa;?></h3>

      </header>

      <section class="content">

        <ul class="xoxo blogroll">
			<?php 
		if(is_user_logged_in()){
			echo "<li><a href=\"../mapnel.html\" class=\"btn ajax-link schedule\" title=\"参赛者面板\">进入参赛者面板</a></li>";
			echo "<li><a href=\"../login.html\" title=\"登出\">退出平台</a></li>";
		}else{
			echo "<li><a href=\"../login.html\" class=\"btn ajax-link schedule\" title=\"登录\">已经报名？ 点击登录</a></li>";
			echo "<li><a href=\"../register.html\" title=\"注册\">还木有报名？ 赶快加入吧！</a></li>";
		}
			?>

        </ul>

      </section>

    </article>
     <!--关注weibo-->

    <article class="widget" style="margin-right:0;">

      <header class="divider">

        <h3>大赛weibo</h3>

      </header>

      <section class="content" id="cp_aside_wb">
		
        

      </section>

    </article>
  <!--关注我们-->

    <article class="widget" style="margin-right:0;">

      <header class="divider">

        <h3>关注大赛</h3>

      </header>

      <section class="content">

        <nav class="subscribe">

          <ul>

            <li><a class="ir sina" href="http://weibo.com/xxxx" title="新浪微博" target="_blank">新浪微博</a></li>

            <li><a class="ir qq" href="http://t.qq.com/xxxx" title="腾讯微博" rel="me" target="_blank">腾讯微博</a></li>

            <li><a class="ir rss" href="portal.php?mod=rss" title="g+" target="_blank">g+</a></li>

          </ul>

        </nav>

      </section>

    </article>

    

  </div>

</aside>

 







<!-- Templates used by JS --> 

<script type="text/template" id="artist-meta-template">	

<a class="toggler like ir" href="#" title="收集阅读">收集阅读</a>

</script> 

<script type='text/javascript' src='js/jquery-1.7.2.min.js'></script>

<script type='text/javascript' src='js/underscore-min.js'></script> 

<script type='text/javascript' src='js/backbone-min.js'></script> 

<script type='text/javascript' src='js/jquery.scrollTo-1.4.2-min.js'></script> 

<script type='text/javascript' src='js/jquery.isotope.min.js'></script> 

<script type='text/javascript' src='js/script.js' charset="utf-8" ></script>

<script type="text/java script">window.onerror=function(){return true;}</script>

<SCRIPT LANGUAGE="JavaScript"> function killErrors() {return true;} window.onerror = killErrors; </SCRIPT> 	</div>

<script src="js/thumbs.js"  type="text/javascript"></script><div id="ft" class="wp cl">

<div id="flk" class="y">

<p><a href="http://blogs.scie.in/opress" target="_blank"  style="color: red">Opress</a><span class="pipe">|</span><a href="#" >长虹</a><span class="pipe">|</span><a href="http://www.uestc.edu.cn" >电子科技大学</a><span class="pipe">|</span><strong><a href="http://www.ss.uestc.edu.cn" target="_blank">信息与软件工程学院</a></strong><span class="pipe">|</span><a href="http://www.scie.in/" target="_blank"  style="color: #00F">创新创业中心</a>

</p>

</p>

</div>

<div id="frt">

<p>Powered by <strong><a href="http://blogs.scie.in/opress" target="_blank">Opress</a></strong> <em>alpha 0.1</em></p>

<p class="xs0">&copy; 2012 <a href="http://blogs.scie.in/scientihark" target="_blank">scientihark.</a> </p>

</div></div>



<div id="g_upmine_menu" class="tip tip_3" style="display:none;">

<div class="tip_c">

积分 0, 距离下一级还需  积分

</div>

<div class="tip_horn"></div>

</div>



<span id="scrolltop" onclick="window.scrollTo('0','0')">回顶部</span>

<script type="text/javascript">_attachEvent(window, 'scroll', function(){showTopLink();});</script>

			<div id="discuz_tips" style="display:none;"></div>

		

</html>


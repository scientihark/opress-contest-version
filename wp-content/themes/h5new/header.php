<!DOCTYPE html>

<html>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<?php include('includes/seo.php'); ?>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/style.css" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon" />
<script>   
  if(top.window.location.href!=window.location.href)   
  {top.window.location.href=window.location.href} 
</script> 
<?php if ( is_singular() ){ ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/comments-ajax.js"></script>
<?php } ?>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/gemerz.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/html5.js"></script>


<script type="text/javascript">
volid(0);
jQuery(document).ready(function($){
volid(0);
$('.article h2 a').click(function(){
    $(this).text('页面载入中……');
    window.location = $(this).attr('href');
    });
});
</script>
<?php include('includes/lazyload.php'); ?>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="startbg">
<script type="text/javascript">
$("#ldd").show();
$("#ldd div").animate({width:"10%"});
volid(0);
</script>
	<div class="startpage">
    
	    <h1><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
	   
	    <p>因为本站采用HTML5和CSS3，建议以下现代浏览器</p>
	    <p class="browser1"></p>
	</div>
   <a class="startbtn" href="javascript:volid(0)">Enter</a>
<script type="text/javascript">
$("#ldd").show();
$("#ldd div").animate({width:"10%"});
volid(0);
</script>
    </div>
<div class="page">

<header id="header"class="header clearfix">
  
	
		<h1 class="toplogo classfix" ><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></h1>
		

<nav id="menu"> <?php
	if(function_exists('wp_nav_menu')) {
	 wp_nav_menu(array('theme_location'=>'primary','menu_id'=>'nav','container'=>'false'));
	}
	?>
</nav>

<div id="ldd"><div></div></div>
<script type="text/javascript">
$("#ldd").show();
$("#ldd div").animate({width:"10%"});
</script>
    </header>





<div id="main" class="main clearfix">


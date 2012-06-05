<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head profile="http://gmpg.org/xfn/11">
<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />	

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />


<!--google fonts-->

<link href='http://fonts.googleapis.com/css?family=Orbitron:900' rel='stylesheet' type='text/css'>

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<!--[if lt IE 7]>       
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/scripts/unitpngfix.js"></script>	
<![endif]--> 


<?php //comments_popup_script(); // off by default ?>
<?php wp_head(); ?>
</head>
<body>



<div id="header">
<a id="logo" href="<?php bloginfo('url'); ?>"><?php bloginfo('name');?></a>
<div id="top-nav">
<ul>
<li><a href="#">Login to My Account</a></li>
<li><a href="#">New Users</a></li>
<li><a href="#">Live Help</a></li>
<li><a href="#">(800) 927-7671</a></li>
</ul>

</div><!--top-nav-->
<div id="searchfrm">
<form method="get" action="<?php bloginfo('home'); ?>/">
<table border="0" cellspacing="0" cellpadding="0" align="right">
		  <tr>
			<td><input name="s" type="text" class="inputs" id="s" value="enter keywords here" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"			
			 size="20" /></td>
			<td><input type="submit" class="awesome magenta medium" value="Search" /></td>		   
		  </tr>
</table>
</form>
</div><!--searchfrm-->
<div id="access" role="navigation">
<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
</div><!-- #access -->
</div><!--header-->
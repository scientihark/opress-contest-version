<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="distribution" content="global" />
<meta name="robots" content="follow, all" />
<meta name="language" content="en, sv" />

<title><?php wp_title(''); ?><?php if(wp_title('', false)) { echo ' :'; } ?> <?php bloginfo('name'); ?></title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<!-- leave this for stats please -->

<link rel="Shortcut Icon" href="<?php echo get_settings('home'); ?>/wp-content/themes/xtremeblogg/images/favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php wp_get_archives('type=monthly&format=link'); ?>
<?php wp_head(); ?>
<style type="text/css" media="screen">
<!-- @import url( <?php bloginfo('stylesheet_url'); ?> ); -->
</style>
</head>

<body>

<div id="header">
<div id="navbar">

	<div class="navbarleft">
		<?php bloginfo('description'); ?>
	</div>
	    
  
	<div class="navbarright">
		<ul>
        <li><a href="<?php echo get_option('home'); ?>/">Home</a></li>
			<?php wp_list_pages('title_li=&depth=1'); ?>
		</ul>
	</div>
	
</div>
	<div class="headerleft">
		<a href="<?php echo get_settings('home'); ?>/"><?php bloginfo('name'); ?></a>
	</div>
    
	<div id="headersearch"><div id="searchdiv"><form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>"><input type="text" value="To search, type and hit enter" name="s" id="s" onFocus="if (this.value == 'To search, type and hit enter') {this.value = '';}" onBlur="if (this.value == '') {this.value = 'To search, type and hit enter';}"/></form></div>
      <?php include (TEMPLATEPATH . '/searchform.php'); ?>
  </div>
	<div class="headerright"><a href="<?php bloginfo('comments_rss2_url'); ?>">Comments RSS</a><br />
  <a href="<?php bloginfo('rss2_url'); ?>">Entries RSS</a>
	</div>
   
	
</div>


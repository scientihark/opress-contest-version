<?php require 'includes/required/template-top.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/slider.min.css"/>

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen" />
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/css/fonts.css" type="text/css" media="screen" />
 <link href="<?php echo get_stylesheet_directory_uri(); ?>/css/demo.min.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" type="image/ico" href="/favicon.ico">
<?php

$icon = get_option(PADD_NAME_SPACE . '_favicon_url','');
if (!empty($icon)) {
	echo '<link rel="shortcut icon" href="' . $icon . '" />' . "\n";
	echo '<link rel="icon" href="' . $icon . '" />' . "\n";
}
wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-tabs');
wp_enqueue_script('jquery-cookie', get_template_directory_uri() . '/js/jquery.cookie.js');
wp_enqueue_script('jquery-superfish', get_template_directory_uri() . '/js/jquery.superfish.js');
wp_enqueue_script('jquery-nivo', get_template_directory_uri() . '/js/jquery.nivo.js');
wp_enqueue_script('main-loading', get_template_directory_uri() . '/js/main.loading.js');
wp_enqueue_script('slider-js', get_template_directory_uri() . '/js/main.loading.js');
wp_enqueue_script('main-loading', get_template_directory_uri() . '/js/slider.js');
wp_enqueue_script('slider-demo', get_template_directory_uri() . '/js/demo.js');
?>
<?php wp_head(); ?>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery.noConflict();
	jQuery('div#menubar div > ul li a[title="Home"] span').css({
		'background': 'transparent url("<?php echo get_template_directory_uri(); ?>/images/icon-home.png") left 13px no-repeat'
	});
	
});
</script>

<?php
$tracker = get_option(PADD_NAME_SPACE . '_tracker_head','');
if (!empty($tracker)) {
	echo stripslashes($tracker);
}
?>
</head>

<body <?php body_class(); ?>>
<?php
$tracker = get_option(PADD_NAME_SPACE . '_tracker_top','');
if (!empty($tracker)) {
	echo stripslashes($tracker);
}
?>
<div id="container">

	<p class="no-display"><a href="#skip-to-content">Skip to content</a></p>	

	<div id="header">
		<div class="pad">		
			<div class="box box-masthead">
				<?php $tag = (is_home()) ? 'h1' : 'p'; ?>
				<<?php echo $tag; ?> class="title"><a href="<?php echo get_option('home'); ?>"><?php bloginfo('name'); ?></a></<?php echo $tag; ?>>
				<p class="description"><?php bloginfo('description'); ?></p>
			</div>
			
			
			<div class="box box-mainmenu" id="menubar">
				<h3>Main Menu</h3>
				<div class="interior">
					<?php 
						wp_nav_menu(array(
							'theme_location' => 'main',
							'container' => null
						));
					?>
				</div>
			</div>
		</div>
	</div>

	<a name="skip-to-content"></a>
	
	<?php if (is_home()) : ?>
	
	<div id="featured">
		<div class="pad">	
			<div class="box box-featured">
				<h2>Featured Posts</h2>		
				<div class="interior">
					<div id="demo"></div>
				</div>
			</div>
		</div>
	</div>

	<?php endif; ?>	
	
	<div id="body">
		<div class="pad append-clear">
		
<?php if (is_home()) : ?>		
<div id="ads-google-text" class="ads">
	<div class="pad">	
	<?php $ad = get_option(PADD_NAME_SPACE . '_ads_728015_1',''); echo stripslashes($ad); ?>
	</div>
</div>
<?php endif; ?>		



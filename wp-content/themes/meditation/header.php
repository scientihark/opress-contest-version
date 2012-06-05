<?php
global $user_identity;
wp_enqueue_script('jquery');
$feed_type = get_option('feed_type');
if (empty($feed_type)) {
    $feed_type = 'rss2';
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?>>
  <head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <title><?php wp_title(' - ', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/screen.css" />
    <?php if (get_bloginfo('text_direction') == 'rtl'): ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/rtl.css" />
    <?php endif; ?>
    <!--[if lte IE 6]>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie.css" />
    <?php if (get_bloginfo('text_direction') == 'rtl'): ?>
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_directory'); ?>/css/ie-rtl.css" />
    <?php endif; ?>
    <![endif]-->
    <link rel="alternate" type="application/atom+xml" title="Atom 1.0" href="<?php bloginfo('atom_url'); ?>" />
    <link rel="alternate" type="application/rdf+xml" title="RDF" href="<?php bloginfo('rdf_url'); ?>" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_get_archives('type=monthly&format=link'); ?>
    <?php wp_head(); ?>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/nav.js"></script>
    <?php if ((is_single() || is_page()) && comments_open()): ?>
    <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/comments.js"></script>
    <?php endif; ?>
  </head>
  <body>
    <div id="container">
      <div id="header">
        <h1><a href="<?php bloginfo('url'); ?>/"><?php if (get_option('logo_url')): ?><img src="<?php echo get_option('logo_url'); ?>" alt="<?php bloginfo('name'); ?>" /><?php else: bloginfo('name'); endif; ?></a></h1>
        <h2 id="header-description"><?php bloginfo('description'); ?></h2>
        <div id="nav">
          <?php w3_list_menus(); ?>
          <div class="clear"></div>
        </div>
        <div id="guide">
          <ul>
            <?php if ($user_ID): ?>
            <li><?php printf(__('Hello, %s!', 'meditation'), '<a href="'. site_url('/wp-admin/profile.php', 'login') .'" class="profile" title="'. __('Hotkeys') . '(Ctrl + Shift + Alt + P)">'. $user_identity .'</a>'); ?></li>
            <?php endif; ?>

            <?php if ($custom_header = get_option('custom_header')): ?>
            <li class="custom"><?php echo $custom_header; ?></li>
            <?php endif; ?>

            <li class="login" title="<?php _e('Hotkeys'); ?>(Ctrl + Shift + Alt + L)"><?php wp_loginout(w3_url()); ?></li>

            <?php if (current_user_can('publish_posts')): ?>
            <li class="new-post" title="<?php _e('Hotkeys'); ?>(Ctrl + Shift + Alt + N)"><a href="<?php echo site_url('wp-admin/post-new.php', 'admin'); ?>"><?php _e('New Post'); ?></a></li>
            <?php endif; ?>

            <?php if ($user_ID): ?>
            <li class="admin" title="<?php _e('Hotkeys'); ?>(Ctrl + Shift + Alt + A)"><a href="<?php echo admin_url(); ?>"><?php _e('Site Admin'); ?></a></li>
            <?php elseif(get_option('users_can_register')): ?>
            <li class="register" title="<?php _e('Hotkeys'); ?>(Ctrl + Shift + Alt + R)"><a href="<?php echo site_url('wp-login.php?action=register&amp;redirect_to='.urlencode(w3_url()), 'login'); ?>"><?php _e('Register'); ?></a></li>
            <?php endif; ?>

            <li class="feed" title="<?php _e('Hotkeys'); ?>(Ctrl + Shift + Alt + F)"><a href="<?php bloginfo($feed_type . '_url'); ?>"><?php _e('Subscribe', 'meditation'); ?></a></li>
          </ul>
        </div>
      </div>

      <div id="content"<?php if (($layout = get_option('theme_layout'))) echo ' class="' . $layout . '"'; ?>>
        <?php get_sidebar(); ?>
        <div id="maincontent">
          <div id="maincontent-inner">
            <?php w3_breadcrumb(); ?>
            <?php if (function_exists('dynamic_sidebar')) dynamic_sidebar('Before Content'); ?>

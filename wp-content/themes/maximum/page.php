<?php get_header();?>
<div id="main">
<div id="main-container">
<?php  if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>
<?php if(have_posts()):?><?php while(have_posts()):the_post();?>
<div class="post-title"><a href="<?php the_permalink()?>"><?php the_title();?> </a></div><!--post-title-->
<div class="post-content">
<?php the_content();?>
</div><!--post-content-->
<?php endwhile;?>
<?php posts_nav_link();?>
<?php endif;?>
</div><!--main-container-->
<?php get_sidebar();?>
<?php include ('r_sidebar.php');?>
</div><!--main-->
<?php get_footer();?>
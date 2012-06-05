<?php get_header();?>
<div id="main">
<div id="main-container">
<?php  if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>
<?php if(have_posts()):?><?php while(have_posts()):the_post();?>

<div class="post-title"><a href="<?php the_permalink()?>"><?php the_title();?> </a>

<span class="post-date"><strong class="month"><?php the_time('M'); ?></strong> <strong class="day"><?php the_time('d'); ?></strong></span>

</div><!--post-title-->
<div class="post-content">
<?php the_content();?>
</div><!--post-content-->
<div class="post-meta">
Under: <?php the_category(', ')?>  <?php the_tags();?>  &nbsp; <?php edit_post_link(  ); ?> 
</div><!--post-meta-->


<?php comments_template( '', true ); ?>


<?php endwhile;?>
<?php endif;?>
</div><!--main-container-->
<?php get_sidebar();?>
<?php include ('r_sidebar.php');?>
</div><!--main-->
<?php get_footer();?>
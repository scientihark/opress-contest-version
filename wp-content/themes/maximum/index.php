<?php get_header();?>
<div id="main">
<div id="main-container">
<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs();?>
<?php if (is_home() && !is_paged()){?>
<div id="crumbs" class="">Welcome to <?php bloginfo('name');?></div>
<?php } ?>


<?php if(have_posts()):?><?php while(have_posts()):the_post();?>
<?php if( $post->ID == $do_not_duplicate ) continue; // do not duplicate feature post ?>



<div class="post-title"><a href="<?php the_permalink()?>"><?php the_title();?> </a>

<span class="post-date"><strong class="month"><?php the_time('M'); ?></strong> <strong class="day"><?php the_time('d'); ?></strong></span>

</div><!--post-title-->
<div class="post-content">
<?php the_content();?>
</div><!--post-content-->
<div class="post-meta">
Under: <?php the_category(', ')?>  <?php the_tags();?>
</div><!--post-meta-->
<?php endwhile;?>

<?php posts_nav_link(' ', '&laquo; Newer Posts', 'Older Posts &raquo;'); ?>



<?php endif;?>
</div><!--main-container-->
<?php get_sidebar();?>
<?php include ('r_sidebar.php');?>
</div><!--main-->
<?php get_footer();?>
<?php get_header(); ?>

<div id="content">

  <div id="wrap">
    <div id="contentleft">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <h1><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
	  <p>Posted on <?php the_time('F j, Y'); ?><br />Filed Under <?php the_category(', ') ?> | <?php comments_popup_link('Leave a Comment', '1 Comment', '% Comments'); ?></p>  
	  <?php the_content(__('Read more'));?>
	  <div style="clear:both;"></div>
 			  
	<!--
	<?php trackback_rdf(); ?>
	-->
      
      <h1>Comments</h1>
	  <?php comments_template(); // Get wp-comments.php template ?>
      
      <?php endwhile; else: ?>
      
      <p><?php _e('Sorry, no posts matched your criteria.'); ?></p><?php endif; ?>
      </div>
    <?php include(TEMPLATEPATH."/l_sidebar.php");?>
    
    <?php include(TEMPLATEPATH."/r_sidebar.php");?>
  </div>
</div>

<!-- The main column ends  -->

<?php get_footer(); ?>
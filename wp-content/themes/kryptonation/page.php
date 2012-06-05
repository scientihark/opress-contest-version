<?php
/*
Template Name: Default Page
*/
?>
<?php get_header(); ?>

<div id="content" class="content-singular content-page">
	<div class="pad">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<?php 
	if (function_exists('bcn_display')) { 
		echo '<p class="breadcrumb">';
		bcn_display(); 
		echo '</p>';
	} 
?>		
<?php while (have_posts()) : ?>
	<?php the_post(); ?>

<div class="title">
	<h1><?php the_title(); ?></h1>	
</div>		
<div class="content">
	<?php the_content(); ?>
</div>

<?php endwhile; ?>

		</div>
	</div>
</div>

<?php get_sidebar(); ?>

<div class="clear"></div>

<?php get_footer(); ?>
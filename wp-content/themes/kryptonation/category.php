<?php
/*
Template Name: Category
*/
?>
<?php get_header(); ?>

<div id="content" class="content-group content-category">
	<div class="pad">
		<div class="post-group">
			<div class="content-title">
				<h1 class="title">Posts Under <?php single_cat_title(); ?> Category</h1>
			</div>
			<?php rewind_posts(); ?>		
			<?php get_template_part('loop','category'); ?>
		</div>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
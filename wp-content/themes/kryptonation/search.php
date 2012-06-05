<?php
/*
Template Name: Search Result
*/
?>
<?php get_header(); ?>

<div id="content" class="content-group content-search">
	<div class="pad">
		<div class="post-group">
			<div class="content-title">
				<h1>Search Results for: <?php echo get_search_query(); ?></h1>	
			</div>
			<?php get_template_part('loop','search'); ?>
		</div>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
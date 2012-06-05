<?php
/*
Template Name: Single Post
*/
?>
<?php get_header(); ?>

<div id="padd-content">
	<div id="padd-content-wrapper">
	
<?php if (have_posts()) : ?>

<div class="padd-post-group padd-post-group-single">
	<div class="padd-post-list padd-post-list-single">
	<?php while (have_posts()) : ?>
		<?php the_post(); ?>
		<div class="padd-post-item padd-post-item-single" id="post-<?php the_ID(); ?>">
			<div class="padd-post-item-title">
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
			</div>
			<div class="padd-post-item-entry">
				<?php the_content(); ?>
				<?php wp_link_pages(array('before' => '<p class="pages"><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
			</div>
		</div>
	<?php endwhile; ?>
	</div>
</div>

<?php else : ?>	

<div class="padd-post-group padd-post-group-result padd-post-group-error">
	<div class="padd-post-group-title">
		<h2>Not Found</h2>
	</div>
	<div class="padd-post-group-descr">
		<p>Sorry, but you are looking for a category that isn't here.</p>
	</div>
</div>

<?php endif; ?>

	</div>
</div>

<?php get_sidebar(); ?>

<div class="padd-clear"></div>

<?php get_footer(); ?>

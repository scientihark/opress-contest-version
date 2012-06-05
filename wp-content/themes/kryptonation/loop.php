

<?php if (!have_posts()) : ?>

<div id="post-0" class="hentry post error404 not-found">
	<div class="title">
		<h2>Not Found</h2>
	</div>
	<div class="content">
		<p>Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.</p>
	</div>
</div>

<?php else : ?>
	<?php 
		$tag = 'h2'; 
		add_filter('excerpt_length', 'padd_theme_hook_excerpt_index_length'); 
		$i = '1';
	?>
	<?php while (have_posts()) : ?>
		<?php the_post(); ?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('append-clear hentry-' . $i); ?>>
			<div class="title">
				<<?php echo $tag;?>><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></<?php echo $tag; ?>>
			</div>
			<div class="thumbnail">
				<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
					<?php
						$padd_image_def = get_template_directory_uri() . '/images/thumbnail.jpg';
						if (has_post_thumbnail()) {
							the_post_thumbnail(PADD_THEME_SLUG . '-thumbnail');
						} else {
							echo '<img class="image-thumbnail" alt="Default thumbnail." src="' . $padd_image_def . '" />';
						}
					?>
				</a>
			</div>
			<?php if ('post' == get_post_type()) : ?>
			<div class="meta">
				<p>
					<span class="date"><?php the_time(get_option('date_format')); ?></span> - 
					<span class="author">Posted by <?php the_author_link(); ?></span> -
					<span class="comments"><a href="<?php comments_link(); ?> "><?php echo comments_number('no comments', '1 comment', '% comments'); ?></a></span>
				</p>
			</div>
			<?php endif; ?>
			<div class="excerpt">
				<?php the_excerpt();?>
			</div>
			
		</div>
		<?php $i = ($i == '1') ? '2' : '1'; ?>
	<?php endwhile; ?>
	<?php
		remove_filter('excerpt_length', 'padd_theme_hook_excerpt_index_length'); 
	?>

	<?php Padd_PageNavigation::render(); ?>

<?php endif; ?>









	
	

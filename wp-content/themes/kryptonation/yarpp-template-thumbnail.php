<?php /*
Example template for use with post thumbnails
Requires WordPress 2.9 and a theme which supports post thumbnails
Author: mitcho (Michael Yoshitaka Erlewine)
*/ ?>
<?php if ($related_query->have_posts()):?>
<ol>
	<?php $padd_image_def = get_template_directory_uri() . '/images/thumbnail-related-posts.jpg'; ?>
	<?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
	<li>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
			<?php 
				$exclude[] = get_the_ID();
				if (has_post_thumbnail()) {
					the_post_thumbnail(PADD_THEME_SLUG . '-related-posts', array('title' => get_the_excerpt()));
				} else {
					echo '<img class="thumbnail" title="' . get_the_title() . '" src="' . $padd_image_def . '" />';
				}
			?>
		</a>
		<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</li>
	<?php endwhile; ?>
</ol>
<?php else: ?>
<p>No related posts.</p>
<?php endif; ?>

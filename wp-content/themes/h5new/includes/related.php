<div class="relatedposts">
	<?php
	$backup = $post; 
	$tags = wp_get_post_tags($post->ID);
	$tagIDs = array();
	if ($tags) {
		echo '<h3>您可能还会对这些文章感兴趣！</h3>';
		echo '<ol>';
		$tagcount = count($tags);
		for ($i = 0; $i < $tagcount; $i++) {
			$tagIDs[$i] = $tags[$i]->term_id;
		}
		$args=array(
			'tag__in' => $tagIDs,
			'post__not_in' => array($post->ID),
			'showposts'=>16,
			'caller_get_posts'=>1
		);
		$my_query = new WP_Query($args);
		if( $my_query->have_posts() ) {
			while ($my_query->have_posts()) : $my_query->the_post(); ?>
			<li><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title(); ?>"><?php echo cut_str($post->post_title,46); ?><?php comments_number(' ','(1)','(%)'); ?></a></li>
			<?php endwhile;
				echo '</ol>';
		} else { ?>
		<!-- 没有相关文章显示随机文章 -->
	<ol>
		<?php
		query_posts(array('orderby' => 'rand', 'showposts' => 16, 'caller_get_posts' => 4));
		if (have_posts()) :
		while (have_posts()) : the_post();?>
		<li><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php echo cut_str($post->post_title,46); ?><?php comments_number(' ','(1)','(%)'); ?></a></li>
		<?php endwhile;endif; ?>
	</ol>
	<?php }
	}
	$post = $backup;
	wp_reset_query();
	?>
</div>
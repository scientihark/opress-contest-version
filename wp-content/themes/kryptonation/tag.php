<?php
/*
Template Name: Tag
*/
?>
<?php get_header(); ?>

<div id="content" class="content-group content-tag">
	<div class="pad">
		<div class="post-group">
			<div class="content-title">
				<h1>Posts Tagged &#8216;<?php single_tag_title(); ?>&#8217;</h1>
			</div>
			<?php rewind_posts(); ?>		
			<?php get_template_part('loop','tag'); ?>
		</div>
	</div>
</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>

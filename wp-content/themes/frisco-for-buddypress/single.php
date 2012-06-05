<?php get_header() ?>

	<div id="content">
		<div class="padder">

			<?php do_action( 'bp_before_blog_single_post' ) ?>

			<div class="page" id="blog-single" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<div class="post-content">
						<div class="entry">
							<?php the_content( __( 'Read the rest of this entry &rarr;', 'buddypress' ) ); ?>
						</div>
					</div>

				</div>


			<?php endwhile; else: ?>

				<p><?php _e( 'Sorry, no posts matched your criteria.', 'buddypress' ) ?></p>

			<?php endif; ?>

		</div>

		<?php do_action( 'bp_after_blog_single_post' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar() ?>

<?php get_footer() ?>

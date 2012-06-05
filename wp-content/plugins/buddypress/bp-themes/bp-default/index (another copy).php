<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_blog_home' ) ?>

		<?php do_action( 'template_notices' ) ?>

		
		</div>

		<?php do_action( 'bp_after_blog_home' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar() ?>

<?php get_footer() ?>

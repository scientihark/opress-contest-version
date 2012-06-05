<?php get_header() ?>

	<div id="content">
		<div class="padder">

		<?php do_action( 'bp_before_blog_page' ) ?>

		<div class="page" id="blog-page" role="main">

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<h2 class="pagetitle"><?php the_title(); ?></h2>

				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

					<div class="entry">

						<?php the_content( __( '<p class="serif">Read the rest of this page &rarr;</p>', 'buddypress' ) ); ?>

						<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buddypress' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
						<?php edit_post_link( __( 'Edit this page.', 'buddypress' ), '<p class="edit-link">', '</p>'); ?>

					</div>

				</div>
<!-- JiaThis Button BEGIN -->
<div id="jiathis_style_32x32">
<a class="jiathis_button_qzone"></a>
<a class="jiathis_button_renren"></a>
<a class="jiathis_button_email"></a>
<a class="jiathis_button_fav"></a>
<a class="jiathis_button_kaixin001"></a>
<a class="jiathis_button_douban"></a>
<a class="jiathis_button_fb"></a>
<a class="jiathis_button_google"></a>
<a class="jiathis_button_xianguo"></a>
<a class="jiathis_button_fanfou"></a>
<a class="jiathis_button_gmail"></a>
<a class="jiathis_button_sina"></a>
<a class="jiathis_button_feixin"></a>
<a class="jiathis_button_xiaoyou"></a>
<a class="jiathis_button_print"></a>
<a class="jiathis_button_copy"></a>
<a class="jiathis_button_twitter"></a>
<a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
<a class="jiathis_counter_style"></a>
</div>
<script type="text/javascript" >
var jiathis_config={
	siteNum:14,
	sm:"copy,qzone,tsina,tqq,renren,kaixin001,douban,t163,fb,fanfou,xianguo,gmail,googleplus",
	summary:"",
	boldNum:6,
	hideMore:false
}
</script>
<script type="text/javascript" src="http://v2.jiathis.com/code/jia.js" charset="utf-8"></script>
<!-- JiaThis Button END -->  

			<?php endwhile; endif; ?>

		</div><!-- .page -->

		<?php do_action( 'bp_after_blog_page' ) ?>

		</div><!-- .padder -->
	</div><!-- #content -->

	<?php get_sidebar() ?>

<?php get_footer(); ?>

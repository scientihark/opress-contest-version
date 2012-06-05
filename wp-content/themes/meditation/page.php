<?php get_header(); ?>
<?php if (have_posts()): the_post(); ?>
            <div id="post-<?php the_ID(); ?>" class="post page">
              <h2 class="storytitle"><?php the_title(); ?></h2>
              <p class="meta">
                <?php if (comments_open()): ?>
                <?php comments_popup_link(__('No Comments'), __('1 Comment'), __('% Comments')); ?>
                | <a href="<?php echo get_post_comments_feed_link(); ?>"><?php _e('Comments Feed'); ?></a>
                <?php if (pings_open()): ?>
                | <a href="<?php trackback_url() ?>"><?php _e('Trackback'); ?></a>
                <?php endif; ?>
                <?php edit_post_link(__('Edit'), '| '); ?>
                <?php else: ?>
                <?php edit_post_link(__('Edit')); ?>
                <?php endif; ?>
              </p>
              <div class="storycontent">
                <?php the_content(); ?>
              </div>
              <br />
              <div class="clear"></div>
              <?php wp_link_pages(array('before' => '<div class="linkpages">', 'after' => '</div>', 'next_or_number' => 'number')); ?>
              <div class="zoom">
                <?php _e('Font:', 'meditation'); ?>
                <a href="#" class="font-large" title="<?php _e('Zoom in font', 'meditation'); ?>"><?php _e('Large', 'meditation'); ?></a> &nbsp;
                <a href="#" class="font-normal" title="<?php _e('Normal font size', 'meditation'); ?>"><?php _e('Normal', 'meditation'); ?></a> &nbsp;
                <a href="#" class="font-small" title="<?php _e('Zoom out font', 'meditation'); ?>"><?php _e('Small', 'meditation'); ?></a>
              </div>
            </div>
<?php
if (comments_open()) {
    comments_template();
}
?>
<?php endif; ?>
<?php get_footer(); ?>

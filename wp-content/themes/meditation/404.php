<?php get_header(); ?>
            <?php if (($ID = get_option('page404'))): $page = get_page($ID); ?>
            <h2 class="storytitle center"><?php echo $page->post_title; ?></h2>
            <div class="storycontent">
              <?php echo $page->post_content; ?>
            </div>
            <?php else: ?>
            <h2 class="center"><?php _e('Page not found'); ?></h2>
            <br />
            <div class="center"><?php get_search_form(); ?></div>
            <br />
            <?php endif; ?>
<?php get_footer(); ?>
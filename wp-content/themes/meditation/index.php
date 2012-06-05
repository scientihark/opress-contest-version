<?php get_header(); ?>
<?php if (have_posts()): $index_meta = get_option('index_meta'); ?>
<?php while (have_posts()): the_post(); ?>
            <div id="post-<?php the_ID(); ?>" class="post">
              <div class="storytitle">
                <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                <div class="meta">
                <?php
                if ($index_meta == 1) {
                    the_tags('', ' &bull; ');
                } elseif ($index_meta == 2) {
                    the_time(get_option('date_format'));
                } elseif ($index_meta == 3) {
                    the_author();
                } else {
                    the_category(' &bull; ');
                }
                ?>
                <?php edit_post_link(__('Edit'), '| '); ?>
                </div>
              </div>
              <div class="storycontent">
                <?php
                if (!empty($post->post_excerpt)) {
                  the_excerpt();
                } else {
                  the_content(__('More...'));
                }
                ?>
              </div>
            </div>
<?php endwhile; ?>
<?php w3_paginate_pages(); ?>
<?php else: ?>
            <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>
<?php get_footer(); ?>

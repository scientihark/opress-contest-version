            <?php if (function_exists('dynamic_sidebar')) dynamic_sidebar('After Content'); ?>
          </div>
        </div>
        <div class="clear"></div>
      </div>

      <div id="footer">
        <?php if (function_exists('wp_nav_menu')): ?>
        <?php wp_nav_menu(array('sort_column' => 'menu_order', 'container_class' => 'pages', 'menu_class' => 'pages', 'theme_location' => 'secondary')); ?>
        <?php else: ?>
        <div class="pages">
          <ul>
            <li><a href="<?php bloginfo('url'); ?>/"><?php bloginfo('name'); ?></a></li>
            <?php wp_list_pages('title_li=&depth=1'); ?>
          </ul>
        </div>
        <?php endif; ?>
        &nbsp;
        <?php if (($custom_footer = get_option('custom_footer'))) echo $custom_footer; ?>
        <div class="powered">
          Powered by <a href="http://wordpress.org/">WordPress</a> &nbsp; Designed by <a href="http://www.w3theme.com/">w3Theme</a>
        </div>
      </div>
    </div>
    <?php wp_footer(); ?>
  </body>
</html>
<!-- <?php printf(__('%d queries. %s seconds.'), get_num_queries(), timer_stop()); ?> -->
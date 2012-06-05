        <?php $layout = get_option('theme_layout'); ?>
        <?php if ($layout == 'layout-tw' || $layout == 'layout-wt'): ?>
        <?php $sidebar = ($layout == 'layout-tw') ? 'leftbar' : 'rightbar'; ?>
        <ul id="<?php echo $sidebar; ?>" class="sidebar">
          <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(ucfirst($sidebar))): ?>

          <li>
            <h3><?php _e('Archives'); ?></h3>
            <ul>
            <?php wp_get_archives(); ?>
            </ul>
          </li>
          <li>
            <h3><?php _e('Recent Posts'); ?></h3>
            <?php w3_recent_posts(); ?>
          </li>
          <li>
            <h3><?php _e('Recent Comments'); ?></h3>
            <?php w3_recent_comments(); ?>
          </li>
          <?php wp_list_bookmarks(); ?>
          <?php endif; ?>
        </ul>
        <?php else: ?>
        <?php
        $leftbar = 'leftbar';
        $rightbar = 'rightbar';
        if (get_bloginfo('text_direction') == 'rtl') {
            $leftbar = 'rightbar';
            $rightbar = 'leftbar';
        }
        ?>
        <ul id="<?php echo $leftbar; ?>" class="sidebar">
          <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(ucfirst($leftbar))): ?>

          <li>
            <h3><?php _e('Archives'); ?></h3>
            <ul>
            <?php wp_get_archives(); ?>
            </ul>
          </li>
          <?php wp_list_bookmarks(); ?>
          <?php endif; ?>
        </ul>
 
        <ul id="<?php echo $rightbar; ?>" class="sidebar">
          <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar(ucfirst($rightbar))): ?>

          <li>
            <h3><?php _e('Recent Posts'); ?></h3>
            <?php w3_recent_posts(); ?>
          </li>
          <li>
            <h3><?php _e('Recent Comments'); ?></h3>
            <?php w3_recent_comments(); ?>
          </li>
          <?php endif; ?>
        </ul>
        <?php endif; ?>

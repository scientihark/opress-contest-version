<?php
/**
 * Theme meditation
 * Copyright (C) 2010 Joe Dotoff
 *
 * @author  w3Theme Studio
 * @link    http://www.w3theme.com/
 * @version 1.0
 * @license W3THEME LICENSE
 */

if (function_exists('automatic_feed_links')) {
    automatic_feed_links();
}

// Register sidebars
register_sidebar(array(
    'name' => 'Leftbar',
    'before_widget' => '<li class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></li>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
));
register_sidebar(array(
    'name' => 'Rightbar',
    'before_widget' => '<li class="widget %2$s"><div class="widget-inner">',
    'after_widget' => '</div></li>',
    'before_title' => '<h3>',
    'after_title' => '</h3>',
));
register_sidebar(array(
    'name' => 'Before Content',
    'before_widget' => '<div class="widget widget-top %2$s">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
));
register_sidebar(array(
    'name' => 'After Content',
    'before_widget' => '<div class="widget widget-bottom %2$s">',
    'after_widget' => '</div>',
    'before_title' => '',
    'after_title' => '',
));

// Register widgets
wp_register_sidebar_widget(
    'w3_recent_comments',
    __('Recent Comments'),
    'w3_recent_comments',
    array('description' => __('The most recent comments') . ' (Theme meditation)')
);

// Register menus
if (function_exists('register_nav_menus')) {
    register_nav_menus(array(
        'primary' => __('Primary links'),
        'secondary' => __('Secondary links'),
    ));
}

// Use secure login
if (get_option('secure_login')) {
    force_ssl_login(TRUE);
    force_ssl_admin(TRUE);
}

// Init theme
load_theme_textdomain('meditation', get_template_directory() . '/languages');
add_action('admin_menu', 'w3_theme_options');
add_action('wp_head', 'w3_meta_seo');
add_action('wp_footer', 'w3_footer');

/**
 * List categories as menus
 *
 * @return void
 */
function w3_list_menus()
{
    if (function_exists('wp_nav_menu')) {
        wp_nav_menu(array('sort_column' => 'menu_order', 'theme_location' => 'primary'));
    } else {
?>
<ul><li<?php if (is_home()) echo ' class="current-cat"'; ?>><a href="<?php bloginfo('url'); ?>/" title="<?php _e('Home'); ?>"><?php _e('Home'); ?></a></li>
<?php
        $args = array(
            'orderby' => 'ID', 'order' => 'ASC', 'show_last_update' => 0,
            'style' => 'list', 'show_count' => 0,
            'hide_empty' => 1, 'use_desc_for_title' => 1,
            'child_of' => 0, 'feed' => '', 'feed_type' => '',
            'feed_image' => '', 'exclude' => '', 'exclude_tree' => '', 'current_category' => 0,
        );
        if (is_category()) {
            global $cat;
            $args['current_category'] = $cat;
        }
        $r = wp_parse_args($args);
        extract($r);
        $categories = get_categories($r);
        $output = '';
        if (!empty($categories)) {
            $output .= walk_category_tree($categories, 0, $r);
        }
        echo $output . '</ul>';
    }
}

/**
 * Use categories as breadcrumb
 *
 * @param string $separator  Separator between the categories
 * @param string $separator2 Separator between the category level
 * @return void
 */
function w3_breadcrumb($separator = ' &bull; ', $separator2 = ' &raquo; ')
{
    if (is_home() || is_front_page()) {
        return;
    }
    echo '<div class="breadcrumb">';
    echo '<a href="'. get_bloginfo('url') .'/">'. __('Home') .'</a>' . $separator2;
    if (is_single() || is_category()) {
        $tree = array();
        if (is_single()) {
            $categories = get_the_category();
            foreach ($categories as $category) {
                w3_walk_category($tree, $category);
            }
        } else {
            global $cat;
            $category = get_category($cat);
            w3_walk_category($tree, $category);
        }
        $len = sizeof($tree);
        for ($i = 0; $i < $len; ++$i) {
            $j = 0;
            $count = sizeof($tree[$i]);
            foreach ($tree[$i] as $category) {
                if (is_category() && $i == $len - 1) {
                    echo $category->cat_name;
                } else {
                    echo '<a href="' . get_category_link($category->term_id) . '">' . $category->cat_name . '</a>';
                }
                if ($j < $count - 1) {
                    echo $separator;
                }
                ++$j;
            }
            if ($i < $len - 1) {
                echo $separator2;
            }
        }
    } else {
        if (is_tag()) {
            echo __('Tags') . $separator2;
        } elseif (is_archive()) {
            echo __('Archives') . $separator2;
        }
        if (is_404()) {
            $title = __('Error ');
        } else {
            $title = preg_replace('/\s*[|-]\s*$/', '', wp_title('', FALSE));
        }
        echo $title;
    }
    echo '</div>';
}

/**
 * Walk parent categories
 *
 * @param array $tree  The category tree
 * @param object $category  The current category
 * @param int $level  The tree level
 * @return int
 */
function w3_walk_category(&$tree, $category, $level = 0)
{
    if ($category->parent != 0 && $category->parent != $category->term_id) {
        $parent = get_category($category->parent);
        $newlevel = w3_walk_category($tree, $parent, ++$level);
        $tree[$newlevel][$category->cat_ID] = $category;
    } else {
        $tree[0][$category->cat_ID] = $category;
    }

    return $level;
}

/**
 * List recent posts
 *
 * @return void
 */
function w3_recent_posts()
{
    global $wpdb;
    $s = wp_cache_get('w3_recent_posts');
    if (FALSE === $s) {
        $limit = get_option('recent_posts_num');
        if (!$limit) {
            $limit = 10;
        }
        $posts = get_posts(array('numberposts' => $limit, 'orderby' => 'post_date_gmt'));
        $s = '';
        if (sizeof($posts) > 0) {
            $s .= '<ul>';
            foreach ($posts as $post) {
                $s .= '<li><a href="' . get_permalink($post) .'" title="'. esc_attr($post->post_title) .'">' . $post->post_title . '</a></li>';
            }
            $s .= '</ul>';
        }
        wp_cache_set('w3_recent_posts', $s);
    }
    echo $s;
}

/**
 * List recent comments
 *
 * @param array $args  The widget options
 * @return void
 */
function w3_recent_comments($args = NULL)
{
    global $wpdb;
    $s = wp_cache_get('w3_recent_comments');
    if (FALSE === $s) {
        $limit = get_option('recent_comments_num');
        if (!$limit) {
            $limit = 10;
        }
        $sql = "SELECT $wpdb->comments.*,$wpdb->posts.post_title FROM $wpdb->comments INNER JOIN $wpdb->posts ON $wpdb->comments.comment_post_ID = $wpdb->posts.ID WHERE $wpdb->comments.comment_approved=1 AND $wpdb->posts.post_status='publish' ORDER BY $wpdb->comments.comment_date_gmt DESC LIMIT $limit";
        $comments = $wpdb->get_results($sql);
        if (sizeof($comments) > 0) {
            $s .= '<ul>';
            foreach ($comments as $comment) {
                $s .= '<li><a href="'. get_permalink($comment->comment_post_ID) .'#comments" title="'. esc_attr(sprintf(__('Comment on %1$s by %2$s'), $comment->post_title, $comment->comment_author)) .'">'. w3_html_substr($comment->comment_content, 30) .'</a></li>';
            }
            $s .= '</ul>';
        }
        wp_cache_set('w3_recent_comments', $s);
    }
    if (is_array($args)) {
        echo $args['before_widget'];
        echo $args['before_title'] . $args['widget_name'] . $args['after_title'];
    }
    echo $s;
    if (is_array($args)) {
        echo $args['after_widget'];
    }
}

/**
 * Post panigate
 *
 * @return void
 */
function w3_paginate_pages()
{
    $page = get_query_var('paged');
    if (!$page) {
        $page = 1;
    }
    $per_page = get_query_var('posts_per_page');
    $total = ceil(w3_count_pages() / $per_page);
    if ($total > 1) {
        $start = ($page - 4 > 0) ? ($page - 4) : 1;
        $end = ($start + 9 < $total) ? ($start + 9) : $total;
        echo '<div class="paginate">';
        for ($i = $start; $i <= $end; $i++) {
            if ($page == $i) {
                echo '<span>' . $i . '</span> ';
            } else {
                printf('<a href="%s" title="'. __('Page') . ' %d">%d</a> ', esc_attr(get_pagenum_link($i)), $i, $i);
            }
        }
        echo '</div>';
    }
}

/**
 * Comment paginate
 *
 * @param strin $args  The anchor string of comments
 * @return void
 */
function w3_paginate_comments($args = '')
{
    $page = get_query_var('cpage');
    $per_page = get_query_var('comments_per_page');
    $total = ceil(get_comments_number() / $per_page);
    if ($total > 1) {
        $start = ($page - 4 > 0) ? ($page - 4) : 1;
        $end = ($start + 9 < $total) ? ($start + 9) : $total;
        echo '<div class="paginate">';
        for ($i = $start ; $i <= $end; $i++) {
            if ($page == $i) {
                echo '<span>' . $i . '</span> ';
            } else {
                printf('<a href="%s" title="'. __('Page') .' %d">%d</a> ', w3_get_comment_link(null, array('page' => $i, 'per_page' => $per_page)) . $args, $i, $i);
            }
        }
        echo '</div>';
    }
}

/**
 * Count total pages of posts
 *
 * @return int
 */
function w3_count_pages()
{
    global $wpdb, $wp_query;
    $count = wp_cache_get('num_posts');
    if (!empty($count)) {
        return $count;
    }
    $where = '';
    $arr = preg_split('/ FROM /i', $wp_query->request, 2);
    if (sizeof($arr) == 2) {
        $where = preg_replace('/ ORDER BY .*/', '', $arr[1]);
        $where = preg_replace('/ LIMIT .*/', '', $where);
        if (preg_match('/ JOIN /i', $where)) {
            $where = " WHERE ID IN (SELECT {$wpdb->posts}.ID FROM {$where})";
        } else {
            $where = " WHERE " . preg_replace('/.* WHERE /i', '', $where);
        }
    }
    $query = "SELECT COUNT(*) AS total FROM {$wpdb->posts}" . $where;
    $rs = $wpdb->get_results($query);
    if (!empty($rs)) {
        wp_cache_set('num_posts', $rs[0]->total);
        return $rs[0]->total;
    }

    return 0;
}

/**
 * Get the comment link
 *
 * @param int $id  The comment id
 * @param array $arg  The argument options
 * @return string
 */
function w3_get_comment_link($id = null, $arg = array())
{
    $link = get_comment_link($id, $arg);
    $link = preg_replace('/#.*/', '', $link);

    return esc_attr($link);
}

/**
 * Get current URL
 *
 * @return string
 */
function w3_url()
{
    static $url;
    if (!isset($url)) {
        $url = is_ssl() ? 'https://' : 'http://';
        $url .= $_SERVER['HTTP_HOST'];
        if ((is_ssl() && $_SERVER['SERVER_PORT'] != 443) || (!is_ssl() && $_SERVER['SERVER_PORT'] != 80)) {
            $url .= ':' . $_SERVER['SERVER_PORT'];
        }
        $url .= $_SERVER['REQUEST_URI'];
    }

    return $url;
}

/**
 * Meta tags for SEO (keywords and description) 
 *
 * @return void
 */
function w3_meta_seo()
{
    if (is_home()) {
        $keywords = get_option('meta_keywords');
        $description = get_option('meta_description');
        if (empty($description)) {
            $description = get_bloginfo('description');
        }
    } elseif (is_single()) {
        global $post;
        $tags = wp_get_post_tags($post->ID);
        if (!empty($tags)) {
            $keywords = '';
            foreach ($tags as $tag) {
                $keywords .= $tag->name . ',';
            }
            $keywords = substr($keywords, 0, -1);
        }
        $description = !empty($post->post_excerpt)? $post->post_excerpt : w3_html_substr($post->post_content, 200);
    }
    if (!empty($keywords)) {
        echo '<meta name="keywords" content="'. esc_attr($keywords) .'" />' . "\n";
    }
    if (!empty($description)) {
        echo '<meta name="description" content="'. esc_attr($description) .'" />' . "\n";
    }
    $author = get_option('meta_author');
    $copyright = get_option('meta_copyright');
    if (!empty($author)) {
        echo '<meta name="author" content="'. esc_attr($author) .'" />' . "\n";
    }
    if (!empty($copyright)) {
        echo '<meta name="copyright" content="'. esc_attr($copyright) .'" />' . "\n";
    }
}

/**
 * Stripe html tags in the string and cut
 *
 * @param string $str  The string to cut
 * @param int $count  The length to cut
 * @return string
 */
function w3_html_substr($str, $count)
{
    $str = trim($str);
    $len = strlen($str);
    $substr = wp_html_excerpt($str, $count);
    if ($len > $count and strlen($substr) == $count) {
        $substr .= '...';
    }

    return $substr;
}

/**
 * Replace &,<,> chars
 *
 * @param string $str  The string to replace
 * @return string
 */
function w3_escape($str)
{
    return str_replace(array('&', '<', '>'), array('&amp;', '&lt;', '&gt;'), $str);
}

/**
 * Theme options
 *
 * @return void
 */
function w3_theme_options()
{
    if ($_GET['page'] == basename(__FILE__) and $_SERVER['REQUEST_METHOD'] == 'POST') {
        update_option('logo_url', $_POST['logo_url']);
        update_option('meta_keywords', stripslashes($_POST['keywords']));
        update_option('meta_description', stripslashes($_POST['description']));
        update_option('meta_author', stripslashes($_POST['author']));
        update_option('meta_copyright', stripslashes($_POST['copyright']));
        update_option('custom_header', stripslashes($_POST['custom_header']));
        update_option('custom_footer', stripslashes($_POST['custom_footer']));
        update_option('footer_code', stripslashes($_POST['footer_code']));
        update_option('theme_layout', $_POST['theme_layout']);
        update_option('page404', $_POST['page404']);
        update_option('index_meta', $_POST['index_meta']);
        update_option('feed_type', $_POST['feed_type']);
        update_option('recent_posts_num', $_POST['recent_posts_num']);
        update_option('recent_comments_num', $_POST['recent_comments_num']);
        update_option('secure_login', $_POST['secure_login']);
        wp_redirect($_SERVER['SCRIPT_NAME'] . '?page=functions.php&updated=true');
        exit();
    }
    add_theme_page(__('Theme Options'), __('Theme Options'), 'edit_themes', basename(__FILE__), 'w3_theme_page');
}

/**
 * Footer options
 *
 * @return void
 */
function w3_footer()
{
    if (($footer = get_option('footer_code'))) {
        echo $footer;
    }
}

/**
 * Display theme option page
 *
 * @return void
 */
function w3_theme_page()
{
    $url = $_SERVER['SCRIPT_NAME'] . '?page=functions.php';
    $theme_layout = get_option('theme_layout');
    $page404 = get_option('page404');
    $index_meta = get_option('index_meta');
    $feed_type = get_option('feed_type');
    $recent_posts_num = get_option('recent_posts_num');
    if (empty($recent_posts_num)) {
        $recent_posts_num = 10;
    }
    $recent_comments_num = get_option('recent_comments_num');
    if (empty($recent_comments_num)) {
        $recent_comments_num = 10;
    }
    include 'options-head.php';
    ?>
    <div class="wrap">
      <div id="icon-themes" class="icon32"><br /></div>
      <h2><?php _e('Theme Options'); ?></h2>
      <form action="<?php echo $url; ?>" method="post">
        <input type="hidden" name="action" value="update" />
        <table class="form-table">
          <tr valign="top">
            <th scope="row"><label for="logo_url"><?php _e('The logo image URL', 'meditation'); ?></label></th>
            <td><input type="text" id="logo_url" name="logo_url" value="<?php echo w3_escape(get_option('logo_url')); ?>" class="regular-text" /></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="keywords"><?php _e('Site keywords', 'meditation'); ?></label></th>
            <td><textarea id="keywords" name="keywords" rows="2" cols="50" class="regular-text code"><?php echo w3_escape(get_option('meta_keywords')); ?></textarea></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="description"><?php _e('Site description', 'meditation'); ?></label></th>
            <td><textarea id="description" name="description" rows="2" cols="50" class="regular-text code"><?php echo w3_escape(get_option('meta_description')); ?></textarea></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="author"><?php _e('Display author', 'meditation'); ?></label></th>
            <td><input type="text" id="author" name="author" value="<?php echo w3_escape(get_option('meta_author')); ?>" class="regular-text" /></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="copyright"><?php _e('Display copyright', 'meditation'); ?></label></th>
            <td><input type="text" id="copyright" name="copyright" value="<?php echo w3_escape(get_option('meta_copyright')); ?>" class="regular-text" /></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="custom_header"><?php _e('Custom header text', 'meditation'); ?></label></th>
            <td><textarea id="custom_header" name="custom_header" rows="4" cols="50" class="regular-text code"><?php echo w3_escape(get_option('custom_header')); ?></textarea></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="custom_footer"><?php _e('Custom footer text', 'meditation'); ?></label></th>
            <td><textarea id="custom_footer" name="custom_footer" rows="4" cols="50" class="regular-text code"><?php echo w3_escape(get_option('custom_footer')); ?></textarea></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="footer_code"><?php _e('Footer code', 'meditation'); ?></label></th>
            <td><textarea id="footer_code" name="footer_code" rows="4" cols="50" class="regular-text code"><?php echo w3_escape(get_option('footer_code')); ?></textarea></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="theme_layout"><?php _e('Layout', 'meditation'); ?></label></th>
            <td>
              <select id="theme_layout" name="theme_layout">
                <option value="layout-twt"<?php selected($theme_layout, 'layout-twt'); ?>><?php _e('3-Columns, Thin, Wide, Thin', 'meditation'); ?></option>
                <option value="layout-wtt"<?php selected($theme_layout, 'layout-wtt'); ?>><?php _e('3-Columns, Wide, Thin, Thin', 'meditation'); ?></option>
                <option value="layout-tw"<?php selected($theme_layout, 'layout-tw'); ?>><?php _e('2-Columns, Thin, Wide', 'meditation'); ?></option>
                <option value="layout-wt"<?php selected($theme_layout, 'layout-wt'); ?>><?php _e('2-Columns, Wide, Thin', 'meditation'); ?></option>
              </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="page404"><?php _e('404 error page', 'meditation'); ?></label></th>
            <td>
              <select id="page404" name="page404">
                <option value=""<?php selected($page404, ''); ?>><?php _e('None'); ?></option>
                <?php $pages = get_pages(); foreach ($pages as $page): ?>
                <option value="<?php echo $page->ID; ?>"<?php selected($page404, $page->ID); ?>><?php echo $page->post_title; ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="index_meta"><?php _e('Show index meta item', 'meditation'); ?></label></th>
            <td>
              <select id="index_meta" name="index_meta">
                <option value="0"<?php selected($index_meta, 0); ?>><?php _e('Categories'); ?></option>
                <option value="1"<?php selected($index_meta, 1); ?>><?php _e('Tags'); ?></option>
                <option value="2"<?php selected($index_meta, 2); ?>><?php _e('Date'); ?></option>
                <option value="3"<?php selected($index_meta, 3); ?>><?php _e('Author'); ?></option>
              </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="feed_type"><?php _e('Default feed type', 'meditation'); ?></label></th>
            <td>
              <select id="feed_type" name="feed_type">
                <option value="atom"<?php selected($feed_type, 'atom'); ?>>ATOM</option>
                <option value="rdf"<?php selected($feed_type, 'rdf'); ?>>RDF</option>
                <option value="rss2"<?php selected($feed_type, 'rss2'); ?>>RSS2</option>
              </select>
            </td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="recent_posts_num"><?php _e('Number of recent posts to show', 'meditation'); ?></label></th>
            <td><input type="text" id="recent_posts_num" name="recent_posts_num" size="2" value="<?php echo $recent_posts_num; ?>" /></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="recent_comments_num"><?php _e('Number of recent comments to show', 'meditation'); ?></label></th>
            <td><input type="text" id="recent_comments_num" name="recent_comments_num" size="2" value="<?php echo $recent_comments_num; ?>" /></td>
          </tr>
          <tr valign="top">
            <th scope="row"><label for="secure_login"><?php _e('Use secure login', 'meditation'); ?></label></th>
            <td>
              <input type="checkbox" id="secure_login" name="secure_login" value="1"<?php checked(get_option('secure_login'), '1'); ?> /> <?php _e('Enable SSL', 'meditation'); ?>
              <p><?php _e('Do not check this if you are not sure, or you will be unable to login!', 'meditation'); ?></p>
              <p><a href="<?php echo str_replace('http://', 'https://', get_option('siteurl')); ?>" target="_blank"><?php _e('Click this link to check you have SSL properly installed.', 'meditation');?></a></p>
            </td>
          </tr>
        </table>
        <p class="submit">
          <input type="submit" class="button-primary" value="<?php _e('Save Changes'); ?>" ?>
        </p>
      </form>
    </div>
    <?php
}
?>
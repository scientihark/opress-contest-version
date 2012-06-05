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

if (!isset($_GET['action'])) die;

require_once '../../../wp-load.php';
require_once 'functions.php';

if ($_GET['action'] == 'get_comments') {
    if (!is_numeric($_GET['post_id'])) {
        die;
    }
    $id = $post_id = $_GET['post_id'];
    if (comments_open($post_id)) {
        $cpage = !empty($_GET['cpage']) ? ($_GET['cpage'] - 1) : 0;
        set_query_var('cpage', $cpage + 1);
        set_query_var('comments_per_page', get_option('comments_per_page'));
        $comments_per_page = get_query_var('comments_per_page');
        $commentcount = $cpage * $comments_per_page;
        $comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_post_ID = $post_id AND comment_approved=1 ORDER BY comment_ID LIMIT $comments_per_page OFFSET $commentcount");
        if ($comments) {
            $comment = $comments[0];
        }
?>
<?php w3_paginate_comments('#comments'); ?>
<ol class="commentlist">
<?php foreach ($comments as $comment): ?>
  <li id="comment-<?php comment_ID(); ?>">
    <div class="authorinfo">
      <p><?php echo get_avatar($comment, 64, '', __('Avatar')); ?></p>
      <p class="strong">
      <?php if (!empty($comment->comment_author_url)): ?>
      <a href="<?php comment_author_url(); ?>" title="<?php printf(__("Visit %s's website", 'meditation'), get_comment_author()); ?>"><?php comment_author(); ?></a>
      <?php else: ?>
      <?php comment_author(); ?>
      <? endif; ?>
      </p>
    </div>
    <div class="comment-content">
      <p class="meta">
        <span class="no"><?php echo ++$commentcount; ?>#</span>
        <em><?php comment_date(); ?> <?php comment_time(); ?></em>
        <?php if ($comment->comment_type == 'trackback' or $comment->comment_type == 'pingback'): ?>
        &nbsp;(<?php comment_type(); ?>)
        <?php endif; ?>
      </p>
      <p class="meta-action">
        <a href="#" class="comment-reply-link" title="<?php _e('Reply to this comment'); ?>"><?php _e('Reply'); ?></a> &nbsp;
        <a href="#" class="comment-quote-link" title="<?php _e('Quote this comment', 'meditation'); ?>"><?php _e('Quote'); ?></a> <?php edit_comment_link(__('Edit'), '&nbsp; '); ?>
      </p>
      <div class="comment-text">
      <?php comment_text(); ?>
      </div>
    </div>
  </li>
<?php endforeach; ?>
</ol>
<?php w3_paginate_comments('#comments'); ?>
<?php
    }
}
?>
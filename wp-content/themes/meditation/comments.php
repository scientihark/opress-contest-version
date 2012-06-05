<?php if (!empty($post->post_password) && $_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password): ?>
            <p><?php _e('Enter your password to view comments.'); ?></p>
<?php return; endif; ?>

<?php
if (comments_open()):
    $cpage = get_query_var('cpage');
    $cpage = empty($cpage) ? 0 : $cpage - 1;
    $comments_per_page = get_query_var('comments_per_page');
    $commentcount = $cpage * $comments_per_page;
    $comments = array_slice($comments, $commentcount, $comments_per_page);
?>
    <?php if ($comments): ?>
            <h3 id="comments">
              <?php _e('Comments'); ?>
              <a href="#postcomment" title="<?php _e('Leave a comment'); ?>">&raquo;</a>
            </h3>
            <div id="comments-content">
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
            </div>
            <br />
    <?php endif; ?>
 
            <h3 id="postcomment"><?php _e('Leave a comment'); ?></h3>

        <?php if (get_option('comment_registration') && !$user_ID): ?>

            <p><?php printf(__('You must be <a href="%s">logged in</a> to post a comment.'), wp_login_url(w3_url())); ?></p>
            
        <?php else: ?>

            <form id="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">

              <?php if ($user_ID): ?>

              <p><?php printf(__('Logged in as %s.'), '<a href="'.get_option('siteurl').'/wp-admin/profile.php">'.$user_identity.'</a>'); ?></p>

              <?php else: ?>

              <p><?php printf(__('<a href="%s">Log in</a> to leave a comment or comment anonymously.', 'meditation'), wp_login_url(w3_url()));?></p>
              <?php if (get_option('users_can_register')): ?>
              <p><?php printf(__('Why register? Fast post, no spam, no moderation required. <a href="%s">Register now</a>!', 'meditation'), site_url('wp-login.php?action=register&amp;redirect_to='.urlencode(w3_url()), 'login')); ?></p>
              <?php endif; ?>
              <br />
              <p><input type="text" class="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="30" /> <?php _e('Name'); ?> <?php if ($req) _e('(required)'); ?></p>
              <p><input type="text" class="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="30" /> <?php _e('E-mail');?> <?php if ($req) _e('(required)'); ?></p>
              <p><input type="text" class="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="30" /> <?php _e('Website'); ?></p>

              <?php endif; ?>

              <p><textarea name="comment" id="comment" class="comment" cols="60" rows="8" tabindex="5"></textarea></p>
              <p>
                <input type="submit" class="submit" name="submit" id="submit" value="<?php _e('Submit Comment'); ?>" />
                <input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
                <?php do_action('comment_form', $post->ID); ?>
              </p>

            </form>
            <script type="text/javascript">
            jQuery("#commentform").submit(function() {
              <?php if ($req): ?>
              if (jQuery("#author").val().trim() == '' || jQuery("#email").val().trim() == '') {
                alert('<?php _e("Error: please fill the required fields (name, email)."); ?>');
                return false;
              }
              if (!/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(jQuery("#email").val().trim())) {
                alert('<?php _e("Error: please enter a valid email address."); ?>');
                return false;
              }
              <?php endif; ?>
              if (jQuery("#comment").val().trim() == '') {
                alert('<?php _e("Error: please type a comment."); ?>');
                return false;
              }
            });
            </script>
        <?php endif; ?>

<?php else: // Comments are closed ?>
            <p><?php _e('Sorry, the comment form is closed at this time.'); ?></p>
<?php endif; ?>

<?php if ( have_comments() ) : ?>
        <?php if ( ! empty($comments_by_type['comment']) ) : ?>
        <h3 id="comments"><?php comments_number('No Responses', 'One Response', '% Responses' );?> to &#8220;<?php the_title(); ?>&#8221;</h3>

        <ol class="commentlist">
        <?php wp_list_comments('type=comment'); ?>
        </ol>
        <?php endif; ?>

        <?php if ( ! empty($comments_by_type['pings']) ) : ?>
        <h3 id="pings">Trackbacks/Pingbacks</h3>

        <ol class="pinglist">
        <?php wp_list_comments('type=pings&callback=list_pings'); ?>
        </ol>
        <?php endif; ?>

        <div class="navigation">
                <div class="alignleft"><?php previous_comments_link() ?></div>
                <div class="alignright"><?php next_comments_link() ?></div>
        </div>
  <?php else : // this is displayed if there are no comments so far ?>

	<?php if ('open' == $post->comment_status) :
		// If comments are open, but there are no comments.
	else : 
		// comments are closed 
	endif;
endif; 

if ('open' == $post-> comment_status) : 

// show the form
?>
<div id="respond"><h3><?php comment_form_title(); ?></h3>
<div id="cancel-comment-reply">
	<small><?php cancel_comment_reply_link(); ?></small>
</div>

<?php if ( get_option('comment_registration') && !$user_ID ) : ?>

<p>You must be <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?redirect_to=<?php echo urlencode(get_permalink()); ?>">logged in</a> to post a comment.</p>

<?php else : ?>
<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

<?php if ( $user_ID ) : ?>

<p>Logged in as <a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a>.
<a href="<?php echo wp_logout_url(urlencode($_SERVER['REQUEST_URI'])); ?>" title="Log out of this account">Logout &raquo;</a></p>

<?php else : ?>
<div class="comment-form-labels">Name <small><?php if ($req) echo "Required:"; ?></small></div>
<p><input type="text" name="author" id="author"  size="40" value="<?php echo $comment_author; ?>" class="comment-form-input-fields"  tabindex="1" /></p>

<div class="comment-form-labels">Email <small> <?php if ($req) echo "Required:"; ?></small></div>
<p><input type="text" name="email" id="email"  size="40" value="<?php echo $comment_author_email; ?>" class="comment-form-input-fields" tabindex="2" /> </p>

<div class="comment-form-labels">Website <small>Optional</small></div>
<p><input type="text" name="url" id="url"  size="40" value="<?php echo $comment_author_url; ?>" class="comment-form-input-fields"  tabindex="3" /></p>

<?php endif; ?>

<div>
<?php comment_id_fields(); ?>
<input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" /></div>

<div class="comment-form-labels">Comment <small>Required:</small></div>
<p><textarea name="comment" id="comment" class="comment-form-input-fields"  cols="40" rows="15" tabindex="4"></textarea></p>

<?php if (get_option("comment_moderation") == "1") { ?>
 <p><small><strong>Please note:</strong> Comment moderation is enabled and may delay your comment. There is no need to resubmit your comment.</small></p>
<?php } ?>

<p><input name="submit" type="submit" id="submit" tabindex="5" class="awesome green medium" value="Submit Comment" /></p>
<?php do_action('comment_form', $post->ID); ?>

</form>
<?php endif; ?>
</div>
<?php endif; ?>

<?php


function padd_theme_widget_socialnet() {
	$padd_sb_delicious = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_delicious'));
	$padd_sb_digg = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_digg'));
	$padd_sb_googlebuzz = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_googlebuzz'));
	$padd_sb_facebook = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_facebook'));
	$padd_sb_stumbleupon = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_stumbleupon'));
	$padd_sb_technorati = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_technorati'));
	$padd_sb_feedburner = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_feedburner'));
	$padd_sb_twitter = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_twitter'));
?>
<ul class="socialnet">
	<li class="facebook">
		<a href="<?php echo $padd_sb_facebook; ?>" class="icon-facebook" title="Facebook Profile">Be my Facebook fan</a>
	</li>
	<li class="twitter">
		<a href="<?php echo $padd_sb_twitter; ?>" class="icon-twitter" title="Twitter Page">Follow my Tweets</a>
	</li>
	<li class="rss">
		<a href="<?php echo $padd_sb_feedburner; ?>" title="RSS Feed">Subscribe via RSS</a>
	</li>
</ul>
<?php
}

/**
 * Renders the Feedburner subscription form.
 *
 * @param string $description
 */
function padd_theme_widget_feedburner($description='Get the latest updates right in your inbox.') {
	$sbfb = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_feedburner'));
?>
<p><?php echo $description; ?></p>
<form id="subscribe" action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('http://feedburner.google.com/fb/a/emailverifySubmit?uri=<?php echo $sbfb->get_username(); ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520'); return true">
	<span class="input"><input type="text" value="Enter your email address" onfocus="if (this.value == 'Enter your email address') {this.value = '';}" onblur="if (this.value == '') { this.value = 'Enter your email address'; }" name="email" /></span>
	<button type="submit"><span>Sign Up Now</span></button>
	<input type="hidden" value="<?php echo $sbfb->get_username(); ?>" name="uri"/>
	<input type="hidden" value="News Subscribe" name="title" />
</form>
<?php
}

function padd_theme_widget_subscription() {
?>
<h4><span>Subscribe to Us</span></h4>
<?php padd_theme_widget_socialnet(); ?>
<h4><span>Subscribe to Our Newsletter</span></h4>
<?php padd_theme_widget_feedburner(); ?>
<?php
}

/**
 * Renders the banner advertisement
 */
function padd_theme_widget_banner() {
	$ads = get_option(PADD_NAME_SPACE . '_ads_728090_1','');
	echo stripslashes($ads);
}

/**
 * Renders the advertisements.
 */
function padd_theme_widget_sponsors() {
	$ad = get_option(PADD_NAME_SPACE . '_ads_300250_1','');
	echo stripslashes($ad);
}

/**
 * Renders the advertisements.
 */
function padd_theme_widget_sponsors_skyscraper() {
	$ad = get_option(PADD_NAME_SPACE . '_ads_160600_1','');
	echo stripslashes($ad);
}

/**
 * Renders the featured posts in home page.
 */
function padd_theme_widget_featured_video() {
	wp_reset_query();	
	$featured = get_option(PADD_NAME_SPACE . '_video_cat_id','1');
	$count = '1';
	query_posts('showposts=' . $count . '&cat=' . $featured  .'&orderby=ID&order=DESC');
?>
<?php while (have_posts()) : the_post(); ?>
		<?php 
			$customfields = get_post_custom(); 
			$code = $customfields['_' . PADD_NAME_SPACE . '_post_thumbnail_video_ytube'][0];
		?>
		<object width="<?php echo PADD_YTUBE_W; ?>" height="<?php echo PADD_YTUBE_H; ?>">
			<param name="movie" value="http://www.youtube.com/v/<?php echo $code; ?>&amp;hl=en_US&amp;fs=1?rel=0"></param>
			<param name="allowFullScreen" value="true"></param>
			<param name="allowscriptaccess" value="always"></param>
			<embed src="http://www.youtube.com/v/<?php echo $code; ?>&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="<?php echo PADD_YTUBE_W; ?>" height="<?php echo PADD_YTUBE_H; ?>" />
		</object>
<?php endwhile; ?>
<?php
	wp_reset_query();
}

/**
 * Renders the list of bookmarks.
 */
function padd_theme_widget_bookmarks() {
	$array = array();
	$array[] = 'category_before=';
	$array[] = 'category_after=';
	$array[] = 'categorize=0';
	$array[] = 'title_li=';
	wp_list_bookmarks(implode('&',$array));
}

/**
 * Renders the list of recent comments.
 *
 * @global object $wpdb
 * @global array $comments
 * @global array $comment
 * @param int $limit
 */
function padd_theme_widget_recent_comments($limit=5) {
	global $wpdb, $comments, $comment;

	if ( !$comments = wp_cache_get( 'recent_comments', 'widget' ) ) {
		$comments = $wpdb->get_results("SELECT * FROM $wpdb->comments WHERE comment_approved = '1' ORDER BY comment_date_gmt DESC LIMIT $limit");
		wp_cache_add( 'recent_comments', $comments, 'widget' );
	}
	echo '<ul class="comments-recent">';
	if ( $comments ) :
		foreach ( (array) $comments as $comment) :
			echo  '<li class="comments-recent">' . sprintf(__('%1$s on %2$s'), get_comment_author_link(), '<a href="'. get_comment_link($comment->comment_ID) . '">' . get_the_title($comment->comment_post_ID) . '</a>') . '</li>';
		endforeach;
	endif;
	echo '</ul>';
}

/**
 * Displays the list of users.
 **/ 
function padd_theme_widget_list_users() {
	global $wpdb;  
	$str_sql = "SELECT ID FROM " . $wpdb->users . " 
				INNER JOIN " . $wpdb->usermeta . " ON " . $wpdb->users. ".ID = " . $wpdb->usermeta . ".user_id
				WHERE
					" . $wpdb->usermeta . ".meta_key = 'padd_appear_user' AND 
					" . $wpdb->usermeta . ".meta_value = '1' ";
	$user_ids = $wpdb->get_col($str_sql);
	
	foreach ($user_ids as $id) {
		echo '<div class="user">';
		echo get_avatar($id,'90');
		echo '<h3><a href="' . get_author_posts_url($id). '">';
		echo get_user_meta($id,'first_name',true) . ' ' . get_user_meta($id,'last_name',true);
		echo '</a></h3>';
		echo '<p>' . get_user_meta($id,'description',true) . '</p>';
		echo '</div>';
	}
}

/** 
 * Renders the tabbed widget.
 */
function padd_theme_widget_tabs() {
	?>
<div id="sidebar-tabs">
	<ul class="header">
		<li class="pop"><a href="#tab-pop">Blogroll</a></li>
		<li class="rcp"><a href="#tab-rcp">Archives</a></li>
		<li class="rcc"><a href="#tab-rcc">Categories</a></li>
	</ul>
	<div id="tab-pop">
		<h4>Blogroll</h4>
		<ul>
			<?php padd_theme_widget_bookmarks(); ?>
		</ul>
	</div>
	<div id="tab-rcp">
		<h4>Archives</h4>
		<ul>
			<?php wp_get_archives(); ?>
		</ul>
	</div>
	<div id="tab-rcc">
		<h4>Categories</h4>
		<ul>
			<?php wp_list_categories('title_li='); ?>
		</ul>
	</div>
</div>
	<?php
}


/**
 * Displays the modified list of popular posts.
 **/ 
function padd_theme_widget_popular_posts($limit=5,$range='all',$order_by='comment_count') {
	global $wpdb;
	$table = $wpdb->prefix . "popularpostsdata";
	$nopages = "AND $wpdb->posts.post_type = 'post'";
	// Range options
	switch($range) {
		case 'all':
			$range = "post_date_gmt < '".gmdate("Y-m-d H:i:s")."'";
			break;
		case 'yesterday':
			$range = $table."cache.day >= '".gmdate("Y-m-d")."' - INTERVAL 1 DAY";
			break;
		case 'daily':
			$range = $table."cache.day = CURDATE()";
			break;
		case 'weekly':
			$range = $table."cache.day >= '".gmdate("Y-m-d")."' - INTERVAL 7 DAY";
			break;
		case 'monthly':
			$range = $table."cache.day >= '".gmdate("Y-m-d")."' - INTERVAL 30 DAY";
			break;
		default:
			$range = "post_date_gmt < '".gmdate("Y-m-d H:i:s")."'";
			break;
	}
	// Sorting options
	switch( $instance['order_by'] ) {
		case 'comments':
			$sortby = 'comment_count';
			break;
		case 'views':
			$sortby = 'pageviews';
			break;
		case 'avg':
			$sortby = 'avg_views';
			break;
		default:
			$sortby = 'comment_count';
			break;
	}

	if ($instance['range'] == 'all') {
		$join = "LEFT JOIN $table ON $wpdb->posts.ID = $table.postid ";
		$force_pv = "AND " . $table . ".pageviews > 0 ";
	} else {
		$join = "RIGHT JOIN ".$table."cache ON $wpdb->posts.ID = " . $table . "cache.id ";
		$force_pv = "";
	}

	$fields .= ", $wpdb->posts.comment_count AS 'comment_count' ";

	$mostpopular = $wpdb->get_results("SELECT $wpdb->posts.ID, $wpdb->posts.post_title $fields FROM $wpdb->posts $join WHERE $wpdb->posts.post_status = 'publish' AND $wpdb->posts.post_password = '' AND $range $force_pv $nopages $exclude GROUP BY $wpdb->posts.ID ORDER BY $sortby DESC LIMIT " . $limit . "");
	
	if ( !is_array($mostpopular) || empty($mostpopular) ) {
		echo '<p>'. __('Sorry. No data so far.', 'wordpress-popular-posts') . '</p>';
	} else {
		foreach ($mostpopular as $post) {
			$comments = '';
			$count = (int) $post->comment_count;
			if ($count > 1) {
				$comments = $count . ' comments';
			} else if ($count == 1) {
				$comments = '1 comment';
			} else {
				$comments = 'no comments';
			}
		?>	
			<div class="popular-post">
				<h3><a href="<?php echo get_permalink($post->ID); ?> " title="Permalink to <?php echo $post->post_title; ?>"><?php echo $post->post_title; ?></a></h3>
				<div class="meta">
					<p>
						<span class="author">Posted by <?php the_author_link(); ?></span> -
						<span class="comments"><a href="<?php echo get_comments_link($post->ID); ?> "><?php echo $comments; ?></a></span>
					</p>
				</div>
			</div>
		<?php
		}
	}

}

/**
 * Renders the Facebook Like Box.
 * 
 * @paran string $id Facebook numerical ID
 * @param int $w Width of the box
 * @param int $h Height of the box
 * @param int $conn Number of connections
 * @param int $stream News feed streaming. 1 to enable, 0 to disable. The default value is 0.
 * @param int $header Like Box header. 1 to show, 0 to hide. The default value is 0.
 */
function padd_theme_widget_facebook_likebox($w=300,$h=250,$conn=10,$stream=0,$header=0) {
	$fb = unserialize(get_option(PADD_NAME_SPACE . '_sn_username_facebook'));
?>
<iframe src="http://www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($fb); ?>&amp;width=<?php echo $w; ?>&amp;connections=<?php echo $conn; ?>&amp;stream=<?php echo $stream == 1 ? 'true' : 'false'; ?>&amp;header=<?php echo $header == 1 ? 'true' : 'false'; ?>&amp;height=<?php echo $h; ?>" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $w; ?>px; height:<?php echo $h; ?>px;" allowTransparency="true"></iframe>
<?php
}

function padd_theme_widget_sitemap_menus() {
?>
<div class="col col-l">
	<?php 
		wp_nav_menu(array(
			'theme_location' => 'sitemap-l',
			'container' => null,
		));
	?>
</div>
<div class="col col-r">
	<?php 
		wp_nav_menu(array(
			'theme_location' => 'sitemap-r',
			'container' => null,
		));
	?>
</div>
<div class="clear"></div>
<?php
}

/**
 * Renders the list of comments.
 *
 * @param string $comment
 * @param string $args
 * @param string $depth
 */
function padd_theme_single_comments($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID() ?>">
		<div class="comment">
			<div class="comment-interior append-clear">
				<div class="comment-author append-clear">
					<div class="comment-avatar"><?php echo get_avatar($comment,'33'); ?></div>
					<div class="comment-meta">
						<span class="author"><?php echo get_comment_author_link(); ?> says: </span>
						<span class="time"><?php echo get_comment_date('F j, Y'); ?></span>
					</div>
				</div>
				<div class="comment-details">
					<div class="comment-details-interior">
						<?php comment_text(); ?>
						<?php if ($comment->comment_approved == '0') : ?>
						<p class="comment-notice"><?php _e('My comment is awaiting moderation.') ?></p>
						<?php endif; ?>
					</div>
				</div>
				<div class="comment-actions clear">
					<?php edit_comment_link(__('Edit'),'<span class="edit">','</span> | ') ?>
					<?php comment_reply_link(array_merge( $args, array('respond_id' => 'reply' ,'add_below' => 'reply', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</div>
			</div>
		</div>
	<?php
}

/**
 * Render the list of trackbacks.
 *
 * @param string $comment
 * @param string $args
 * @param string $depth
 */
function padd_theme_single_trackbacks($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?> id="pings-<?php comment_ID() ?>">
		<?php comment_author_link(); ?>
	<?php
}

/**
 * Renders the related posts
 *
 * @param int|string $post_ID
 */
function padd_theme_single_related_posts($post_ID) {
	$enabled = get_option(PADD_NAME_SPACE . '_rp_enable');
	if ($enabled) {

		$tag_ids = array();
		$cat_ids = array();

		$tags = wp_get_post_tags($post_ID);
		foreach($tags as $tag) {
			$tag_ids[] = $tag->term_id;
		}

		$cats = get_the_category($post_ID);
		if ($cats) {
			foreach($cats as $cat) {
				$cat_ids[] = $cat->term_id;
			}
		}

		$args = array(
					'post__not_in' => array($post_ID),
					'showposts' => intval(get_option(PADD_NAME_SPACE . '_rp_max',4)),
					'caller_get_posts' => 1
				);
		if (!empty($tag_ids) && get_option(PADD_NAME_SPACE . '_consider_tags','1') === '1') {
			$args['tag__in'] = $tag_ids;
		}
		if (!empty($cat_ids) && get_option(PADD_NAME_SPACE . '_consider_categories','1') === '1') {
			$args['category__in'] = $cat_ids;
		}

		$rp_query = new wp_query($args);
		
		$padd_image_def = get_template_directory_uri() . '/images/thumbnail-related-posts.jpg';

		if ($rp_query->have_posts()) {
			echo '<ol>';
			while ($rp_query->have_posts()) {
				$rp_query->the_post();
			?>
				<li>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
						<?php 
							$exclude[] = get_the_ID();
							if (has_post_thumbnail()) {
								the_post_thumbnail(PADD_THEME_SLUG . '-related-posts', array('title' => get_the_excerpt()));
							} else {
								echo '<img class="thumbnail" title="' . get_the_title() . '" src="' . $padd_image_def . '" />';
							}
						?>
					</a>
					<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a>
				</li>
			<?php
			}
			echo '</ol>';
		} else {
			echo '<p>There are no related posts on this entry.</p>';
		}
	} else {
		echo '<p>Related posts has been disabled.</p>';
	}
	// That should fix the bug in the single.php.
	wp_reset_query();
}

/**
 * Renders the featured posts in home page.
 */
function padd_theme_post_featured_posts($exclude=array()) {
	wp_reset_query();	
	$featured = get_option(PADD_NAME_SPACE . '_featured_cat_id','1');
	$count = get_option(PADD_NAME_SPACE . '_featured_cat_limit');
	query_posts('showposts=' . $count . '&cat=' . $featured);
	$padd_image_def = get_template_directory_uri() . '/images/thumbnail-gallery.jpg';
	add_filter('excerpt_length', 'padd_theme_hook_excerpt_featured_length');
?>
<div id="slideshow">
<?php while (have_posts()) : the_post(); ?>
	<a class="image" href="<?php the_permalink(); ?>" title="Permanent Link to <?php the_title_attribute(); ?>">
	<?php 
		$exclude[] = get_the_ID();
		if (has_post_thumbnail()) {
			the_post_thumbnail(PADD_THEME_SLUG . '-gallery', array('title' => get_the_excerpt()));
		} else {
			echo '<img class="thumbnail" title="' . get_the_title() . '" src="' . $padd_image_def . '" />';
		}
	?>
	</a>
<?php endwhile; ?>		
</div>
<?php
	wp_reset_query();
	remove_filter('excerpt_length','padd_theme_hook_excerpt_featured_length');
	return $exclude;
}

function padd_theme_share_button($class='share') {
?>
<ul>
	<li class="digg"><a class="DiggThisButton DiggCompact" href="http://digg.com/submit?url=<?php echo urlencode(get_permalink());?>&amp;title=<?php echo urlencode(get_the_title()); ?>">Digg</a></li>
	<li class="facebook"><a name="fb_share" type="button_count" share_url="<?php the_permalink(); ?>">Share</a></li>
	<li class="twitter"><a href="http://twitter.com/share?url=<?php echo urlencode(get_permalink());?>&amp;count=horizontal" class="twitter-share-button">Twitter</a></li>
</ul>
<?php
}

/** 
 * Renders the theme credits.
 */
function padd_theme_credits() {
	do_action(__FUNCTION__);
}
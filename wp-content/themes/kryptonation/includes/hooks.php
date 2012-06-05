<?php

/**
 * Sets the default menu arguments.
 */
function padd_theme_hook_menu_args($args) {
	$args['show_home'] = true;
	$args['container'] = null;
	return $args;
}

/**
 * Renders the "More" string in excerpt.
 */
function padd_theme_hook_excerpt_index_more() {
	return '...';
}

/**
 * Customize excerpt for Social Bookmarking
 */
function padd_theme_hook_excerpt_bookmark($text) {
	return strip_tags($text);
}

/**
 * Removes the "More" string in excerpt for Social Bookmarking.
 */
function padd_theme_hook_excerpt_bookmark_more() {
	return '...';
}

/**
 * Sets the excerpt length in index page.
 */
function padd_theme_hook_excerpt_index_length($length) {
	return 30;
}

/**
 * Sets the excerpt length in index page.
 */
function padd_theme_hook_excerpt_content_length($length) {
	return 80;
}

function padd_theme_hook_excerpt_featured_more() {
	return '...';
}

/**
 * Sets the excerpt length for featured posts.
 */
function padd_theme_hook_excerpt_featured_length($length) {
	return 12;
}

/**
 * Sets the excerpt length for teasers.
 */
function padd_theme_hook_excerpt_teaser_length($length) {
	return 60;
}

/**
 * Renders the "More" string in excerpt.
 */
function padd_theme_hook_excerpt_about_more() {
	return '...';
}

/**
 * Sets the excerpt length for About paragraph.
 */
function padd_theme_hook_excerpt_about_length($length) {
	return 15;
}

/**
 * Sets the excerpt length for pages.
 */
function padd_theme_hook_excerpt_pages_length($length) {
	return 17;
}

/**
 * Count comments.
 */
function padd_theme_hook_count_comments($count) {
	if (!is_admin()) {
		global $id;
		$comments_by_type = &separate_comments(get_comments('status=approve&post_id=' . $id));
		return count($comments_by_type['comment']);
	} else {
		return $count;
	}
}


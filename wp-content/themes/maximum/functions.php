<?php
//add class to next and previous links
add_filter('next_posts_link_attributes', 'next_posts_link_attributes');
add_filter('previous_posts_link_attributes', 'prev_posts_link_attributes');

function next_posts_link_attributes(){
	return 'class="nextpostslink"';
}
function prev_posts_link_attributes(){
	return 'class="previouspostslink"';
}
// widgetize sidebars...


if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Left Sidebar',
'before_widget' => '<div class="sidebar-row white">',
'after_widget' => '</div>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
if ( function_exists('register_sidebar') )
register_sidebar(array(
'name' => 'Right Sidebar',
'before_widget' => '<div class="sidebar-row white">',
'after_widget' => '</div>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));


//breadcrumbs
function dimox_breadcrumbs() {
 
  $delimiter = '&raquo;';
  $name = 'Home'; //text for the 'Home' link
  $currentBefore = '<span class="current">';
  $currentAfter = '</span>';
  if ( !is_home() && !is_front_page() || is_paged() ) {
 
    echo '<div id="crumbs">';
 
    global $post;
    $home = get_bloginfo('url');
    echo '<a href="' . $home . '">' . $name . '</a> ' . $delimiter . ' ';
 
    if ( is_category() ) {
      global $wp_query;
      $cat_obj = $wp_query->get_queried_object();
      $thisCat = $cat_obj->term_id;
      $thisCat = get_category($thisCat);
      $parentCat = get_category($thisCat->parent);
      if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
      echo $currentBefore . 'Archive by category &#39;';
      single_cat_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_day() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('d') . $currentAfter;
 
    } elseif ( is_month() ) {
      echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
      echo $currentBefore . get_the_time('F') . $currentAfter;
 
    } elseif ( is_year() ) {
      echo $currentBefore . get_the_time('Y') . $currentAfter;
 
    } elseif ( is_single() && !is_attachment() ) {
      $cat = get_the_category(); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_attachment() ) {
      $parent = get_post($post->post_parent);
      $cat = get_the_category($parent->ID); $cat = $cat[0];
      echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
      echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && !$post->post_parent ) {
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_page() && $post->post_parent ) {
      $parent_id  = $post->post_parent;
      $breadcrumbs = array();
      while ($parent_id) {
        $page = get_page($parent_id);
        $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
        $parent_id  = $page->post_parent;
      }
      $breadcrumbs = array_reverse($breadcrumbs);
      foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
      echo $currentBefore;
      the_title();
      echo $currentAfter;
 
    } elseif ( is_search() ) {
      echo $currentBefore . 'Search results for &#39;' . get_search_query() . '&#39;' . $currentAfter;
 
    } elseif ( is_tag() ) {
      echo $currentBefore . 'Posts tagged &#39;';
      single_tag_title();
      echo '&#39;' . $currentAfter;
 
    } elseif ( is_author() ) {
       global $author;
      $userdata = get_userdata($author);
      echo $currentBefore . 'Articles posted by ' . $userdata->display_name . $currentAfter;
 
    } elseif ( is_404() ) {
      echo $currentBefore . 'Error 404' . $currentAfter;
    }
 
    if ( get_query_var('paged') ) {
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
      echo __('Page') . ' ' . get_query_var('paged');
      if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
    }
 
    echo '</div>';
 
  }
}
// add menu and thumbs
if (function_exists('add_theme_support')) {
    add_theme_support('menus');
	add_theme_support('post-thumbnails');
}
//dynamic menus
function register_my_menus() {
register_nav_menus(
	array(
	'primary' => __( 'Header Menu' )
	)
	);
}
add_action( 'init', 'register_my_menus' );
function get_theStyle(){
global $post;
	$thumb = get_the_post_thumbnail($post->ID);		
	if($thumb != ''){
		$pattern= "/(?<=src=['|\"])[^'|\"]*?(?=['|\"])/i";
		preg_match($pattern, $thumb, $thePath);
		$theSrc = $thePath[0];
		$theStyle = 'style="background:url(' . $theSrc . ') no-repeat right top;"';	
		return $theStyle;
	}		
}
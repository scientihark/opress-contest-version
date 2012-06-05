<?php

add_filter('excerpt_more','padd_theme_hook_excerpt_index_more');
add_filter('get_comments_number','padd_theme_hook_count_comments',0);
add_filter('wp_page_menu_args','padd_theme_hook_menu_args');

<?php

class Padd_PageNavigation {
	
 	const ANTE_PAGE = '';
	const POST_PAGE = '';
	
	public static function get_nearest_round($num, $to_nearest) {
	   return floor($num/$to_nearest)*$to_nearest;
	}

	public static function render() {
		global $wpdb, $wp_query;
		if (!is_single()) {
			$request = $wp_query->request;
			$posts_per_page = intval(get_query_var('posts_per_page'));
			$paged = intval(get_query_var('paged'));
			$numposts = $wp_query->found_posts;
			$max_page = $wp_query->max_num_pages;
			if(empty($paged) || $paged == 0) {
				$paged = 1;
			}

			$pages_to_show = intval(get_option(PADD_NAME_SPACE . '_pgn_pages_to_show'));
			$larger_page_to_show = intval(get_option(PADD_NAME_SPACE . '_pgn_larger_page_numbers'));
			$larger_page_multiple = intval(get_option(PADD_NAME_SPACE . '_pgn_larger_page_numbers_multiple'));
	
			$pages_to_show_minus_1 = $pages_to_show - 1;
			$half_page_start = floor($pages_to_show_minus_1/2);
			$half_page_end = ceil($pages_to_show_minus_1/2);
			$start_page = $paged - $half_page_start;
			if($start_page <= 0) {
				$start_page = 1;
			}
			$end_page = $paged + $half_page_end;
			if(($end_page - $start_page) != $pages_to_show_minus_1) {
				$end_page = $start_page + $pages_to_show_minus_1;
			}
			if($end_page > $max_page) {
				$start_page = $max_page - $pages_to_show_minus_1;
				$end_page = $max_page;
			}
			if($start_page <= 0) {
				$start_page = 1;
			}
			$larger_per_page = $larger_page_to_show*$larger_page_multiple;
			$larger_start_page_start = (Padd_PageNavigation::get_nearest_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
			$larger_start_page_end = Padd_PageNavigation::get_nearest_round($start_page, 10) + $larger_page_multiple;
			$larger_end_page_start = Padd_PageNavigation::get_nearest_round($end_page, 10) + $larger_page_multiple;
			$larger_end_page_end = Padd_PageNavigation::get_nearest_round($end_page, 10) + ($larger_per_page);
			if($larger_start_page_end - $larger_page_multiple == $start_page) {
				$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
				$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
			}
			if($larger_start_page_start <= 0) {
				$larger_start_page_start = $larger_page_multiple;
			}
			if($larger_start_page_end > $max_page) {
				$larger_start_page_end = $max_page;
			}
			if($larger_end_page_end > $max_page) {
				$larger_end_page_end = $max_page;
			}
			if($max_page > 1) {
				$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), 'Page %CURRENT_PAGE% of %TOTAL_PAGES%');
				$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
				echo $before.'<div class="pagination">'."\n";
				if(!empty($pages_text)) {
					echo '<span class="pages">' . Padd_PageNavigation::ANTE_PAGE . $pages_text . Padd_PageNavigation::POST_PAGE . '</span>';
				}
				if ($start_page >= 2 && $pages_to_show < $max_page) {
					$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), '&laquo; First');
					echo '<a href="'.clean_url(get_pagenum_link()).'" class="first page-word" title="'.$first_page_text.'">' . Padd_PageNavigation::ANTE_PAGE . $first_page_text . Padd_PageNavigation::POST_PAGE . '</a>';
					echo '<span class="extend">' . Padd_PageNavigation::ANTE_PAGE . '...' . Padd_PageNavigation::POST_PAGE . '</span>';
				}
				if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
					for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
						echo '<a href="'.clean_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">' . Padd_PageNavigation::ANTE_PAGE . $page_text . Padd_PageNavigation::POST_PAGE . '</a>';
					}
				}
				if (($paged - 1) > 0) {
					echo '<a href="'.clean_url(get_pagenum_link($paged - 1)).'" class="page prev" title="Previous">' . Padd_PageNavigation::ANTE_PAGE . '&laquo; Prev' . Padd_PageNavigation::POST_PAGE . '</a>';
				}
				for($i = $start_page; $i  <= $end_page; $i++) {						
					if($i == $paged) {
						$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
						echo '<span class="current">'. Padd_PageNavigation::ANTE_PAGE . $current_page_text. Padd_PageNavigation::POST_PAGE . '</span>';
					} else {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
						echo '<a href="'.clean_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">' . Padd_PageNavigation::ANTE_PAGE .$page_text . Padd_PageNavigation::POST_PAGE . '</a>';
					}
				}
				if (($paged + 1) <= $max_page) {
					echo '<a href="'.clean_url(get_pagenum_link($paged + 1)).'" class="page next" title="Next">' . Padd_PageNavigation::ANTE_PAGE . 'Next &raquo;' . Padd_PageNavigation::POST_PAGE . '</a>';
				}
				if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
					for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
						$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), '%PAGE_NUMBER%');
						echo '<a href="'.clean_url(get_pagenum_link($i)).'" class="page" title="'.$page_text.'">'.Padd_PageNavigation::ANTE_PAGE .$page_text . Padd_PageNavigation::POST_PAGE.'</a>';
					}
				}
				if ($end_page < $max_page) {
					echo '<span class="extend">' . Padd_PageNavigation::ANTE_PAGE . '...' . Padd_PageNavigation::POST_PAGE . '</span>';
					$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page),'Last &raquo;');
					echo '<a href="'.clean_url(get_pagenum_link($max_page)).'" class="last page-word" title="'.$last_page_text.'">' . Padd_PageNavigation::ANTE_PAGE .$last_page_text . Padd_PageNavigation::POST_PAGE . '</a>';
				}
				echo '</div>'.$after."\n";
			}
		}
	}
	
}

?>
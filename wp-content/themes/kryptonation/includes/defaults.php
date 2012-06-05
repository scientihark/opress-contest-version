<?php

$padd_socialnet = array(
	'delicious' => new Padd_SocialNetwork('Delicious','http://delicious.com/%u%'),
	'digg' => new Padd_SocialNetwork('Digg','http://digg.com/users/%u%'),
	'facebook' => new Padd_SocialNetwork('Facebook','http://www.facebook.com/%u%'),
	'feedburner' => new Padd_SocialNetwork('Feedburner','http://feeds.feedburner.com/%u%'),
	'flickr' => new Padd_SocialNetwork('Flickr','http://www.flickr.com/photos/%u%'),
	'googlebuzz' => new Padd_SocialNetwork('Gooogle Buzz','http://www.google.com/profiles/%u%'),
	'lastfm' => new Padd_SocialNetwork('last.fm','http://www.last.fm/user/%u%'),
	'stumbleupon' => new Padd_SocialNetwork('StumbleUpon','http://www.stumbleupon.com/stumbler/%u%'),
	'technorati' => new Padd_SocialNetwork('Technorati','http://technorati.com/people/technorati/%u%'),
	'twitter' => new Padd_SocialNetwork('Twitter','http://www.twitter.com/%u%'),
	'youtube' => new Padd_SocialNetwork('YouTube','http://www.youtube.com/%u%'),
);

$padd_socialbook = array(
	'delicious' => new Padd_SocialBookmark('Delicious','http://delicious.com/post?url=%url%&amp;title=%title%&amp;notes=%excerpt%'),
	'digg' => new Padd_SocialBookmark('Digg','http://digg.com/submit?phase=2&amp;url=%url%&amp;title=%title%&amp;bodytext=%excerpt%'),
	'newsvine' => new Padd_SocialBookmark('Newsvine','http://www.newsvine.com/_tools/seed&amp;save?u=%url%&amp;h=%title%'),
	'rss' => new Padd_SocialBookmark('RSS',get_bloginfo('rss2_url')),
	'stumbleupon' => new Padd_SocialBookmark('StumbleUpon','http://www.stumbleupon.com/post?url=%url%&amp;title=%title%'),
	'technorati' => new Padd_SocialBookmark('Technorati','http://technorati.com/faves?add=%url%'),
	'twitter' => new Padd_SocialBookmark('Twitter','http://twitter.com/home?status=%title%%20-%20%url%')
);

$installed = get_option(PADD_NAME_SPACE . '_' . PADD_THEME_SLUG . '_installed','0');
$installed = ('0' === $installed) ? false : true;

if (!$installed) {
	// Core
	update_option(PADD_NAME_SPACE . '_' . PADD_THEME_SLUG . '_installed','1');

	// General
	update_option(PADD_NAME_SPACE . '_favicon_url','');
	update_option(PADD_NAME_SPACE . '_featured_cat_id','1');
	update_option(PADD_NAME_SPACE . '_featured_cat_limit','3');
	
	// Tracker
	update_option(PADD_NAME_SPACE . '_tracker_head','');
	update_option(PADD_NAME_SPACE . '_tracker_top','');
	update_option(PADD_NAME_SPACE . '_tracker_bot','');

	// Social Networking
	foreach ($padd_socialnet as $k => $v) {
		$v->set_username('paddsolutions');
		update_option(PADD_NAME_SPACE . '_sn_username_' . $k,serialize($v));
	}
	
	// Related Posts
	update_option(PADD_NAME_SPACE . '_rp_enable','1');
	update_option(PADD_NAME_SPACE . '_rp_max','4');
	update_option(PADD_NAME_SPACE . '_rp_consider_tags','1');
	update_option(PADD_NAME_SPACE . '_rp_consider_categories','1');
	
	// Page Navigation
	update_option(PADD_NAME_SPACE . '_pgn_pages_to_show','5');
	update_option(PADD_NAME_SPACE . '_pgn_larger_page_numbers','0');
	update_option(PADD_NAME_SPACE . '_pgn_larger_page_numbers_multiple','10');

	// Custom Advertisement
	update_option(PADD_NAME_SPACE . '_ads_728015_1','<a href="http://www.paddsolutions.com">Padd Solutions</a>');
	update_option(PADD_NAME_SPACE . '_ads_468060_1','<img alt="Advertisement" src="' . get_template_directory_uri() . '/images/advertisement-468x060.jpg" />');
	update_option(PADD_NAME_SPACE . '_ads_300250_1','<img alt="Advertisement" src="' . get_template_directory_uri() . '/images/advertisement-300x250.jpg" />');
	update_option(PADD_NAME_SPACE . '_ads_728090_1','<img alt="Advertisement" src="' . get_template_directory_uri() . '/images/advertisement-728x090.jpg" />');
	update_option(PADD_NAME_SPACE . '_ads_160600_1','<img alt="Advertisement" src="' . get_template_directory_uri() . '/images/advertisement-160x600.jpg" />');
}



<?php

add_action('admin_menu', 'WPLS_add_options');
function WPLS_add_options() {
	add_options_page('WP-localStorage options','WP-localStorage', 8, __FILE__, 'WPLS_the_options');
}

function WPLS_addScript(){
	$script = '<script type="text/javascript" src="' . get_bloginfo('wpurl') . '/js/wp-localstorage.jsx"></script>';
	echo $script;
}

function WPLS_addScript_admin(){
	$script = '<script type="text/javascript">';
	$script .= 'if(!window.WPLS_opt){';
	$script .= 'window.WPLS_opt={"btn":"' . get_bloginfo('wpurl') . '/wp-content/plugins/wp-localstorage/img/store.png"}';
	$script .= '}';
	$script .= '</script>';
	$script .= '<script type="text/javascript" src="' . get_bloginfo('wpurl') . '/js/wp-localstorage-posts.jsx"></script>';
	$css = '<link rel="stylesheet" href="' .get_bloginfo("wpurl") . '/wp-content/plugins/wp-localstorage/css/wp-localstorage.css" type="text/css" media="screen" />';
	echo $css.$script;
}

if(get_option("WPLS_storecomment")){
	add_action ('wp_head', 'WPLS_addScript');
}
if(get_option("WPLS_storepost")){
	add_action ('admin_head', 'WPLS_addScript_admin');
}


?>
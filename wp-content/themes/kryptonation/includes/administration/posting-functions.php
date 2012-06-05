<?php

$padd_meta_boxes = array(
	new Padd_Input_Option(
		'_' . PADD_NAME_SPACE . '_post_thumbnail_video_ytube',
		'YouTube Video Code',
		'The code to be used as video thumbnail in the sidebar. If the URL of the YouTube video, for example, is 
		 <code>http://www.youtube.com/watch?v=mKtdTJP_GUI</code>, <code>mKtdTJP_GUI</code> is the video code.',
		array('type' => 'textfield', 'width' => 200)
	),
); 

function padd_new_meta_boxes() {
	global $post, $padd_meta_boxes;
	require get_theme_root() . '/' . PADD_THEME_SLUG .  '/includes/administration/posting-ui.php';
}

function padd_create_meta_box() {
	global $theme_name;
	if (function_exists('add_meta_box')) {
		add_meta_box(PADD_NAME_SPACE . '-meta-boxes','YouTube Video Thumbnail',PADD_NAME_SPACE . '_new_meta_boxes','post','normal','high');
	}
}

function padd_save_post_data($id) {
	global $post, $padd_meta_boxes;

	if ('page' == $_POST['post_type']) {
		if (!current_user_can('edit_page',$id)) {
			return $id;
		} else {
			if (!current_user_can('edit_post', $id)) {
				return $id;
			}
		}
	}
		
	foreach ($padd_meta_boxes as $opt) {
		$data = $_REQUEST[$opt->get_keyword()];
		if (get_post_meta($id,$opt->get_keyword()) == '') {
			add_post_meta($id,$opt->get_keyword(),$data,true);
		} else if($data!= get_post_meta($id,$opt->get_keyword(), true)) {
			update_post_meta($id,$opt->get_keyword(),$data);
		} else if ($data == '') {
			delete_post_meta($id,$opt->get_keyword(),get_post_meta($id,$opt->get_keyword(), true));
		}
	}
}

add_action('admin_menu', 'padd_create_meta_box');  
add_action('save_post', 'padd_save_post_data');  

?>
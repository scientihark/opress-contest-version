<?php

class Padd_Widget_Custom_Ads extends WP_Widget {

	function Padd_Widget_Custom_Ads() {
		$widget_ops = array(
						'classname' => 'box-ads',
						'description' => PADD_THEME_NAME . ' Theme widget for custom advertisement. For the management of the sponsors\' images and links, go to ' . PADD_THEME_NAME . ' Options.'
					);
		$this->WP_Widget(PADD_THEME_SLUG . '_custom_ads',PADD_THEME_NAME . ' Custom Ads', $widget_ops);
		$this->alt_option_name = PADD_THEME_SLUG .  '_widget_custom_ads';
	}

	function widget($args,$instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget . "\n";

		if (!empty($title)) {
			echo $before_title . $title . $after_title . "\n";
		} else {
			echo $before_title . 'Sponsors' . $after_title . "\n";
		}
		padd_theme_widget_sponsors();
		echo $after_widget . "\n";
	}

	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array)$new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array) $instance, array( 'title' => ''));
		$title = $instance['title'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
		<p>For the management of the sponsors' images and links, proceed to <a href="<?php bloginfo('url'); ?>/wp-admin/themes.php?page=functions.php"><?php echo PADD_THEME_NAME; ?> Options</a>. </p>

<?php
	}

	function save_settings($settings) {
		$settings['_multiwidget'] = 0;
		update_option( $this->option_name, $settings );
	}
}

class Padd_Widget_Featured_Video extends WP_Widget {

	function Padd_Widget_Featured_Video() {
		$widget_ops = array(
						'classname' => 'box-featured-video',
						'description' => PADD_THEME_NAME . ' Theme widget for featured video. For the management of the featured video, go to ' . PADD_THEME_NAME . ' Options.'
					);
		$this->WP_Widget(PADD_THEME_SLUG . '_featured_video',PADD_THEME_NAME . ' Featured Video', $widget_ops);
		$this->alt_option_name = PADD_THEME_SLUG . '_widget_featured_video';
	}

	function widget($args,$instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget . "\n";

		if (!empty($title)) {
			echo $before_title . $title . $after_title . "\n";
		} else {
			echo $before_title . 'Featured Video' . $after_title . "\n";
		}
		padd_theme_widget_featured_video();
		echo $after_widget . "\n";
	}

	function update($new_instance,$old_instance) {
		$instance = $old_instance;
		$new_instance = wp_parse_args((array)$new_instance, array( 'title' => ''));
		$instance['title'] = strip_tags($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$instance = wp_parse_args((array) $instance, array( 'title' => ''));
		$title = $instance['title'];
?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>
<?php
	}
}

register_widget('Padd_Widget_Custom_Ads');
register_widget('Padd_Widget_Featured_Video');

?>
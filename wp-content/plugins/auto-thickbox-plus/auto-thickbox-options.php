<?php
/*
 * Auto ThickBox Plus Options
 * Copyright (C) 2010-2012 attosoft <http://attosoft.info/en/>
 * This file is distributed under the same license as the Auto ThickBox Plus package.
 * attosoft <contact@attosoft.info>, 2010.
 */

class auto_thickbox_options {

	// Auto ThickBox Plus Options
	function register_options_page() {
		add_options_page($this->texts['options'], AUTO_THICKBOX_PLUS, 'manage_options', $this->base_dir, array(&$this, 'options_page'));
		add_meta_box( 'general-box', __('General'), array(&$this, 'general_metabox'), 'auto-thickbox-options', 'normal' );
		add_meta_box( 'action-box', $this->texts['action'], array(&$this, 'action_metabox'), 'auto-thickbox-options', 'normal' );
		add_meta_box( 'view-box', $this->texts['view'], array(&$this, 'view_metabox'), 'auto-thickbox-options', 'normal' );
		add_meta_box( 'text-box', __('Text'), array(&$this, 'text_metabox'), 'auto-thickbox-options', 'normal' );
		add_meta_box( 'image-box', $this->texts['image'], array(&$this, 'image_metabox'), 'auto-thickbox-options', 'normal' );
		add_meta_box( 'effect-box', __('Effect', 'auto-thickbox') . ' (' . __('beta', 'auto-thickbox') . ')', array(&$this, 'effect_metabox'), 'auto-thickbox-options', 'normal' );
		add_action('media_upload_image', array(&$this, 'save_all_changes_hook'));
	}

	function save_all_changes_hook() {
?>
<script type="text/javascript">
/* <![CDATA[ */
jQuery(function($) {
	var action = $('#image-form').attr('action');
	if (action.indexOf('post_id=0') != -1) {
		$('.ml-submit #save').click(function() { // switch to Media Library tab
			$('#image-form').attr('action', action.replace('tab=type', 'tab=library'));
		});
	}
});
/* ]]> */
</script>
<?php
	}

	function register_scripts() {
		$this->has_slider = function_exists('wp_script_is') && wp_script_is('jquery-ui-slider', 'registered');
		$deps = array('postbox', 'farbtastic', 'media-upload');
		if ($this->has_slider) $deps[] = 'jquery-ui-slider';
		wp_enqueue_script('auto-thickbox', $this->base->plugins_url('auto-thickbox.js', __FILE__), $deps, AUTO_THICKBOX_PLUS_VERSION, true);
	}

	function register_styles() {
		wp_enqueue_style('auto-thickbox', $this->base->plugins_url('auto-thickbox.css', __FILE__), array('farbtastic', 'thickbox'), AUTO_THICKBOX_PLUS_VERSION);
	}

	function options_page() {
?>
<div class="wrap">
	<?php screen_icon(); ?>
	<h2><?php echo $this->texts['options']; ?></h2>
	<form method="post" action="options.php" name="form">
	<?php settings_fields( 'auto-thickbox-plus-options' ); ?>
		<div id="poststuff" class="metabox-holder">
		<?php
				wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
				wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
				do_meta_boxes( 'auto-thickbox-options', 'normal', null );
		?>
		</div>
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
			<input type="submit" class="button-primary" value="<?php _e('Reset') ?>" name="reset" />
		</p>
	</form>
</div>
<?php
	}

	function general_metabox() {
?>
<table class="form-table">
	<tr>
		<th scope="row"><?php _e('Default Display Style', 'auto-thickbox'); ?></th>
		<td colspan="2">
			<label><input type="radio" name="auto-thickbox-plus[thickbox_style]" value="single"<?php $this->checked($this->options['thickbox_style'], 'single'); ?> />
			<?php _e('Single Image (explicitly specify a@rel attribute as needed)', 'auto-thickbox'); ?></label><br />
			<label><input type="radio" name="auto-thickbox-plus[thickbox_style]" value="gallery"<?php $this->checked($this->options['thickbox_style'], 'gallery'); ?> />
			<?php _e('Gallery Images (automatically set a@rel attribute in \'gallery-id\' format)', 'auto-thickbox'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('ThickBox on Text Links', 'auto-thickbox'); ?></th>
		<td colspan="2">
			<label><input type="radio" name="auto-thickbox-plus[thickbox_text]" value="auto"<?php $this->checked($this->options['thickbox_text'], 'auto'); ?> />
			<?php _e('Auto (automatically set a@class=&quot;thickbox&quot;)', 'auto-thickbox'); ?></label><br />
			<label><input type="radio" name="auto-thickbox-plus[thickbox_text]" value="manual"<?php $this->checked($this->options['thickbox_text'], 'manual'); ?> />
			<?php _e('Manual (explicitly specify a@class=&quot;thickbox&quot; as needed)', 'auto-thickbox'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Auto Resize', 'auto-thickbox'); ?></th>
		<td colspan="2">
			<label><input type="checkbox" name="auto-thickbox-plus[auto_resize]"<?php $this->checked($this->options['auto_resize'], 'on'); ?> />
			<?php _e('Enabled'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('ThickBox Resources', 'auto-thickbox'); ?></th>
		<td colspan="2">
			<label><input type="checkbox" name="auto-thickbox-plus[builtin_res]"<?php $this->checked($this->options['builtin_res'], 'on'); ?> />
			<?php _e('Use WordPress built-in thickbox.js/css (some extra features will be disabled)', 'auto-thickbox'); ?></label>
		</td>
	</tr>
</table>
<?php
	}

	function action_metabox() {
		$click_end_disabled = in_array($this->options['click_img'], array('close', 'none'));
		$click_range_disabled = $this->options['click_img'] != 'prev_next';
?>
<table class="form-table">
	<tr>
		<th scope="row"><?php _e('Mouse Click', 'auto-thickbox'); ?></th>
		<th scope="row"><?php echo $this->texts['image']; ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_img]" value="close"<?php $this->checked($this->options['click_img'], 'close'); ?> onclick="disableClickOption(this)" />
			<?php echo $this->texts['close']; ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_img]" value="none"<?php $this->checked($this->options['click_img'], 'none'); ?> onclick="disableClickOption(this)" />
			<?php echo $this->texts['none']; ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_img]" value="next"<?php $this->checked($this->options['click_img'], 'next'); ?> onclick="disableClickOption(this)" />
			<?php echo $this->texts['next2']; ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_img]" value="prev_next"<?php $this->checked($this->options['click_img'], 'prev_next'); ?> onclick="disableClickOption(this)" />
			<?php echo "{$this->texts['prev2']} / {$this->texts['next2']}"; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php echo "{$this->texts['image']} ({$this->texts['first2']} / {$this->texts['last2']})"; ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_end]" value="close"<?php $this->checked($this->options['click_end'], 'close'); $this->disabled($click_end_disabled); ?> />
			<?php echo $this->texts['close']; ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_end]" value="none"<?php $this->checked($this->options['click_end'], 'none'); $this->disabled($click_end_disabled); ?> />
			<?php echo $this->texts['none']; ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_end]" value="loop"<?php $this->checked($this->options['click_end'], 'loop'); $this->disabled($click_end_disabled); ?> />
			<?php echo $this->texts['loop']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Clickable Range', 'auto-thickbox'); ?></th>
		<td class="slider">
			<input type="text" name="auto-thickbox-plus[click_range]" value="<?php echo $this->options['click_range']; ?>" id="click-range" class="small-text"<?php $this->disabled($click_range_disabled); ?> />
			<span>%</span>
			<?php if ($this->has_slider): ?>
				<div id="click-range-slider"></div>
			<?php else: ?>
				<span>[0 - 50]</span>
			<?php endif; ?>
			<div style="clear:left"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Background'); ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_bg]" value="close"<?php $this->checked($this->options['click_bg'], 'close'); ?> />
			<?php echo $this->texts['close']; ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[click_bg]" value="none"<?php $this->checked($this->options['click_bg'], 'none'); ?> />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Mouse Wheel', 'auto-thickbox'); ?> (<?php _e('Scroll'); ?>)</th>
		<th scope="row"><?php echo $this->texts['image']; ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[wheel_img]" value="prev_next"<?php $this->checked($this->options['wheel_img'], 'prev_next'); ?> />
			<?php echo "{$this->texts['prev2']} / {$this->texts['next2']}"; ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[wheel_img]" value="none"<?php $this->checked($this->options['wheel_img'], 'none'); ?> />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Drag &amp; Drop', 'auto-thickbox'); ?></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?> (<?php echo $this->texts['image']; ?>)</th>
		<td>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[drag_img_move]"<?php $this->checked($this->options['drag_img_move'], 'on'); ?> />
			<?php _e('Move', 'auto-thickbox'); ?></label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[drag_img_resize]"<?php $this->checked($this->options['drag_img_resize'], 'on'); ?> />
			<?php _e('Resize', 'auto-thickbox'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?> (<?php _e('Content'); ?>)</th>
		<td>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[drag_content_move]"<?php $this->checked($this->options['drag_content_move'], 'on'); ?> />
			<?php _e('Move', 'auto-thickbox'); ?></label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[drag_content_resize]"<?php $this->checked($this->options['drag_content_resize'], 'on'); ?> />
			<?php _e('Resize', 'auto-thickbox'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['shortcuts']; ?></th>
		<th scope="row"><?php echo $this->texts['close']; ?></th>
		<td>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_close_esc]"<?php $this->checked($this->options['key_close_esc'], 'on'); ?> />
				Esc</label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_close_enter]"<?php $this->checked($this->options['key_close_enter'], 'on'); ?> />
				Enter</label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php echo $this->texts['prev2']; ?></th>
		<td>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_prev_angle]"<?php $this->checked($this->options['key_prev_angle'], 'on'); ?> />
				< ( , )</label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_prev_left]"<?php $this->checked($this->options['key_prev_left'], 'on'); ?> />
			<?php _e('Left'); ?></label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_prev_tab]"<?php $this->checked($this->options['key_prev_tab'], 'on'); ?> />
				Shift + Tab</label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_prev_space]"<?php $this->checked($this->options['key_prev_space'], 'on'); ?> />
				Shift + <?php _e('Space', 'auto-thickbox'); ?></label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_prev_bs]"<?php $this->checked($this->options['key_prev_bs'], 'on'); ?> />
				BackSpace</label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php echo $this->texts['next2']; ?></th>
		<td>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_next_angle]"<?php $this->checked($this->options['key_next_angle'], 'on'); ?> />
				> ( . )</label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_next_right]"<?php $this->checked($this->options['key_next_right'], 'on'); ?> />
			<?php _e('Right'); ?></label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_next_tab]"<?php $this->checked($this->options['key_next_tab'], 'on'); ?> />
				Tab</label>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_next_space]"<?php $this->checked($this->options['key_next_space'], 'on'); ?> />
			<?php _e('Space', 'auto-thickbox'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php echo "{$this->texts['first2']} / {$this->texts['last2']}"; ?></th>
		<td>
			<label class="item"><input type="checkbox" name="auto-thickbox-plus[key_end_home_end]"<?php $this->checked($this->options['key_end_home_end'], 'on'); ?> />
				Home / End</label>
		</td>
	</tr>
</table>
<?php
	}

	function view_metabox() {
		$bgcolor_title_trans = $this->options['bgcolor_title'] == 'transparent';
		$bgcolor_cap_trans = $this->options['bgcolor_cap'] == 'transparent';
		$bgcolor_img_trans = $this->options['bgcolor_img'] == 'transparent';
		$bgcolor_content_trans = $this->options['bgcolor_content'] == 'transparent';
		$bgcolor_bg_trans = $this->options['bgcolor_bg'] == 'transparent';
		$border_win_none = $this->options['border_win'] == 'none';
		$border_img_tl_none = $this->options['border_img_tl'] == 'none';
		$border_img_br_none = $this->options['border_img_br'] == 'none';
		$box_shadow_win_none = $this->options['box_shadow_win'] == 'none';
		$txt_shadow_title_none = $this->options['txt_shadow_title'] == 'none';
		$txt_shadow_cap_none = $this->options['txt_shadow_cap'] == 'none';
?>
<table class="form-table">
	<tr>
		<th scope="row"><?php _e('Position'); ?></th>
		<th scope="row"><?php _e('Title'); ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_title]" value="top"<?php $this->checked($this->options['position_title'], 'top'); ?> />
			<?php _e('Top'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_title]" value="bottom"<?php $this->checked($this->options['position_title'], 'bottom'); ?> />
			<?php _e('Bottom'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_title]" value="none"<?php $this->checked($this->options['position_title'], 'none'); ?> />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Caption'); ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_cap]" value="top"<?php $this->checked($this->options['position_cap'], 'top'); ?> />
			<?php _e('Top'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_cap]" value="bottom"<?php $this->checked($this->options['position_cap'], 'bottom'); ?> />
			<?php _e('Bottom'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_cap]" value="none"<?php $this->checked($this->options['position_cap'], 'none'); ?> />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/position', 'auto-thickbox'); ?>" target="_blank"><?php _e('Position'); ?></a></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_win]" value="fixed"<?php $this->checked($this->options['position_win'], 'fixed'); ?> />
			<?php _e('Fixed'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[position_win]" value="absolute"<?php $this->checked($this->options['position_win'], 'absolute'); ?> />
			<?php _e('Absolute', 'auto-thickbox'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/font-family', 'auto-thickbox'); ?>" target="_blank"><?php echo ucwords(__('Font family')); ?></a></th>
		<th scope="row"><?php _e('Title'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[font_title]" value="<?php $this->esc_attr($this->options['font_title']); ?>" style="width:70%" />
			<label><input type="checkbox" name="auto-thickbox-plus[font_weight_title]" value="bold"<?php $this->checked($this->options['font_weight_title'], 'bold'); ?> />
			<?php _e('Bold'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Caption'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[font_cap]" value="<?php $this->esc_attr($this->options['font_cap']); ?>" style="width:70%" />
			<label><input type="checkbox" name="auto-thickbox-plus[font_weight_cap]" value="bold"<?php $this->checked($this->options['font_weight_cap'], 'bold'); ?> />
			<?php _e('Bold'); ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/font-size', 'auto-thickbox'); ?>" target="_blank"><?php echo ucwords(__('Font size')); ?></a></th>
		<th scope="row"><?php _e('Title'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[font_size_title]" value="<?php echo $this->options['font_size_title']; ?>" class="small-text" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Caption'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[font_size_cap]" value="<?php echo $this->options['font_size_cap']; ?>" class="small-text" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Navigation'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[font_size_nav]" value="<?php echo $this->options['font_size_nav']; ?>" class="small-text" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/color', 'auto-thickbox'); ?>" target="_blank"><?php _e('Text Color'); ?></a></th>
		<th scope="row"><?php _e('Title'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[color_title]" value="<?php echo $this->options['color_title']; ?>" />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Caption'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[color_cap]" value="<?php echo $this->options['color_cap']; ?>" />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Navigation'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[color_nav]" value="<?php echo $this->options['color_nav']; ?>" />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/background-color', 'auto-thickbox'); ?>" target="_blank"><?php _e('Background Color'); ?></a></th>
		<th scope="row"><?php _e('Title'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[bgcolor_title]" value="<?php echo $this->options['bgcolor_title']; ?>"<?php $this->disabled($bgcolor_title_trans); ?> />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[bgcolor_title]" value="transparent"<?php $this->checked($bgcolor_title_trans); ?> onclick="disableOption(this)" />
			<?php _e('Transparent', 'auto-thickbox'); ?></label>
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Caption'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[bgcolor_cap]" value="<?php echo $this->options['bgcolor_cap']; ?>"<?php $this->disabled($bgcolor_cap_trans); ?> />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[bgcolor_cap]" value="transparent"<?php $this->checked($bgcolor_cap_trans); ?> onclick="disableOption(this)" />
			<?php _e('Transparent', 'auto-thickbox'); ?></label>
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?> (<?php echo $this->texts['image']; ?>)</th>
		<td>
			<input type="text" name="auto-thickbox-plus[bgcolor_img]" value="<?php echo $this->options['bgcolor_img']; ?>"<?php $this->disabled($bgcolor_img_trans); ?> />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[bgcolor_img]" value="transparent"<?php $this->checked($bgcolor_img_trans); ?> onclick="disableOption(this)" />
			<?php _e('Transparent', 'auto-thickbox'); ?></label>
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?> (<?php _e('Content'); ?>)</th>
		<td>
			<input type="text" name="auto-thickbox-plus[bgcolor_content]" value="<?php echo $this->options['bgcolor_content']; ?>"<?php $this->disabled($bgcolor_content_trans); ?> />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[bgcolor_content]" value="transparent"<?php $this->checked($bgcolor_content_trans); ?> onclick="disableOption(this)" />
			<?php _e('Transparent', 'auto-thickbox'); ?></label>
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Background'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[bgcolor_bg]" value="<?php echo $this->options['bgcolor_bg']; ?>"<?php $this->disabled($bgcolor_bg_trans); ?> />
			<a href="#" class="pickcolor colorpreview hide-if-no-js"></a>
			<input type="button" class="pickcolor button hide-if-no-js" value="<?php $this->esc_attr($this->texts['sel_color']); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[bgcolor_bg]" value="transparent"<?php $this->checked($bgcolor_bg_trans); ?> onclick="disableOption(this)" />
			<?php _e('Transparent', 'auto-thickbox'); ?></label>
			<br /><div class="colorpicker"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/margin', 'auto-thickbox'); ?>" target="_blank"><?php _e('Margin', 'auto-thickbox'); ?></a></th>
		<th scope="row"><?php echo $this->texts['image']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[margin_img]" value="<?php echo $this->options['margin_img']; ?>" class="small-text" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/border', 'auto-thickbox'); ?>" target="_blank"><?php _e('Border'); ?></a></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[border_win]" value="<?php echo $this->options['border_win']; ?>"<?php $this->disabled($border_win_none); ?> />
			<label><input type="checkbox" name="auto-thickbox-plus[border_win]" value="none"<?php $this->checked($border_win_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php echo $this->texts['image']; ?> (<?php _e('Top left'); ?>)</th>
		<td>
			<input type="text" name="auto-thickbox-plus[border_img_tl]" value="<?php echo $this->options['border_img_tl']; ?>"<?php $this->disabled($border_img_tl_none); ?> />
			<label><input type="checkbox" name="auto-thickbox-plus[border_img_tl]" value="none"<?php $this->checked($border_img_tl_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php echo $this->texts['image']; ?> (<?php _e('Bottom right'); ?>)</th>
		<td>
			<input type="text" name="auto-thickbox-plus[border_img_br]" value="<?php echo $this->options['border_img_br']; ?>"<?php $this->disabled($border_img_br_none); ?> />
			<label><input type="checkbox" name="auto-thickbox-plus[border_img_br]" value="none"<?php $this->checked($border_img_br_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/border-radius', 'auto-thickbox'); ?>" target="_blank"><?php _e('Border Radius', 'auto-thickbox'); ?></a></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[radius_win]" value="<?php echo $this->options['radius_win']; ?>" class="small-text" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php echo $this->texts['image']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[radius_img]" value="<?php echo $this->options['radius_img']; ?>" class="small-text" /> px
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/opacity', 'auto-thickbox'); ?>" target="_blank"><?php _e('Opacity', 'auto-thickbox'); ?></a></th>
		<th scope="row"><?php _e('Background'); ?></th>
		<td class="slider">
			<input type="text" name="auto-thickbox-plus[opacity_bg]" value="<?php echo $this->options['opacity_bg']; ?>" class="small-text" />
			<?php if ($this->has_slider): ?>
				<label class="opacity-trans"><?php _e('Transparent', 'auto-thickbox'); ?></label>
				<div class="opacity-slider"></div>
				<label class="opacity-opaque"><?php _e('Opaque', 'auto-thickbox'); ?></label>
			<?php else: ?>
				<span>[0 - 1]</span>
			<?php endif; ?>
			<div style="clear:left"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Thumbnail'); ?></th>
		<td class="slider">
			<input type="text" name="auto-thickbox-plus[opacity_thumb]" value="<?php echo $this->options['opacity_thumb']; ?>" class="small-text" />
			<?php if ($this->has_slider): ?>
				<label class="opacity-trans"><?php _e('Transparent', 'auto-thickbox'); ?></label>
				<div class="opacity-slider"></div>
				<label class="opacity-opaque"><?php _e('Opaque', 'auto-thickbox'); ?></label>
			<?php else: ?>
				<span>[0 - 1]</span>
			<?php endif; ?>
			<div style="clear:left"></div>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/box-shadow', 'auto-thickbox'); ?>" target="_blank"><?php _e('Box Shadow', 'auto-thickbox'); ?></a></th>
		<th scope="row"><?php _e('Window', 'auto-thickbox'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[box_shadow_win]" value="<?php echo $this->options['box_shadow_win']; ?>" size="27"<?php $this->disabled($box_shadow_win_none); ?> />
			<label><input type="checkbox" name="auto-thickbox-plus[box_shadow_win]" value="none"<?php $this->checked($box_shadow_win_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><a href="<?php $this->esc_attr_e('https://developer.mozilla.org/en/CSS/text-shadow', 'auto-thickbox'); ?>" target="_blank"><?php _e('Text Shadow', 'auto-thickbox'); ?></a></th>
		<th scope="row"><?php _e('Title'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[txt_shadow_title]" value="<?php echo $this->options['txt_shadow_title']; ?>" size="27"<?php $this->disabled($txt_shadow_title_none); ?> />
			<label><input type="checkbox" name="auto-thickbox-plus[txt_shadow_title]" value="none"<?php $this->checked($txt_shadow_title_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"></th>
		<th scope="row"><?php _e('Caption'); ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[txt_shadow_cap]" value="<?php echo $this->options['txt_shadow_cap']; ?>" size="27"<?php $this->disabled($txt_shadow_cap_none); ?> />
			<label><input type="checkbox" name="auto-thickbox-plus[txt_shadow_cap]" value="none"<?php $this->checked($txt_shadow_cap_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
</table>
<?php
	}

	function text_metabox() {
?>
<table class="form-table">
	<tr>
		<th scope="row"><?php _e('Title'); ?></th>
		<td>
			<input type="hidden" name="auto-thickbox-plus[ref_title]" value="<?php echo $this->options['ref_title']; ?>" />
			<ol class="sortable">
				<?php $this->sortable_items($this->options['ref_title']); ?>
			</ol>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Caption'); ?></th>
		<td>
			<input type="hidden" name="auto-thickbox-plus[ref_cap]" value="<?php echo $this->options['ref_cap']; ?>" />
			<ol class="sortable">
				<?php $this->sortable_items($this->options['ref_cap']); ?>
			</ol>
		</td>
	</tr>
</table>
<?php
	}

	function sortable_items($refs) {
		foreach (explode(',', $refs) as $ref) {
			switch (trim($ref, "'")) {
				case "link-title": echo "<li class='ui-state-default' id='link-title'>{$this->texts['link']} - " . __('Title') . " (<code>a@title</code>)</li>"; break;
				case "link-name": echo "<li class='ui-state-default' id='link-name'>{$this->texts['link']} - " . __('Name') . " (<code>a@name</code>)</li>"; break;
				case "blank": echo "<li class='ui-state-default' id='blank'>" . __('Blank') . "</li>"; break;
				case "img-title": echo "<li class='ui-state-default' id='img-title'>{$this->texts['image']} - " . __('Title') . " (<code>img@title</code>)</li>"; break;
				case "img-alt": echo "<li class='ui-state-default' id='img-alt'>{$this->texts['image']} - " . __('Alternate Text') . " (<code>img@alt</code>)</li>"; break;
				case "gallery-cap": echo "<li class='ui-state-default' id='gallery-cap'>" . __('Gallery') . " - " . __('Caption') . " (<code>dd.gallery-caption</code>)</li>"; break;
				case "img-desc": echo "<li class='ui-state-default' id='img-desc'>{$this->texts['image']} - " . __('Description') . " (<code>img@longdesc</code>)</li>"; break;
				case "img-name": echo "<li class='ui-state-default' id='img-name'>{$this->texts['image']} - " . __('Name') . " (<code>img@name</code>)</li>"; break;
			}
		}
	}

	function image_metabox() {
		$img_prev_none = $this->options['img_prev'] == 'none';
		$img_prev = !$img_prev_none ? $this->options['img_prev'] : $this->options_def['img_prev'];
		$img_next_none = $this->options['img_next'] == 'none';
		$img_next = !$img_next_none ? $this->options['img_next'] : $this->options_def['img_next'];
		$img_first_none = $this->options['img_first'] == 'none';
		$img_first = !$img_first_none ? $this->options['img_first'] : $this->options_def['img_first'];
		$img_last_none = $this->options['img_last'] == 'none';
		$img_last = !$img_last_none ? $this->options['img_last'] : $this->options_def['img_last'];
		$img_close_none = $this->options['img_close'] == 'none';
		$img_close = !$img_close_none ? $this->options['img_close'] : $this->options_def['img_close'];
		$img_close_btn_none = $this->options['img_close_btn'] == 'none';
		$img_close_btn = !$img_close_btn_none ? $this->options['img_close_btn'] : $this->options_def['img_close_btn'];
		$img_load_none = $this->options['img_load'] == 'none';
		$img_load = !$img_load_none ? $this->options['img_load'] : $this->options_def['img_load'];
?>
<table class="form-table">
	<tr>
		<th scope="row"><?php echo $this->texts['prev2']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[img_prev]" value="<?php $this->esc_attr($img_prev); ?>" style="width:70%"<?php $this->disabled($img_prev_none); ?> />
			<input type="button" class="media-uploader button" value="<?php $this->esc_attr_e('Select a File', 'auto-thickbox'); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[img_prev]" value="none"<?php $this->checked($img_prev_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['next2']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[img_next]" value="<?php $this->esc_attr($img_next); ?>" style="width:70%"<?php $this->disabled($img_next_none); ?> />
			<input type="button" class="media-uploader button" value="<?php $this->esc_attr_e('Select a File', 'auto-thickbox'); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[img_next]" value="none"<?php $this->checked($img_next_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['first2']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[img_first]" value="<?php $this->esc_attr($img_first); ?>" style="width:70%"<?php $this->disabled($img_first_none); ?> />
			<input type="button" class="media-uploader button" value="<?php $this->esc_attr_e('Select a File', 'auto-thickbox'); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[img_first]" value="none"<?php $this->checked($img_first_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['last2']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[img_last]" value="<?php $this->esc_attr($img_last); ?>" style="width:70%"<?php $this->disabled($img_last_none); ?> />
			<input type="button" class="media-uploader button" value="<?php $this->esc_attr_e('Select a File', 'auto-thickbox'); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[img_last]" value="none"<?php $this->checked($img_last_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['close']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[img_close]" value="<?php $this->esc_attr($img_close); ?>" style="width:70%"<?php $this->disabled($img_close_none); ?> />
			<input type="button" class="media-uploader button" value="<?php $this->esc_attr_e('Select a File', 'auto-thickbox'); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[img_close]" value="none"<?php $this->checked($img_close_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['close']; ?> (<?php _e('Button', 'auto-thickbox'); ?>)</th>
		<td>
			<input type="text" name="auto-thickbox-plus[img_close_btn]" value="<?php $this->esc_attr($img_close_btn); ?>" style="width:70%"<?php $this->disabled($img_close_btn_none); ?> />
			<input type="button" class="media-uploader button" value="<?php $this->esc_attr_e('Select a File', 'auto-thickbox'); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[img_close_btn]" value="none"<?php $this->checked($img_close_btn_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['load']; ?></th>
		<td>
			<input type="text" name="auto-thickbox-plus[img_load]" value="<?php $this->esc_attr($img_load); ?>" style="width:70%"<?php $this->disabled($img_load_none); ?> />
			<input type="button" class="media-uploader button" value="<?php $this->esc_attr_e('Select a File', 'auto-thickbox'); ?>" />
			<label><input type="checkbox" name="auto-thickbox-plus[img_load]" value="none"<?php $this->checked($img_load_none); ?> onclick="disableOption(this)" />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
</table>
<?php
	}

	function effect_metabox() {
		$effect_speed = $this->options['effect_speed'];
		$effect_speed_num = is_numeric($effect_speed);
		switch ($effect_speed) {
			case "fast": $effect_speed = "200"; break;
			case "normal": $effect_speed = "400"; break;
			case "slow": $effect_speed = "600"; break;
		}
?>
<table class="form-table">
	<tr>
		<th scope="row"><?php echo $this->texts['open']; ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_open]" value="zoom"<?php $this->checked($this->options['effect_open'], 'zoom'); ?> />
			<?php _e('Zoom', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_open]" value="slide"<?php $this->checked($this->options['effect_open'], 'slide'); ?> />
			<?php _e('Slide', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_open]" value="fade"<?php $this->checked($this->options['effect_open'], 'fade'); ?> />
			<?php _e('Fade', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_open]" value="none"<?php $this->checked($this->options['effect_open'], 'none'); ?> />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php echo $this->texts['close']; ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_close]" value="zoom"<?php $this->checked($this->options['effect_close'], 'zoom'); ?> />
			<?php _e('Zoom', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_close]" value="slide"<?php $this->checked($this->options['effect_close'], 'slide'); ?> />
			<?php _e('Slide', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_close]" value="fade"<?php $this->checked($this->options['effect_close'], 'fade'); ?> />
			<?php _e('Fade', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_close]" value="none"<?php $this->checked($this->options['effect_close'], 'none'); ?> />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Transition', 'auto-thickbox'); ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_trans]" value="zoom"<?php $this->checked($this->options['effect_trans'], 'zoom'); ?> />
			<?php _e('Zoom', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_trans]" value="slide"<?php $this->checked($this->options['effect_trans'], 'slide'); ?> />
			<?php _e('Slide', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_trans]" value="fade"<?php $this->checked($this->options['effect_trans'], 'fade'); ?> />
			<?php _e('Fade', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_trans]" value="none"<?php $this->checked($this->options['effect_trans'], 'none'); ?> />
			<?php echo $this->texts['none']; ?></label>
		</td>
	</tr>
	<tr>
		<th scope="row"><?php _e('Speed', 'auto-thickbox'); ?></th>
		<td>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_speed]" value="fast"<?php $this->checked($this->options['effect_speed'], 'fast'); ?> onclick="updateEffectSpeed(this)" />
			<?php _e('Fast', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_speed]" value="normal"<?php $this->checked($this->options['effect_speed'], 'normal'); ?> onclick="updateEffectSpeed(this)" />
			<?php _e('Normal', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_speed]" value="slow"<?php $this->checked($this->options['effect_speed'], 'slow'); ?> onclick="updateEffectSpeed(this)" />
			<?php _e('Slow', 'auto-thickbox'); ?></label>
			<label class="item"><input type="radio" name="auto-thickbox-plus[effect_speed]" value="number"<?php $this->checked($effect_speed_num); ?> onclick="updateEffectSpeed(this)" />
				<input type="text" name="auto-thickbox-plus[effect_speed]" value="<?php echo $effect_speed; ?>"<?php $this->disabled(!$effect_speed_num); ?> class="small-text" /> ms</label>
		</td>
	</tr>
</table>
<?php
	}

	/**
	 * XXX: disabled() function is from WordPress 3.0
	 * @see /wp-includes/general-template.php
	 */
	function disabled( $disabled, $current = true, $echo = true ) {
		if (function_exists( 'disabled' ))
			return disabled( $disabled, $current, $echo );
		else if (function_exists( '__checked_selected_helper' ))
			return __checked_selected_helper( $disabled, $current, $echo, 'disabled' );

		$result = $disabled == $current ? " disabled='disabled'" : '';
		if ( $echo ) echo $result;
		return $result;
	}
	function checked( $checked, $current = true, $echo = true ) {
		if ( version_compare('2.8', get_bloginfo('version')) > 0 )
			checked( $checked, $current );
		else
			return checked( $checked, $current, $echo );
	}

	// @return void (echo esc_attr())
	function esc_attr( $text ) {
		echo function_exists( 'esc_attr' ) ? esc_attr( $text ) : attribute_escape( $text );
	}
	function esc_attr_e( $text, $domain ) {
		if (function_exists( 'esc_attr_e' ))
			esc_attr_e( $text, $domain );
		else
			echo attribute_escape( __( $text, $domain ) );
	}

	var $base;
	var $base_dir;
	var $options, $options_def;
	var $texts;
	var $has_slider;

	function auto_thickbox_options(&$auto_thickbox) {
		$this->__construct($auto_thickbox); // for PHP4
	}

	function __construct(&$auto_thickbox) {
		add_action('admin_menu', array(&$this, 'register_options_page'));
		add_action('admin_init', array(&$this, 'register_options'));
		add_action('admin_print_scripts-settings_page_auto-thickbox-plus', array(&$this, 'register_scripts'));
		add_action('admin_print_styles-settings_page_auto-thickbox-plus', array(&$this, 'register_styles'));

		$this->base = &$auto_thickbox;
		$this->base_dir = &$auto_thickbox->base_dir;

		$this->options_def = &$auto_thickbox->options_def;
		$this->options = &$auto_thickbox->options;
		$this->texts = &$auto_thickbox->texts;
	}

	function register_options() {
		register_setting( 'auto-thickbox-plus-options', 'auto-thickbox-plus', array(&$this, 'options_callback') );
	}

	var $checkboxes = array('auto_resize', 'builtin_res',
		'drag_img_move', 'drag_img_resize',
		'drag_content_move', 'drag_content_resize',
		'key_close_esc', 'key_close_enter',
		'key_prev_angle', 'key_prev_left', 'key_prev_tab', 'key_prev_space', 'key_prev_bs',
		'key_next_angle', 'key_next_right', 'key_next_tab', 'key_next_space',
		'key_end_home_end');

	function options_callback($options) {
		if (isset($_POST['reset'])) return $this->options_def;
		foreach ($this->checkboxes as $checkbox) {
			if (!isset($options[$checkbox]))
				$options[$checkbox] = 'off';
		}
		return $options;
	}
} # auto_thickbox_options

?>
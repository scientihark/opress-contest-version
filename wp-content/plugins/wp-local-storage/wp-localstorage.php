<?php
/*
 * Plugin Name: WP-localStorage
 * Plugin URI: http://www.xhtmlweaver.com 
 * Description: WP LOCAL Storage
 * Version: 1.0
 */

require_once(dirname(__FILE__).'/func/function.php');
function WPLS_the_options() {
?>
<div class="wrap">
	<div class="icon32" id="icon-options-general"><br></div>
	<h2>WP-localStorage options</h2>

	<form method="post" action="options.php">
		<?php wp_nonce_field('update-options'); ?>
		<h3>WP-localStorage configure</h3>
		<table class="form-table">
		<tr valign="top">
			<th scope="row">Store the comment?</th>
			<td>
				<input name="WPLS_storecomment" type="checkbox" value="checkbox" <?php if(get_option("WPLS_storecomment")) echo "checked='checked'"; ?>/>
				<label style="margin-left:3px;" class="description">Store comment</label>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Store the post?</th>
			<td>
				<input name="WPLS_storepost" type="checkbox" value="checkbox" <?php if(get_option("WPLS_storepost")) echo "checked='checked'"; ?>/>
				<label style="margin-left:3px;" class="description">Store post</label>
			</td>
		</tr>
		</table>
		<input type="hidden" name="action" value="update" />
		<input type="hidden" name="page_options" value="WPLS_storecomment,WPLS_storepost" />

		<p class="submit">
			<input type="submit" name="Submit" class="button-primary" value="Save Change" />
		</p>
	</form>
</div>
<?php
}
?>

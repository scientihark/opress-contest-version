
<div class="wrap">
<div id="icon-themes" class="icon32"><br /></div>
<h2><?php echo PADD_THEME_NAME; ?> Options</h2>

<form method="post" id="padd-theme-admin-options" action="themes.php?page=options-functions.php">

	<div id="padd-admin-tabs">

		<ul>
			<li><a href="#padd-admin-tab-general">General</a></li>
			<li><a href="#padd-admin-tab-tracker">Page Tracker</a></li>
			<li><a href="#padd-admin-tab-sn">Social Networking</a></li>
			<?php if (!function_exists('related_posts')) : ?>
			<li><a href="#padd-admin-tab-relatedposts">Related Posts</a></li>
			<?php endif; ?>
			<li><a href="#padd-admin-tab-pagenav">Page Navigation</a></li>
			<li><a href="#padd-admin-tab-ads-custom">Custom Ads</a></li>
		</ul>

		<fieldset id="padd-admin-tab-general">
			<h3>General Settings</h3>
			<p>General settings for <?php echo PADD_THEME_NAME; ?> theme to work.</p>
			<table class="form-table">
			<?php
				foreach ($padd_options['general'] as $opt) {
					$opt->set_value(get_option($opt->get_keyword()));
					echo $opt;
				}
			?>
			</table>
		</fieldset>
		
		<fieldset id="padd-admin-tab-tracker">
			<h3>Page Tracker Settings</h3>
			<p>Page tracker options for <?php echo PADD_THEME_NAME; ?> theme.</p>
			<table class="form-table">
			<?php
				foreach ($padd_options['tracker'] as $opt) {
					$opt->set_value(get_option($opt->get_keyword()));
					echo $opt;
				}
			?>
			</table>
		</fieldset>

		<fieldset id="padd-admin-tab-sn">
			<h3>Social Networking</h3>
			<p>Social networking settings for <?php echo PADD_THEME_NAME; ?> theme to work.</p>
			<table class="form-table">
			<?php
				foreach ($padd_options['socialnetwork'] as $opt) {
					echo $opt;
				}
			?>
			</table>
		</fieldset>
		
		<?php if (!function_exists('related_posts')) : ?>
		<fieldset id="padd-admin-tab-relatedposts">
			<h3>Related Posts</h3>
			<p>Related posts options for <?php echo PADD_THEME_NAME; ?> theme.</p>
			<table class="form-table">
			<?php
				foreach ($padd_options['relatedposts'] as $opt) {
					$opt->set_value(get_option($opt->get_keyword()));
					echo $opt;
				}
			?>
			</table>
		</fieldset>
		<?php endif; ?>
		
		<fieldset id="padd-admin-tab-pagenav">
			<h3>Page Navigation Options</h3>
			<p>Page navigation options for <?php echo PADD_THEME_NAME; ?> theme.</p>
			<table class="form-table">
			<?php
				foreach ($padd_options['pagenav'] as $opt) {
					$opt->set_value(get_option($opt->get_keyword()));
					echo $opt;
				}
			?>
			</table>
		</fieldset>
		
		<fieldset id="padd-admin-tab-ads-custom">
			<h3>Custom Advertisement Settings</h3>
			<p>You can make your own advertisement in this settings.</p>
			<table class="form-table">
			<?php
				foreach ($padd_options['advertisements'] as $opt) {
					$opt->set_value(get_option($opt->get_keyword()));
					echo $opt;
				}
			?>
			</table>
		</fieldset>
		
	</div>

	<p class="submit">
		<button class="button button-primary" name="action" type="submit" value="save">Save Settings</button>
	</p>
</form>


</div>


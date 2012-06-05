<?php
/*
Plugin Name: BP Profile Search
Plugin URI: http://www.blogsweek.com/bp-profile-search/
Description: Search BuddyPress extended profiles.
Version: 3.0
Author: Andrea Tarantini
Author URI: http://www.blogsweek.com/
*/

include 'bps-functions.php';

register_activation_hook (__FILE__, 'bps_activate');
function bps_activate ()
{
	bps_set_default_options ();
	return true;
}

add_action ('init', 'bps_init');
function bps_init ()
{
	global $bps_options;

	$bps_options = get_option ('bps_options');
	if ($bps_options == false)  bps_set_default_options ();
	return true;
}

add_action (is_multisite ()? 'network_admin_menu': 'admin_menu', 'bps_add_pages', 20);
function bps_add_pages ()
{
	add_submenu_page ('bp-general-settings', 'Profile Search Setup', 'Profile Search', 'manage_options', 'bp-profile-search', 'bps_admin');
	return true;
}

function bps_set_default_options ()
{
	global $bps_options;

	$bps_options['header'] = '<h4>Advanced Search</h4>';
	$bps_options['show'] = array ('Enabled');
	$bps_options['message'] = 'Toggle Form';
	$bps_options['fields'] = array ();
	$bps_options['agerange'] = 0;
	$bps_options['agelabel'] = 'Age Range';
	$bps_options['agedesc'] = 'minimum and maximum age';
	$bps_options['searchmode'] = 'Partial Match';
	$bps_options['filtered'] = 1;

	update_option ('bps_options', $bps_options);
	return true;
}

function bps_admin ()
{
	$tabs = array ('main' => 'Form Configuration', 'options' => 'Advanced Options', );

	$tab = $_GET['tab'];
	if (empty ($tab) || !isset ($tabs[$tab]))  $tab = 'main';
?>

<div class="wrap">
  
  <h2><?php echo esc_html ('Profile Search Setup'); ?></h2>

  <ul class="subsubsub">
<?php
	foreach ($tabs as $action => $text)
	{
		$sep = (end ($tabs) != $text)? ' | ' : '';
		$class = ($action == $tab)? ' class="current"' : '';
		$href = add_query_arg ('tab', $action);
		echo "\t\t<li><a href='$href'$class>$text</a>$sep</li>\n";
	}
?>
  </ul>
  <br class="clear" />

<?php
	$function = 'bps_admin_'. $tab;
	$function ();
?>
</div>
<?php
}

function bps_admin_main ()
{
	global $bps_options;

	if ($_POST['action'] == 'update')
	{
		bps_set_options (array ('header', 'show', 'message', 'fields', 'agerange', 'agelabel', 'agedesc'));
		$message = "Settings saved.";
	}
?>

<?php if ($message) : ?>
  <div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php endif; ?>

  <form method="post" action="">
	<?php wp_nonce_field ('bps_admin_main'); ?>
	<input type="hidden" name="action" value="update" />
	
	<h3>Form Header and Fields</h3>

	<p>Select the header text and the profile fields to include in your search form.</p>
	<p>After you configure your form, you can display it:
	<ul>
	<li>a) In a post or page, using the shortcode <strong>[bp_profile_search_form]</strong></li>
	<li>b) In a sidebar or widget area, using the <em>BP Profile Search</em> widget</li>
	<li>c) In your template files, e.g. in your Members Directory page, using the code <strong>&lt;?php do_action ('bp_profile_search_form'); ?&gt;</strong></li>
	</ul>
	Please note that the Form Header and the Toggle Form feature apply to case c) only.<br/>See <em>readme.txt</em> for more detailed instructions.</p>	

	<table class="form-table">
	<tr valign="top"><th scope="row">Search Form Header:</th><td>
		<textarea name="bps_options[header]" class="large-text code" rows="4"><?php echo $bps_options['header']; ?></textarea>
	</td></tr>
	<tr valign="top"><th scope="row">Toggle Form:</th><td>
		<label><input type="checkbox" name="bps_options[show][]" value="Enabled"<?php if (in_array ('Enabled', (array)$bps_options['show'])) echo ' checked="checked"'; ?> /> Enabled</label><br />
	</td></tr>
	<tr valign="top"><th scope="row">Toggle Form Message:</th><td>
		<input type="text" name="bps_options[message]" value="<?php echo $bps_options['message']; ?>"  />
	</td></tr>
	<tr valign="top"><th scope="row">Selected Profile Fields:</th><td>
		<?php bps_fields ('bps_options[fields]', $bps_options['fields']); ?>
	</td></tr>
	</table>
	
	<h3>Age Range Search</h3>

	<p>If your extended profiles include a birth date field, your search form can include the Age Range Search option. To enable this option, select the birth date field below.</p>	

	<table class="form-table">
	<tr valign="top"><th scope="row">Birth Date Field:</th><td>
		<?php bps_agerange ('bps_options[agerange]', $bps_options['agerange']); ?>
	</td></tr>
	<tr valign="top"><th scope="row">Search Field Label:</th><td>
		<input type="text" name="bps_options[agelabel]" value="<?php echo $bps_options['agelabel']; ?>"  />
	</td></tr>
	<tr valign="top"><th scope="row">Search Field Description:</th><td>
		<input type="text" name="bps_options[agedesc]" value="<?php echo $bps_options['agedesc']; ?>" class="large-text" />
	</td></tr>
	</table>

	<p class="submit">
	  <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
  </form>

<?php
}

function bps_admin_options ()
{
	global $bps_options;

	if ($_POST['action'] == 'update')
	{
		bps_set_options (array ('searchmode', 'filtered'));
		$message = "Settings saved.";
	}
?>

<?php if ($message) : ?>
  <div id="message" class="updated fade"><p><?php echo $message; ?></p></div>
<?php endif; ?>

  <form method="post" action="">
	<?php wp_nonce_field ('bps_admin_options'); ?>
	<input type="hidden" name="action" value="update" />
	
	<h3>Text Search Mode</h3>

	<p>Select your text search mode here. Choose between partial match (a search for <i>John</i> matches <i>John</i>, <i>Johnson</i>, <i>Long John Silver</i>, and so on) and exact match (a search for <i>John</i> matches <i>John</i> only). In both modes the wildcard characters <i>% (percent sign)</i>, matching zero or more characters, and <i>_ (underscore)</i>, matching exactly one character, may be used.</p>	

	<table class="form-table">
	<tr valign="top"><th scope="row">Text Search Mode:</th><td>
		<label><input type="radio" name="bps_options[searchmode]" value="Partial Match"<?php if ('Partial Match' == $bps_options['searchmode']) echo ' checked="checked"'; ?> /> Partial Match</label><br />
		<label><input type="radio" name="bps_options[searchmode]" value="Exact Match"<?php if ('Exact Match' == $bps_options['searchmode']) echo ' checked="checked"'; ?> /> Exact Match</label><br />
	</td></tr>
	</table>
	
	<h3>Filtered Members List</h3>

	<p>BP Profile Search filters the members list in your Members Directory page. Usually there is only one members list in that page, but sometimes widgets or other plugins add more lists, so you have to tell BP Profile Search which is the list to filter. If your searches always return the full members directory, try changing this number here.</p>	

	<table class="form-table">
	<tr valign="top"><th scope="row">Filtered Members List:</th><td>
		<select name="bps_options[filtered]">
		<option value="1"<?php if ('1' == $bps_options['filtered']) echo ' selected="selected"'; ?>>1&nbsp;</option>
		<option value="2"<?php if ('2' == $bps_options['filtered']) echo ' selected="selected"'; ?>>2&nbsp;</option>
		<option value="3"<?php if ('3' == $bps_options['filtered']) echo ' selected="selected"'; ?>>3&nbsp;</option>
		<option value="4"<?php if ('4' == $bps_options['filtered']) echo ' selected="selected"'; ?>>4&nbsp;</option>
		</select>
	</td></tr>
	</table>

	<p class="submit">
	  <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>
  </form>

<?php
}

function bps_set_options ($vars)
{
	global $bps_options;

	foreach ($vars as $var)
		$bps_options[$var] = stripslashes_deep ($_POST['bps_options'][$var]);

	update_option ('bps_options', $bps_options);
}

function bps_get_vars ($vars)
{
	foreach ($vars as $var)
	{
		global $$var;

		if (empty ($_POST["$var"]))
			$$var = empty ($_GET["$var"])? '': $_GET["$var"];
		else
			$$var = $_POST["$var"];
		
		$$var = stripslashes_deep ($$var);
	}
}
?>

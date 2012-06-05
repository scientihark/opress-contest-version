<?php
include 'bps-searchform.php';

function bps_fields ($name, $values)
{
	global $field;
	global $dateboxes;

	if (bp_is_active ('xprofile')) : 
	if (function_exists ('bp_has_profile')) : 
		if (bp_has_profile ('hide_empty_fields=0')) :
			$dateboxes = array ();
			$dateboxes[0] = '';

			while (bp_profile_groups ()) : 
				bp_the_profile_group (); 

				echo '<strong>'. bp_get_the_profile_group_name (). ':</strong><br />';

				while (bp_profile_fields ()) : 
					bp_the_profile_field(); 
					switch (bp_get_the_profile_field_type ())
					{
					case 'datebox':	
						$disabled = 'disabled="disabled"';
						$dateboxes[bp_get_the_profile_field_id ()] = bp_get_the_profile_field_name ();
						break;
					default:
						$disabled = '';
						break;
					}
?>
<label><input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $field->id; ?>" <?php echo $disabled; ?>
<?php if (in_array ($field->id, (array)$values))  echo ' checked="checked"'; ?> />
<?php bp_the_profile_field_name(); ?>
<?php if (bp_get_the_profile_field_is_required ()) 
	_e (' (required) ', 'buddypress');
else
	_e (' (optional) ', 'buddypress'); ?>
<?php bp_the_profile_field_description (); ?></label><br />

<?php 			endwhile;
			endwhile; 
		endif;
	endif; 
	endif;

	return true;
}

function bps_agerange ($name, $value)
{
	global $dateboxes;

	if (count ($dateboxes) > 1)
	{
		echo "<select name=\"$name\">\n";
		foreach ($dateboxes as $fid => $fname)
		{
			echo "<option value=\"$fid\"";
			if ($fid == $value)  echo " selected=\"selected\"";
			echo ">$fname &nbsp;</option>\n";
		}
		echo "</select>\n";
	}
	else
		echo 'There is no date field in your profile';

	return true;
}

add_filter ('bp_core_get_users', 'bps_search', 99, 2);
function bps_search ($results, $params)
{
	global $bp;
	global $wpdb;
	global $bps_list;
	global $bps_options;

	if ($_POST['bp_profile_search'] != true)  return $results;

	$bps_list += 1;
	if ($bps_list != $bps_options['filtered'])  return $results;

	$noresults['users'] = array ();
	$noresults['total'] = 0;

	$emptyform = true;

	if (bp_has_profile ('hide_empty_fields=0')):
		while (bp_profile_groups ()):
			bp_the_profile_group ();
			while (bp_profile_fields ()): 
				bp_the_profile_field ();

				$id = bp_get_the_profile_field_id ();
				$value = $_POST["field_$id"];
				$to = $_POST["field_{$id}_to"];

				if ($value == '' && $to == '')  continue;

				switch (bp_get_the_profile_field_type ())
				{
				case 'textbox':
				case 'textarea':
					$sql = "SELECT user_id from {$bp->profile->table_name_data}";
					if ($bps_options['searchmode'] == 'Partial Match')
						$sql .= " WHERE field_id = $id AND value LIKE '%%$value%%'";
					else					
						$sql .= " WHERE field_id = $id AND value LIKE '$value'";
					break;

				case 'selectbox':
				case 'radio':
					$sql = "SELECT user_id from {$bp->profile->table_name_data}";
					$sql .= " WHERE field_id = $id AND value = '$value'";
					break;

				case 'multiselectbox':
				case 'checkbox':
					$sql = "SELECT user_id from {$bp->profile->table_name_data}";
					$sql .= " WHERE field_id = $id";
					$like = array ();
					foreach ($value as $curvalue)
						$like[] = "value LIKE '%\"$curvalue\"%'";
					$sql .= ' AND ('. implode (' OR ', $like). ')';	
					break;

				case 'datebox':
					if ($id != $bps_options['agerange']) continue;

					$time = time ();
					$day = date ("j", $time);
					$month = date ("n", $time);
					$year = date ("Y", $time);
					$ymin = $year - $to - 1;
					$ymax = $year - $value;

					$sql = "SELECT user_id from {$bp->profile->table_name_data}";
					$sql .= " WHERE field_id = $id AND value > '$ymin-$month-$day' AND value <= '$ymax-$month-$day'";
					break;
				}

				$found = $wpdb->get_results ($sql);
				if (!is_array ($userids)) 
					$userids = bps_conv ($found, 'user_id');
				else
					$userids = array_intersect ($userids, bps_conv ($found, 'user_id'));

				if (count ($userids) == 0)  return $noresults;
				$emptyform = false;

			endwhile;
		endwhile;
	endif;

	if ($emptyform == true)  return $noresults;

	remove_filter ('bp_core_get_users', 'bps_search', 99, 2);

	$params['per_page'] = count ($userids);
	$params['include'] = $wpdb->escape (implode (',', $userids));
	$results = bp_core_get_users ($params);

	return $results;
}

function bps_conv ($objects, $field)
{
	$array = array ();

	foreach ($objects as $object)
		$array[] = $object->$field;

	return $array;	
}

add_shortcode ('bp_profile_search_form', 'bps_shortcode');
function bps_shortcode ($attr, $content)
{
	ob_start ();
	bps_form ('bps_shortcode');
	return ob_get_clean ();
}

class bps_widget extends WP_Widget
{
	function bps_widget ()
	{
		$widget_ops = array ('description' => 'Your BP Profile Search form');
		$this->WP_Widget ('bp_profile_search', 'BP Profile Search', $widget_ops);
	}

	function widget ($args, $instance)
	{
		extract ($args);
		$title = apply_filters ('widget_title', esc_attr ($instance['title']));
	
		echo $before_widget;
		if ($title)
			echo $before_title. $title. $after_title;
		bps_form ('bps_widget');
		echo $after_widget;
	}

	function update ($new_instance, $old_instance)
	{
		$instance = $old_instance;
		$instance['title'] = strip_tags ($new_instance['title']);
		return $instance;
	}

	function form ($instance)
	{
		$title = strip_tags ($instance['title']);
	?>
		<p>
		<label for="<?php echo $this->get_field_id ('title'); ?>"><?php _e ('Title:', 'wpm'); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id ('title'); ?>" name="<?php echo $this->get_field_name ('title'); ?>" type="text" value="<?php echo esc_attr ($title); ?>" />
		</p>
	<?php
	}
}

add_action ('widgets_init', 'bps_widget_init');
function bps_widget_init ()
{
	register_widget ('bps_widget');
}
?>

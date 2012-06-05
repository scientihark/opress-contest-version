<?php

add_action ('bp_profile_search_form', 'bps_form');
function bps_form ($form_id)
{
	global $field;
	global $bps_options;

	$action = bp_get_root_domain (). '/'. bp_get_members_root_slug (). '/';

	if ($form_id == '')
	{
	$form_id = 'bps_action';
?>	
	<div class="item-list-tabs">
	<ul>
	<li><?php echo $bps_options['header']; ?></li>
<?php if (in_array ('Enabled', (array)$bps_options['show'])) { ?>
	<li class="last">
	<input id="bps_show" type="submit" value="<?php echo $bps_options['message']; ?>" />
	</li>
<?php } ?>
	</ul>
<?php if (in_array ('Enabled', (array)$bps_options['show'])) { ?>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('#bps_action').hide();
		$('#bps_show').click(function(){
			$('#bps_action').toggle();
		});
	});
</script>
<?php } ?>
</div>
<?php
	}

echo "<form action='$action' method='post' id='$form_id' class='standard-form'>";

	if (bp_has_profile ('hide_empty_fields=0'))  while (bp_profile_groups ())
	{
		bp_the_profile_group ();
		while (bp_profile_fields ())
		{
			bp_the_profile_field ();
			$fname = 'field_'. $field->id;
			$posted = $_POST[$fname];
			$posted_to = $_POST[$fname. '_to'];

			if ($field->id == $bps_options['agerange'])
			{
				$from = ($posted == '' && $posted_to == '')? '': (int)$posted;
				$to = ($posted_to == '')? $from: (int)$posted_to;
				if ($to < $from)  $to = $from;

echo '<div '. bp_get_field_css_class ('editfield'). '>';
echo "<label for='$fname'>{$bps_options['agelabel']}</label>";
echo "<input style='width: 10%;' type='text' name='$fname' value='$from' />";
echo '&nbsp;-&nbsp;';
echo "<input style='width: 10%;' type='text' name='{$fname}_to' value='$to' />";
echo "<p class='description'>{$bps_options['agedesc']}</p>";
echo '</div>';
			}

			if (!in_array ($field->id, (array)$bps_options['fields']))  continue;

echo '<div '. bp_get_field_css_class ('editfield'). '>';

			if (!method_exists ($field, 'get_children'))
				$field = new BP_XProfile_Field ($field->id);
			$options = $field->get_children ();

			switch (bp_get_the_profile_field_type ())
			{
			case 'textbox':
echo "<label for='$fname'>$field->name</label>";
echo "<input type='text' name='$fname' id='$fname' value='$posted' />";
			break;

			case 'textarea':
echo "<label for='$fname'>$field->name</label>";
echo "<textarea rows='5' cols='40' name='$fname' id='$fname'>$posted</textarea>";
			break;

			case 'selectbox':
echo "<label for='$fname'>$field->name</label>";
echo "<select name='$fname' id='$fname'>";
echo "<option value=''></option>";

			foreach ($options as $option)
			{
				$selected = ($option->name == $posted)? "selected='selected'": "";
echo "<option $selected value='$option->name'>$option->name</option>";
			}
echo "</select>";
			break;

			case 'multiselectbox':
echo "<label for='$fname'>$field->name</label>";
echo "<select name='{$fname}[]' id='$fname' multiple='multiple'>";

			foreach ($options as $option)
			{
				$selected = (in_array ($option->name, (array)$posted))? "selected='selected'": "";
echo "<option $selected value='$option->name'>$option->name</option>";
			}
echo "</select>";
			break;

			case 'radio':
echo "<div class='radio'>";
echo "<span class='label'>$field->name</span>";
echo "<div id='$fname'>";

			foreach ($options as $option)
			{
				$selected = ($option->name == $posted)? "checked='checked'": "";
echo "<label><input $selected type='radio' name='$fname' value='$option->name'>$option->name</label>";
			}
echo '</div>';
echo "<a class='clear-value' href='javascript:clear(\"$fname\");'>". __('Clear', 'buddypress'). "</a>";
echo '</div>';
			break;

			case 'checkbox':
echo "<div class='checkbox'>";
echo "<span class='label'>$field->name</span>";

			foreach ($options as $option)
			{
				$selected = (in_array ($option->name, (array)$posted))? "checked='checked'": "";
echo "<label><input $selected type='checkbox' name='{$fname}[]' value='$option->name'>$option->name</label>";
			}
echo '</div>';
			break;
			}

echo '</div>';
		}
	}

echo "<div class='submit'>";
echo "<input type='submit' value='". __('Search', 'buddypress'). "' />";
echo '</div>';
echo "<input type='hidden' name='bp_profile_search' value='true' />";
echo "<input type='hidden' name='num' value='9999' />";
echo '</form>';
}
?>

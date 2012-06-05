<?php
$base_name = plugin_basename('wp-clap/options.php');
$base_page = 'admin.php?page='.$base_name;
$text = '';

if(isset($_POST['submit'])) {
	$options['name']            = $_POST['name'];
	$options['uname']           = stripslashes( $_POST['uname'] );
	$options['avatar']          = $_POST['avatar'];
	$options['avatar_file']     = stripslashes( $_POST['avatar_file'] );
	$options['avatar_size']     = stripslashes( $_POST['avatar_size'] );
	$options['frequency']       = $_POST['frequency'];
	$options['before_f']        = stripslashes( $_POST['before_f'] );
	$options['after_f']         = stripslashes( $_POST['after_f'] );
	$options['d_home']          = $_POST['d_home'];
	$options['d_post']          = $_POST['d_post'];
	$options['d_page']          = $_POST['d_page'];
	$options['d_f']             = $_POST['d_f'];
	$options['d_f_nopage']      = $_POST['d_f_nopage'];
	$options['d_no_pages']      = $_POST['d_no_pages'];
	$options['title_container'] = stripslashes( $_POST['title_container'] );
	$options['title_text']      = stripslashes( $_POST['title_text'] );
	$options['text']            = stripslashes( $_POST['text'] );
	$options['text_loading']    = stripslashes( $_POST['text_loading'] );
	$options['text_done']       = stripslashes( $_POST['text_done'] );
	$options['text_img']        = stripslashes( $_POST['text_img'] );
	$options['text_notice']     = stripslashes( $_POST['text_notice'] );
	$options['css']             = $_POST['css'];
	$options['admin_claps']     = $_POST['admin_claps'];
	$options['admin_clappers']  = $_POST['admin_clappers'];
	$options['admin_average_claps'] = $_POST['admin_average_claps'];
	$options['clp_html']        = stripslashes( $_POST['clp_html'] );
	if ($options['name'] == '')          { $options['name'] = false; }        else { $options['name'] = true; }
	if ($options['avatar'] == '')        { $options['avatar'] = false; }      else { $options['avatar'] = true; }
	if ($options['frequency'] == '')     { $options['frequency'] = false; }   else { $options['frequency'] = true; }
	if ($options['d_home'] == '')        { $options['d_home'] = false; }      else { $options['d_home'] = true; }
	if ($options['d_post'] == '')        { $options['d_post'] = false; }      else { $options['d_post'] = true; }
	if ($options['d_page'] == '')        { $options['d_page'] = false; }      else { $options['d_page'] = true; }
	if ($options['d_f'] == '')           { $options['d_f'] = false; }         else { $options['d_f'] = true; }
	if ($options['d_f_nopage'] == '')    { $options['d_f_nopage'] = false; }  else { $options['d_f_nopage'] = true; }
	if ($options['css'] == '')           { $options['css'] = false; }         else { $options['css'] = true; }
	if ($options['admin_claps'] == '')   { $options['admin_claps'] = false; } else { $options['admin_claps'] = true; }
	if ($options['admin_clappers'] == '') { $options['admin_clappers'] = false; } else { $options['admin_clappers'] = true; }
	if ($options['admin_average_claps'] == '')           { $options['admin_average_claps'] = false; }       else { $options['admin_average_claps'] = true; }
	if ($options['avatar_size'] < 8)  { $options['avatar_size'] = 8; }
	if ($options['avatar_size'] > 96) { $options['avatar_size'] > 96; }
	if (trim(str_replace(array("\r\n", "\n", "\r"),'',$options['clp_html']))=='') {
		$options['clp_html'] = clp_default_html();
	}
	update_option('wp_clap', $options);
	$text .= '<font color="green">'.__('Settings saved.', 'wp-clap').'</font>';
}

$options = clp_getoptions();
?>
<div class="wrap">

	<?php screen_icon(); ?>
	
    <h2><?php _e('WP Clap Options', 'wp-clap'); ?></h2>
    
    <?php if(!empty($text)) { echo '<!-- Last Action --><div id="message" class="updated fade"><p>'.$text.'</p></div>'; } ?>
        
    <form method="post" action="<?php echo site_url(); ?>/wp-admin/options-general.php?page=<?php echo plugin_basename(__FILE__); ?>">
    
    <h3><?php _e('Clapper', 'wp-clap'); ?></h3>
    
    <table class="form-table">
      <tr>
        <th scope="row" valign="top">
          <?php _e('Show Name', 'wp-clap'); ?>
        </th>
        <td><input name="name" type="checkbox" id="name" value="true"<?php if($options['name'] == true) { echo ' checked="checked"'; } ?> /></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Default Name', 'wp-clap'); ?>
        </th>
        <td><input name="uname" type="text" id="uname" value="<?php echo $options['uname']; ?>" size="50" /></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Show Avatar', 'wp-clap'); ?>
        </th>
        <td><input name="avatar" type="checkbox" id="avatar" value="true"<?php if($options['avatar'] == true) { echo ' checked="checked"'; } ?> /></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Default Avatar(URL)', 'wp-clap'); ?>
        </th>
        <td><input name="avatar_file" type="text" id="avatar_file" value="<?php echo $options['avatar_file']; ?>" size="50" /></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Avatar Size', 'wp-clap'); ?>
        </th>
        <td><input name="avatar_size" type="text" id="avatar_size" value="<?php echo $options['avatar_size']; ?>" size="5" /> <?php _e('(8 to 96)', 'wp-clap'); ?></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Frequency', 'wp-clap'); ?>
        </th>
        <td>
        	<input name="frequency" type="checkbox" id="frequency" value="true"<?php if($options['frequency'] == true) { echo ' checked="checked"'; } ?> /> <label for="frequency"><?php _e('Show Frequency', 'wp-clap'); ?></label>&nbsp;&nbsp;&nbsp;&nbsp;
        	<label for="before_f"><?php _e('Before Frequency', 'wp-clap'); ?></label> <input name="before_f" type="text" id="before_f" value="<?php echo $options['before_f']; ?>" size="5" />&nbsp;&nbsp;&nbsp;&nbsp;
            <label for="after_f"><?php _e('After Frequency', 'wp-clap'); ?></label> <input name="after_f" type="text" id="after_f" value="<?php echo $options['after_f']; ?>" size="5" />
        </td>
      </tr>
    </table>
    
    <h3><?php _e('Clap Area', 'wp-clap'); ?></h3>
    
    <table class="form-table">
      <tr>
        <th scope="row" valign="top">
          <?php _e('Title', 'wp-clap'); ?>
        </th>
        <td>
			<label for="title_text"><?php _e('Title', 'wp-clap'); ?></label> <input name="title_text" type="text" id="title_text" value="<?php echo $options['title_text']; ?>" size="22" />&nbsp;&nbsp;&nbsp;&nbsp;
			<label for="title_container"><?php _e('Container', 'wp-clap'); ?></label> <input name="title_container" type="text" id="title_container" value="<?php echo $options['title_container']; ?>" size="5" />
		</td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Clap Text', 'wp-clap'); ?>
        </th>
        <td><input name="text" type="text" id="text" value="<?php echo $options['text']; ?>" size="50" /></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Clapping Text', 'wp-clap'); ?>
        </th>
        <td><input name="text_loading" type="text" id="text_loading" value="<?php echo $options['text_loading']; ?>" size="50" /></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Clapped Text', 'wp-clap'); ?>
        </th>
        <td><input name="text_done" type="text" id="text_done" value="<?php echo $options['text_done']; ?>" size="50" /></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Clap Image(URL)', 'wp-clap'); ?>
        </th>
        <td>
        	<input name="text_img" type="text" id="text_img" value="<?php echo $options['text_img']; ?>" size="50" /><br/>
        	<?php _e('Use a image with the clap link.', 'wp-clap'); ?>
        </td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Notice', 'wp-clap'); ?>
        </th>
        <td>
        	<textarea name="text_notice" cols="50" rows="6" id="text_notice" class="code"><?php echo $options['text_notice']; ?></textarea>
            <p><?php _e('You can use those tags to show the clap frequency:<br/> <strong>%clap_f%</strong> total calps<br/> <strong>%clap_f_s%</strong> clappers<br/>  <strong>%clap_f_ave%</strong> average claps.', 'wp-clap'); ?></p>
        </td>
      </tr>
    </table>
    
    <h3><?php _e('Miscellaneous', 'wp-clap'); ?></h3>
    
    <table class="form-table">
      <tr>
        <th scope="row" valign="top"><?php _e('Style', 'wp-clap'); ?></th>
        <td><input name="css" type="checkbox" id="css" value="true"<?php if($options['css'] == true) { echo ' checked="checked"'; } ?> /> <label for="css"><?php _e('Use my own style instead of the default style.(Remove the default wp-clap-style.css)', 'wp-clap'); ?></label></td>
      </tr>
      <tr>
        <th scope="row" valign="top">
          <?php _e('Display', 'wp-clap'); ?>
        </th>
        <td>
			<input name="d_home" type="checkbox" id="d_home" value="true"<?php if($options['d_home'] == true) { echo ' checked="checked"'; } ?> /> <label for="d_home"><?php _e('on home', 'wp-clap'); ?></label>&nbsp;&nbsp;
			<input name="d_post" type="checkbox" id="d_post" value="true"<?php if($options['d_post'] == true) { echo ' checked="checked"'; } ?> /> <label for="d_post"><?php _e('on single post', 'wp-clap'); ?></label>&nbsp;&nbsp;			
			<input name="d_page" type="checkbox" id="d_page" value="true"<?php if($options['d_page'] == true) { echo ' checked="checked"'; } ?> /> <label for="d_page"><?php _e('on page', 'wp-clap'); ?></label> <br/>
			<?php _e('If uncheck these options, please add tag: <strong>&lt;?php wp_clap(); ?&gt;</strong> to anywhere you want.', 'wp-clap'); ?>
			<br/>
			<input name="d_f" type="checkbox" id="d_f" value="true"<?php if($options['d_f'] == true) { echo ' checked="checked"'; } ?> /> <label for="d_f"><?php _e('Auto insert frequency into post and excerpt (right top)', 'wp-clap'); ?></label>&nbsp;&nbsp;
			<input name="d_f_nopage" type="checkbox" id="d_f_nopage" value="true"<?php if($options['d_f_nopage'] == true) { echo ' checked="checked"'; } ?> /> <label for="d_f_nopage"><?php _e('except pages', 'wp-clap'); ?></label>
		</td>
      </tr>
      <tr>
      	<th scope="row" valign="top">&nbsp;</th>
      	<td>
      		<p><?php _e('Do NOT display claps on the following pages:', 'wp-clap'); ?></p>
      		<p>
      			<?php
      			$pages = get_pages();
      			if ($pages) {
      				foreach ($pages as $pagg) {
      					echo '<label><input type="checkbox" name="d_no_pages[]" value="'.$pagg->ID.'" '.(in_array($pagg->ID,(array)$options['d_no_pages'])?'checked="checked"':'').'/> '.$pagg->post_title.'</label><br/>';
      				}
      			} else {
      				_e('No pages.', 'wp-clap');
      			}
      			?>
      		</p>
      	</td>
      </tr>
      <tr>
        <th scope="row" valign="top"><?php _e('Show on Admin', 'wp-clap'); ?></th>
        <td>
			<input name="admin_claps" type="checkbox" id="admin_claps" value="true"<?php if($options['admin_claps'] == true) { echo ' checked="checked"'; } ?> /> <label for="admin_claps"><?php _e('Total claps', 'wp-clap'); ?></label>&nbsp;&nbsp;
			<input name="admin_clappers" type="checkbox" id="admin_clappers" value="true"<?php if($options['admin_clappers'] == true) { echo ' checked="checked"'; } ?> /> <label for="admin_clappers"><?php _e('Total clappers', 'wp-clap'); ?></label>&nbsp;&nbsp;
			<input name="admin_average_claps" type="checkbox" id="admin_average_claps" value="true"<?php if($options['admin_average_claps'] == true) { echo ' checked="checked"'; } ?> /> <label for="admin_average_claps"><?php _e('Average Claps', 'wp-clap'); ?></label> 
		</td>
      </tr>
    </table>
    
    <h3><?php _e('Custom HTML', 'wp-clap'); ?></h3>
    
    <table class="form-table">
      <tr>
        <th scope="row" valign="top">HTML</th>
        <td>
        	<textarea name="clp_html" cols="70" rows="8" id="clp_html" class="code"><?php echo $options['clp_html']; ?></textarea>
        	<p>
        		<?php _e('You can write your own HTML for single clappers.', 'wp-clap'); ?><br/>
        		<?php _e('If you do not know how to use it, leave it alone.', 'wp-clap'); ?><br/>
        		<?php _e('To reset the HTML, simply empty it and save. It will be replaced by the default HTML.', 'wp-clap'); ?><br/>
        		<a href="javascript:void(0);" onclick="ShowCode();"><?php _e('Click here to show the available code', 'wp-clap'); ?></a>
        		<div id="clpHTMLCode" style="display:none;">
        			<ul>
        				<li>(:claps) - <?php _e('claps', 'wp-clap'); ?></li>
        				<li>(:clap_name) - <?php _e("clapper's name", 'wp-clap'); ?></li>
        				<li>(:clap_site) - <?php _e("clapper's site", 'wp-clap'); ?></li>
        				<li>(:clap_email) - <?php _e("clapper's email (MD5 encode)", 'wp-clap'); ?></li>
        				<li>(:before_f) - <?php _e('before frequency', 'wp-clap'); ?></li>
        				<li>(:after_f) - <?php _e('after frequency', 'wp-clap'); ?></li>
        				<li>(:avatar_size) - <?php _e('the size of avatar', 'wp-clap'); ?></li>
        				<li>(:avatar_file) - <?php _e('default avatar', 'wp-clap'); ?></li>
        			</ul>
        		</div>
        	</p>
        </td>
      </tr>
    </table>
    
        
    <table class="form-table">
      <tr>
        <th scope="row" valign="top">&nbsp;</th>
        <td><input name="submit" class="button" value="<?php _e('Save Changes', 'wp-clap'); ?>" type="submit" /></td>
      </tr>
    </table>
    
    </form>
	
	<h3><?php _e('Links', 'wp-clap'); ?></h3>
	
	<p><a href="http://blog.lolily.com/"><?php _e('Visit Author Homepage', 'wp-clap'); ?></a></p>
	<p><a href="http://blog.lolily.com/wordpress-plugin-wp-clap.html"><?php _e('Visit Plugin Homepage', 'wp-clap'); ?></a></p>
</div>
<script type="text/javascript">
function ShowCode(){
	var id = 'clpHTMLCode';
	if (document.getElementById(id).style.display=='none'){
		document.getElementById(id).style.display = "block";
	}else{
		document.getElementById(id).style.display = "none";
	}
}
</script>
<?php
/*
Plugin Name: BuddyPress xProfiles ACL
Plugin URI: http://www.geektantra.com/2011/09/buddypress-xprofiles-acl/
Description: Create access control over BuddyPress Extended Profile Groups. <strong>BuddyPress xProfiles ACL</strong> plugin requires the <strong style="color: #21759B;">BuddyPress</strong> Plugin to be activated and needs <strong style="color: #21759B;">BuddyPress Extended Profiles</strong> component to be enabled.
Version: 0.20.1
Revision Date: November 6, 2011
Requires at least: WP 3.2, BuddyPress 1.2.8
Tested up to: WP 3.2.1, BuddyPress 1.5.1
Author: NetTantra
Author URI: http://www.nettantra.com
Site Wide Only: true
*/

function xpa_load_manage_profile_acls_form_js() {
  wp_enqueue_script('jquery','1.6.2');
}

function xpa_dependencies_unmet_warning() {
  echo '<div class="error fade"><p>'.__('<strong>BuddyPress xProfiles ACL</strong> plugin requires the <strong>BuddyPress</strong> Plugin to be activated and needs <strong>BuddyPress Extended Profiles</strong> component to be enabled.', 'buddypress-xprofiles-acl').'</p></div>';
}

class BPxProfileACL {
  var $groups;
  var $allowed_xprofile_groups;
  var $user_allowed_xprofile_groups;
  function filter_allowed_xprofile_groups($allowed_xprofile_groups) {
    global $wp_roles;
    if(!isset($allowed_xprofile_groups['xprofile_public_groups']) || !is_array($allowed_xprofile_groups['xprofile_public_groups']))
      $allowed_xprofile_groups['xprofile_public_groups'] = array('1');
    if(count($wp_roles->roles) > 0) {
      foreach($wp_roles->roles as $role_key=>$role) {
        if((!is_array($allowed_xprofile_groups)) or !array_key_exists($role_key, $allowed_xprofile_groups)) {
          $allowed_xprofile_groups[$role_key][] = "1";
        }
      }
    }
    return $allowed_xprofile_groups;
  }
  function BPxProfileACL() {
    if(class_exists('BP_XProfile_Group')) {
      $this->groups = BP_XProfile_Group::get();
      $this->allowed_xprofile_groups = (is_array($this->allowed_xprofile_groups)) ? 
                                              $this->allowed_xprofile_groups : 
                                              unserialize(get_option("allowed_xprofile_groups"));
      $this->allowed_xprofile_groups = $this->filter_allowed_xprofile_groups($this->allowed_xprofile_groups);
      global $current_user;
      get_currentuserinfo();
      if($current_user->ID) {
        $this->user_allowed_xprofile_groups = array();
        foreach($current_user->roles as $role_key) {
          $this->user_allowed_xprofile_groups = array_merge($this->user_allowed_xprofile_groups, $this->allowed_xprofile_groups[$role_key]);
        }
      } else {
        $this->user_allowed_xprofile_groups = isset($this->allowed_xprofile_groups['xprofile_public_groups']) ? $this->allowed_xprofile_groups['xprofile_public_groups'] : array('1');
      }
    } else {
      include_once(ABSPATH.'/wp-admin/includes/plugin.php');
      deactivate_plugins(plugin_basename(__FILE__), true);
      add_action('admin_notices', 'xpa_dependencies_unmet_warning');
    }
  }
  function manage_profile_acls_form() {
    global $wp_roles;
    if($_POST['role_key'] and $_POST['profile_group_id']) {
      switch($_POST['action']) {
        case "Add":
          $this_role_key = $_POST['role_key'];
          $this->allowed_xprofile_groups[$this_role_key][] = $_POST['profile_group_id'];
          $this->allowed_xprofile_groups[$this_role_key] = array_unique($this->allowed_xprofile_groups[$this_role_key]);
          update_option("allowed_xprofile_groups", serialize($this->allowed_xprofile_groups));
        break;
        case "Delete":
          if($_POST['profile_group_id'] == "1") {
            echo '<div class="error fade"><p>'.__('The <strong>Base</strong> profile group cannot be removed from a role.', 'buddypress-xprofiles-acl').'</p></div>';
          }else {
            $this_role_key = $_POST['role_key'];
            $profile_group_position = array_search($_POST['profile_group_id'], $this->allowed_xprofile_groups[$this_role_key]);
            unset($this->allowed_xprofile_groups[$this_role_key][$profile_group_position]);
            update_option("allowed_xprofile_groups", serialize($this->allowed_xprofile_groups));
          }
        break;
      }
    }
    ?>
    <script type="text/javascript">
    /* <![CDATA[ */
      jQuery(function(){
        jQuery(".show_add_profile_group_form").click(function(){
          jQuery(this).parents(".xprofile_field_groups:first").find(".add_profile_group_form").fadeIn();
          jQuery(this).hide();
        });
        jQuery(".xprofile_field_groups").find("input[type='reset']").click(function(){
          jQuery(this).parents(".add_profile_group_form:first").hide().parents(".xprofile_field_groups:first").find(".show_add_profile_group_form").show();
        });
        jQuery(".delete_profile_group_id").click(function(){
          var conf = confirm("<?php _e('Are you sure you want to remove this Profile Group from this role?', 'buddypress-xprofiles-acl'); ?>");
          if(conf) jQuery(this).prev("form").submit();
        })
      });
    /* ]]> */
    </script>
    <style type="text/css">
      <!--
      .add_profile_group_form_block { height: 22px; padding: 2px 0px 2px; vertical-align: middle; margin: 2px 0px 0px; }
      .add_profile_group_form { display: none; }
      .show_add_profile_group_form { margin:1px; vertical-align: middle; display: inline-block; }
      .small { font-size: 9px; }
      .profile_groups { float: left; padding: 2px 4px; border: 1px solid #CCC; margin-right: 3px; background: #EEE; font-size: 11px; line-height: 12px; vertical-align: middle; -moz-border-radius: 3px; border-radius: 3px; }
      a.delete_profile_group_id:link,a.delete_profile_group_id:visited { display: inline-block; padding: 2px 3px 2px; line-height: 9px; font-size: 9px; background: #888; color: #fff; font-family: "Comic Sans MS"; font-weight: bold; -moz-border-radius: 3px; border-radius: 3px;  }
      a.delete_profile_group_id:hover { background: #BBB; }
      -->
    </style>
      <div class="wrap">
        <h2><?php _e('Assign Profile Groups to User Roles', 'buddypress-xprofiles-acl'); ?></h2>
        <table class="widefat">
          <thead>
            <tr>
              <th width="150px"><?php _e('Role', 'buddypress-xprofiles-acl'); ?></th>
              <th><?php _e('xProfile Field Groups', 'buddypress-xprofiles-acl'); ?></th>
            </tr>
          </thead>
          <tbody>
            <!-- Public Groups\\ -->
            <tr style="background: #E5F6FF;">
              <td><strong><?php _e('Public xProfiles Groups'); ?></strong></td>
              <td class="xprofile_field_groups">
                <div class="xprofile_field_groups_block">
                  <?php foreach($this->allowed_xprofile_groups['xprofile_public_groups'] as $profile_group_id): ?>
                  <div class="profile_groups">
                  <?php 
                    $this_profile_group = BP_XProfile_Group::get( array('profile_group_id' => $profile_group_id) );
                    $this_profile_group = $this_profile_group[0];
                    echo $this_profile_group->name;
                  ?>
                    <form method="post" action="" style="display:none;">
                      <input type="hidden" name="role_key" value="<?php echo 'xprofile_public_groups'; ?>" />
                      <input type="hidden" name="profile_group_id" value="<?php echo $this_profile_group->id; ?>" />
                      <input type="hidden" name="action" value="Delete" />
                    </form>
                    <a href="javascript:void(0)" class="delete_profile_group_id" title="<?php _e('Remove Profile Group', 'buddypress-xprofiles-acl'); ?>">X</a>
                  </div>
                  <?php endforeach; ?>
                  <div style="clear:both;"></div>
                </div>
                <?php 
                  $this_role_groups = array();
                  foreach($this->groups as $group) { $this_role_groups[] = $group->id; }
                  if( count( array_diff($this_role_groups, $this->allowed_xprofile_groups['xprofile_public_groups']) ) > 0) {
                    $hide_add_profile_group_form_block = false;
                  } else {
                    $hide_add_profile_group_form_block = true;
                  }
                ?>
                <div class="add_profile_group_form_block">
                  <?php if($hide_add_profile_group_form_block): ?>
                  <p class="description"><?php _e('No more groups available', 'buddypress-xprofiles-acl'); ?></p>
                  <?php else: ?>
                  <a href="javascript:void(0)" class="show_add_profile_group_form button"><?php _e('Add', 'buddypress-xprofiles-acl'); ?></a>
                  <div class="add_profile_group_form">
                    <form method="post" action="" id="add-field-group-to_<?php echo 'xprofile_public_groups'; ?>">
                      <select name="profile_group_id" id="field-group-<?php echo 'xprofile_public_groups'; ?>">
                        <?php foreach($this->groups as $group): ?>
                        <?php if( !in_array($group->id, $this->allowed_xprofile_groups['xprofile_public_groups'] ) ): ?>
                        <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                      <input type="hidden" name="role_key" value="<?php echo 'xprofile_public_groups'; ?>" />
                      <input type="submit" class="button small" name="action" value="<?php _e('Add', 'buddypress-xprofiles-acl'); ?>" />
                      <input type="reset" class="button small" name="cancel_button" value="<?php _e('Cancel', 'buddypress-xprofiles-acl'); ?>" />
                    </form>
                  </div>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
            <!--Public Groups//-->
          <?php $index = 0; 
          foreach($wp_roles->roles as $role_key=>$role): $index++; ?>
            <tr<?php echo ($index%2) ? '': ' class="alt"'; ?>>
              <td><strong><?php echo $role['name']; ?></strong></td>
              <td class="xprofile_field_groups">
                <div class="xprofile_field_groups_block">
                  <?php foreach($this->allowed_xprofile_groups[$role_key] as $profile_group_id): ?>
                  <div class="profile_groups">
                  <?php 
                    $this_profile_group = BP_XProfile_Group::get( array('profile_group_id' => $profile_group_id) );
                    $this_profile_group = $this_profile_group[0];
                    echo $this_profile_group->name;
                  ?>
                    <form method="post" action="" style="display:none;">
                      <input type="hidden" name="role_key" value="<?php echo $role_key; ?>" />
                      <input type="hidden" name="profile_group_id" value="<?php echo $this_profile_group->id; ?>" />
                      <input type="hidden" name="action" value="Delete" />
                    </form>
                    <a href="javascript:void(0)" class="delete_profile_group_id" title="<?php _e('Remove Profile Group', 'buddypress-xprofiles-acl'); ?>">X</a>
                  </div>
                  <?php endforeach; ?>
                  <div style="clear:both;"></div>
                </div>
                <?php 
                  $this_role_groups = array();
                  foreach($this->groups as $group) { $this_role_groups[] = $group->id; }
                  if( count( array_diff($this_role_groups, $this->allowed_xprofile_groups[$role_key]) ) > 0) {
                    $hide_add_profile_group_form_block = false;
                  } else {
                    $hide_add_profile_group_form_block = true;
                  }
                ?>
                <div class="add_profile_group_form_block">
                  <?php if($hide_add_profile_group_form_block): ?>
                  <p class="description"><?php _e('No more groups available', 'buddypress-xprofiles-acl'); ?></p>
                  <?php else: ?>
                  <a href="javascript:void(0)" class="show_add_profile_group_form button"><?php _e('Add', 'buddypress-xprofiles-acl'); ?></a>
                  <div class="add_profile_group_form">
                    <form method="post" action="" id="add-field-group-to_<?php echo $role_key; ?>">
                      <select name="profile_group_id" id="field-group-<?php echo $role_key; ?>">
                        <?php foreach($this->groups as $group): ?>
                        <?php if( !in_array($group->id, $this->allowed_xprofile_groups[$role_key] ) ): ?>
                        <option value="<?php echo $group->id; ?>"><?php echo $group->name; ?></option>
                        <?php endif; ?>
                        <?php endforeach; ?>
                      </select>
                      <input type="hidden" name="role_key" value="<?php echo $role_key; ?>" />
                      <input type="submit" class="button small" name="action" value="<?php _e('Add', 'buddypress-xprofiles-acl'); ?>" />
                      <input type="reset" class="button small" name="cancel_button" value="<?php _e('Cancel', 'buddypress-xprofiles-acl'); ?>" />
                    </form>
                  </div>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php
  }
  
  function filter_xprofile_groups_with_acl() {
    global $bp, $profile_template, $current_user;
    get_currentuserinfo();
    foreach($profile_template->groups as $key => $profile_group) {
      if( ! in_array($profile_group->id, $this->user_allowed_xprofile_groups) ) {
        unset($profile_template->groups[$key]);
      }
    }
  }
  
  function block_screen_edit_profile() {
    global $bp, $current_user;
    get_currentuserinfo();
    if($current_user->ID) {
      if( ! in_array($bp->action_variables[1], $this->user_allowed_xprofile_groups) ) {
        bp_core_redirect( $bp->displayed_user->domain . BP_XPROFILE_SLUG . '/edit/group/1' );
      }
    }
  }
  
  function change_profile_groups_tabs(){
    global $bp, $current_user;
    get_currentuserinfo();
    if($current_user->ID) {
      $groups = BP_XProfile_Group::get( array( 'fetch_fields' => true ) );
      foreach($groups as $key => $profile_group) {
        if( ! in_array($profile_group->id, $this->user_allowed_xprofile_groups) ) {
          unset($groups[$key]);
        }
      }
      $groups = array_values($groups);
      wp_cache_set( 'xprofile_groups_inc_empty', $groups, 'bp' );
    }
  }
}

function xpa_admin_menu() {
  $bp_xp_acl_plugin = new BPxProfileACL;
  add_options_page('BP xProfiles ACL - Assign Extended Profile Groups to Roles', 'BP xProfiles ACL', 9, 'bp-profiles-acl-manager', array($bp_xp_acl_plugin, 'manage_profile_acls_form'));
}

function xpa_init_acl() {
  $bp_xp_acl_plugin = new BPxProfileACL;
  add_action('xprofile_screen_edit_profile', array($bp_xp_acl_plugin, 'block_screen_edit_profile'));
  add_action('xprofile_template_loop_start', array($bp_xp_acl_plugin, 'filter_xprofile_groups_with_acl'));
  add_action('bp_before_profile_field_content', array($bp_xp_acl_plugin, 'change_profile_groups_tabs'));
}

function xpa_plugin_init_action() {
  $bp_xp_acl_plugin = new BPxProfileACL;
}

function xpa_plugin_load_locales() {
  $locale = get_locale();
  $mo_file = dirname(__FILE__) . "/languages/buddypress-xprofiles-acl-$locale.mo";
  if ( file_exists( $mo_file ) )
    load_textdomain( 'buddypress-xprofiles-acl', $mo_file );
}

add_action('plugins_loaded', 'xpa_plugin_load_locales');
add_action('init', 'xpa_plugin_init_action');
add_action('bp_init', 'xpa_init_acl');
add_action('admin_menu', 'xpa_admin_menu');
add_action('admin_print_scripts-settings_page_bp-profiles-acl-manager', 'xpa_load_manage_profile_acls_form_js');


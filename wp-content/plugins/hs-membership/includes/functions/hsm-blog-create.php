<?php
/*  
Copyright: © 2010 Haden Software <http://haden.cc/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/

/**************************************************************************************************/
/* Direct access denial.                                                                          */
/**************************************************************************************** 0.9.0 ***/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
  exit("Do not access this file directly.");

/**************************************************************************************************/
/* Function to refresh cached user capabilities                                                   */
/* add_action("signup_finished",...);                                                             */                          
/*  This function refresh the users capabilities after a new blog is created.  Under certain      */
/*  conditions these capabilites are overwritten when a new blog is created for an existing member*/
/*  with s2Member roles.                                                                          */
/**************************************************************************************** 0.9.0 ***/
if (!function_exists ("hsmember_blog_create_refresh_caps")) {
  function hsmember_blog_create_refresh_caps() {
    global $wpdb;
	  // The current_user object still have the correct capabilities, so just get it from there.
		$current_user = (is_user_logged_in ()) ? wp_get_current_user () : false;
		$data = get_object_vars($current_user->data);
		if (isset($data[$wpdb->base_prefix.'1_capabilities'])) {
  		$meta_value = maybe_serialize($data[$wpdb->base_prefix.'1_capabilities']);
		  $wpdb->insert($wpdb->usermeta,array('user_id' => $current_user->ID,
		                                      'meta_key' => $wpdb->base_prefix.'1_capabilities',
		                                      'meta_value' => $meta_value));
		}
  } // end of hsmember_blog_create_refresh_caps()
}

/**************************************************************************************************/
/* Function to check if user is allowed access to create a new blog                               */
/* add_filter("wpmu_active_signup",...);                                                          */                          
/*  This function check if user access to creating blogs is controlled according to user level,   */
/*  and if so return the correct value to the filter.                                             */
/* Version                                                                                        */
/*  0.9.0 - Created                                                                               */
/*  0.9.3 - Bug Fix: $active_signup not correctly set to 'none' if access was restricted.         */
/*                   Filter 'hsmember_blog_create_after_check_access' was not applied if the      */
/*                   access was allowed                                                           */
/* Results                                                                                        */
/*  'blog' - Access is controlled and user has required level.                                    */
/*  'none' - Access is controlled and user do not have required level.                            */
/*  Original value -  Access is not controlled.                                                   */
/**************************************************************************************************/
if (!function_exists ("hsmember_blog_create_check_access")) {
	function hsmember_blog_create_check_access($active_signup) {
		if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','>='))
			// Leave it to s2Member to decide if it is version 3.2 or more
			return $active_signup;
    // Ignore the supplied value, because BuddyPress cache the wrong value.
    $active_signup = get_site_option('registration');
    $active_signup = apply_filters("hsmember_blog_create_before_check_access", 
                                   $active_signup ); // return "all", "none", "blog" or "user"
    if ( $GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] &&
        ($GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] > 0) &&
        ($active_signup == 'user')) {
      // Blog Creation Access is restricted, now check if the user has the capability
      $active_signup = 'none';
      switch ($GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"]) {
        case 1: 
          if (current_user_can ("access_s2member_level1"))
            $active_signup = 'blog';
          break;
        case 2:
          if (current_user_can ("access_s2member_level2"))
            $active_signup = 'blog';
          break;
        case 3:
          if (current_user_can ("access_s2member_level3"))
            $active_signup = 'blog';
          break;
        case 4:
          if (current_user_can ("access_s2member_level4"))
            $active_signup = 'blog';
          break;
      }
    }
    $active_signup = apply_filters("hsmember_blog_create_after_check_access",
                                   $active_signup ); // return "all", "none", "blog" or "user"
    return $active_signup;
  } // end of hsmember_blog_create_check_access()
}

/**************************************************************************************************/
/* Function to force the Super Admin >> Options >> Allow new registrations setting.               */
/* add_filter("pre_site_option_registration",...);                                                */                          
/*  Force the 'registration' site option to user if blog creation is under control of the Multi-  */
/*  Site Membership plugin                                                                        */
/* Results                                                                                        */
/*  'user'  - Access is controlled Multi-Site Membership plugin.                                  */
/*  false   -  Access is not controlled.                                                          */
/**************************************************************************************** 0.9.0 ***/
if (!function_exists ("hsmember_blog_create_force_options")) {
  function hsmember_blog_create_force_options($pv_new) {
		if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','>='))
			// Leave it to s2Member to decide if it is version 3.2 or more
			return $active_signup;
    do_action("hsmember_blog_create_before_force_options",get_defined_vars ());
    if ( $GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] &&
        ($GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] > 0)) {
      $pv_new = 'user';
    }
    $pv_new = apply_filters("hsmember_blog_create_after_force_options",$pv_new);
    return $pv_new;
  } // end of hsmember_blog_create_force_options()
}
?>

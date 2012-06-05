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
/*  Register actions for wp-core hooks.                                                           */
/*    0.9.0 - Created                                                                             */
/*    0.9.4 - Added add_action("before_signup_form",...)                                          */
/*            Added add_action("network_admin_notices",...)                                       */
/*            Added add_action("network_admin_menu",...)                                          */
/**************************************************************************************************/
add_action("signup_finished",               "hsmember_blog_create_refresh_caps");
add_filter("wpmu_active_signup",            "hsmember_blog_create_check_access");
add_filter("pre_update_option_registration","hsmember_blog_create_force_options");
add_filter("pre_update_site_option_registration","hsmember_blog_create_force_options");
add_action("admin_init",                    "hsmember_notices_super_admin_options");
add_action("admin_notices",                 "hsmember_notices_show_admin_notices");
add_action("network_admin_notices",         "hsmember_notices_show_admin_notices");
add_action("admin_menu",                    "hsmember_menu_top_add");
add_action("network_admin_menu",            "hsmember_menu_top_add");
add_action("admin_menu",                    "hsmember_edit_add_custom_box");
add_action("save_post",                     "hsmember_edit_save_data");

/**************************************************************************************************/
/*  Register actions for s2Member hooks.                                                          */
/*    0.9.0 - Created                                                                             */
/*    0.9.4 - Added additional hooks for filters                                                  */
/*              add_filter("ws_plugin__s2member_check_post_level_access_excluded",...)            */
/*              add_filter("ws_plugin__s2member_check_page_level_access_excluded",...)            */
/**************************************************************************************************/
add_filter("ws_plugin__s2member_check_ruri_level_access_excluded","hsmember_level_access_check_ruri");     

add_filter("ws_plugin__s2member_check_catg_level_access_excluded","hsmember_level_access_check_catg");     

add_filter("ws_plugin__s2member_check_ptag_level_access_excluded","hsmember_level_access_check_ptag");     

add_filter("ws_plugin__s2member_check_post_level_access_excluded","hsmember_level_access_check_post");
add_filter("ws_plugin__s2member_check_post_level_access_excluded","hsmember_level_access_check_catg");
add_filter("ws_plugin__s2member_check_post_level_access_excluded","hsmember_level_access_check_ptag");
add_filter("ws_plugin__s2member_check_post_level_access_excluded","hsmember_level_access_check_ruri");     

add_filter("ws_plugin__s2member_check_page_level_access_excluded","hsmember_level_access_check_page");
add_filter("ws_plugin__s2member_check_page_level_access_excluded","hsmember_level_access_check_ruri");

add_filter("ws_plugin__s2member_is_systematic_use_page",          "hsmember_systematic_page");

/**************************************************************************************************/
/*  Register the activation | de-activation hooks.                                                */
/**************************************************************************************** 0.9.0 ***/
/* Register the activation | de-activation routines. */
register_activation_hook($GLOBALS["_HSMEMBER_"]["l"],"hsmember_activate");
?>
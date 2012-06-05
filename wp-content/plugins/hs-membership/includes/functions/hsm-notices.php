<?php
/*  
Copyright: © 2010 Haden Software <http://haden.cc/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/

/**************************************************************************************************/
/* This file provide generate and display notices on the Admin Site's.                            */
/* Functions provided:                                                                            */
/*  hsmember_notices_super_admin_options - Generate notices to be displayed on the Network Admin  */
/*                                         site                                                   */
/*  hsmember_notices_show_admin_notices  - Show the admin notices previously generated.           */
/**************************************************************************************************/

/**************************************************************************************************/
/* Direct access denial.                                                                          */
/**************************************************************************************************/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
  exit ("Do not access this file directly.");

/**************************************************************************************************/
/* Function to display admin notices on the Admin Pages                                           */
/*  Attach to add_action("admin_init",...);                                                       */
/* Version History:                                                                               */
/*  0.9.0 - Created, Super admin notice on control of 'Allow new registrations' option            */
/*  0.9.4 - Added, Notices on functionality not available due to incompatible systems             */
/**************************************************************************************************/
if (!function_exists ("hsmember_notices_super_admin_options")) {
  function hsmember_notices_super_admin_options() {
    do_action ("hsmember_notices_before_super_admin_options", get_defined_vars ());
    if ($GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"]      &&
        $GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] > 0  &&
				version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','<') &&
        version_compare(get_bloginfo("version"),HSMEMBER_MIN_WP_VERSION, ">=")) {
      $notice = "<em>* Note: The HS-Membership plugin has control over the <code>Allow new registrations = ".
                esc_html(get_site_option("registration"))."</code> option. For further details, see: ".
                "<code>HS-Member -> General Options -> Blog Creation Restriction</code>.</em>";
      do_action ("hsmember_notices_during_super_admin_options", get_defined_vars ());
      hsmember_notices_add_admin_notice ($notice,'ms-options.php');
    }
    if ($GLOBALS["_HSMEMBER_"]["o"]["new_activation"] == 1) {
      hsmember_compat_check_with_notices("plugins.php");
      $GLOBALS['_HSMEMBER_']['o']['new_activation'] = 0;
      hsmember_globals_option_save();
    }
    do_action ("hsmember_notices_after_super_admin_options", get_defined_vars ());
    return;
  } // end of hsmember_notices_super_admin_options
}

/**************************************************************************************************/
/* Function to add admin notices to be displayed                                                  */
/*  INPUT: $pv_message - The text of the notice to display.                                       */
/*         $pv_page    - Filename of the page to display the notice for.                          */
/*                       default=FALSE - Display on all admin pages.                              */
/*         $pv_error   - TRUE: Display as an error.                                               */
/*                       default=FALSE: Display as a message.                                     */
/**************************************************************************************** 0.9.0 ***/
if (!function_exists ("hsmember_notices_add_admin_notice"))	{
  function hsmember_notices_add_admin_notice ($pv_message = FALSE,$pv_page = FALSE, $pv_error = FALSE) {
    global $pagenow;
		do_action ("hsmember_notices_before_add_admin_notice", get_defined_vars ());
    if ($pv_message && is_string($pv_message))	{
      $lv_notice_array['message'] = $pv_message;
      $lv_notice_array['error']   = $pv_error;
      if ($GLOBALS["_HSMEMBER_"]["n"]["processed"]) {
        // Notices has already been displayed, so just display this one.
        if ($lv_notice_array['error'])
          echo '<div class="error fade"><p>'.$lv_notice_array['message'].'</p></div>';
        else
          echo '<div class="updated fade"><p>'.$lv_notice_array['message'].'</p></div>';
      }
      else if ($GLOBALS["_HSMEMBER_"]["n"][$pv_page]) {
        // There are already notices for this page, so just add this one.
        array_push($GLOBALS["_HSMEMBER_"]["n"][$pv_page],$lv_notice_array);
      }
      else {
        // First notice for this page.
        $GLOBALS["_HSMEMBER_"]["n"][$pv_page] = array($lv_notice_array);
      }
		}
		do_action ("hsmember_notices_after_add_admin_notice", get_defined_vars ());
  } // end of function hsmember_notices_add_admin_notice()
}

/**************************************************************************************************/
/* Function to display the admin notices for the current page                                     */
/*  Attach to: add_action("admin_notices",...);                                                   */
/*  Attach to: add_action("network_admin_notices",...)                                            */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_notices_show_admin_notices")) {
  function hsmember_notices_show_admin_notices () {
    global $pagenow;
    do_action("hsmember_notices_before_show_admin_notices", get_defined_vars ());
    if (is_array($GLOBALS["_HSMEMBER_"]["n"][0])) {
      foreach ($GLOBALS["_HSMEMBER_"]["n"][0] as $lv_notice)
        if ($lv_notice['error'])
          echo '<div class="error fade"><p>'.$lv_notice['message'].'</p></div>';
        else
          echo '<div class="updated fade"><p>'.$lv_notice['message'].'</p></div>';
    }
    if (is_array($GLOBALS["_HSMEMBER_"]["n"][$pagenow])) {
      foreach ($GLOBALS["_HSMEMBER_"]["n"][$pagenow] as $lv_notice)
        if ($lv_notice['error'])
          echo '<div class="error fade"><p>'.$lv_notice['message'].'</p></div>';
        else
          echo '<div class="updated fade"><p>'.$lv_notice['message'].'</p></div>';
    }
    $GLOBALS["_HSMEMBER_"]["n"]["processed"] = TRUE;
  } // end of function hsmember_notices_show_admin_notices()
}
?>

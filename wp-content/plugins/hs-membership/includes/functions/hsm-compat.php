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
/**************************************************************************************************/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");

/**************************************************************************************************/
/* This file contain functions used to check the compatibility of the plugin with other plugins   */
/*  loaded.                                                                                       */
/* Functions provided:                                                                            */
/*  hsmember_compat_check_with_notices - Check compatibilty and create Admin Page notices if req. */
/**************************************************************************************************/

/**************************************************************************************************/
/* Function to check for plugin compatibility and create Admin Page notices if required.          */
/*  Notices will be placed directly on the Notice Queue.                                          */
/*    0.9.4 - Created                                                                             */
/*  INPUT: $pv_page - Filename of the page to display the notice for.                             */
/*                    default=FALSE - Display on all admin pages.                                 */
/*  RETURN: TRUE - Plugin is compatible.                                                          */
/**************************************************************************************************/
if (!function_exists("hsmember_compat_check_with_notices")) {
  function hsmember_compat_check_with_notices($page=FALSE) {
    $result = TRUE;
    if (version_compare(PHP_VERSION,HSMEMBER_MIN_PHP_VERSION,"<")) {
      $notice = "<b>HS-Membership Plugin :</b> PHP version ".HSMEMBER_MIN_PHP_VERSION." or later is".
                " required for the HS-Membership plugin to function correctly. The functionality of".
                " the plugin has been disabled. Please upgrade to PHP version ".
                HSMEMBER_MIN_PHP_VERSION." to use this plugin.";
      hsmember_notices_add_admin_notice ($notice,$page,TRUE);
      $result = FALSE;
    }
    if (version_compare(get_bloginfo ("version"),HSMEMBER_MIN_WP_VERSION, "<")) {
      $notice = "<b>HS-Membership Plugin :</b> Wordpress version ".HSMEMBER_MIN_WP_VERSION." or".
                " later is required for the HS-Membership plugin to function correctly. The".
                " HS-Membership plugin has not been activated. Please upgrade to Wordpress".
                " version ".HSMEMBER_MIN_WP_VERSION." to use this plugin.";
      hsmember_notices_add_admin_notice ($notice,$page,TRUE);
      $result = FALSE;
    }
    if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,HSMEMBER_MIN_S2_VERSION, "<")) {
      $notice = "<b>HS-Membership Plugin :</b> The s2Member plugin version ".HSMEMBER_MIN_S2_VERSION.
                " or later is required for the HS-Membership plugin to function correctly.  The".
                " HS-Membership plugin has not been activated. Please upgrade to or install".
                " s2Member version ".HSMEMBER_MIN_S2_VERSION." to use this plugin.";
      hsmember_notices_add_admin_notice ($notice,$page,TRUE);
      $result = FALSE;
    }
    return $result;
  } // end of hsmember_compat_check_with_notices()
}
?>
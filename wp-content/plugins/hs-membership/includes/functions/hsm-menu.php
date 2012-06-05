<?php
/*  
Copyright: © 2010 Haden Software <http://haden.cc/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/

/**************************************************************************************************/
/* This file provide the Menus that are displayed in the Admin Site's.                            */
/* Functions provided:                                                                            */
/*  hsmember_menu_top_add             - Add the Options Menu link(s) to the Admin pages           */
/*  hsmember_menu_options_page        - Display the Admin Options page                            */
/*  hsmember_menu_update_all_options  - Update options from the Admin Options page                */
/**************************************************************************************************/

/**************************************************************************************************/
/* Direct access denial.                                                                          */
/**************************************************************************************************/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");

/**************************************************************************************************/
/* Function to add the options menus for the Network Admin page.                                  */
/*  Attach to action("admin_menu",...)                                                            */
/*  Attach to action("network_admin_menu",...)                                                    */
/* Version History:                                                                               */
/*  0.9.4 - Created                                                                               */
/*  1.0.0 - Set required capability to 'activate_plugins' to allow sub-blog admins access to the  */
/*          menu.                                                                                 */
/**************************************************************************************************/
if (!function_exists ("hsmember_menu_top_add")) {
  function hsmember_menu_top_add() {
    add_menu_page("HS-Membership Options",
                  "HS-Member",
                  "activate_plugins",
                  "hsmember-menu-top",
                  "hsmember_menu_options_page");
  } // end of hsmember_menu_top_add()
}

/**************************************************************************************************/
/* Function to display the General Options page for HS-Membership                                 */
/*  Called from the menu item hsmember-menu-top                                                   */
/* Version Updates:                                                                               */
/*  0.9.0 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_menu_options_page")) {
	function hsmember_menu_options_page() {
    // Will return true if compatible, or generate notice(s) if not
    if (hsmember_compat_check_with_notices('')) {
      hsmember_menu_update_all_options ();
      include_once dirname(dirname(__FILE__))."/option-pages/hsm-opt-general.php";
    }
	} // end of hsmember_menu_options_page()
}

/**************************************************************************************************/
/* Function to save/update all plugin option values                                               */
/* Version Updates:                                                                               */
/*  0.9.0 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_menu_update_all_options")) {
  function hsmember_menu_update_all_options () {
    if (($lv_nonce = $_POST["hsmember_options_nonce"]) && 
        wp_verify_nonce($lv_nonce,"hsmember-options-nonce")) {
      foreach ($_POST as $lv_key => $lv_value) {
        if (preg_match("/^".preg_quote ("hsmember","/")."/",$lv_key)) {
          (is_array($lv_value)) ? array_shift ($lv_value) : null;
					$GLOBALS["_HSMEMBER_"]["o"][preg_replace("/^".preg_quote("hsmember_options_","/")."/","",$lv_key)] = $lv_value;
        }
      }
			$GLOBALS["_HSMEMBER_"]["o"]["options_version"] = $GLOBALS["_HSMEMBER_"]["o"]["options_version"] + 0.001;
			$GLOBALS["_HSMEMBER_"]["o"] = hsmember_configure_options_validate($GLOBALS["_HSMEMBER_"]["o"]);
      // Override the main options values, this need to be done as BuddyPress use a cached version of
      //  the system variables so the pre_site_option filter dont always work.
      if ( $GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] &&
          ($GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] > 0)) {
        update_site_option('registration','user');
      }
			eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
			unset ($__refs, $__v);
			update_option("hsmember_options",$GLOBALS["_HSMEMBER_"]["o"]);
    }
		return;
	} // end of hsmember_menu_update_all_options()
}
?>
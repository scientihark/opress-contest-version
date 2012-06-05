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
	exit ("Do not access this file directly.");

/**************************************************************************************************/
/* This file contain functions used to activate the plugin.                                       */
/* Functions provided:                                                                            */
/*  hsmember_activate - Activate the HS-Membership plugin and setup the database if required      */
/**************************************************************************************************/

/**************************************************************************************************/
/* Function for handling plugin activation.                                                       */
/*  Initialize option values here. Initializing these options will force them to be autoloaded    */
/*  into WordPress instead of generating extra queries before they are set.                       */
/* Version History                                                                                */
/*    0.9.0 - Created                                                                             */
/**************************************************************************************************/
if (!function_exists ("hsmember_activate")) {
  function hsmember_activate() {
    if (hsmember_compat_check_with_notices()) {
      /* Create the new variables */
      $GLOBALS['_HSMEMBER_']['o']['new_activation'] = 1;
      hsmember_globals_option_save();
      /* Capture the last activated plugin version number */
      update_option("hsmember_activated_version",HSMEMBER_VERSION);
    }
    else {
      hsmember_notices_show_admin_notices();
	    if (version_compare(get_bloginfo ("version"),"3.0","<")) {
	  		$plugins = get_option('active_plugins');
	      $out = array();
  	    foreach($plugins as $key => $val)
  				if(substr($val,-12) != 'hsmember.php')
  					$out[$key] = $val;
	  		update_option('active_plugins', $out);
	  	}
	  	else {
	  		$plugins = get_site_option('active_sitewide_plugins');
	      $out = array();
  	    foreach($plugins as $key => $val)
  				if(substr($key,-12) != 'hsmember.php')
  					$out[$key] = $val;
	  		update_site_option('active_sitewide_plugins', $out);
	    }
      exit();
    }
  } // end of hsmember_activate()
}
?>
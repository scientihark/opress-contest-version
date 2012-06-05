<?php
/*  
Copyright: © 2010 Haden Software <http://haden.cc/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/

/**************************************************************************************************/
/* This file provide functions to determine if we are are on a systematic use page.               */
/* Functions provided:                                                                            */
/*  hsmember_systematic_page - Check Level Permission for Request URI access                      */
/**************************************************************************************************/

/**************************************************************************************************/
/* Direct access denial.                                                                          */
/**************************************************************************************************/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");

/**************************************************************************************************/
/* Function to determine if we are are on a systematic use page.                                  */
/*  Attach to: add_filter("ws_plugin__s2member_is_systematic_use_page");                          */
/* Version History:                                                                               */
/*  0.9.0 - Created, Add check for the login_required_page.                                       */
/**************************************************************************************** 0.9.0 ***/
if (!function_exists ("hsmember_systematic_page")) {
  function hsmember_systematic_page($pv_systematic) {
    static $sv_systematic_cache;
    if ($pv_systematic) {
      /* Page is already identified as systematic, nothing further to do */
      return ($sv_systematic_cache = $pv_systematic);
    }
    else if (        $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"] && 
             is_page($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])  ) {
      return ($sv_systematic_cache = apply_filters("hsmember_systematic_use_page",
                                                   true, get_defined_vars ()));
    }
		else {
			return ($sv_systematic_cache = apply_filters("hsmember_systematic_use_page",
                                                   false, get_defined_vars ()));
		}
  } // end of hsmember_systematic_page()
}
?>
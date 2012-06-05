<?php
/*  
Copyright: © 2010 Haden Software <http://haden.cc/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/

/**************************************************************************************************/
/* This file provide functions to overide the level checking functions of s2Member.  Where        */
/*  applicable the display of the Membership Options Page by s2Member will be overidden and the   */
/*  Login Required Page will be displayed.                                                        */
/* Functions provided:                                                                            */
/*  hsmember_level_access_check_ruri - Check Level Permission for Request URI access              */
/**************************************************************************************************/

/**************************************************************************************************/
/* Direct access denial.                                                                          */
/**************************************************************************************************/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");

/**************************************************************************************************/
/* Function to check Level Permission for Request URI access.                                     */
/*  Attach to: add_filter("ws_plugin__s2member_check_ruri_level_access_excluded",...);            */
/*  If a login_required_page is set up and the Visitor is not logged in, overide the              */
/*  membership_page with the login_required_page.                                                 */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/*  0.9.3 - Updated to use bridge functions                                                       */
/*  0.9.4 - Updated to use s2Member API functions. Bridge removed.                                */
/**************************************************************************************************/
if (!function_exists ("hsmember_level_access_check_ruri")) {
  function hsmember_level_access_check_ruri() {
    if (!apply_filters("hsmember_level_access_exclude_check_ruri",false,get_defined_vars()) &&
        $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"] &&
        !is_user_logged_in()) {
      if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.5','>=')) {
        if (!is_uri_permitted_by_s2member($_SERVER["REQUEST_URI"])) {
          wp_redirect(add_query_arg("level_req",$lv_level,
                      get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
          exit (); // If we got to here, something went wrong, abort
        }
      }
      else if (!ws_plugin__s2member_is_systematic_use_page()) {
        for ($lv_level=0;$lv_level<=4;$lv_level++) {
          foreach (preg_split("/[\r\n\t]+/",
                              ws_plugin__s2member_fill_ruri_level_access_rc_vars(
                              $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_ruris"]))
                   as $lv_str) {                   
            if ($lv_str && preg_match ("/".preg_quote($lv_str, "/")."/",$_SERVER["REQUEST_URI"]) &&
                ws_plugin__s2member_nocache_constants (true) !== "nill") {
              wp_redirect(add_query_arg("level_req",$lv_level,
                                        get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
              exit (); // If we got to here, something went wrong, abort
            }
          }
        }
      }
    }
    return FALSE; // Continue processing the page for membership levels.
  } // end of hsmember_level_access_check_ruri()
}

/**************************************************************************************************/
/* Function to check Level Permission for Category access.                                        */
/*  Attach to: add_filter("ws_plugin__s2member_check_catg_level_access_excluded",...);            */
/*  If a login_required_page is set up and the Visitor is not logged in, overide the              */
/*  membership_page with the login_required_page.                                                 */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/*  0.9.3 - Updated to use bridge functions                                                       */
/*  0.9.4 - Updated to use s2Member API functions. Bridge removed.                                */
/**************************************************************************************************/
if (!function_exists ("hsmember_level_access_check_catg")) {
  function hsmember_level_access_check_catg() {
    global $post;
    if (!apply_filters("hsmember_level_access_exclude_check_catg",false,get_defined_vars()) &&
        $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"] &&
        !is_user_logged_in()) {
      if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.5','>=')) {
        if (!is_category_permitted_by_s2member(get_query_var("cat"))) {
          wp_redirect(add_query_arg("level_req",$lv_level,
                      get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
          exit (); // If we got to here, something went wrong, abort
        }
      }
      else {
        if (((is_category() && ($lv_cat = get_query_var("cat"))) ||
            (is_single() && !is_page() && is_object($post) && ($lv_post = $post->ID))) &&
             !ws_plugin__s2member_is_systematic_use_page()) {
          if (is_category () && $lv_cat) {
            // Browsing by catagory            
            for ($lv_level=0;$lv_level<=4;$lv_level++) {
              unset($lv_catgs);
              if ( $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_catgs"] &&
                  ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_catgs"] === "all" ||
                   in_array($lv_cat,($lv_catgs=preg_split("/[\r\n\t\s;,]+/",
                                                          $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_catgs"])))) &&
                   ws_plugin__s2member_nocache_constants(true) !== "nill") {
                wp_redirect(add_query_arg("level_req",$lv_level,
                                          get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
                exit(); // If we got to here, something went wrong, abort
              }
              if ($lv_catgs) {
                foreach ($lv_catgs as $lv_catg) {
                  if ($lv_catg && cat_is_ancestor_of($lv_catg,$lv_cat) &&
                      ws_plugin__s2member_nocache_constants(true) !== "nill") {
                    wp_redirect(add_query_arg("level_req",$lv_level,
                                              get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
                    exit(); // If we got to here, something went wrong, abort
                  }
                }
              }              
            }
          }
          else if (is_single() && !is_page() && $lv_post) {
            // Browsing by post            
            for ($lv_level=0;$lv_level<=4;$lv_level++) {
              unset($catgs);
              if ( $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_catgs"] &&
                  ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_catgs"] === "all" ||
                   in_category(($lv_catgs = preg_split("/[\r\n\t\s;,]+/",
                                                       $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_catgs"])),
                               $lv_post) ||
                   ws_plugin__s2member_in_descendant_category($lv_catgs,$lv_post)) &&
                  ws_plugin__s2member_nocache_constants(true) !== "nill" ) {
                wp_redirect(add_query_arg("level_req",$lv_level,
                                          get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
                exit(); // If we got to here, something went wrong, abort
              }
            }
          }
        }
      }
    }
    return FALSE; // Continue processing the page for membership levels.
  } // end of hsmember_level_access_check_catg()
}

/**************************************************************************************************/
/* Function for handling Page Tag Level Access permissions.                                       */
/*  Attach to: add_filter("ws_plugin__s2member_check_ptag_level_access_excluded");                */
/*  If a login_required_page is set up and the Visitor is not logged in, overide the              */
/*  membership_page with the login_required_page.                                                 */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/*  0.9.3 - Updated to use bridge functions                                                       */
/*  0.9.4 - Updated to use s2Member API functions. Bridge removed.                                */
/**************************************************************************************************/
if (!function_exists ("hsmember_level_access_check_ptag")) {
	function hsmember_level_access_check_ptag() {
    global $post;
    if (!apply_filters("hsmember_level_access_exclude_check_ptag",false,get_defined_vars()) &&
        $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"] &&
        !is_user_logged_in()) {
      if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.5','>=')) {
        if (!is_tag_permitted_by_s2member(get_query_var("tag"))) {
          wp_redirect(add_query_arg("level_req",$lv_level,
                      get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
          exit (); // If we got to here, something went wrong, abort
        }
      }
      else {
		    if (((is_tag() && ($lv_tag = get_query_var ("tag"))) ||
				    (is_single() && has_tag() && is_object ($post) && ($lv_post = $post->ID))) &&
 			      !ws_plugin__s2member_is_systematic_use_page()) {
    			if (is_tag() && $lv_tag) {
            // Browsing by tag
            for ($lv_level=0;$lv_level<=4;$lv_level++) {
              if ( $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_ptags"] &&
                  ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_ptags"] === "all" ||
                   is_tag(preg_split("/[\r\n\t;,]+/",
                          preg_replace("/( +)/", "-",
                                       $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_ptags"])))) &&
                  ws_plugin__s2member_nocache_constants (true) !== "nill") {
                wp_redirect(add_query_arg("level_req",$lv_level,
                            get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
                exit (); // If we got to here, something went wrong, abort
              }
            }
          }
    			else if (is_single() && has_tag() && $lv_post) {
            // Browsing by post
            for ($lv_level=0;$lv_level<=4;$lv_level++) {
              if ( $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_ptags"] &&
                  ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_ptags"] === "all" ||
                   has_tag(preg_split("/[\r\n\t;,]+/",
                           preg_replace ("/( +)/", "-",
                                         $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_ptags"])))) &&
                  ws_plugin__s2member_nocache_constants (true) !== "nill") {
                wp_redirect(add_query_arg("level_req",$lv_level,
                            get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
                exit (); // If we got to here, something went wrong, abort
              }
            }
          }
        }
      }
    }
		return FALSE; // Continue processing the page for membership levels.
	} // hsmember_level_access_check_ptag
}

/**************************************************************************************************/
/* Function for handling Post Level Access permissions.                                           */
/*  Attach to: add_filter("ws_plugin__s2member_check_post_level_access_excluded");                */
/*  If a login_required_page is set up and the Visitor is not logged in, overide the              */
/*  membership_page with the login_required_page.                                                 */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/*  0.9.3 - Updated to use bridge functions                                                       */
/*  0.9.4 - Updated to use s2Member API functions. Bridge removed.                                */
/**************************************************************************************************/
if (!function_exists("hsmember_level_access_check_post")) {
	function hsmember_level_access_check_post () {
		global $post; // Still in template redirect phase, get_the_ID() not yet available.
    if (!apply_filters("hsmember_level_access_exclude_check_post",false,get_defined_vars()) &&
        $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"] &&
        !is_user_logged_in()) {
      if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.5','>=')) {
        if (!is_post_permitted_by_s2member($post->ID)) {
          wp_redirect(add_query_arg("level_req",$lv_level,
                      get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
          exit (); // If we got to here, something went wrong, abort
        }
      }
      else {
        if (is_single() && !is_page() && is_object($post) && ($lv_post = $post->ID) &&
 			      !ws_plugin__s2member_is_systematic_use_page()) {
          for ($lv_level=0;$lv_level<=4;$lv_level++) {
            if ( $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_posts"] &&
                ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_posts"] === "all" ||
                 in_array($lv_post,preg_split("/[\r\n\t\s;,]+/",
                                              $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_posts"]))) &&
                 ws_plugin__s2member_nocache_constants(true) !== "nill" ) {
              wp_redirect(add_query_arg("level_req",$lv_level,
                          get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
              exit (); // If we got to here, something went wrong, abort
            }
          }
        }
      }
    }
		return FALSE; // Continue processing the page for membership levels.
	} // end of hsmember_level_access_check_post
}

/**************************************************************************************************/
/* Function for handling Page Level Access permissions.                                           */
/*  Attach to: add_filter("ws_plugin__s2member_check_page_level_access_excluded");                */
/*  If a login_required_page is set up and the Visitor is not logged in, overide the              */
/*  membership_page with the login_required_page.                                                 */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/*  0.9.3 - Updated to use bridge functions                                                       */
/*  0.9.4 - Updated to use s2Member API functions. Bridge removed.                                */
/**************************************************************************************************/
if (!function_exists("hsmember_level_access_check_page")) {
	function hsmember_level_access_check_page () {
		global $post; // Still in template redirect phase, get_the_ID() not yet available.
    if (!apply_filters("hsmember_level_access_exclude_check_page",false,get_defined_vars()) &&
        $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"] &&
        !is_user_logged_in()) {
      if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.5','>=')) {
        if (!is_page_permitted_by_s2member($post->ID)) {
          wp_redirect(add_query_arg("level_req",$lv_level,
                      get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
          exit (); // If we got to here, something went wrong, abort
        }
      }
      else {
        if (is_page() && is_object($post) && ($page_ID = $post->ID)) {
          // Hard-code a few pages, that should always be protected
    			if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] &&
    			    $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"] == $page_ID &&
    	  	    $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] != $page_ID &&
    			    ws_plugin__s2member_nocache_constants(true) !== "nill") {
    		    wp_redirect(add_query_arg("level_req","0",
    		                get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
    				exit(); // If we got to here, something went wrong, abort
    			}
    			if ( $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"] &&
    					($login_redirection_override = ws_plugin__s2member_fill_login_redirect_rc_vars(
    						              $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"])) &&
    					($login_redirect_path  = @parse_url($login_redirection_override, PHP_URL_PATH)) &&
    					($login_redirect_query = @parse_url ($login_redirection_override, PHP_URL_QUERY)) !== "nill" &&
    					($login_redirect_uri   = (($login_redirect_query) ? $login_redirect_path."?".$login_redirect_query
    						                                                     : $login_redirect_path)) &&
    					preg_match("/^".preg_quote($login_redirect_uri,"/")."$/",$_SERVER["REQUEST_URI"]) &&
        	  	$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] != $page_ID &&
    					ws_plugin__s2member_nocache_constants (true) !== "nill") {
    			  wp_redirect(add_query_arg("level_req","0",
    		                get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
    				exit(); // If we got to here, something went wrong, abort
    			}
    			if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] &&
              $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"] == $page_ID &&
    			    $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"] != $page_ID &&
    			    ws_plugin__s2member_nocache_constants(true) !== "nill") {
    			  wp_redirect(add_query_arg("level_req","0",
    			              get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
    				exit(); // If we got to here, something went wrong, abort
    			}
          // Never restrict systematic use pages. Except for the pages above.
     			if (!ws_plugin__s2member_is_systematic_use_page()) {
            // Now start looking at the membership levels
            for ($lv_level=0;$lv_level<=4;$lv_level++) {
              if ( $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_pages"] &&
                  ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_pages"] === "all" ||
                   in_array($page_ID,preg_split("/[\r\n\t\s;,]+/",
                                $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_pages"]))) &&
                  ws_plugin__s2member_nocache_constants(true) !== "nill" ) {
                wp_redirect(add_query_arg("level_req",$lv_level,
                            get_page_link($GLOBALS["_HSMEMBER_"]["o"]["login_required_page"])));
                exit (); // If we got to here, something went wrong, abort
              }
            }
          }
        }
      }
    }
		return FALSE; // Continue processing the page for membership levels.
	} // end of hsmember_level_access_check_page
}
?>
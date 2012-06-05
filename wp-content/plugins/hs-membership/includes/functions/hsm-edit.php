<?php
/*  
Copyright: © 2010 Haden Software <http://haden.cc/>

Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/

/**************************************************************************************************/
/* This file attach and define the meta-box to the Page/Post edit screen                          */
/* Functions provided:                                                                            */
/*  hsmember_edit_add_custom_box - Add the meta-box if required.                                  */
/*  hsmember_edit_save_data
/**************************************************************************************************/

/**************************************************************************************************/
/* Direct access denial.                                                                          */
/**************************************************************************************************/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");

/**************************************************************************************************/
/* Function to add our custom box to the Post/Page edit page.                                     */
/*  Depending on the s2Member version this function may do nothing.                               */
/*  Attach to: add_action("admin_menu",...);                                                      */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_edit_add_custom_box")) {
  function hsmember_edit_add_custom_box() {
    // Check if we have all the correct versions,
    //  Functionality disabled from s2Member 3.2 as it made a similar function available
    if (version_compare(PHP_VERSION,HSMEMBER_MIN_PHP_VERSION,">=")                 &&
        version_compare(get_bloginfo ("version"),HSMEMBER_MIN_WP_VERSION, ">=")    &&
        version_compare(WS_PLUGIN__S2MEMBER_VERSION,HSMEMBER_MIN_S2_VERSION, ">=") &&
				version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','<')                        ){
      add_meta_box("hsmember_plugin","HS-Membership","hsmember_edit_custom_box_post","post","side");
      add_meta_box("hsmember_plugin","HS-Membership","hsmember_edit_custom_box_page","page","side");
    }
  } // end of hsmember_edit_add_custom_box()
}

/**************************************************************************************************/
/* Function to display our custom box to the Post edit page.                                      */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_edit_custom_box_post") &&
		version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','<')) {
  function hsmember_edit_custom_box_post() {
  	global $post;
    do_action("hsmember_edit_before_custom_box_post",get_defined_vars());
    // Get Post ID
    $lv_post = $post->ID;
    // Check if Post ID is currently restricted
    $lv_level_restricted = -1;
    $lv_level_all = -1;
    for ($lv_level=4;$lv_level>=0;$lv_level--) {
      if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_posts"]) {
        if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_posts"] === "all") {
          $lv_level_all = $lv_level;
        }
        else if (in_array($lv_post,preg_split("/[\r\n\t\s;,]+/",
                                              $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_posts"]))) {
          $lv_level_restricted = $lv_level;
        }
      }
    }
    echo "<input type='hidden' name='_hsmember_post_access_old' value='".$lv_level_restricted."'/>";
    echo "<input type='hidden' name='_hsmember_post_id' value='$lv_post'/>";
    echo "Access Restriction: \n";
      echo "<select name='_hsmember_post_access' id='hsmember-post-access'>\n";
        echo "<option value='-1'".($lv_level_restricted==-1 ? " selected='selected'>" : ">")."&mdash; None &mdash;</option>\n";
        for ($lv_level=0;$lv_level<=4;$lv_level++) {
          echo "<option value='$lv_level'";
          echo ($lv_level_restricted == $lv_level ? " selected='selected'>" : ">");
          echo "s2Member Level $lv_level</option>\n";
        }
      echo "</select><br />\n";
    if ($lv_level_all>-1) {
      echo "<br>";
      echo "<div style='clear:both;font-size:x-small;'>";
        echo "Note: Currently all Posts require 's2Member&nbsp;Level&nbsp;".$lv_level_all."' access to be viewed.";
        echo " To change this setting please go to s2Member&nbsp;>&nbsp;General&nbsp;Options&nbsp;> Post&nbsp;Access&nbsp;Restriction";
      echo "</div>";
    }
    do_action("hsmember_edit_after_custom_box_post",get_defined_vars());
  } // end of hsmember_edit_custom_box_post()
}

/**************************************************************************************************/
/* Function to display our custom box to the Page edit page.                                      */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_edit_custom_box_page") &&
		version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','<')) {
  function hsmember_edit_custom_box_page() {
  	global $post;
    do_action("hsmember_edit_before_custom_box_page",get_defined_vars());
    // Get Post ID
    $lv_post = $post->ID;
    // Check if Post is a system page
  	if (!in_array ($lv_post,array($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["membership_options_page"],
                                  $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"],
                                  $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["file_download_limit_exceeded_page"],
                                  $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"]))) {
      // Check if Post ID is currently restricted
      $lv_level_restricted = -1;
      $lv_level_all = -1;
      for ($lv_level=4;$lv_level>=0;$lv_level--) {
        if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_pages"]) {
          if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_pages"] === "all") {
            $lv_level_all = $lv_level;
          }
          else if (in_array($lv_post,preg_split("/[\r\n\t\s;,]+/",
                                                $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$lv_level."_pages"]))) {
            $lv_level_restricted = $lv_level;
          }
        }
      }
      echo "<input type='hidden' name='_hsmember_page_access_old' value='".$lv_level_restricted."'/>";
      echo "<input type='hidden' name='_hsmember_page_id' value='$lv_post'/>";
      echo "Access Restriction: \n";
        echo "<select name='_hsmember_page_access' id='hsmember-page-access'>\n";
          echo "<option value='-1'".($lv_level_restricted==-1 ? " selected='selected'>" : ">")."&mdash; None &mdash;</option>\n";
          for ($lv_level=0;$lv_level<=4;$lv_level++) {
            echo "<option value='$lv_level'";
            echo ($lv_level_restricted == $lv_level ? " selected='selected'>" : ">");
            echo "s2Member Level $lv_level</option>\n";
          }
        echo "</select><br />\n";
      if ($lv_level_all>-1) {
        echo "<br>";
        echo "<div style='clear:both;font-size:x-small;'>";
          echo "Note: Currently all Pages require 's2Member&nbsp;Level&nbsp;".$lv_level_all."' access to be viewed.";
          echo " To change this setting please go to s2Member&nbsp;>&nbsp;General&nbsp;Options&nbsp;> Page&nbsp;Access&nbsp;Restriction";
        echo "</div>";
      }
    }
    else {
      echo "<div style='clear:both;font-size:x-small;'>";
        echo "This page is part of your access control system and access to it cannot be restricted";
      echo "</div>";
    }
    do_action("hsmember_edit_after_custom_box_page",get_defined_vars());
  } // end of hsmember_edit_custom_box_page()
}

/**************************************************************************************************/
/* Function to update the custom box data from the Post/Page edit page.                           */
/*  Depending on the s2Member version this function may do nothing.                               */
/*  Attach to: add_action("save_post",...);                                                       */
/* Version History:                                                                               */
/*  0.9.0 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_edit_save_data")) {
  function hsmember_edit_save_data($pv_post_id) {
		if (version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','>='))
			return;
    if (isset($_REQUEST['_hsmember_post_access']) && isset($_REQUEST['_hsmember_post_access_old']) &&
             ($_REQUEST['_hsmember_post_access']  !=       $_REQUEST['_hsmember_post_access_old']) &&
             ($_REQUEST['_hsmember_post_id']      ==       $pv_post_id)) {
      if ($_REQUEST['_hsmember_post_access_old'] > -1) {
        $lv_access_array = preg_split("/[\r\n\t\s;,]+/",
                                      $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_post_access_old']."_posts"]);
        array_splice($lv_access_array,array_search($pv_post_id,$lv_access_array),1);
        $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_post_access_old']."_posts"] = implode(',',$lv_access_array);
      }
      if ($_REQUEST['_hsmember_post_access'] > -1) {
        if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_post_access']."_posts"] === 'all') {
          $lv_notice = "The <em>Membership Access</em> option could not be set to level ".$_REQUEST['_hsmember_post_access'].
                       " as all Posts currently require that level access to be viewed.  To complete".
                       " this action access restriction on all posts must first be removed. Go to".
                       " s2Member&nbsp;>&nbsp;General&nbsp;Options&nbsp;> Post&nbsp;Access&nbsp;Restriction".
                       " to do so.";
          hsmember_notices_add_admin_notice($lv_notice,0,true);
        }
        else {
          $lv_access_array = preg_split("/[\r\n\t\s;,]+/",
                                        $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_post_access']."_posts"]);
          $lv_access_array[] = $pv_post_id;
          $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_post_access']."_posts"] = implode(',',$lv_access_array);
        }
      }
      $lv_options = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"];
      $lv_options["options_version"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] + 0.001;
      $lv_options = apply_filters("hsmember_edit_during_save_data",$lv_options);
      $lv_options = ws_plugin__s2member_configure_options_and_their_defaults ($lv_options);
      update_option ("ws_plugin__s2member_options", $lv_options);
    }
    if (isset($_REQUEST['_hsmember_page_access']) && isset($_REQUEST['_hsmember_page_access_old']) &&
             ($_REQUEST['_hsmember_page_access']  !=       $_REQUEST['_hsmember_page_access_old']) &&
             ($_REQUEST['_hsmember_page_id']      ==       $pv_post_id)) {
      if ($_REQUEST['_hsmember_page_access_old'] > -1) {
        $lv_access_array = preg_split("/[\r\n\t\s;,]+/",
                                      $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_page_access_old']."_pages"]);
        array_splice($lv_access_array,array_search($pv_post_id,$lv_access_array),1);
        $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_page_access_old']."_pages"] = implode(',',$lv_access_array);
      }
      if ($_REQUEST['_hsmember_page_access'] > -1) {
        if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_page_access']."_pages"] === 'all') {
          $lv_notice = "The <em>Membership Access</em> option could not be set to level ".$_REQUEST['_hsmember_page_access'].
                       " as all Pages currently require that level access to be viewed.  To complete".
                       " this action access restriction on all pages must first be removed. Go to".
                       " s2Member&nbsp;>&nbsp;General&nbsp;Options&nbsp;> Page&nbsp;Access&nbsp;Restriction".
                       " to do so.";
          hsmember_notices_add_admin_notice($lv_notice,0,true);
        }
        else {
          $lv_access_array = preg_split("/[\r\n\t\s;,]+/",
                                        $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_page_access']."_pages"]);
          $lv_access_array[] = $pv_post_id;
          $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$_REQUEST['_hsmember_page_access']."_pages"] = implode(',',$lv_access_array);
        }
      }
      $lv_options = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"];
      $lv_options["options_version"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"] + 0.001;
      $lv_options = apply_filters("hsmember_edit_during_save_data",$lv_options);
      $lv_options = ws_plugin__s2member_configure_options_and_their_defaults ($lv_options);
      update_option ("ws_plugin__s2member_options", $lv_options);
    }
  } // end of function hsmember_edit_save_data()
}
?>
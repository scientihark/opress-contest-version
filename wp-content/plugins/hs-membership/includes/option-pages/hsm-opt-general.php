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
/* Include Page Header and Credits                                                                */
/**************************************************************************************** 0.9.0 ***/
include_once dirname(dirname(__FILE__))."/option-pages/hsm-opt-header.php";

/**************************************************************************************************/
/* Login required page options                                                                    */
/**************************************************************************************** 0.9.0 ***/
if (apply_filters("hsmember_options_login_required_page", true, get_defined_vars ())) {
  do_action("hsmember_options_before_login_required_page", get_defined_vars ());
  echo "<h3>Login Required Page</h3>\n";
  echo "<table class='form-table'>\n";
    echo "<tr valign='top'>\n";
      echo "<th scope='row'>\n";
        echo "<label for='hsmember_options-login-required-page'>\n";
          echo "Login Required Page\n";
        echo "</label>\n";
      echo "</th>\n";
      echo "<td>\n";
        echo "<select name='hsmember_options_login_required_page'";
               echo " id='hsmember-options-login-required-page'>\n";
          echo "<option value=''>&mdash; Disabled &mdash;</option>\n";
          foreach (($lv_pages = array_merge((array)get_pages())) as $lv_page) {
            echo "<option value='".esc_attr($lv_page->ID)."'";
              echo ($lv_page->ID == $GLOBALS["_HSMEMBER_"]["o"]["login_required_page"]
                    ? " selected='selected'>" : ">");
            echo  esc_html($lv_page->post_title)."</option>\n";
          }
        echo "</select><br />\n";
        echo "Please choose a Page that prompt Visitors to login or signup for an account.<br /><br />\n";
        echo "Create and/or choose an existing Page that request the user to log in or register for";
        echo " an account. This is the page that Visitors will be redirected to, should they";
        echo " attempt to access an area of your site that requires the Visitor to be registered to";
        echo " view.<br /><br />\n";
        echo "This page does not replace the Membership Options Page option provided by s2Member,";
        echo " but will be displayed before the Membership Options Page is displayed. This is";
        echo " required to prevent the user's payment status being overwritten by the signup process.\n";
      echo "</td>\n";
    echo "</tr>\n";
  echo "</table>\n";
  do_action("hsmember_options_after_login_required_page", get_defined_vars ());
}

/**************************************************************************************************/
/* Blog Creation restriction options                                                              */
/**************************************************************************************** 0.9.0 ***/
if (apply_filters("hsmember_options_blog_create_access",true, get_defined_vars()) &&
		version_compare(WS_PLUGIN__S2MEMBER_VERSION,'3.2','<')) {
  do_action ("hsmember_options_before_blog_create_access", get_defined_vars ());
  echo "<h3>Blog Creation Restriction</h3>\n";
  echo "<table class='form-table'>\n";
    echo "<tr valign='top'>\n";
      echo "<th scope='row'>\n";
        echo "<label for='hsmember-options-blog-create-access'>\n";
          echo "Blog Creation Access Level:\n";
        echo "</label>\n";
      echo "</th>\n";
      echo "<td>\n";
        echo "<select name='hsmember_options_blog_create_access'";
               echo " id='hsmember-options-blog-create-access'>\n";
          echo "<option value='0'>&mdash; Disabled &mdash;</option>\n";
          for ($lv_lvl=1;$lv_lvl<=4;$lv_lvl++) {
            echo "<option value='$lv_lvl'";
              echo ($GLOBALS["_HSMEMBER_"]["o"]["blog_create_access"] == $lv_lvl
                 ? " selected='selected'>" : ">");
              echo "s2Member Level $lv_lvl</option>\n";
          }
        echo "</select><br />\n";
        echo "Please select the minimum user level that can create new blogs or disabled if all";
        echo " users can create blogs.<br /><br />\n";
        echo "This option allow you to restrict access for users to create a new blog. Select the";
        echo " user level that can create new blogs. The default is 'disabled' that will allow";
        echo " all users to create blogs<br /><br />\n";
        echo "IMPORTANT: When this option is used, the 'Allow new registrations' option under the";
        echo " Super Admin menu will controlled and overwritten by this option.\n";
       echo "</td>\n";
     echo "</tr>\n";
   echo "</table>\n";
  do_action ("msmember_options_after_blog_create_access",get_defined_vars ());
}

/**************************************************************************************************/
/* Page footer and submit buttons                                                                 */
/**************************************************************************************** 0.9.0 ***/
include_once dirname(dirname(__FILE__))."/option-pages/hsm-opt-footer.php";
?>
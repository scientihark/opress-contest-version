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
/* Check for dependancies                                                                         */
/**************************************************************************************** 0.9.0 ***/
if (!version_compare(PHP_VERSION,HSMEMBER_MIN_PHP_VERSION,">="))
  echo "<div class='error fade'><p>You need PHP version ".HSMEMBER_MIN_PHP_VERSION." to use the HS-Membership plugin.</p></div>";
if (!version_compare(get_bloginfo ("version"),HSMEMBER_MIN_WP_VERSION, ">="))
  echo "<div class='error fade'><p>You need Wordpress version ".HSMEMBER_MIN_WP_VERSION." to use the HS-Membership plugin.</p></div>";
if (!version_compare(WS_PLUGIN__S2MEMBER_VERSION,HSMEMBER_MIN_S2_VERSION, ">="))
  echo "<div class='error fade'><p>You need s2Member version ".HSMEMBER_MIN_S2_VERSION." to use the HS-Membership plugin.</p></div>";
if (defined(BP_VERSION) && !version_compare(BP_VERSION,HSMEMBER_MIN_BP_VERSION, ">="))
  echo "<div class='error fade'><p>You need BuddyPress version ".HSMEMBER_MIN_BP_VERSION." to use the HS-Membership plugin.</p></div>";

/**************************************************************************************************/
/* Page Header and Credits                                                                        */
/**************************************************************************************** 0.9.0 ***/
echo "<div class='wrap'>\n";
  echo "<div id='icon-plugins' class='icon32'><br /></div>\n";
  echo "<h2>HS-Membership General Options<div>Developed by <a href='http://haden.cc' target='_blank'>Haden Software</a></div></h2>\n";
/*  echo "<div id='message' class='updated fade'>\n";
    echo "This options page is added by the Multi-Site Membership plugin. The Multi-Site Membership";
    echo " plugin as an addon pluging to the s2Member Plugin, that specifically address Multi-Site";
    echo " issues. For the full functionality of the Multi-Site Membership plugin, please ensure that";
    echo " at least version ".HSMEMBER_MIN_S2_VERSION." of s2Member and version ";
    echo   HSMEMBER_MIN_BP_VERSION." of the BuddyPress is installed.\n";
  echo "</div>\n";*/
  echo "<form method='post'";
       echo " name='hsmember_options_form'";
       echo " id='hsmember-options-form'>\n";
    echo "<input type='hidden'";
          echo " name='hsmember_options_nonce'";
          echo " id='hsmember-options-nonce'";
          echo " value='".esc_attr(wp_create_nonce("hsmember-options-nonce"))."'/>\n";


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
/* Page footer and submit buttons                                                                 */
/**************************************************************************************** 0.9.0 ***/
	echo "<p class='submit'>";
      echo "<input type='submit' class='button-primary' name='Submit' value='Save Changes' />";
    echo "</p>\n";
  echo "</form>";
echo "</div>\n";


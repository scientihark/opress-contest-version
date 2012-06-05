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

/* Include all of the functions that came with this plugin. */
if (is_dir(dirname(__FILE__)."/functions"))
  if ($lv_temp_r = opendir(dirname(__FILE__)."/functions"))
    while (($lv_temp_s = readdir($lv_temp_r)) !== false)
      if (preg_match("/\.php$/",$lv_temp_s) && !preg_match ("/^index\.php$/i", $lv_temp_s))
        include_once dirname(__FILE__)."/functions/".$lv_temp_s;
?>
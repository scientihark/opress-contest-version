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
/* This file contain functions used to update and configure the $GLOBALS values for the           */
/*  HS-Membership Plugin                                                                          */
/* Functions provided:                                                                            */
/*  hsmember_globals_options_load - Function to load option values to the $GLOBALS                */
/*                                  variable                                                      */
/*  hsmember_globals_options_save - Function to save the option values from the $GLOBALS variable */
/*                                  to the data tables                                            */
/* Hooks Provided:                                                                                */
/*  hsmember_options_load - Filter to modify the options after it has been loaded.                */
/*  hsmember_options_save - Action to modify the options before they are saved to the data tables.*/
/**************************************************************************************************/

/**************************************************************************************************/
/* Function to update the $GLOBALS['_HSMEMBER_'] and save its data to the data tables.            */
/*  If an input parameter is supplied, the it will be merged with $GLOBALS['_HSMEMBER_'].         */
/*  The result will be saved to the data tables.                                                  */
/*  The data will also be checked for data integrity and set to default values where needed.      */
/* Input Parameters:                                                                              */
/*  $options - Value supplied by the calling function.                                            */
/* Version History:                                                                               */
/*  0.9.4 - Created                                                                               */
/**************************************************************************************************/
if (!function_exists ("hsmember_globals_option_save")) {
  function hsmember_globals_option_save($options = "") {
    $def = hsmember_configure_options_defaults();
    if ($options != "")
      $GLOBALS["_HSMEMBER_"]["o"] = array_merge($GLOBALS["_HSMEMBER_"]["o"],(array)$options);
    hsmember_configure_options_validate();
    do_action("hsmember_options_update");
    update_option("hsmember_options",$GLOBALS["_HSMEMBER_"]["o"]);
  } // end of hsmember_configure_option_update()
}
?>
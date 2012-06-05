<?php
/*
Copyright: ©2011 Haden Software
Plugin Name: HS-Membership
Author URI: http://haden.cc/
Author: Haden Software
Version: 1.0

Requirements
Requires: WordPress 3.0+, s2Member 3.1.2+, PHP 5.2+
Tested up to: WordPress 3.2.1, s2Member 110815

Description: Addon plugin to s2Member. Additional functionality for Multi-Site Installations. s2Member 3.1.2 required.
Tags: membership, members, member, register, signup, paypal, pay pal, s2member, subscriber, members only, buddypress, buddy press, buddy press compatible, shopping cart, checkout, api, options panel included, websharks framework, w3c validated code, multi widget support, includes extensive documentation, highly extensible 
 
Released under the terms of the GNU General Public License.
You should have received a copy of the GNU General Public License,
along with this software. In the main directory, see: /licensing/
If not, see: <http://www.gnu.org/licenses/>.
*/ 

/**************************************************************************************************/
/* Direct access denial.                                                                          */
/**************************************************************************************** 1.0.0 ***/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
  exit ("Do not access this file directly.");

/**************************************************************************************************/
/* Define versions.                                                                               */
/**************************************************************************************** 1.0.0 ***/
define ("HSMEMBER_VERSION", "1.0.0");
define ("HSMEMBER_MIN_S2_VERSION", "3.1.2");
define ("HSMEMBER_MIN_BP_VERSION", "1.2.5.2");
define ("HSMEMBER_MIN_PHP_VERSION", "5.2");
define ("HSMEMBER_MIN_WP_VERSION", "3.0");

/**************************************************************************************************/
/* Include files                                                                                  */
/**************************************************************************************** 1.0.0 ***/
do_action ("hsmember_before_loaded");
$GLOBALS["_HSMEMBER_"]["l"] = __FILE__;
include_once dirname (__FILE__)."/includes/hsm-configure.php";
include_once dirname (__FILE__)."/includes/hsm-hooks.php";
include_once dirname (__FILE__)."/includes/hsm-functions.php";
do_action ("hsmember_after_loaded");
?>
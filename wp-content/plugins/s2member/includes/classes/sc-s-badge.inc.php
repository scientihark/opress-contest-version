<?php
/**
* Shortcode for `[s2Member-Security-Badge /]`.
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\Security_Badges
* @since 110524RC
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_sc_s_badge"))
	{
		/**
		* Shortcode for `[s2Member-Security-Badge /]`.
		*
		* @package s2Member\Security_Badges
		* @since 110524RC
		*/
		class c_ws_plugin__s2member_sc_s_badge
			{
				/**
				* Handles the Shortcode for: `[s2Member-Security-Badge /]`.
				*
				* @package s2Member\Security_Badges
				* @since 110524RC
				*
				* @attaches-to ``add_shortcode("s2Member-Security-Badge");``
				*
				* @param array $attr An array of Attributes.
				* @param str $content Content inside the Shortcode.
				* @param str $shortcode The actual Shortcode name itself.
				* @return inner Return-value of inner routine.
				*/
				public static function sc_s_badge ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						return c_ws_plugin__s2member_sc_s_badge_in::sc_s_badge ($attr, $content, $shortcode);
					}
			}
	}
?>
<?php
/**
* Shortcode `[s2Key /]`.
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
* @package s2Member\s2Key
* @since 110912
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_sc_keys"))
	{
		/**
		* Shortcode `[s2Key /]`.
		*
		* @package s2Member\s2Key
		* @since 110912
		*/
		class c_ws_plugin__s2member_sc_keys
			{
				/**
				* Handles the Shortcode for: `[s2Key /]`.
				*
				* @package s2Member\s2Key
				* @since 110912
				*
				* @attaches-to ``add_shortcode("s2Key");``
				*
				* @param array $attr An array of Attributes.
				* @param str $content Content inside the Shortcode.
				* @param str $shortcode The actual Shortcode name itself.
				* @return inner Return-value of inner routine.
				*/
				public static function sc_get_key ($attr = FALSE, $content = FALSE, $shortcode = FALSE)
					{
						return c_ws_plugin__s2member_sc_keys_in::sc_get_key ($attr, $content, $shortcode);
					}
			}
	}
?>
<?php
/**
* HTML utilities.
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
* @package s2Member\Utilities
* @since 110720
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_html"))
	{
		/**
		* HTML utilities.
		*
		* @package s2Member\Utilities
		* @since 110720
		*/
		class c_ws_plugin__s2member_utils_html
			{
				/**
				* Returns a DOCTYPE tag along with the HEAD section and title tag.
				*
				* This method should NOT be called upon until
				* {@link s2Member\API_Constants\c_ws_plugin__s2member_constants::constants()}
				* has been processed. We need access to: ``WS_PLUGIN__S2MEMBER_API_CONSTANTS_MD5``.
				*
				* @package s2Member\Utilities
				* @since 110720
				*
				* @param str $doctype_html_head_title Optional. The title of the HTML document being generated.
				* @param str $doctype_html_head_action Optional. An action Hook to process during HEAD generation.
				* @return str A DOCTYPE tag along with the HEAD section and title tag, configured by parameters.
				*/
				public static function doctype_html_head ($doctype_html_head_title = FALSE, $doctype_html_head_action = FALSE)
					{
						$s2o = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["s2o_url"]; /* Loads s2Member only. */
						/**/
						ob_start (); /* Start output buffering here so we can "return" the output from this utility. */
						/**/
						echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . "\n";
						/**/
						echo '<html xmlns="http://www.w3.org/1999/xhtml">' . "\n";
						echo '<head>' . "\n";
						/**/
						echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />' . "\n";
						/**/
						echo '<script type="text/javascript" src="' . esc_attr (site_url ("/wp-includes/js/jquery/jquery.js?ver=" . urlencode (c_ws_plugin__s2member_utilities::ver_checksum ()))) . '"></script>' . "\n";
						echo '<script type="text/javascript" src="' . esc_attr (site_url ("/wp-includes/js/l10n.js?ver=" . urlencode (c_ws_plugin__s2member_utilities::ver_checksum ()))) . '"></script>' . "\n";
						/**/
						echo '<script type="text/javascript">' . "var pwsL10n = {empty: '" . c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Strength indicator", "s2member-front", "s2member")) . "', short: '" . c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Very weak", "s2member-front", "s2member")) . "', bad: '" . c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Weak", "s2member-front", "s2member")) . "', good: '" . c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Medium", "s2member-front", "s2member")) . "', strong: '" . c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Strong", "s2member-front", "s2member")) . "', mismatch: '" . c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Mismatch", "s2member-front", "s2member")) . "'}; try{convertEntities(pwsL10n);}catch(e){};</script>" . "\n";
						echo '<script type="text/javascript" src="' . esc_attr (site_url ("/wp-admin/js/password-strength-meter.js?ver=" . urlencode (c_ws_plugin__s2member_utilities::ver_checksum ()))) . '"></script>' . "\n";
						/**/
						echo '<script type="text/javascript" src="' . esc_attr ($s2o . "?ws_plugin__s2member_js_w_globals=" . urlencode (WS_PLUGIN__S2MEMBER_API_CONSTANTS_MD5) . "&amp;qcABC=1&amp;ver=" . urlencode (c_ws_plugin__s2member_utilities::ver_checksum ())) . '"></script>' . "\n";
						/**/
						echo '<link href="' . esc_attr ($s2o . "?ws_plugin__s2member_css=1&amp;qcABC=1&amp;ver=" . urlencode (c_ws_plugin__s2member_utilities::ver_checksum ())) . '" type="text/css" rel="stylesheet" media="all" />' . "\n";
						/**/
						if ($doctype_html_head_title) /* Add <title></title> tag? */
							echo '<title>' . $doctype_html_head_title . '</title>' . "\n";
						/**/
						if ($doctype_html_head_action) /* Add content from Hook? */
							do_action ($doctype_html_head_action, get_defined_vars ());
						/**/
						echo '</head>' . "\n";
						/**/
						return ob_get_clean ();
					}
			}
	}
?>
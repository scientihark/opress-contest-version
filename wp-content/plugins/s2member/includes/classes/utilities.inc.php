<?php
/**
* General utilities.
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
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utilities"))
	{
		/**
		* General utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utilities
			{
				/**
				* Evaluates PHP code, and "returns" output.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $code A string of data, possibly with embedded PHP code.
				* @return str Output after PHP evaluation.
				*/
				public static function evl ($code = FALSE)
					{
						ob_start (); /* Output buffer. */
						/**/
						eval ("?>" . trim ($code));
						/**/
						return ob_get_clean ();
					}
				/**
				* Buffers ( gets ) function output.
				*
				* A variable length of additional arguments are possible.
				* Additional parameters get passed into the ``$function``.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $function Name of a function to call upon.
				* @return str Output after call to function.
				* 	Any output is buffered and returned.
				*/
				public static function get ($function = FALSE)
					{
						$args = func_get_args ();
						$function = array_shift ($args);
						/**/
						if (is_string ($function) && $function)
							{
								ob_start ();
								/**/
								if (is_array ($args) && !empty ($args))
									{
										$return = call_user_func_array ($function, $args);
									}
								else /* There are no additional arguments to pass. */
									{
										$return = call_user_func ($function);
									}
								/**/
								$echo = ob_get_clean ();
								/**/
								return (!strlen ($echo) && strlen ($return)) ? $return : $echo;
							}
						else /* Else return null. */
							return;
					}
				/**
				* Builds a version checksum for this installation.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @return str String with `[version]-[pro version]-[consolidated checksum]`.
				*/
				public static function ver_checksum ()
					{
						$checksum = WS_PLUGIN__S2MEMBER_VERSION; /* Software version string. */
						$checksum .= (c_ws_plugin__s2member_utils_conds::pro_is_installed ()) ? "-" . WS_PLUGIN__S2MEMBER_PRO_VERSION : ""; /* Pro version string? */
						$checksum .= "-" . abs (crc32 ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["checksum"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_checksum"] . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["options_version"]));
						/**/
						return $checksum; /* ( i.e. version-pro version-checksum ) */
					}
				/**
				* String with all version details *( for PHP, WordPress®, s2Member, and Pro )*.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @return str String with `PHP vX.XX :: WordPress® vX.XX :: s2Member® vX.XX :: s2Member® Pro vX.XX`.
				*/
				public static function ver_details ()
					{
						$details = "PHP v" . PHP_VERSION . " :: WordPress® v" . get_bloginfo ("version") . " :: s2Member® v" . WS_PLUGIN__S2MEMBER_VERSION;
						$details .= (c_ws_plugin__s2member_utils_conds::pro_is_installed ()) ? " :: s2Member® Pro v" . WS_PLUGIN__S2MEMBER_PRO_VERSION : "";
						/**/
						return $details; /* Return all details. */
					}
				/**
				* Generates s2Member Security Badge.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $v A variation number to display. Defaults to `1`.
				* @param bool $no_cache Defaults to false. If true, the HTML markup will contain query string params that prevent caching.
				* @param bool $display_on_failure. Defaults to false. True if we need to display the "NOT yet verified" version inside admin panels.
				* @return str HTML markup for display of s2Member Security Badge.
				*/
				public static function s_badge_gen ($v = "1", $no_cache = FALSE, $display_on_failure = FALSE)
					{
						if ($v && file_exists (($template = dirname (dirname (__FILE__)) . "/templates/badges/s-badge.php")))
							{
								$badge = trim (c_ws_plugin__s2member_utilities::evl (file_get_contents ($template)));
								$badge = preg_replace ("/%%site_url%%/i", urlencode (site_url ()), preg_replace ("/%%v%%/i", (string)$v, $badge));
								$badge = preg_replace ("/%%no_cache%%/i", (($no_cache) ? "&amp;no_cache=" . urlencode (mt_rand (0, PHP_INT_MAX)) : ""), $badge);
								$badge = preg_replace ("/%%display_on_failure%%/i", (($display_on_failure) ? "&amp;display_on_failure=1" : ""), $badge);
							}
						/**/
						return (!empty ($badge)) ? $badge : ""; /* Return Security Badge. */
					}
				/**
				* Acquires information about memory usage.
				*
				* @package s2Member\Utilities
				* @since 110815
				*
				* @return str String with `Memory x MB :: Real Memory x MB :: Peak Memory x MB :: Real Peak Memory x MB`.
				*/
				public static function mem_details ()
					{
						$memory = number_format (memory_get_usage () / 1048576, 2, ".", "");
						$real_memory = number_format (memory_get_usage (true) / 1048576, 2, ".", "");
						$peak_memory = number_format (memory_get_peak_usage () / 1048576, 2, ".", "");
						$real_peak_memory = number_format (memory_get_peak_usage (true) / 1048576, 2, ".", "");
						/**/
						$details = "Memory " . $memory . " MB :: Real Memory " . $real_memory . " MB :: Peak Memory " . $peak_memory . " MB :: Real Peak Memory " . $real_peak_memory . " MB";
						/**/
						return $details; /* Return all details. */
					}
				/**
				* Acquires s2Member options for the Main Site of a Multisite Network.
				*
				* @package s2Member\Utilities
				* @since 110912
				*
				* @return array Array of s2Member options for the Main Site.
				*/
				public static function mms_options ()
					{
						return (is_multisite ()) ? (array)get_site_option ("ws_plugin__s2member_options") : array ();
					}
				/**
				* Builds an array of backtrace callers.
				*
				* @package s2Member\Utilities
				* @since 110912
				*
				* @param array $debug_backtrace Optional. Defaults to ``debug_backtrace()``.
				* @return array Array of backtrace callers (lowercase).
				*/
				public static function callers ($debug_backtrace = FALSE)
					{
						$callers = array (); /* Initialize array. */
						foreach (($debug_backtrace = (is_array ($debug_backtrace)) ? $debug_backtrace : debug_backtrace ()) as $caller)
							if (isset ($caller["class"], $caller["function"]) || (!isset ($caller["class"]) && isset ($caller["function"])))
								$callers[] = (isset ($caller["class"])) ? $caller["class"] . "::" . $caller["function"] : $caller["function"];
						/**/
						return array_map ("strtolower", array_unique ($callers));
					}
			}
	}
?>
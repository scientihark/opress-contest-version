<?php
/**
* Login redirections.
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
* @package s2Member\Login_Redirects
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_login_redirects"))
	{
		/**
		* Login redirections.
		*
		* @package s2Member\Login_Redirects
		* @since 3.5
		*/
		class c_ws_plugin__s2member_login_redirects
			{
				/**
				* Handles login redirections.
				*
				* @package s2Member\Login_Redirects
				* @since 3.5
				*
				* @attaches-to ``add_action("wp_login");``
				*
				* @param str $username Expects Username to be passed in by the Action Hook.
				* @return null Or exits script execution after a redirection takes place.
				*/
				public static function login_redirect ($username = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_login_redirect", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$username = (!$username && is_object ($user = wp_get_current_user ()) && !empty ($user->user_login)) ? strtolower ($user->user_login) : strtolower ($username);
						/**/
						if ($username && ((isset ($user) && is_object ($user)) || is_object ($user = new WP_User ($username))) && !empty ($user->ID) && ($user_id = $user->ID))
							{
								if (!get_user_option ("s2member_registration_ip", $user_id)) /* Have we got this yet? */
									update_user_option ($user_id, "s2member_registration_ip", $_SERVER["REMOTE_ADDR"]);
								/**/
								if (($logins = (int)get_user_option ("s2member_login_counter", $user_id) + 1) >= 1 || ($logins = 1))
									update_user_option ($user_id, "s2member_login_counter", $logins);
								/**/
								if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_password"]) /* Nag em? */
									delete_user_setting ("default_password_nag") . update_user_option ($user_id, "default_password_nag", false, true);
								/**/
								$disable_login_ip_restrictions = apply_filters ("ws_plugin__s2member_disable_login_ip_restrictions", false, get_defined_vars ());
								/**/
								if (($ok = true) && !is_super_admin ($user_id) && $username !== "demo" && !$disable_login_ip_restrictions)
									$ok = c_ws_plugin__s2member_ip_restrictions::ip_restrictions_ok ($_SERVER["REMOTE_ADDR"], $username);
								/**/
								if (($redirect = apply_filters ("ws_plugin__s2member_login_redirect", (($user->has_cap ("edit_posts")) ? false : true), get_defined_vars ())))
									{
										$obey_redirect_to = apply_filters ("ws_plugin__s2member_obey_login_redirect_to", /* By default, we obey this. */ true, get_defined_vars ());
										/**/
										if (!$obey_redirect_to || empty ($_REQUEST["redirect_to"]) || !is_string ($_REQUEST["redirect_to"]) || $_REQUEST["redirect_to"] === admin_url () || preg_match ("/^\/?wp-admin\/?$/", $_REQUEST["redirect_to"]))
											{
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_login_redirect", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
												/**/
												if ($redirect && is_string ($redirect)) /* Is this a string? */
													wp_redirect ($redirect); /* Dynamic URL introduced by a Filter? */
												/**/
												else if ($redirection_url = c_ws_plugin__s2member_login_redirects::login_redirection_url ($user))
													wp_redirect ($redirection_url); /* Special Redirection URL configured with s2Member. */
												/**/
												else /* Else we use the Login Welcome Page configured for s2Member. */
													wp_redirect (get_page_link ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_welcome_page"]));
												/**/
												exit (); /* Clean exit. */
											}
									}
							}
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_after_login_redirect", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						return; /* Return for uniformity. */
					}
				/**
				* Parses a Special Login Redirection URL.
				*
				* @package s2Member\Login_Redirects
				* @since 3.5
				*
				* @param obj $user Optional. A WP_User object. Defaults to the current User, if logged-in.
				* @param bool $root_returns_false Defaults to false. True if the function should return false when a URL is reduced to the site root.
				* @return str|bool A Special Login Redirection URL with Replacement Codes having been parsed, or false if ``$root_returns_false = true`` and the URL is the site root.
				*/
				public static function login_redirection_url ($user = FALSE, $root_returns_false = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_login_redirection_url", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$url = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["login_redirection_override"];
						$url = c_ws_plugin__s2member_login_redirects::fill_login_redirect_rc_vars ($url, $user, $root_returns_false);
						/**/
						return apply_filters ("ws_plugin__s2member_login_redirection_url", $url, get_defined_vars ());
					}
				/**
				* Parses a Special Login Redirection URI.
				*
				* @package s2Member\Login_Redirects
				* @since 3.5
				*
				* @param obj $user Optional. A WP_User object. Defaults to the current User, if logged-in.
				* @param bool $root_returns_false Defaults to false. True if the function should return false when a URI is reduced to the site root.
				* @return str|bool A Special Login Redirection URI with Replacement Codes having been parsed, or false if ``$root_returns_false = true`` and the URI is the site root.
				*/
				public static function login_redirection_uri ($user = FALSE, $root_returns_false = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_login_redirection_uri", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (($url = c_ws_plugin__s2member_login_redirects::login_redirection_url ($user, $root_returns_false)))
							$uri = c_ws_plugin__s2member_utils_urls::parse_uri ($url);
						/**/
						return apply_filters ("ws_plugin__s2member_login_redirection_uri", ((!empty ($uri)) ? $uri : false), get_defined_vars ());
					}
				/**
				* Fills Replacement Codes in Special Redirection URLs.
				*
				* @package s2Member\Login_Redirects
				* @since 3.5
				*
				* @param str $url A URL with possible Replacement Codes in it.
				* @param obj $user Optional. A `WP_User` object. Defaults to the current User, if logged-in.
				* @param bool $root_returns_false Defaults to false. True if the function should return false when a URL is reduced to the site root.
				* @return str|bool A Special Login Redirection URL with Replacement Codes having been parsed, or false if ``$root_returns_false = true`` and the URL is the site root.
				*/
				public static function fill_login_redirect_rc_vars ($url = FALSE, $user = FALSE, $root_returns_false = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_fill_login_redirect_rc_vars", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$url = (string)$url; /* Force ``$url`` to a string value. */
						$orig_url = $url; /* Record the original URL that was passed in. */
						/**/
						$user = ((is_object ($user) || is_object ($user = (is_user_logged_in ()) ? wp_get_current_user () : false)) && !empty ($user->ID)) ? $user : false;
						/**/
						$user_id = ($user) ? (string)$user->ID : "";
						$user_login = ($user) ? (string)strtolower ($user->user_login) : "";
						/**/
						$user_level = (string)c_ws_plugin__s2member_user_access::user_access_level ($user);
						$user_role = (string)c_ws_plugin__s2member_user_access::user_access_role ($user);
						$user_ccaps = (string)implode ("-", c_ws_plugin__s2member_user_access::user_access_ccaps ($user));
						$user_logins = ($user) ? (string)(int)get_user_option ("s2member_login_counter", $user_id) : "-1";
						/**/
						$url = preg_replace ("/%%current_user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_login), $url);
						$url = preg_replace ("/%%current_user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $url);
						$url = preg_replace ("/%%current_user_level%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_level), $url);
						$url = preg_replace ("/%%current_user_role%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_role), $url);
						$url = preg_replace ("/%%current_user_ccaps%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_ccaps), $url);
						$url = preg_replace ("/%%current_user_logins%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_logins), $url);
						/**/
						if ( /* Only if s2Member's fault » */$url !== $orig_url && (!($parse = c_ws_plugin__s2member_utils_urls::parse_url ($url, -1, false)) || (!empty ($parse["path"]) && strpos ($parse["path"], "//") !== false)))
							$url = site_url ("/"); /* Defaults to Home Page. We don't return invalid URLs produced by empty Replacement Codes ( i.e. with `//` ). */
						/**/
						if ($root_returns_false /* Used by s2Member's security gate. */ && c_ws_plugin__s2member_utils_conds::is_site_root ($url))
							$url = false; /* In case we need to return false on root URLs ( i.e. don't protect the Home Page inadvertently ). */
						/**/
						return apply_filters ("ws_plugin__s2member_fill_login_redirect_rc_vars", $url, get_defined_vars ());
					}
			}
	}
?>
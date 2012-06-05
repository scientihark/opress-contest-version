<?php
/**
* PayPal® utilities.
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
* @package s2Member\PayPal
* @since 3.5
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_paypal_utilities"))
	{
		/**
		* PayPal® utilities.
		*
		* @package s2Member\PayPal
		* @since 3.5
		*/
		class c_ws_plugin__s2member_paypal_utilities
			{
				/**
				* Get ``$_POST`` or ``$_REQUEST`` vars from PayPal®.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @return array|bool An array of verified ``$_POST`` or ``$_REQUEST`` variables, else false.
				*/
				public static function paypal_postvars ()
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_postvars", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/*
						Custom conditionals can be applied by filters.
						*/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						if (!($postvars = apply_filters ("ws_plugin__s2member_during_paypal_postvars_conditionals", array (), get_defined_vars ())))
							{
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (!empty ($_GET["tx"]) && empty ($_GET["s2member_paypal_proxy"]))
									{
										$postback["tx"] = $_GET["tx"];
										$postback["cmd"] = "_notify-synch";
										$postback["at"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_identity_token"];
										/**/
										$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
										/**/
										if (preg_match ("/^SUCCESS/i", ($response = trim (c_ws_plugin__s2member_utils_urls::remote ("https://" . $endpoint . "/cgi-bin/webscr", $postback, array ("timeout" => 20))))))
											{
												foreach (preg_split ("/[\r\n]+/", preg_replace ("/^SUCCESS/i", "", $response)) as $varline)
													{
														list ($key, $value) = preg_split ("/\=/", $varline, 2);
														if (strlen ($key = trim ($key)) && strlen ($value = trim ($value)))
															$postvars[$key] = trim (stripslashes (urldecode ($value)));
													}
												/**/
												return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
											}
										else /* Nope. */
											return false;
									}
								else if (!empty ($_REQUEST) && is_array ($postvars = stripslashes_deep ($_REQUEST)))
									{
										foreach ($postvars as $key => $value)
											if (preg_match ("/^s2member_/", $key))
												unset ($postvars[$key]);
										/**/
										$postback = $postvars; /* Copy. */
										$postback["cmd"] = "_notify-validate";
										/**/
										$postvars = c_ws_plugin__s2member_utils_strings::trim_deep ($postvars);
										/**/
										$endpoint = ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "www.sandbox.paypal.com" : "www.paypal.com";
										/**/
										if (!empty ($_GET["s2member_paypal_proxy"]) && !empty ($_GET["s2member_paypal_proxy_verification"]) && $_GET["s2member_paypal_proxy_verification"] === c_ws_plugin__s2member_paypal_utilities::paypal_proxy_key_gen ())
											return apply_filters ("ws_plugin__s2member_paypal_postvars", array_merge ($postvars, array ("proxy_verified" => $_GET["s2member_paypal_proxy"])), get_defined_vars ());
										/**/
										else if (empty ($_POST) && !empty ($_GET["s2member_paypal_proxy"]) && !empty ($_GET["s2member_paypal_proxy_verification"]) && c_ws_plugin__s2member_utils_urls::s2member_sig_ok ($_SERVER["REQUEST_URI"], false, false, "s2member_paypal_proxy_verification"))
											return apply_filters ("ws_plugin__s2member_paypal_postvars", array_merge ($postvars, array ("proxy_verified" => $_GET["s2member_paypal_proxy"])), get_defined_vars ());
										/**/
										else if (trim (strtolower (c_ws_plugin__s2member_utils_urls::remote ("https://" . $endpoint . "/cgi-bin/webscr", $postback, array ("timeout" => 20)))) === "verified")
											return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
										/**/
										else /* Nope. */
											return false;
									}
								else /* Nope. */
									return false;
							}
						else /* Else a custom conditional has been applied by Filters. */
							{
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("ws_plugin__s2member_paypal_postvars", $postvars, get_defined_vars ());
							}
					}
				/**
				* Generates a PayPal® Proxy Key, for simulated IPN responses.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @return str A Proxy Key. It's an MD5 Hash, 32 chars, URL-safe.
				*/
				public static function paypal_proxy_key_gen () /* Generate Key. */
					{
						global $current_site, $current_blog; /* Multisite Networking. */
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_proxy_key_gen", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_multisite () && !is_main_site ())
							$key = md5 (c_ws_plugin__s2member_utils_encryption::xencrypt ($current_blog->domain . $current_blog->path, false, false));
						/**/
						else /* Else it's a standard Proxy Key; not on a Multisite Network, or not on the Main Site anyway. */
							$key = md5 (c_ws_plugin__s2member_utils_encryption::xencrypt (preg_replace ("/\:[0-9]+$/", "", $_SERVER["HTTP_HOST"]), false, false));
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_proxy_key_gen", $key, get_defined_vars ());
					}
				/**
				* Calls upon the PayPal® API, and returns the response.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param array $post_vars An array of variables to send through the PayPal® API call.
				* @return array An array of variables returned by the PayPal® API.
				*
				* @todo Optimize this routine with ``empty()`` and ``isset()``.
				* @todo Possibly integrate this API: {@link http://msdn.microsoft.com/en-us/library/ff512417.aspx}.
				*/
				public static function paypal_api_response ($post_vars = FALSE)
					{
						global /* For Multisite support. */ $current_site, $current_blog;
						/**/
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_api_response", get_defined_vars ());
						unset /* Unset defined __refs, __v. */ ($__refs, $__v);
						/**/
						$url = "https://" . (($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_sandbox"]) ? "api-3t.sandbox.paypal.com" : "api-3t.paypal.com") . "/nvp";
						/**/
						$post_vars = apply_filters ("ws_plugin__s2member_paypal_api_post_vars", $post_vars, get_defined_vars ());
						$post_vars = (is_array ($post_vars)) ? $post_vars : array ();
						/**/
						$post_vars["VERSION"] = /* Configure the PayPal® API version. */ "71.0";
						$post_vars["USER"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_username"];
						$post_vars["PWD"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_password"];
						$post_vars["SIGNATURE"] = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["paypal_api_signature"];
						/**/
						$input_time = /* Record input/nvp for logging. */ date ("D M j, Y g:i:s a T");
						/**/
						$nvp = trim (c_ws_plugin__s2member_utils_urls::remote ($url, $post_vars, array ("timeout" => 20)));
						/**/
						$output_time = /* Now record after output time. */ date ("D M j, Y g:i:s a T");
						/**/
						wp_parse_str /* Parse NVP response. */ ($nvp, $response);
						$response = c_ws_plugin__s2member_utils_strings::trim_deep ($response);
						/**/
						if (!$response["ACK"] || !preg_match ("/^(Success|SuccessWithWarning)$/i", $response["ACK"]))
							{
								if (strlen ($response["L_ERRORCODE0"]) || $response["L_SHORTMESSAGE0"] || $response["L_LONGMESSAGE0"])
									/* translators: Exclude `%2$s` and `%3$s`. These are English details returned by PayPal®. Replace `%2$s` and `%3$s` with: `Unable to process, please try again`, or something to that affect. Or, if you prefer, you could Filter ``$response["__error"]`` with `ws_plugin__s2member_paypal_api_response`. */
									$response["__error"] = sprintf (_x ('Error #%1$s. %2$s. %3$s.', "s2member-front", "s2member"), $response["L_ERRORCODE0"], rtrim ($response["L_SHORTMESSAGE0"], "."), rtrim ($response["L_LONGMESSAGE0"], "."));
								/**/
								else /* Else, generate an error messsage - so something is reported back to the Customer. */
									$response["__error"] = _x ("Error. Please contact Support for assistance.", "s2member-front", "s2member");
							}
						/**/
						$logv = c_ws_plugin__s2member_utilities::ver_details ();
						$logm = c_ws_plugin__s2member_utilities::mem_details ();
						$log4 = $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . "\nUser-Agent: " . $_SERVER["HTTP_USER_AGENT"];
						$log4 = (is_multisite () && !is_main_site ()) ? ($_log4 = $current_blog->domain . $current_blog->path) . "\n" . $log4 : $log4;
						$log2 = (is_multisite () && !is_main_site ()) ? "paypal-api-4-" . trim (preg_replace ("/[^a-z0-9]/i", "-", $_log4), "-") . ".log" : "paypal-api.log";
						/**/
						if (isset ($post_vars["ACCT"]) && strlen ($post_vars["ACCT"]) > 4)
							$post_vars["ACCT"] = str_repeat ("*", strlen ($post_vars["ACCT"]) - 4) . substr ($post_vars["ACCT"], -4);
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["gateway_debug_logs"])
							if (is_dir ($logs_dir = $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["logs_dir"]))
								if (is_writable ($logs_dir) && c_ws_plugin__s2member_utils_logs::archive_oversize_log_files ())
									if (($log = "-------- Input vars: ( " . $input_time . " ) --------\n" . var_export ($post_vars, true) . "\n"))
										if (($log .= "-------- Output string/vars: ( " . $output_time . " ) --------\n" . $nvp . "\n" . var_export ($response, true)))
											file_put_contents ($logs_dir . "/" . $log2, $logv . "\n" . $logm . "\n" . $log4 . "\n" . $log . "\n\n", FILE_APPEND);
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_api_response", c_ws_plugin__s2member_paypal_utilities::_paypal_api_response_filters ($response), get_defined_vars ());
					}
				/**
				* A sort of callback function that Filters PayPal® responses.
				*
				* Provides alternative explanations in some cases that require special attention.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param array $response Expects an array of response variables returned by the PayPal® API.
				* @return array An array of variables returned by the PayPal® API, after ``$response["__error"]`` is Filtered.
				*/
				public static function _paypal_api_response_filters ($response = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("_ws_plugin__s2member_before_paypal_api_response_filters", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (!empty ($response["__error"]) && !empty ($response["L_ERRORCODE0"]))
							{
								if ((int)$response["L_ERRORCODE0"] === 10422)
									$response["__error"] = sprintf (_x ("Error #%s. Transaction declined. Please use an alternate funding source.", "s2member-front", "s2member"), $response["L_ERRORCODE0"]);
								/**/
								else if ((int)$response["L_ERRORCODE0"] === 10435)
									$response["__error"] = sprintf (_x ("Error #%s. Transaction declined. Express Checkout was NOT confirmed.", "s2member-front", "s2member"), $response["L_ERRORCODE0"]);
								/**/
								else if ((int)$response["L_ERRORCODE0"] === 10417)
									$response["__error"] = sprintf (_x ("Error #%s. Transaction declined. Please use an alternate funding source.", "s2member-front", "s2member"), $response["L_ERRORCODE0"]);
							}
						/**/
						return $response; /* Filters already applied with: ``ws_plugin__s2member_paypal_api_response``. */
					}
				/**
				* Converts a term `D|W|M|Y` into PayPal® Pro format.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param str $term Expects one of `D|W|M|Y`.
				* @return bool|str A full singular description of the term *( i.e. `Day|Week|Month|Year` )*, else false.
				*/
				public static function paypal_pro_term ($term = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_term", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$paypal_pro_terms = array ("D" => "Day", "W" => "Week", "M" => "Month", "Y" => "Year");
						/**/
						$pro_term = (!empty ($paypal_pro_terms[strtoupper ($term)])) ? $paypal_pro_terms[strtoupper ($term)] : false;
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_term", $pro_term, get_defined_vars ());
					}
				/**
				* Converts a term `Day|Week|Month|Year` into PayPal® Standard format.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param str $term Expects one of `Day|Week|Month|Year`.
				* @return bool|str A term code *( i.e. `D|W|M|Y` )*, else false.
				*/
				public static function paypal_std_term ($term = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_std_term", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						$paypal_std_terms = array ("DAY" => "D", "WEEK" => "W", "MONTH" => "M", "YEAR" => "Y");
						/**/
						$std_term = (!empty ($paypal_std_terms[strtoupper ($term)])) ? $paypal_std_terms[strtoupper ($term)] : false;
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_std_term", $std_term, get_defined_vars ());
					}
				/**
				* Get `subscr_id` from either an array with `recurring_payment_id|subscr_id`, or use an existing string.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param str|array $array_or_string Either an array of PayPal® post vars, or a string.
				* @return str|bool A `subscr_id` string if non-empty, else false.
				*/
				public static function paypal_pro_subscr_id ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_subscr_id", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && !empty ($array["recurring_payment_id"]))
							$subscr_id = trim ($array["recurring_payment_id"]);
						/**/
						else if (is_array ($array = $array_or_string) && !empty ($array["subscr_id"]))
							$subscr_id = trim ($array["subscr_id"]);
						/**/
						else if (is_string ($string = $array_or_string) && !empty ($string))
							$subscr_id = trim ($string);
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_subscr_id", ((!empty ($subscr_id)) ? $subscr_id : false), get_defined_vars ());
					}
				/**
				* Get `item_number` from either an array with `PROFILEREFERENCE|rp_invoice_id|item_number1|item_number`, or use an existing string.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param str|array $array_or_string Either an array of PayPal® post vars, or a string.
				* 	If it's a string, we make sure it is a valid `level:ccaps:eotper` or `sp:ids:expiration` combination.
				* @return str|bool An `item_number` string if non-empty, else false.
				*/
				public static function paypal_pro_item_number ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_item_number", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && (!empty ($array["PROFILEREFERENCE"]) || !empty ($array["rp_invoice_id"])))
							list ($_reference, $_domain, $_item_number) = array_map ("trim", preg_split ("/~/", ((!empty ($array["PROFILEREFERENCE"])) ? $array["PROFILEREFERENCE"] : $array["rp_invoice_id"]), 3));
						/**/
						else if (is_array ($array = $array_or_string) && !empty ($array["item_number1"]))
							$_item_number = trim ($array["item_number1"]);
						/**/
						else if (is_array ($array = $array_or_string) && !empty ($array["item_number"]))
							$_item_number = trim ($array["item_number"]);
						/**/
						else if (is_string ($string = $array_or_string) && !empty ($string))
							$_item_number = trim ($string);
						/**/
						if (!empty ($_item_number) && preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_w_or_wo_level_regex"], $_item_number))
							$item_number = $_item_number;
						/**/
						else if (!empty ($_item_number) && preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["sp_access_item_number_regex"], $_item_number))
							$item_number = $_item_number;
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_item_number", ((!empty ($item_number)) ? $item_number : false), get_defined_vars ());
					}
				/**
				* Get `item_name` from either an array with `product_name|item_name1|item_name`, or use an existing string.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param str|array $array_or_string Either an array of PayPal® post vars, or a string.
				* @return str|bool An `item_name` string if non-empty, else false.
				*/
				public static function paypal_pro_item_name ($array_or_string = FALSE)
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_item_name", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && !empty ($array["product_name"]))
							$item_name = trim ($array["product_name"]);
						/**/
						else if (is_array ($array = $array_or_string) && !empty ($array["item_name1"]))
							$item_name = trim ($array["item_name1"]);
						/**/
						else if (is_array ($array = $array_or_string) && !empty ($array["item_name"]))
							$item_name = trim ($array["item_name"]);
						/**/
						else if (is_string ($string = $array_or_string) && !empty ($string))
							$item_name = trim ($string);
						/**/
						return apply_filters ("ws_plugin__s2member_paypal_pro_item_name", ((!empty ($item_name)) ? $item_name : false), get_defined_vars ());
					}
				/**
				* Get `period1` from either an array with `PROFILEREFERENCE|rp_invoice_id|period1`, or use an existing string.
				*
				* This will also convert `1 Day`, into `1 D`, and so on.
				* This will also convert `1 SemiMonth`, into `2 W`, and so on.
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param str|array $array_or_string Either an array of PayPal® post vars, or a string.
				* 	If it's a string, we make sure it is a valid `period term` combination.
				* @param str $default Optional. Value if unavailable. Defaults to `0 D`.
				* @return str A `period1` string if possible, or defaults to `0 D`.
				*/
				public static function paypal_pro_period1 ($array_or_string = FALSE, $default = "0 D")
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_period1", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && (!empty ($array["PROFILEREFERENCE"]) || !empty ($array["rp_invoice_id"])))
							{
								list ($_reference, $_domain, $_item_number) = array_map ("trim", preg_split ("/~/", ((!empty ($array["PROFILEREFERENCE"])) ? $array["PROFILEREFERENCE"] : $array["rp_invoice_id"]), 3));
								list ($_start_time, $_period1, $_period3) = array_map ("trim", preg_split ("/\:/", $_reference, 3));
							}
						else if (is_array ($array = $array_or_string) && !empty ($array["period1"]))
							$_period1 = trim ($array["period1"]);
						/**/
						else if (is_string ($string = $array_or_string) && !empty ($string))
							$_period1 = trim ($string);
						/**/
						if (!empty ($_period1)) /* Were we able to get a `period1` string? */
							{
								list ($num, $span) = array_map ("trim", preg_split ("/ /", $_period1, 2));
								/**/
								if (strtoupper ($span) === "SEMIMONTH")
									if (is_numeric ($num) && $num >= 1)
										eval ('$num = "2"; $span = "W";');
								/**/
								if (strlen ($span) !== 1) /* To Standard format. */
									$span = c_ws_plugin__s2member_paypal_utilities::paypal_std_term ($span);
								/**/
								$span = (preg_match ("/^[DWMY]$/i", $span)) ? $span : "";
								$num = ($span && is_numeric ($num) && $num >= 0) ? $num : "";
								/**/
								$period1 = ($num && $span) ? $num . " " . strtoupper ($span) : $default;
								/**/
								return apply_filters ("ws_plugin__s2member_paypal_pro_period1", $period1, get_defined_vars ());
							}
						else /* Default. */
							return apply_filters ("ws_plugin__s2member_paypal_pro_period1", $default, get_defined_vars ());
					}
				/**
				* Get `period3` from either an array with `PROFILEREFERENCE|rp_invoice_id|period3`, or use an existing string.
				*
				* This will also convert `1 Day`, into `1 D`, and so on.
				* This will also convert `1 SemiMonth`, into `2 W`, and so on.
				* The Regular Period can never be less than 1 day ( `1 D` ).
				*
				* @package s2Member\PayPal
				* @since 3.5
				*
				* @param str|array $array_or_string Either an array of PayPal® post vars, or a string.
				* 	If it's a string, we make sure it is a valid `period term` combination.
				* @param str $default Optional. Value if unavailable. Defaults to `1 D`.
				* @return str A `period3` string if possible, or defaults to `1 D`.
				*/
				public static function paypal_pro_period3 ($array_or_string = FALSE, $default = "1 D")
					{
						eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
						do_action ("ws_plugin__s2member_before_paypal_pro_period3", get_defined_vars ());
						unset ($__refs, $__v); /* Unset defined __refs, __v. */
						/**/
						if (is_array ($array = $array_or_string) && (!empty ($array["PROFILEREFERENCE"]) || !empty ($array["rp_invoice_id"])))
							{
								list ($_reference, $_domain, $_item_number) = array_map ("trim", preg_split ("/~/", ((!empty ($array["PROFILEREFERENCE"])) ? $array["PROFILEREFERENCE"] : $array["rp_invoice_id"]), 3));
								list ($_start_time, $_period1, $_period3) = array_map ("trim", preg_split ("/\:/", $_reference, 3));
							}
						else if (is_array ($array = $array_or_string) && !empty ($array["period3"]))
							$_period3 = trim ($array["period3"]);
						/**/
						else if (is_string ($string = $array_or_string) && !empty ($string))
							$_period3 = trim ($string);
						/**/
						if (!empty ($_period3)) /* Were we able to get a `period3` string? */
							{
								list ($num, $span) = array_map ("trim", preg_split ("/ /", $_period3, 2));
								/**/
								if (strtoupper ($span) === "SEMIMONTH")
									if (is_numeric ($num) && $num >= 1)
										eval ('$num = "2"; $span = "W";');
								/**/
								if (strlen ($span) !== 1) /* To Standard format. */
									$span = c_ws_plugin__s2member_paypal_utilities::paypal_std_term ($span);
								/**/
								$span = (preg_match ("/^[DWMY]$/i", $span)) ? $span : "";
								$num = ($span && is_numeric ($num) && $num >= 0) ? $num : "";
								/**/
								$period3 = ($num && $span) ? $num . " " . strtoupper ($span) : $default;
								/**/
								return apply_filters ("ws_plugin__s2member_paypal_pro_period3", $period3, get_defined_vars ());
							}
						else /* Default. */
							return apply_filters ("ws_plugin__s2member_paypal_pro_period3", $default, get_defined_vars ());
					}
			}
	}
?>
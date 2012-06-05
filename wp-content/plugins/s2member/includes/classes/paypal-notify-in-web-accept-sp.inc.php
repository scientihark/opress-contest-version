<?php
/**
* s2Member's PayPal® IPN handler ( inner processing routine ).
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
* @since 110720
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit ("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_paypal_notify_in_web_accept_sp"))
	{
		/**
		* s2Member's PayPal® IPN handler ( inner processing routine ).
		*
		* @package s2Member\PayPal
		* @since 110720
		*/
		class c_ws_plugin__s2member_paypal_notify_in_web_accept_sp
			{
				/**
				* s2Member's PayPal® IPN handler ( inner processing routine ).
				*
				* @package s2Member\PayPal
				* @since 110720
				*
				* @param array $vars Required. An array of defined variables passed by {@link s2Member\PayPal\c_ws_plugin__s2member_paypal_notify_in::paypal_notify()}.
				* @return array|bool The original ``$paypal`` array passed in ( extracted ) from ``$vars``, or false when conditions do NOT apply.
				*
				* @todo Optimize with ``empty()`` and ``isset()``.
				*/
				public static function cp ($vars = array ()) /* Conditional phase for ``c_ws_plugin__s2member_paypal_notify_in::paypal_notify()``. */
					{
						extract ($vars); /* Extract all vars passed in from: ``c_ws_plugin__s2member_paypal_notify_in::paypal_notify()``. */
						/**/
						if (/**/(!empty ($paypal["txn_type"]) && preg_match ("/^web_accept$/i", $paypal["txn_type"]))/**/
						&& (!empty ($paypal["item_number"]) && preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["sp_access_item_number_regex"], $paypal["item_number"]))/**/
						&& (empty ($paypal["payment_status"]) || empty ($payment_status_issues) || !preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
						&& (!empty ($paypal["payer_email"])) && (!empty ($paypal["txn_id"]))/**/)
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_before_sp_access", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (!get_transient ($transient_ipn = "s2m_ipn_" . md5 ("s2member_transient_" . $_paypal_s)) && set_transient ($transient_ipn, time (), 31556926 * 10))
									{
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as ( `web_accept` ) for Specific Post/Page Access.";
										/**/
										list (, $paypal["sp_ids"], $paypal["hours"]) = preg_split ("/\:/", $paypal["item_number"], 3);
										/**/
										$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
										$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[a-z0-9]+~[0-9\.]+$/i", $paypal["invoice"])) ? preg_replace ("/^[a-z0-9]+~/i", "", $paypal["invoice"]) : $paypal["ip"];
										/**/
										if (($sp_access_url = c_ws_plugin__s2member_sp_access::sp_access_link_gen ($paypal["sp_ids"], $paypal["hours"])) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												$processing = $during = true; /* Yes, we ARE processing this. */
												/**/
												if (preg_match ("/(referenc|associat)/i", $paypal["option_name1"]) && $paypal["option_selection1"]) /* Associating this purchase with a Member? */
													if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["option_selection1"], $paypal["option_selection1"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
														{
															$sp_references = (array)get_user_option ("s2member_sp_references", $user_id);
															$_sp_reference = array ("time" => time (), "ids" => $paypal["sp_ids"], "hours" => $paypal["hours"], "url" => $sp_access_url);
															$sp_references = c_ws_plugin__s2member_utils_arrays::array_unique (array_merge ($sp_references, $_sp_reference));
															update_user_option ($user_id, "s2member_sp_references", $sp_references);
															/**/
															$paypal["s2member_log"][] = "Specific Post/Page ~ Sale associated with User ID: " . $user_id . ".";
														}
												/**/
												$sbj = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "sp_email_subject"]);
												$sbj = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $sbj);
												/**/
												$msg = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "sp_email_message"]);
												$msg = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $msg);
												/**/
												$rec = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $GLOBALS["WS_PLUGIN__"]["s2member"]["o"][(($_GET["s2member_paypal_proxy"] && preg_match ("/pro-emails/", $_GET["s2member_paypal_proxy_use"])) ? "pro_" : "") . "sp_email_recipients"]);
												$rec = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $rec);
												/**/
												if (($rec = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $rec)) && ($rec = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $rec)))
													if (($rec = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $rec))) /* Full amount of the payment, before fee is subtracted. */
														if (($rec = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $rec)) && ($rec = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $rec)))
															if (($rec = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"])), $rec)) && ($rec = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"])), $rec)))
																if (($rec = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_dq (c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $rec))) /* **NOTE** c_ws_plugin__s2member_utils_strings::esc_dq() is applied here. ( ex. "N\"ame" <email> ). */
																	if (($rec = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $rec)))
																		if (($rec = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $rec)))
																			/**/
																			if (($sbj = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $sbj)) && ($sbj = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $sbj)))
																				if (($sbj = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $sbj))) /* Full amount of the payment, before fee is subtracted. */
																					if (($sbj = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $sbj)) && ($sbj = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $sbj)))
																						if (($sbj = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $sbj)) && ($sbj = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $sbj)))
																							if (($sbj = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $sbj)))
																								if (($sbj = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $sbj)))
																									if (($sbj = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $sbj)))
																										/**/
																										if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $msg)))
																											if (($msg = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg))) /* Full amount of the payment, before fee is subtracted. */
																												if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																													if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																														if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																															if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																																if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																																	/**/
																																	if (($rec = trim (preg_replace ("/%%(.+?)%%/i", "", $rec))) && ($sbj = trim (preg_replace ("/%%(.+?)%%/i", "", $sbj))) && ($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg))))
																																		{
																																			foreach (c_ws_plugin__s2member_utils_strings::parse_emails ($rec) as $recipient) /* Go through a possible list of recipients. */
																																				c_ws_plugin__s2member_email_configs::email_config () . wp_mail ($recipient, apply_filters ("ws_plugin__s2member_sp_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_sp_email_msg", $msg, get_defined_vars ()), "From: \"" . preg_replace ('/"/', "'", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_name"]) . "\" <" . $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"] . ">\r\nContent-Type: text/plain; charset=utf-8") . c_ws_plugin__s2member_email_configs::email_config_release ();
																																			/**/
																																			$paypal["s2member_log"][] = "Specific Post/Page Confirmation Email sent to: " . $rec . ".";
																																		}
												/**/
												if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_urls"]) as $url)
															/**/
															if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (rawurlencode ($sp_access_url)), $url)))
																if (($url = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours")))), $url)))
																	if (($url = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["txn_id"])), $url)))
																		if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																			if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																				if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																					if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																						if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["ip"])), $url)))
																							/**/
																							if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																								c_ws_plugin__s2member_utils_urls::remote ($url);
														/**/
														$paypal["s2member_log"][] = "Specific Post/Page ~ Sale Notification URLs have been processed.";
													}
												/**/
												if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														$msg = $sbj = "( s2Member / API Notification Email ) - Specific Post/Page ~ Sale";
														$msg .= "\n\n"; /* Spacing in the message body. */
														/**/
														$msg .= "sp_access_url: %%sp_access_url%%\n";
														$msg .= "sp_access_exp: %%sp_access_exp%%\n";
														$msg .= "amount: %%amount%%\n";
														$msg .= "txn_id: %%txn_id%%\n";
														$msg .= "item_number: %%item_number%%\n";
														$msg .= "item_name: %%item_name%%\n";
														$msg .= "first_name: %%first_name%%\n";
														$msg .= "last_name: %%last_name%%\n";
														$msg .= "full_name: %%full_name%%\n";
														$msg .= "payer_email: %%payer_email%%\n";
														$msg .= "user_ip: %%user_ip%%\n";
														/**/
														$msg .= "cv0: %%cv0%%\n";
														$msg .= "cv1: %%cv1%%\n";
														$msg .= "cv2: %%cv2%%\n";
														$msg .= "cv3: %%cv3%%\n";
														$msg .= "cv4: %%cv4%%\n";
														$msg .= "cv5: %%cv5%%\n";
														$msg .= "cv6: %%cv6%%\n";
														$msg .= "cv7: %%cv7%%\n";
														$msg .= "cv8: %%cv8%%\n";
														$msg .= "cv9: %%cv9%%";
														/**/
														if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($sp_access_url), $msg)))
															if (($msg = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours"))), $msg)))
																if (($msg = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $msg)))
																	if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																		if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																			if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																				if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																					if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																						/**/
																						if ($sbj && ($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg)))) /* Still have a ``$sbj`` and a ``$msg``? */
																							/**/
																							foreach (c_ws_plugin__s2member_utils_strings::parse_emails ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_sale_notification_recipients"]) as $recipient)
																								wp_mail ($recipient, apply_filters ("ws_plugin__s2member_sp_sale_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_sp_sale_notification_email_msg", $msg, get_defined_vars ()), "Content-Type: text/plain; charset=utf-8");
														/**/
														$paypal["s2member_log"][] = "Specific Post/Page ~ Sale Notification Emails have been processed.";
													}
												/**/
												if ($processing && $_GET["s2member_paypal_proxy"] && ($url = $_GET["s2member_paypal_proxy_return_url"]) && is_array ($cv = preg_split ("/\|/", $paypal["custom"]))) /* A Proxy is requesting a Return URL? */
													{
														if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%sp_access_url%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (rawurlencode ($sp_access_url)), $url)))
															if (($url = preg_replace ("/%%sp_access_exp%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (c_ws_plugin__s2member_utils_time::approx_time_difference (time (), strtotime ("+" . $paypal["hours"] . " hours")))), $url)))
																if (($url = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["txn_id"])), $url)))
																	if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																		if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																			if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																				if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																					if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["ip"])), $url)))
																						/**/
																						if (($url = trim ($url))) /* Preserve Remaining replacements. */
																							/* Because the parent routine may perform replacements too. */
																							$paypal["s2member_paypal_proxy_return_url"] = $url;
														/**/
														$paypal["s2member_log"][] = "Specific Post/Page Return, a Proxy Return URL is ready.";
													}
												/**/
												if ($processing && ($code = $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_tracking_codes"]) && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														if (($code = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $code)) && ($code = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $code)) && ($code = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $code)))
															if (($code = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $code)) && ($code = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $code)))
																if (($code = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $code)) && ($code = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $code)))
																	if (($code = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $code)))
																		if (($code = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $code)))
																			if (($code = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $code)))
																				/**/
																				if (($code = trim (preg_replace ("/%%(.+?)%%/i", "", $code)))) /* This gets stored into a Transient Queue. */
																					{
																						$paypal["s2member_log"][] = "Storing Specific Post/Page Tracking Codes into a Transient Queue. These will be processed on-site.";
																						set_transient ("s2m_" . md5 ("s2member_transient_sp_tracking_codes_" . $paypal["txn_id"]), $code, 43200);
																					}
													}
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_paypal_notify_during_sp_access", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										else
											$paypal["s2member_log"][] = "Unable to generate Access Link for Specific Post/Page Access. Does your Leading Post/Page still exist?";
									}
								else /* Else, this is a duplicate IPN. Must stop here. */
									{
										$paypal["s2member_log"][] = "Not processing. Duplicate IPN.";
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as ( `web_accept` ) for Specific Post/Page Access.";
										$paypal["s2member_log"][] = "Duplicate IPN. Already processed. This IPN will be ignored.";
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_after_sp_access", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_web_accept_sp", $paypal, get_defined_vars ());
							}
						else
							return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_web_accept_sp", false, get_defined_vars ());
					}
			}
	}
?>
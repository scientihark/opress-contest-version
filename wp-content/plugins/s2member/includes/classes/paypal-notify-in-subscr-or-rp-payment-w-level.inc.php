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
if (!class_exists ("c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_w_level"))
	{
		/**
		* s2Member's PayPal® IPN handler ( inner processing routine ).
		*
		* @package s2Member\PayPal
		* @since 110720
		*/
		class c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_w_level
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
						if (/**/(!empty ($paypal["txn_type"]) && preg_match ("/^(subscr_payment|recurring_payment)$/i", $paypal["txn_type"]))/**/
						&& ((!empty ($paypal["item_number"]) || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal))) && preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_w_level_regex"], $paypal["item_number"]))/**/
						&& (!empty ($paypal["subscr_id"]) || ($paypal["subscr_id"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_subscr_id ($paypal)))/**/
						&& (empty ($paypal["payment_status"]) || empty ($payment_status_issues) || !preg_match ($payment_status_issues, $paypal["payment_status"]))/**/
						&& (!empty ($paypal["item_name"]) || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)))/**/
						&& (!empty ($paypal["payer_email"]) || ($paypal["payer_email"] = c_ws_plugin__s2member_utils_users::get_user_email_with ($paypal["subscr_id"])))/**/
						&& (!empty ($paypal["txn_id"])) && (!empty ($paypal["mc_gross"]))/**/)
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_payment", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (!get_transient ($transient_ipn = "s2m_ipn_" . md5 ("s2member_transient_" . $_paypal_s)) && set_transient ($transient_ipn, time (), 31556926 * 10))
									{
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as " . ($identified_as = "( `subscr_payment|recurring_payment` )") . ".";
										$paypal["s2member_log"][] = "Sleeping for 5 seconds. Waiting for a possible ( `subscr_signup|subscr_modify|recurring_payment_profile_created` ).";
										sleep (5); /* Sleep here for a moment. PayPal® sometimes sends a subscr_payment before the subscr_signup, subscr_modify. */
										/* It is NOT a big deal if they do. However, s2Member goes to sleep here, just to help keep the log files in a logical order. */
										$paypal["s2member_log"][] = "Awake. It's " . date ("D M j, Y g:i:s a T") . ". s2Member `txn_type` identified as " . $identified_as . ".";
										/**/
										list ($paypal["level"], $paypal["ccaps"]) = preg_split ("/\:/", $paypal["item_number"], 2);
										/**/
										$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
										$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[a-z0-9]+~[0-9\.]+$/i", $paypal["invoice"])) ? preg_replace ("/^[a-z0-9]+~/i", "", $paypal["invoice"]) : $paypal["ip"];
										/**/
										if (($user_id = c_ws_plugin__s2member_utils_users::get_user_id_with ($paypal["subscr_id"])) && is_object ($user = new WP_User ($user_id)) && $user->ID)
											{
												$processing = $during = true; /* Yes, we ARE processing this. */
												/**/
												$pr_times = get_user_option ("s2member_paid_registration_times", $user_id);
												$pr_times["level"] = (!$pr_times["level"]) ? time () : $pr_times["level"]; /* Preserves existing. */
												$pr_times["level" . $paypal["level"]] = (!$pr_times["level" . $paypal["level"]]) ? time () : $pr_times["level" . $paypal["level"]];
												update_user_option ($user_id, "s2member_paid_registration_times", $pr_times); /* Update now. */
												/**/
												if (!get_user_option ("s2member_first_payment_txn_id", $user_id)) /* 1st payment? */
													update_user_option ($user_id, "s2member_first_payment_txn_id", $paypal["txn_id"]);
												/**/
												update_user_option ($user_id, "s2member_last_payment_time", time ()); /* Also update last payment time. */
												/**/
												$paypal["s2member_log"][] = "Updated Payment Times for this Member."; /* Flag this action in the log. */
												/**/
												$fields = get_user_option ("s2member_custom_fields", $user_id); /* These will be needed in the routines below. */
												$user_reg_ip = get_user_option ("s2member_registration_ip", $user_id); /* Original IP during Registration. */
												$user_reg_ip = $paypal["ip"] = ($user_reg_ip) ? $user_reg_ip : $paypal["ip"]; /* Now merge conditionally. */
												/**/
												if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_urls"]) as $url)
															/**/
															if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["subscr_id"])), $url)))
																if (($url = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["txn_id"])), $url)))
																	if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
																		if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																			if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																				if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																					{
																						if (($url = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->first_name)), $url)) && ($url = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->last_name)), $url)))
																							if (($url = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($user->first_name . " " . $user->last_name))), $url)))
																								if (($url = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_email)), $url)))
																									if (($url = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user->user_login)), $url)))
																										if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_reg_ip)), $url)))
																											if (($url = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($user_id)), $url)))
																												{
																													if (is_array ($fields) && !empty ($fields))
																														foreach ($fields as $var => $val) /* Custom Registration/Profile Fields. */
																															if (!($url = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (maybe_serialize ($val))), $url)))
																																break;
																													/**/
																													if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																														c_ws_plugin__s2member_utils_urls::remote ($url);
																												}
																					}
														/**/
														$paypal["s2member_log"][] = "Payment Notification URLs have been processed.";
													}
												/**/
												if ($processing && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
													{
														$msg = $sbj = "( s2Member / API Notification Email ) - Payment";
														$msg .= "\n\n"; /* Spacing in the message body. */
														/**/
														$msg .= "subscr_id: %%subscr_id%%\n";
														$msg .= "amount: %%amount%%\n";
														$msg .= "txn_id: %%txn_id%%\n";
														$msg .= "item_number: %%item_number%%\n";
														$msg .= "item_name: %%item_name%%\n";
														$msg .= "first_name: %%first_name%%\n";
														$msg .= "last_name: %%last_name%%\n";
														$msg .= "full_name: %%full_name%%\n";
														$msg .= "payer_email: %%payer_email%%\n";
														/**/
														$msg .= "user_first_name: %%user_first_name%%\n";
														$msg .= "user_last_name: %%user_last_name%%\n";
														$msg .= "user_full_name: %%user_full_name%%\n";
														$msg .= "user_email: %%user_email%%\n";
														$msg .= "user_login: %%user_login%%\n";
														$msg .= "user_ip: %%user_ip%%\n";
														$msg .= "user_id: %%user_id%%\n";
														/**/
														if (is_array ($fields) && !empty ($fields))
															foreach ($fields as $var => $val)
																$msg .= $var . ": %%" . $var . "%%\n";
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
														if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%subscr_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["subscr_id"]), $msg)))
															if (($msg = preg_replace ("/%%amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["txn_id"]), $msg)))
																if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
																	if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																		if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																			if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																				{
																					if (($msg = preg_replace ("/%%user_first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->first_name), $msg)) && ($msg = preg_replace ("/%%user_last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->last_name), $msg)))
																						if (($msg = preg_replace ("/%%user_full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($user->first_name . " " . $user->last_name)), $msg)))
																							if (($msg = preg_replace ("/%%user_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_email), $msg)))
																								if (($msg = preg_replace ("/%%user_login%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user->user_login), $msg)))
																									if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_reg_ip), $msg)))
																										if (($msg = preg_replace ("/%%user_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($user_id), $msg)))
																											{
																												if (is_array ($fields) && !empty ($fields))
																													foreach ($fields as $var => $val) /* Custom Registration/Profile Fields. */
																														if (!($msg = preg_replace ("/%%" . preg_quote ($var, "/") . "%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (maybe_serialize ($val)), $msg)))
																															break;
																												/**/
																												if ($sbj && ($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg)))) /* Still have a ``$sbj`` and a ``$msg``? */
																													/**/
																													foreach (c_ws_plugin__s2member_utils_strings::parse_emails ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["payment_notification_recipients"]) as $recipient)
																														wp_mail ($recipient, apply_filters ("ws_plugin__s2member_payment_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_payment_notification_email_msg", $msg, get_defined_vars ()), "Content-Type: text/plain; charset=utf-8");
																											}
																				}
														/**/
														$paypal["s2member_log"][] = "Payment Notification Emails have been processed.";
													}
												/**/
												eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
												do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_payment", get_defined_vars ());
												unset ($__refs, $__v); /* Unset defined __refs, __v. */
											}
										else /* Otherwise, we need to re-generate/store this IPN into a Transient Queue. Then re-process it on registration. */
											{
												$paypal["s2member_log"][] = "Skipping this IPN response, for now. The Subscr. ID is not associated with a registered Member.";
												/**/
												$ipn = array ("txn_type" => "subscr_payment"); /* Create a simulated IPN response for txn_type=subscr_payment. */
												/**/
												foreach ($paypal as $var => $val)
													if (in_array ($var, array ("subscr_gateway", "subscr_id", "txn_id", "custom", "invoice", "mc_gross", "mc_currency", "tax", "payer_email", "first_name", "last_name", "item_name", "item_number", "option_name1", "option_selection1", "option_name2", "option_selection2")))
														$ipn[$var] = $val;
												/**/
												$paypal["s2member_log"][] = "Re-generating. This IPN will go into a Transient Queue; and be re-processed during registration.";
												/**/
												set_transient ("s2m_" . md5 ("s2member_transient_ipn_subscr_payment_" . $paypal["subscr_id"]), $ipn, 43200);
											}
									}
								else /* Else, this is a duplicate IPN. Must stop here. */
									{
										$paypal["s2member_log"][] = "Not processing. Duplicate IPN.";
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as ( `subscr_payment|recurring_payment` ).";
										$paypal["s2member_log"][] = "Duplicate IPN. Already processed. This IPN will be ignored.";
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_payment", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_w_level", $paypal, get_defined_vars ());
							}
						else
							return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_w_level", false, get_defined_vars ());
					}
			}
	}
?>
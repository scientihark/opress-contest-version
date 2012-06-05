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
if (!class_exists ("c_ws_plugin__s2member_paypal_notify_in_sp_refund_reversal"))
	{
		/**
		* s2Member's PayPal® IPN handler ( inner processing routine ).
		*
		* @package s2Member\PayPal
		* @since 110720
		*/
		class c_ws_plugin__s2member_paypal_notify_in_sp_refund_reversal
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
						if (/**/(/**/(!empty ($paypal["txn_type"]) && preg_match ("/^new_case$/i", $paypal["txn_type"]) && !empty ($paypal["case_type"]) && preg_match ("/^chargeback$/i", $paypal["case_type"]))/**/
						|| (!empty ($paypal["payment_status"]) && preg_match ("/^(refunded|reversed|reversal)$/i", $paypal["payment_status"])) /* The "txn_type" is irrelevant in these special situations. */)/**/
						&& ((!empty ($paypal["item_number"]) || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal))) && preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["sp_access_item_number_regex"], $paypal["item_number"]))/**/
						&& (!empty ($paypal["item_name"]) || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)) || ($paypal["item_name"] = $_SERVER["HTTP_HOST"]))/**/
						&& (!empty ($paypal["payer_email"])) && (!empty ($paypal["parent_txn_id"]))/**/)
							{
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_before_sp_refund_reversal", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (!get_transient ($transient_ipn = "s2m_ipn_" . md5 ("s2member_transient_" . $_paypal_s)) && set_transient ($transient_ipn, time (), 31556926 * 10))
									{
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as ( `[empty or irrelevant]` ) w/ `payment_status` ( `refunded|reversed|reversal` ) - or - `new_case` w/ `case_type` ( `chargeback` ).";
										/**/
										$paypal["ip"] = (preg_match ("/ip address/i", $paypal["option_name2"]) && $paypal["option_selection2"]) ? $paypal["option_selection2"] : "";
										$paypal["ip"] = (!$paypal["ip"] && preg_match ("/^[a-z0-9]+~[0-9\.]+$/i", $paypal["invoice"])) ? preg_replace ("/^[a-z0-9]+~/i", "", $paypal["invoice"]) : $paypal["ip"];
										/**/
										$processing = $during = true; /* Yes, we ARE processing this. */
										/*
										Refunds and chargeback reversals. This is excluded from the processing check.
										In other words, s2Member sends `Refund/Reversal` Notifications ANYTIME a Refund/Reversal occurs; even if s2Member did not process it otherwise.
										Since this routine ignores the processing check, it is *possible* that Refund/Reversal Notification URLs will be contacted more than once.
											If you're writing scripts that depend on Refund/Reversal Notifications, please keep this in mind.
										*/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_urls"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												foreach (preg_split ("/[\r\n\t]+/", $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_urls"]) as $url)
													/**/
													if (($url = preg_replace ("/%%cv([0-9]+)%%/ei", 'urlencode(trim($cv[$1]))', $url)) && ($url = preg_replace ("/%%parent_txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["parent_txn_id"])), $url)))
														if (($url = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_number"])), $url)) && ($url = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["item_name"])), $url)))
															if (($url = preg_replace ("/%%-amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_gross"])), $url)) && ($url = preg_replace ("/%%-fee%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["mc_fee"])), $url)))
																if (($url = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["first_name"])), $url)) && ($url = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["last_name"])), $url)))
																	if (($url = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode (trim ($paypal["first_name"] . " " . $paypal["last_name"]))), $url)))
																		if (($url = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["payer_email"])), $url)))
																			if (($url = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (urlencode ($paypal["ip"])), $url)))
																				/**/
																				if (($url = trim (preg_replace ("/%%(.+?)%%/i", "", $url))))
																					c_ws_plugin__s2member_utils_urls::remote ($url);
												/**/
												$paypal["s2member_log"][] = "Specific Post/Page ~ Refund/Reversal Notification URLs have been processed.";
											}
										/**/
										if ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_recipients"] && is_array ($cv = preg_split ("/\|/", $paypal["custom"])))
											{
												$msg = $sbj = "( s2Member / API Notification Email ) - Specific Post/Page ~ Refund/Reversal";
												$msg .= "\n\n"; /* Spacing in the message body. */
												/**/
												$msg .= "parent_txn_id: %%parent_txn_id%%\n";
												$msg .= "item_number: %%item_number%%\n";
												$msg .= "item_name: %%item_name%%\n";
												$msg .= "-amount: %%-amount%%\n";
												$msg .= "-fee: %%-fee%%\n";
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
												if (($msg = preg_replace ("/%%cv([0-9]+)%%/ei", 'trim($cv[$1])', $msg)) && ($msg = preg_replace ("/%%parent_txn_id%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["parent_txn_id"]), $msg)))
													if (($msg = preg_replace ("/%%item_number%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_number"]), $msg)) && ($msg = preg_replace ("/%%item_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["item_name"]), $msg)))
														if (($msg = preg_replace ("/%%-amount%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_gross"]), $msg)) && ($msg = preg_replace ("/%%-fee%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["mc_fee"]), $msg)))
															if (($msg = preg_replace ("/%%first_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["first_name"]), $msg)) && ($msg = preg_replace ("/%%last_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["last_name"]), $msg)))
																if (($msg = preg_replace ("/%%full_name%%/i", c_ws_plugin__s2member_utils_strings::esc_ds (trim ($paypal["first_name"] . " " . $paypal["last_name"])), $msg)))
																	if (($msg = preg_replace ("/%%payer_email%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["payer_email"]), $msg)))
																		if (($msg = preg_replace ("/%%user_ip%%/i", c_ws_plugin__s2member_utils_strings::esc_ds ($paypal["ip"]), $msg)))
																			/**/
																			if ($sbj && ($msg = trim (preg_replace ("/%%(.+?)%%/i", "", $msg)))) /* Still have a ``$sbj`` and a ``$msg``? */
																				/**/
																				foreach (c_ws_plugin__s2member_utils_strings::parse_emails ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["sp_ref_rev_notification_recipients"]) as $recipient)
																					wp_mail ($recipient, apply_filters ("ws_plugin__s2member_sp_ref_rev_notification_email_sbj", $sbj, get_defined_vars ()), apply_filters ("ws_plugin__s2member_sp_ref_rev_notification_email_msg", $msg, get_defined_vars ()), "Content-Type: text/plain; charset=utf-8");
												/**/
												$paypal["s2member_log"][] = "Specific Post/Page ~ Refund/Reversal Notification Emails have been processed.";
											}
										/**/
										eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_paypal_notify_during_sp_refund_reversal", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								else /* Else, this is a duplicate IPN. Must stop here. */
									{
										$paypal["s2member_log"][] = "Not processing. Duplicate IPN.";
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as ( `[empty or irrelevant]` ) w/ `payment_status` ( `refunded|reversed|reversal` ) - or - `new_case` w/ `case_type` ( `chargeback` ).";
										$paypal["s2member_log"][] = "Duplicate IPN. Already processed. This IPN will be ignored.";
									}
								/**/
								eval ('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_after_sp_refund_reversal", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_sp_refund_reversal", $paypal, get_defined_vars ());
							}
						else
							return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_sp_refund_reversal", false, get_defined_vars ());
					}
			}
	}
?>
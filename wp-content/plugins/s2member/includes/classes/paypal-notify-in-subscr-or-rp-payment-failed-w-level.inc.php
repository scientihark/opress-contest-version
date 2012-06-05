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
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_failed_w_level"))
	{
		/**
		* s2Member's PayPal® IPN handler ( inner processing routine ).
		*
		* @package s2Member\PayPal
		* @since 110720
		*/
		class c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_failed_w_level
			{
				/**
				* s2Member's PayPal® IPN handler ( inner processing routine ).
				*
				* @package s2Member\PayPal
				* @since 110720
				*
				* @param array $vars Required. An array of defined variables passed by {@link s2Member\PayPal\c_ws_plugin__s2member_paypal_notify_in::paypal_notify()}.
				* @return array|bool The original ``$paypal`` array passed in ( extracted ) from ``$vars``, or false when conditions do NOT apply.
				*/
				public static function cp ($vars = array ()) /* Conditional phase for ``c_ws_plugin__s2member_paypal_notify_in::paypal_notify()``. */
					{
						extract($vars); /* Extract all vars passed in from: ``c_ws_plugin__s2member_paypal_notify_in::paypal_notify()``. */
						/**/
						if (/**/(!empty ($paypal["txn_type"]) && preg_match ("/^(subscr_failed|recurring_payment_failed|recurring_payment_skipped)$/i", $paypal["txn_type"]))/**/
						&& ((!empty ($paypal["item_number"]) || ($paypal["item_number"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_number ($paypal))) && preg_match ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["membership_item_number_w_level_regex"], $paypal["item_number"]))/**/
						&& (!empty ($paypal["subscr_id"]) || ($paypal["subscr_id"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_subscr_id ($paypal)))/**/
						&& (!empty ($paypal["item_name"]) || ($paypal["item_name"] = c_ws_plugin__s2member_paypal_utilities::paypal_pro_item_name ($paypal)))/**/
						&& (!empty ($paypal["payer_email"]) || ($paypal["payer_email"] = c_ws_plugin__s2member_utils_users::get_user_email_with ($paypal["subscr_id"])))/**/)
							{
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_before_subscr_failed", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								if (!get_transient ($transient_ipn = "s2m_ipn_" . md5 ("s2member_transient_" . $_paypal_s)) && set_transient ($transient_ipn, time (), 31556926 * 10))
									{
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as ( `subscr_failed|recurring_payment_failed|recurring_payment_skipped` ).";
										/**/
										$processing = $during = true; /* Yes, we ARE processing this. */
										/**/
										$paypal["s2member_log"][] = "This `txn_type` does not require any action on the part of s2Member.";
										$paypal["s2member_log"][] = "s2Member does NOT respond to individual failed payments, only multiple consecutive failed payments.";
										$paypal["s2member_log"][] = "When multiple consecutive payments fail, a special IPN response will be triggered.";
										/**/
										eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
										do_action ("ws_plugin__s2member_during_paypal_notify_during_subscr_failed", get_defined_vars ());
										unset ($__refs, $__v); /* Unset defined __refs, __v. */
									}
								else /* Else, this is a duplicate IPN. Must stop here. */
									{
										$paypal["s2member_log"][] = "Not processing. Duplicate IPN.";
										$paypal["s2member_log"][] = "s2Member `txn_type` identified as ( `subscr_failed|recurring_payment_failed|recurring_payment_skipped` ).";
										$paypal["s2member_log"][] = "Duplicate IPN. Already processed. This IPN will be ignored.";
									}
								/**/
								eval('foreach(array_keys(get_defined_vars())as$__v)$__refs[$__v]=&$$__v;');
								do_action ("ws_plugin__s2member_during_paypal_notify_after_subscr_failed", get_defined_vars ());
								unset ($__refs, $__v); /* Unset defined __refs, __v. */
								/**/
								return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_failed_w_level", $paypal, get_defined_vars ());
							}
						else
							return apply_filters ("c_ws_plugin__s2member_paypal_notify_in_subscr_or_rp_payment_failed_w_level", false, get_defined_vars ());
					}
			}
	}
?>
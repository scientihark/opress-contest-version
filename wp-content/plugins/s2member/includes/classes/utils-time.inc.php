<?php
/**
* Time utilities.
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
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_utils_time"))
	{
		/**
		* Time utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_time
			{
				/**
				* Determines the difference between two timestamps.
				*
				* Returns the difference in a human readable format.
				* Supports: minutes, hours, days, weeks, months, and years. This is an improvement on WordPress® ``human_time_diff()``.
				* This returns an "approximate" time difference. Rounded to the nearest minute, hour, day, week, month, year.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param int $from Beginning timestamp to start from.
				* @param int $to Ending timestamp to stop at.
				* @return str Human readable difference between ``$from`` and ``$to``.
				*/
				public static function approx_time_difference ($from = FALSE, $to = FALSE)
					{
						$from = (!$from) ? strtotime ("now") : (int)$from;
						$to = (!$to) ? strtotime ("now") : (int)$to;
						/**/
						if (($difference = abs ($to - $from)) < 3600)
							{
								$m = (int)round ($difference / 60);
								/**/
								$since = ($m < 1) ? _x ("less than a minute", "s2member-front", "s2member") : $since;
								$since = ($m === 1) ? _x ("1 minute", "s2member-front", "s2member") : $since;
								$since = ($m > 1) ? sprintf (_nx ("%s minute", "%s minutes", $m, "s2member-front", "s2member"), $m) : $since;
								$since = ($m >= 60) ? _x ("about 1 hour", "s2member-front", "s2member") : $since;
							}
						else if ($difference >= 3600 && $difference < 86400)
							{
								$h = (int)round ($difference / 3600);
								/**/
								$since = ($h === 1) ? _x ("1 hour", "s2member-front", "s2member") : $since;
								$since = ($h > 1) ? sprintf (_nx ("%s hour", "%s hours", $h, "s2member-front", "s2member"), $h) : $since;
								$since = ($h >= 24) ? _x ("about 1 day", "s2member-front", "s2member") : $since;
							}
						else if ($difference >= 86400 && $difference < 604800)
							{
								$d = (int)round ($difference / 86400);
								/**/
								$since = ($d === 1) ? _x ("1 day", "s2member-front", "s2member") : $since;
								$since = ($d > 1) ? sprintf (_nx ("%s day", "%s days", $d, "s2member-front", "s2member"), $d) : $since;
								$since = ($d >= 7) ? _x ("about 1 week", "s2member-front", "s2member") : $since;
							}
						else if ($difference >= 604800 && $difference < 2592000)
							{
								$w = (int)round ($difference / 604800);
								/**/
								$since = ($w === 1) ? _x ("1 week", "s2member-front", "s2member") : $since;
								$since = ($w > 1) ? sprintf (_nx ("%s week", "%s weeks", $w, "s2member-front", "s2member"), $w) : $since;
								$since = ($w >= 4) ? _x ("about 1 month", "s2member-front", "s2member") : $since;
							}
						else if ($difference >= 2592000 && $difference < 31556926)
							{
								$m = (int)round ($difference / 2592000);
								/**/
								$since = ($m === 1) ? _x ("1 month", "s2member-front", "s2member") : $since;
								$since = ($m > 1) ? sprintf (_nx ("%s month", "%s months", $m, "s2member-front", "s2member"), $m) : $since;
								$since = ($m >= 12) ? _x ("about 1 year", "s2member-front", "s2member") : $since;
							}
						else if ($difference >= 31556926) /* Years. */
							{
								$y = (int)round ($difference / 31556926);
								/**/
								$since = ($y === 1) ? _x ("1 year", "s2member-front", "s2member") : $since;
								$since = ($y > 1) ? sprintf (_nx ("%s year", "%s years", $y, "s2member-front", "s2member"), $y) : $since;
							}
						/**/
						return $since;
					}
				/**
				* Calculate Auto-EOT Time, based on `user_id`, `period1`, `period3`, `last_payment_time`, or an optional `eotper`.
				*
				* Used by s2Member's built-in Auto-EOT System, and also by its IPN routines.
				* `last_payment_time` can be forced w/ ``$lpt`` *( i.e. for delayed eots )*.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param int|str $user_id Optional. A WordPress® User ID.
				* @param str $period1 Optional. First Intial "Period Term" *( i.e. `0 D` )*.
				* 	Only used when ``$user_id`` is passed in.
				* @param str $period3 Optional. Regular "Period Term" *( i.e. `1 M` )*.
				* 	Only used when ``$user_id`` is passed in.
				* @param str $eotper Optional. A Fixed "Period Term" *( i.e. `1 M` )*.
				* 	This replaces ``$period1`` / ``$period3``.
				* 	Not used when ``$user_id`` is passed in.
				* 	Only when ``$user_id`` is not passed in.
				* @param int $lpt Optional. Force feed the Last Payment Time.
				* 	Only used when ``$user_id`` is passed in.
				* @param int $ext Optional. Existing EOT Time for the User.
				* 	Always considered; even when ``$user_id`` is not passed in.
				* 	But only when ``$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_time_ext_behavior"] === "extend"``.
				* @return int Unix timestamp indicating the EOT Time calculated by this routine.
				*/
				public static function auto_eot_time ($user_id = FALSE, $period1 = FALSE, $period3 = FALSE, $eotper = FALSE, $lpt = FALSE, $ext = FALSE)
					{
						if ($user_id && ($user = new WP_User ($user_id)) && $user->ID) /* Valid user_id? */
							{
								$registration_time = strtotime ($user->user_registered);
								$last_payment_time = get_user_option ("s2member_last_payment_time", $user_id);
								$last_payment_time = ((int)$lpt) ? (int)$lpt : (int)$last_payment_time;
								/**/
								if (!($p1_time = 0) && ($period1 = trim (strtoupper ($period1))))
									{
										list ($num, $span) = preg_split ("/ /", $period1, 2);
										/**/
										$days = 0; /* Days start at 0. */
										/**/
										if (is_numeric ($num) && !is_numeric ($span))
											{
												$days = ($span === "D") ? 1 : $days;
												$days = ($span === "W") ? 7 : $days;
												$days = ($span === "M") ? 30 : $days;
												$days = ($span === "Y") ? 365 : $days;
											}
										/**/
										$p1_days = (int)$num * (int)$days;
										$p1_time = $p1_days * 86400;
									}
								/**/
								if (!($p3_time = 0) && ($period3 = trim (strtoupper ($period3))))
									{
										list ($num, $span) = preg_split ("/ /", $period3, 2);
										/**/
										$days = 0; /* Days start at 0. */
										/**/
										if (is_numeric ($num) && !is_numeric ($span))
											{
												$days = ($span === "D") ? 1 : $days;
												$days = ($span === "W") ? 7 : $days;
												$days = ($span === "M") ? 30 : $days;
												$days = ($span === "Y") ? 365 : $days;
											}
										/**/
										$p3_days = (int)$num * (int)$days;
										$p3_time = $p3_days * 86400;
									}
								/**/
								if (!$last_payment_time) /* If there's been no payment yet.
								After p1, if there was a p1. Otherwise, reg. time + 1 day grace. */
									$auto_eot_time = $registration_time + $p1_time + 86400;
								/**/
								/* Else if p1, and last payment within p1, last + p1 + 1 day grace. */
								else if ($p1_time && $last_payment_time <= $registration_time + $p1_time)
									$auto_eot_time = $last_payment_time + $p1_time + 86400;
								/**/
								else /* Otherwise, after last payment + p3 + 1 day grace. */
									$auto_eot_time = $last_payment_time + $p3_time + 86400;
							}
						/**/
						else if ($eotper) /* Otherwise, if we have a specific EOT period; calculate from today. */
							{
								if (!($eot_time = 0) && ($eotper = trim (strtoupper ($eotper))))
									{
										list ($num, $span) = preg_split ("/ /", $eotper, 2);
										/**/
										$days = 0; /* Days start at 0. */
										/**/
										if (is_numeric ($num) && !is_numeric ($span))
											{
												$days = ($span === "D") ? 1 : $days;
												$days = ($span === "W") ? 7 : $days;
												$days = ($span === "M") ? 30 : $days;
												$days = ($span === "Y") ? 365 : $days;
											}
										/**/
										$eot_days = (int)$num * (int)$days;
										$eot_time = $eot_days * 86400;
									}
								/**/
								$auto_eot_time = strtotime ("now") + $eot_time + 86400;
							}
						/**/
						settype ($auto_eot_time, "integer"); /* Force to integer type here. */
						/**/
						if ($ext && $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["eot_time_ext_behavior"] === "extend")
							if ((int)$ext > strtotime ("now")) /* Existing EOT Time must be in the future. */
								$auto_eot_time = $auto_eot_time + ((int)$ext - strtotime ("now"));
						/**/
						return ($auto_eot_time <= 0) ? strtotime ("now") : $auto_eot_time;
					}
				/**
				* Converts a Term `[D,W,M,Y,L,Day,Week,Month,Year,Lifetime]` into `Daily`, `Weekly`, `Monthly`, `Yearly`, `Lifetime`.
				*
				* Can also handle "Period Term" combinations. Where the Period will be stripped automatically before conversion.
				*
				* For example, `1 D`, would become, just `Daily`. Another example, `3 Y` would become `Yearly`; and `1 L`, would become `Lifetime`.
				* Recurring examples: `2 W`, becomes `Bi-Weekly`, `3 M` becomes `Quarterly`, and `2 M` becomes `Bi-Monthly`.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $term_or_period_term A Term, or a "Period Term" combination.
				* @param str $directive Optional. One of `recurring|singular|plural`. Defaults to `recurring`.
				* @return str|bool A Term Cycle *( i.e. `Daily`, `Weekly`, `Monthly`, `Yearly`, `Lifetime`, etc. )*, else false on failure.
				*
				* @todo Add support here for fixed recurring payments configured through `rrt=""`.
				*/
				public static function term_cycle ($term_or_period_term = FALSE, $directive = "recurring")
					{
						$term_cycle_key = trim (strtoupper (preg_replace ("/^(.+?) /", "", $term_or_period_term)));
						/**/
						if ($term_cycle_key && $directive === "recurring") /* recurring = Daily, Weekly, Bi-Weekly, Monthly, Bi-Monthly, Quarterly, Yearly, Lifetime. */
							{
								$paypal_term_cycles = array ("D" => _x ("Daily", "s2member-front", "s2member"), "W" => _x ("Weekly", "s2member-front", "s2member"), "M" => _x ("Monthly", "s2member-front", "s2member"), "Y" => _x ("Yearly", "s2member-front", "s2member"), "L" => _x ("Lifetime", "s2member-front", "s2member"), "DAY" => _x ("Daily", "s2member-front", "s2member"), "WEEK" => _x ("Weekly", "s2member-front", "s2member"), "MONTH" => _x ("Monthly", "s2member-front", "s2member"), "YEAR" => _x ("Yearly", "s2member-front", "s2member"), "Lifetime" => _x ("Lifetime", "s2member-front", "s2member"));
								/**/
								$term_cycle = isset ($paypal_term_cycles[$term_cycle_key]) ? $paypal_term_cycles[$term_cycle_key] : false;
								/**/
								$term_cycle = (strtoupper ($term_or_period_term) === "2 W") ? _x ("Bi-Weekly", "s2member-front", "s2member") : $term_cycle;
								$term_cycle = (strtoupper ($term_or_period_term) === "2 M") ? _x ("Bi-Monthly", "s2member-front", "s2member") : $term_cycle;
								$term_cycle = (strtoupper ($term_or_period_term) === "3 M") ? _x ("Quarterly", "s2member-front", "s2member") : $term_cycle;
							}
						else if ($term_cycle_key && $directive === "singular") /* singular = Day, Week, Month, Year, Lifetime. */
							{
								$paypal_term_cycles = array ("D" => _x ("Day", "s2member-front", "s2member"), "W" => _x ("Week", "s2member-front", "s2member"), "M" => _x ("Month", "s2member-front", "s2member"), "Y" => _x ("Year", "s2member-front", "s2member"), "L" => _x ("Lifetime", "s2member-front", "s2member"), "DAY" => _x ("Day", "s2member-front", "s2member"), "WEEK" => _x ("Week", "s2member-front", "s2member"), "MONTH" => _x ("Month", "s2member-front", "s2member"), "YEAR" => _x ("Year", "s2member-front", "s2member"), "Lifetime" => _x ("Lifetime", "s2member-front", "s2member"));
								/**/
								$term_cycle = isset ($paypal_term_cycles[$term_cycle_key]) ? $paypal_term_cycles[$term_cycle_key] : false;
							}
						else if ($term_cycle_key && $directive === "plural") /* plural = Days, Weeks, Months, Years, Lifetimes. */
							{
								$paypal_term_cycles = array ("D" => _x ("Days", "s2member-front", "s2member"), "W" => _x ("Weeks", "s2member-front", "s2member"), "M" => _x ("Months", "s2member-front", "s2member"), "Y" => _x ("Years", "s2member-front", "s2member"), "L" => _x ("Lifetimes", "s2member-front", "s2member"), "DAY" => _x ("Days", "s2member-front", "s2member"), "WEEK" => _x ("Weeks", "s2member-front", "s2member"), "MONTH" => _x ("Months", "s2member-front", "s2member"), "YEAR" => _x ("Years", "s2member-front", "s2member"), "Lifetime" => _x ("Lifetimes", "s2member-front", "s2member"));
								/**/
								$term_cycle = isset ($paypal_term_cycles[$term_cycle_key]) ? $paypal_term_cycles[$term_cycle_key] : false;
							}
						/**/
						return (!empty ($term_cycle)) ? $term_cycle : false;
					}
				/**
				* Converts a "Period Term", and Recurring flag.
				*
				* Returns a full Term explanation *( lowercase )*.
				* Example: `2 months`.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $period_term A "Period Term" combination.
				* @param bool|int|str $recurring Defaults to false. If true, the ``$period_term`` is recurring. Can also be the string `0|1|BN`.
				* @return str Verbose *( lowercase )* Period Term description *( i.e. `weekly`, `every 3 weeks`, `lifetime`, `3 months`, `1 month`, etc. )*.
				*
				* @todo Add support here for fixed recurring payments configured through `rrt=""`.
				*/
				public static function period_term ($period_term = FALSE, $recurring = FALSE)
					{
						list ($period, $term) = preg_split ("/ /", ($period_term = strtoupper ($period_term)), 2);
						$recurring = (is_string ($recurring) && strtoupper ($recurring) === "BN") ? (int)0 : (int)$recurring;
						/**/
						$cycle_recurring = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "recurring");
						$cycle_singular = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "singular");
						$cycle_plural = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "plural");
						/**/
						if ($recurring && in_array ($period_term, array ("1 D", "1 W", "2 W", "1 M", "2 M", "3 M", "1 Y")))
							$period_term = strtolower ($cycle_recurring); /* Results in an "ly" ending. */
						/**/
						else if ($recurring) /* Otherwise, it's recurring; but NOT an "ly" ending. */
							/* translators: Each cycle ( i.e. `each day/week/month` or `every 2 days/weeks/months`, etc. ). Cycles are translated elsewhere. */
							$period_term = strtolower (sprintf (_nx ('each %2$s', 'every %1$s %3$s', $period, "s2member-front", "s2member"), $period, $cycle_singular, $cycle_plural));
						/**/
						else if (strtoupper ($term) === "L") /* One-payment for lifetime access. */
							$period_term = strtolower (_x ("lifetime", "s2member-front", "s2member")); /* Life. */
						/**/
						else /* Otherwise, this is NOT recurring. Results in X days/weeks/months/years/lifetime. */
							/* translators: Membership cycle ( i.e. `1 day/week/month` or `2 days/weeks/months`, etc. ). Most of this is translated elsewhere. */
							$period_term = strtolower (sprintf (_nx ('%1$s %2$s', '%1$s %3$s', $period, "s2member-front", "s2member"), $period, $cycle_singular, $cycle_plural));
						/**/
						return $period_term; /* Return converted value. */
					}
				/**
				* Converts a Billing Amount, Period Term, and Recurring flag.
				*
				* Returns a full Billing Term explanation.
				* Example: `1.00 for 2 months`.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param int|str $amount A numeric amount, usually in US dollars.
				* @param str $period_term A "Period Term" combo, with space separation.
				* @param bool|int|str $recurring Defaults to false. If true, the ``$period_term`` is recurring. Can also be the string `0|1|BN`.
				* @return str Verbose *( lowercase )* Amount Period Term description *( i.e. `1.00`, `1.00 / monthly`, `1.00 every 3 months`, `1.00 for 1 month`, `1.00 for 3 months`, etc. )*.
				*
				* @todo Add support here for fixed recurring payments configured through `rrt=""`.
				*/
				public static function amount_period_term ($amount = FALSE, $period_term = FALSE, $recurring = FALSE)
					{
						list ($period, $term) = preg_split ("/ /", ($period_term = strtoupper ($period_term)), 2);
						$recurring = (is_string ($recurring) && strtoupper ($recurring) === "BN") ? (int)0 : (int)$recurring;
						/**/
						$cycle_recurring = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "recurring");
						$cycle_singular = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "singular");
						$cycle_plural = c_ws_plugin__s2member_utils_time::term_cycle ($period_term, "plural");
						/**/
						if ($recurring && in_array ($period_term, array ("1 D", "1 W", "2 W", "1 M", "2 M", "3 M", "1 Y")))
							$amount_period_term = number_format ($amount, 2, ".", "") . " / " . strtolower ($cycle_recurring);
						/**/
						else if ($recurring) /* Otherwise, it's recurring; but NOT an "ly" ending. */
							/* translators: Each cycle ( i.e. `each day/week/month` or `every 2 days/weeks/months`, etc. ). Cycles are translated elsewhere. */
							$amount_period_term = number_format ($amount, 2, ".", "") . " " . strtolower (sprintf (_nx ('each %2$s', 'every %1$s %3$s', $period, "s2member-front", "s2member"), $period, $cycle_singular, $cycle_plural));
						/**/
						else if (strtoupper ($term) === "L") /* One-payment for lifetime access. */
							$amount_period_term = number_format ($amount, 2, ".", ""); /* Price. */
						/**/
						else /* Otherwise, this is NOT recurring. Results in 0.00 for X days/weeks/months/years/lifetime. */
							/* translators: Cycle ( i.e. `for 1 day/week/month` or `for 2 days/weeks/months`, etc. ). Most of this is translated elsewhere. */
							$amount_period_term = number_format ($amount, 2, ".", "") . " " . strtolower (sprintf (_nx ('for %1$s %2$s', 'for %1$s %3$s', $period, "s2member-front", "s2member"), $period, $cycle_singular, $cycle_plural));
						/**/
						return $amount_period_term; /* Return converted value. */
					}
			}
	}
?>
/**
* Core JavaScript file for the s2Member plugin.
*
* This is the development version of the code.
* Which ultimately produces s2member-min.js.
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
* @package s2Member
* @since 3.0
*/
jQuery(document).ready (function($)
	{
		var runningBuddyPress = '<?php echo c_ws_plugin__s2member_utils_conds::bp_is_installed ("query-active-plugins") ? "1" : ""; ?>';
		var filesBaseDir = '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (c_ws_plugin__s2member_utils_dirs::basename_dir_app_data ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["files_dir"])); ?>';
		var skipAllFileConfirmations = ( typeof ws_plugin__s2member_skip_all_file_confirmations !== 'undefined' && ws_plugin__s2member_skip_all_file_confirmations) ? true : false;
		var uniqueFilesDownloadedInPage = /* Real-time counts in a single page/instance. */ [];
		/**/
		if (S2MEMBER_CURRENT_USER_IS_LOGGED_IN && S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY < S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED && !skipAllFileConfirmations)
			{
				$('a[href*="s2member_file_download="], a[href*="/s2member-files/"], a[href^="s2member-files/"], a[href*="/' + filesBaseDir.replace (/([\:\.\[\]])/g, '\\$1') + '/"], a[href^="' + filesBaseDir.replace (/([\:\.\[\]])/g, '\\$1') + '/"]').click (function()
					{
						if (!this.href.match /* Do NOT prompt on downloads issued with a Key. */ (/s2member[_\-]file[_\-]download[_\-]key[\=\-].+/i))
							{
								var c = '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Confirm File Download —", "s2member-front", "s2member")); ?>' + '\n\n';
								c += $.sprintf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("You`ve downloaded %s protected %s in the last %s.", "s2member-front", "s2member")); ?>', S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY, ((S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("file", "s2member-front", "s2member")); ?>' : '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("files", "s2member-front", "s2member")); ?>'), ((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("24 hours", "s2member-front", "s2member")); ?>' : $.sprintf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("%s days", "s2member-front", "s2member")); ?>', S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS))) + '\n\n';
								c += (S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_IS_UNLIMITED) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("You`re entitled to UNLIMITED downloads though ( so, no worries ).", "s2member-front", "s2member")); ?>' : $.sprintf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("You`re entitled to %s unique %s %s.", "s2member-front", "s2member")); ?>', S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED, ((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("download", "s2member-front", "s2member")); ?>' : '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("downloads", "s2member-front", "s2member")); ?>'), ((S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("each day", "s2member-front", "s2member")); ?>' : $.sprintf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("every %s-day period", "s2member-front", "s2member")); ?>', S2MEMBER_CURRENT_USER_DOWNLOADS_ALLOWED_DAYS)));
								/**/
								if ((this.href.match (/s2member[_\-]skip[_\-]confirmation/i) && !this.href.match (/s2member[_\-]skip[_\-]confirmation[\=\-](0|no|false)/i)) || confirm(c))
									{
										if ($.inArray (this.href, uniqueFilesDownloadedInPage) === -1)
											S2MEMBER_CURRENT_USER_DOWNLOADS_CURRENTLY++, uniqueFilesDownloadedInPage.push (this.href);
										/**/
										return /* Allow. */ true;
									}
								else /* Disallow. */
									return false;
							}
						else /* Allow. */
							return true;
					});
			}
		/**/
		if (!location.href.match (/\/wp-admin(\/|\?|$)/))
			{
				$('input#ws-plugin--s2member-profile-password1, input#ws-plugin--s2member-profile-password2').keyup (function()
					{
						ws_plugin__s2member_passwordStrength($('input#ws-plugin--s2member-profile-login'), $('input#ws-plugin--s2member-profile-password1'), $('input#ws-plugin--s2member-profile-password2'), $('div#ws-plugin--s2member-profile-password-strength'));
					});
				/**/
				$('form#ws-plugin--s2member-profile').submit ( /* Validate Profile. */function()
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						var $password1 = $('input#ws-plugin--s2member-profile-password1', context);
						var $password2 = $('input#ws-plugin--s2member-profile-password2', context);
						/**/
						var $submissionButton = $('input#ws-plugin--s2member-profile-submit', context);
						/**/
						$(':input', context).each ( /* Go through them all together. */function()
							{
								var id = /* Remove numeric suffixes. */ $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, '');
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().children ('strong').first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += /* Collect errors. */ error + '\n\n';
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + errors);
								/**/
								return false;
							}
						/**/
						else if ($.trim ($password1.val ()) && $.trim ($password1.val ()) !== $.trim ($password2.val ()))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Passwords do not match up. Please try again.", "s2member-front", "s2member")); ?>');
								/**/
								return false;
							}
						/**/
						else if ($.trim ($password1.val ()) && /* Enforce minimum length requirement here. */ $.trim ($password1.val ()).length < 6)
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Password MUST be at least 6 characters. Please try again.", "s2member-front", "s2member")); ?>');
								/**/
								return false;
							}
						/**/
						ws_plugin__s2member_animateProcessing($submissionButton);
						/**/
						return true;
					});
			}
		/**/
		if (location.href.match (/\/wp-signup\.php/))
			{
				$('div#content > div.mu_register > form#setupform').submit (function()
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						$('input#user_email', context).attr ('data-expected', 'email');
						/**/
						var $submissionButton = $('p.submit input[type="submit"]', context);
						/**/
						$('input#user_name, input#user_email, input#blogname, input#blog_title, input#captcha_code', context).attr ({'aria-required': 'true'});
						/**/
						$(':input', context).each ( /* Go through them all together. */function()
							{
								var id = /* Remove numeric suffixes. */ $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, '');
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += /* Collect errors. */ error + '\n\n';
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + errors);
								/**/
								return false;
							}
						/**/
						ws_plugin__s2member_animateProcessing($submissionButton);
						/**/
						return true;
					});
			}
		/**/
		if (location.href.match (/\/wp-login\.php/))
			{
				$('input#ws-plugin--s2member-custom-reg-field-user-pass1, input#ws-plugin--s2member-custom-reg-field-user-pass2').keyup (function()
					{
						ws_plugin__s2member_passwordStrength($('input#user_login'), $('input#ws-plugin--s2member-custom-reg-field-user-pass1'), $('input#ws-plugin--s2member-custom-reg-field-user-pass2'), $('div#ws-plugin--s2member-custom-reg-field-user-pass-strength'));
					});
				/**/
				$('div#login > form#registerform input#wp-submit').attr /* Makes plenty of room ( i.e. tab indexes ) for Custom Registration Fields. */ ('tabindex', '1000');
				/**/
				$('div#login > form#registerform').submit (function()
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						$('input#user_email', context).attr ('data-expected', 'email');
						/**/
						var $pass1 = $('input#ws-plugin--s2member-custom-reg-field-user-pass1[aria-required="true"]', context);
						var $pass2 = $('input#ws-plugin--s2member-custom-reg-field-user-pass2', context);
						/**/
						var $submissionButton = /* Registration submission button. */ $('input#wp-submit', context);
						/**/
						$('input#user_login, input#user_email, input#captcha_code', context).attr ({'aria-required': 'true'});
						/**/
						$(':input', context).each ( /* Go through them all together. */function()
							{
								var id = /* Remove numeric suffixes. */ $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, '');
								/**/
								if /* No for="" attribute on these fields. */ ($.inArray (id, ['user_login', 'user_email', 'captcha_code']) !== -1)
									{
										if /* Use label. */ ((label = $.trim ($(this).parent ('label').text ().replace (/[\r\n\t]+/g, ' '))))
											{
												if (error = ws_plugin__s2member_validationErrors(label, this, context))
													errors += /* Collect errors. */ error + '\n\n';
											}
									}
								else if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().children ('span').first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += /* Collect errors. */ error + '\n\n';
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + errors);
								/**/
								return false;
							}
						/**/
						else if ($pass1.length && $.trim ($pass1.val ()) !== $.trim ($pass2.val ()))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Passwords do not match up. Please try again.", "s2member-front", "s2member")); ?>');
								/**/
								return false;
							}
						/**/
						else if /* Enforce minimum length requirement here. */ ($pass1.length && $.trim ($pass1.val ()).length < 6)
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Password MUST be at least 6 characters. Please try again.", "s2member-front", "s2member")); ?>');
								/**/
								return false;
							}
						/**/
						ws_plugin__s2member_animateProcessing($submissionButton);
						/**/
						return true;
					});
			}
		/**/
		if (location.href.match (/\/wp-admin\/(user\/)?profile\.php/))
			{
				$('form#your-profile').submit ( /* Validation. */function()
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						$('input#email', context).attr ('data-expected', 'email');
						/**/
						$(':input[id^="ws-plugin--s2member-profile-"]', context).each ( /* Go through them all together. */function()
							{
								var id = /* Remove numeric suffixes. */ $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, '');
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += /* Collect errors. */ error + '\n\n';
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + errors);
								/**/
								return false;
							}
						/**/
						return true;
					});
			}
		/**/
		if /* Attach form submission handler to `/register` for BuddyPress. */ (runningBuddyPress)
			{
				$('body.registration form div#ws-plugin--s2member-custom-reg-fields-4bp-section').closest ('form').submit (function()
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						$('input#signup_email', context).attr ('data-expected', 'email');
						/**/
						$('input#signup_username, input#signup_email, input#signup_password, input#field_1', context).attr ({'aria-required': 'true'});
						/**/
						$(':input', context).each ( /* Go through them all together. */function()
							{
								var id = /* Remove numeric suffixes. */ $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, '');
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += /* Collect errors. */ error + '\n\n';
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + errors);
								/**/
								return false;
							}
						/**/
						return true;
					});
				/**/
				$('body.logged-in.profile.profile-edit :input.ws-plugin--s2member-profile-field-4bp').closest ('form').submit (function()
					{
						var context = this, label = '', error = '', errors = '';
						/**/
						$('input#field_1', context).attr ({'aria-required': 'true'});
						/**/
						$(':input', context).each ( /* Go through them all together. */function()
							{
								var id = /* Remove numeric suffixes. */ $.trim ($(this).attr ('id')).replace (/-[0-9]+$/g, '');
								/**/
								if (id && (label = $.trim ($('label[for="' + id + '"]', context).first ().text ().replace (/[\r\n\t]+/g, ' '))))
									{
										if (error = ws_plugin__s2member_validationErrors(label, this, context))
											errors += /* Collect errors. */ error + '\n\n';
									}
							});
						/**/
						if (errors = $.trim (errors))
							{
								alert('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("— Oops, you missed something: —", "s2member-front", "s2member")); ?>' + '\n\n' + errors);
								/**/
								return false;
							}
						/**/
						return true;
					});
			}
		/**/
		ws_plugin__s2member_passwordStrength = function($username, $pass1, $pass2, $result)
			{
				if ($username instanceof jQuery && $pass1 instanceof jQuery && $pass2 instanceof jQuery && $result instanceof jQuery && typeof passwordStrength === 'function' && typeof pwsL10n === 'object')
					{
						$result.removeClass ('ws-plugin--s2member-password-strength-short ws-plugin--s2member-password-strength-bad ws-plugin--s2member-password-strength-good ws-plugin--s2member-password-strength-strong ws-plugin--s2member-password-strength-mismatch');
						/**/
						switch /* Uses WordPress® script: `password-strength-meter` and `pwsL10n`. */ (passwordStrength($pass1.val (), $username.val (), $pass2.val ()))
							{
								case 1:
									$result.addClass ('ws-plugin--s2member-password-strength-short').html (pwsL10n['short']);
									break;
								case 2:
									$result.addClass ('ws-plugin--s2member-password-strength-bad').html (pwsL10n['bad']);
									break;
								case 3:
									$result.addClass ('ws-plugin--s2member-password-strength-good').html (pwsL10n['good']);
									break;
								case 4:
									$result.addClass ('ws-plugin--s2member-password-strength-strong').html (pwsL10n['strong']);
									break;
								case 5:
									$result.addClass ('ws-plugin--s2member-password-strength-mismatch').html (pwsL10n['mismatch']);
									break;
								default:
									$result.addClass ('ws-plugin--s2member-password-strength-short').html (pwsL10n['short']);
							}
					}
				/**/
				return;
			};
		/**/
		ws_plugin__s2member_validationErrors = function(label, field, context, required, expected)
			{
				if (typeof label === 'string' && label && typeof field === 'object' && typeof context === 'object')
					if (typeof field.tagName === 'string' && field.tagName.match (/^(input|textarea|select)$/i) && !field.disabled)
						{
							var tag = field.tagName.toLowerCase (), $field = $(field), type = $.trim ($field.attr ('type')).toLowerCase (), name = $.trim ($field.attr ('name')), value = $field.val ();
							var required = ( typeof required === 'boolean') ? required : ($field.attr ('aria-required') === 'true'), expected = ( typeof expected === 'string') ? expected : $.trim ($field.attr ('data-expected'));
							/**/
							var forcePersonalEmails = ('<?php echo strlen($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_force_personal_emails"]); ?>' > 0) ? true : false;
							var nonPersonalEmailUsers = new RegExp('^(<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (implode ("|", preg_split ("/[\r\n\t ;,]+/", preg_quote ($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_force_personal_emails"], "/")))); ?>)@', 'i');
							/**/
							if (tag === 'input' && type === 'checkbox' && name.match (/\[\]$/))
								{
									if (typeof field.id === 'string' && field.id.match (/-0$/))
										if (required && !$('input[name="' + name.replace (/([\[\]])/g, '\$1') + '"]:checked', context).length)
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please check at least one of the boxes.", "s2member-front", "s2member")); ?>';
								}
							else if (tag === 'input' && type === 'checkbox')
								{
									if (required && !field.checked)
										return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Required. This box must be checked.", "s2member-front", "s2member")); ?>';
								}
							else if (tag === 'input' && type === 'radio')
								{
									if (typeof field.id === 'string' && field.id.match (/-0$/))
										if (required && !$('input[name="' + name.replace (/([\[\]])/g, '\$1') + '"]:checked', context).length)
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please select one of the options.", "s2member-front", "s2member")); ?>';
								}
							else if (tag === 'select' && $field.attr ('multiple'))
								{
									if (required && (!(value instanceof Array) || !value.length))
										return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please select at least one of the options.", "s2member-front", "s2member")); ?>';
								}
							else if (typeof value !== 'string' || (required && !(value = $.trim (value)).length))
								{
									return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("This is a required field, please try again.", "s2member-front", "s2member")); ?>';
								}
							else if ((value = $.trim (value)).length && ((tag === 'input' && type.match (/^(text|password)$/i)) || tag === 'textarea') && typeof expected === 'string' && expected.length)
								{
									if (expected === 'numeric-wp-commas' && (!value.match (/^[0-9\.,]+$/) || isNaN(value.replace (/,/g, ''))))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be numeric ( with or without decimals, commas allowed ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'numeric' && (!value.match (/^[0-9\.]+$/) || isNaN(value)))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be numeric ( with or without decimals, no commas ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'integer' && (!value.match (/^[0-9]+$/) || isNaN(value)))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be an integer ( a whole number, without any decimals ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'integer-gt-0' && (!value.match (/^[0-9]+$/) || isNaN(value) || value <= 0))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be an integer > 0 ( whole number, no decimals, greater than 0 ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'float' && (!value.match (/^[0-9\.]+$/) || !value.match (/[0-9]/) || !value.match (/\./) || isNaN(value)))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a float ( floating point number, decimals required ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'float-gt-0' && (!value.match (/^[0-9\.]+$/) || !value.match (/[0-9]/) || !value.match (/\./) || isNaN(value) || value <= 0))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a float > 0 ( floating point number, decimals required, greater than 0 ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'date' && !value.match (/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a date ( required date format: dd/mm/yyyy ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'email' && !value.match (/^([a-z_~0-9\+\-]+)(((\.?)([a-z_~0-9\+\-]+))*)(@)([a-z0-9]+)(((-*)([a-z0-9]+))*)(((\.)([a-z0-9]+)(((-*)([a-z0-9]+))*))*)(\.)([a-z]{2,6})$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a valid email address.", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'email' && forcePersonalEmails && value.match (nonPersonalEmailUsers))
										{
											return label + '\n' + $.sprintf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use a personal email address.\nAddresses like <%s@> are problematic.", "s2member-front", "s2member")); ?>', value.split ('@')[0]);
										}
									else if (expected === 'url' && !value.match (/^http(s?)\:\/\/(.{5,})$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a full URL ( starting with http or https ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'domain' && !value.match (/^([a-z0-9]+)(((-*)([a-z0-9]+))*)(((\.)([a-z0-9]+)(((-*)([a-z0-9]+))*))*)(\.)([a-z]{2,6})$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a domain name ( domain name only, without http ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'phone' && (!value.match (/^[0-9 \(\)\-]+$/) || value.replace (/[^0-9]/g, '').length !== 10))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a phone # ( 10 digits w/possible hyphens,spaces,brackets ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'uszip' && !value.match (/^[0-9]{5}(-[0-9]{4})?$/))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a US zipcode ( 5-9 digits w/possible hyphen ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'cazip' && !value.match (/^[0-9A-Z]{3}( ?)[0-9A-Z]{3}$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a Canadian zipcode ( 6 alpha-numerics w/possible space ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected === 'uczip' && !value.match (/^[0-9]{5}(-[0-9]{4})?$/) && !value.match (/^[0-9A-Z]{3}( ?)[0-9A-Z]{3}$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be a zipcode ( either a US or Canadian zipcode ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected.match (/^alphanumerics-spaces-punctuation-([0-9]+)(-e)?$/) && !value.match (/^[a-z 0-9,\.\/\?\:;"'\{\}\[\]\|\\\+\=_\-\(\)\*&\^%\$#@\!`~]+$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics, spaces & punctuation only.", "s2member-front", "s2member")); ?>';
										}
									else if (expected.match (/^alphanumerics-spaces-([0-9]+)(-e)?$/) && !value.match (/^[a-z 0-9]+$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics & spaces only.", "s2member-front", "s2member")); ?>';
										}
									else if (expected.match (/^alphanumerics-punctuation-([0-9]+)(-e)?$/) && !value.match (/^[a-z0-9,\.\/\?\:;"'\{\}\[\]\|\\\+\=_\-\(\)\*&\^%\$#@\!`~]+$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics & punctuation only ( no spaces ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected.match (/^alphanumerics-([0-9]+)(-e)?$/) && !value.match (/^[a-z0-9]+$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphanumerics only ( no spaces/punctuation ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected.match (/^alphabetics-([0-9]+)(-e)?$/) && !value.match (/^[a-z]+$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use alphabetics only ( no digits/spaces/punctuation ).", "s2member-front", "s2member")); ?>';
										}
									else if (expected.match (/^numerics-([0-9]+)(-e)?$/) && !value.match (/^[0-9]+$/i))
										{
											return label + '\n' + '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Please use numeric digits only.", "s2member-front", "s2member")); ?>';
										}
									else if (expected.match (/^(any|alphanumerics-spaces-punctuation|alphanumerics-spaces|alphanumerics-punctuation|alphanumerics|alphabetics|numerics)-([0-9]+)(-e)?$/))
										{
											var split = expected.split ('-'), length = Number(split[1]), exactLength = (split.length > 2 && split[2] === 'e') ? true : false;
											/**/
											if /* An exact length is required? */ (exactLength && value.length !== length)
												return label + '\n' + $.sprintf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be exactly %s %s.", "s2member-front", "s2member")); ?>', length, ((split[0] === 'numerics') ? ((length === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digit", "s2member-front", "s2member")); ?>' : '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digits", "s2member-front", "s2member")); ?>') : ((length === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("character", "s2member-front", "s2member")); ?>' : '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("characters", "s2member-front", "s2member")); ?>')));
											/**/
											else if /* Otherwise, we interpret as the minimum length. */ (value.length < length)
												return label + '\n' + $.sprintf ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Must be at least %s %s.", "s2member-front", "s2member")); ?>', length, ((split[0] === 'numerics') ? ((length === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digit", "s2member-front", "s2member")); ?>' : '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("digits", "s2member-front", "s2member")); ?>') : ((length === 1) ? '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("character", "s2member-front", "s2member")); ?>' : '<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("characters", "s2member-front", "s2member")); ?>')));
										}
								}
						}
				/**/
				return '';
			};
		/**/
		ws_plugin__s2member_animateProcessingConfig = {originalText: '', interval: null, speed: 100}, ws_plugin__s2member_animateProcessing = function($obj, reset)
			{
				if /* This function expects a valid jQuery object. */ ($obj instanceof jQuery)
					{
						if /* Resets back to originalText value ( also clears interval ). */ (reset)
							{
								clearInterval(ws_plugin__s2member_animateProcessingConfig.interval);
								/**/
								if (ws_plugin__s2member_animateProcessingConfig.originalText) /* ? */
									$obj.val (ws_plugin__s2member_animateProcessingConfig.originalText);
								/**/
								return; /* No need to proceed any further. */
							}
						/**/
						$obj.first ().each ( /* Interval routine configured here. */function()
							{
								var $this = $(this), i = 0, dir = 'r', dots = ['.', '..', '...'];
								/**/
								ws_plugin__s2member_animateProcessingConfig.originalText = $this.val ();
								/**/
								clearInterval(ws_plugin__s2member_animateProcessingConfig.interval);
								/**/
								ws_plugin__s2member_animateProcessingConfig.interval = setInterval(function()
									{
										if /* Right... */ (dir === 'r')
											{
												if (i + 1 <= dots.length - 1)
													i = i + 1, dir = 'r';
												else /* Switch direction. */
													i = i - 1, dir = 'l';
											}
										/**/
										else if /* Left.. */ (dir === 'l')
											{
												if (i - 1 >= 0)
													i = i - 1, dir = 'l';
												else /* Switch direction. */
													i = i + 1, dir = 'r';
											}
										/**/
										for (var _dots = dots[i], l = dots[i].length; l < dots.length; l++)
											{
												_dots += /* Prevents jumping. */ ' ';
											}
										/**/
										$this.val ('<?php echo c_ws_plugin__s2member_utils_strings::esc_js_sq (_x ("Processing", "s2member-front", "s2member")); ?>' + _dots);
									}, ws_plugin__s2member_animateProcessingConfig.speed);
							});
					}
			};
	});
<?php
/**
* Menu page for the s2Member plugin ( List Server Options page ).
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
* @package s2Member\Menu_Pages
* @since 3.0
*/
if(realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if(!class_exists("c_ws_plugin__s2member_menu_page_els_ops"))
	{
		/**
		* Menu page for the s2Member plugin ( List Server Options page ).
		*
		* @package s2Member\Menu_Pages
		* @since 110531
		*/
		class c_ws_plugin__s2member_menu_page_els_ops
			{
				public function __construct()
					{
						echo '<div class="wrap ws-menu-page">'."\n";
						/**/
						echo '<div id="icon-plugins" class="icon32"><br /></div>'."\n";
						echo '<h2>s2Member® API / List Servers</h2>'."\n";
						/**/
						echo '<table class="ws-menu-page-table">'."\n";
						echo '<tbody class="ws-menu-page-table-tbody">'."\n";
						echo '<tr class="ws-menu-page-table-tr">'."\n";
						echo '<td class="ws-menu-page-table-l">'."\n";
						/**/
						echo '<form method="post" name="ws_plugin__s2member_options_form" id="ws-plugin--s2member-options-form">'."\n";
						echo '<input type="hidden" name="ws_plugin__s2member_options_save" id="ws-plugin--s2member-options-save" value="'.esc_attr(wp_create_nonce("ws-plugin--s2member-options-save")).'" />'."\n";
						/**/
						do_action("ws_plugin__s2member_during_els_ops_page_before_left_sections", get_defined_vars());
						/**/
						if(apply_filters("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_mailchimp", true, get_defined_vars()))
							{
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_mailchimp", get_defined_vars());
								/**/
								echo '<div class="ws-menu-page-group" title="MailChimp® Integration">'."\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-mailchimp-section">'."\n";
								echo '<a href="http://www.s2member.com/mailchimp" target="_blank"><img src="'.esc_attr($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]).'/images/mailchimp-stamp.png" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>'."\n";
								echo '<h3>MailChimp® List Server Integration ( optional )</h3>'."\n";
								echo '<p>s2Member can be integrated with MailChimp®. MailChimp® is an email marketing service. MailChimp® makes it easy to send email newsletters to your Customers, manage your MailChimp® subscriber lists, and track campaign performance. Although s2Member can be integrated with almost ANY list server, we highly recommend MailChimp®; because of their <a href="http://www.s2member.com/mailchimp-api-docs" target="_blank" rel="external">powerful API for MailChimp® services</a>. In future versions of s2Member, we plan to build additional features into s2Member that work with, and extend, MailChimp® services.</p>'."\n";
								echo '<p>For now, we\'ve covered the basics. You can have your Members automatically subscribed to your MailChimp® marketing lists <em>( e.g. newsletters / auto-responders )</em>. You\'ll need a <a href="http://www.s2member.com/mailchimp" target="_blank" rel="external">MailChimp® account</a>, a <a href="http://www.s2member.com/mailchimp-api-key" target="_blank" rel="external">MailChimp® API Key</a>, and your <a href="#" onclick="alert(\'To obtain your MailChimp® List ID(s), log into your MailChimp® account and click the Lists tab. Now click the (View) button, for the List(s) you want to integrate with s2Member. Then, click the (Settings) link. At the bottom of the (Settings) page, for each list; you\\\'ll find a Unique List ID.\'); return false;">MailChimp® List IDs</a>.</p>'."\n";
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_mailchimp", get_defined_vars());
								/**/
								echo '<table class="form-table">'."\n";
								echo '<tbody>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<th>'."\n";
								echo '<label for="ws-plugin--s2member-mailchimp-api-key">'."\n";
								echo 'MailChimp® API Key:'."\n";
								echo '</label>'."\n";
								echo '</th>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<td>'."\n";
								echo '<input type="password" autocomplete="off" name="ws_plugin__s2member_mailchimp_api_key" id="ws-plugin--s2member-mailchimp-api-key" value="'.format_to_edit($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["mailchimp_api_key"]).'" /><br />'."\n";
								echo 'Once you have a MailChimp® account, you\'ll need to <a href="http://www.s2member.com/mailchimp-api-key" target="_blank" rel="external">add an API Key</a>.'."\n";
								echo '</td>'."\n";
								/**/
								echo '</tr>'."\n";
								/**/
								for($n = 0; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++)
									{
										echo '<tr>'."\n";
										/**/
										echo '<th>'."\n";
										echo '<label for="ws-plugin--s2member-level'.$n.'-mailchimp-list-ids">'."\n";
										echo 'List ID(s) for '.(($n === 0) ? 'Free Subscribers' : 'Level #'.$n.' Members').' ( comma-delimited ):'."\n";
										echo '</label>'."\n";
										echo '</th>'."\n";
										/**/
										echo '</tr>'."\n";
										echo '<tr>'."\n";
										/**/
										echo '<td>'."\n";
										echo '<input type="text" autocomplete="off" name="ws_plugin__s2member_level'.$n.'_mailchimp_list_ids" id="ws-plugin--s2member-level'.$n.'-mailchimp-list-ids" value="'.format_to_edit($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$n."_mailchimp_list_ids"]).'" /><br />'."\n";
										echo 'New '.(($n === 0) ? 'Free Subscribers' : 'Level #'.$n.' Members').' will be subscribed to these List IDs.<br />'."\n";
										echo 'Ex: <code>4a44fRio5d, 434ksvviEdf, 8834jsdf923, ee9djfs4jel3</code><br />'."\n";
										echo 'Or: <code>4a44fRio5d::Group Title::Group|Another Group</code>'."\n";
										echo '</td>'."\n";
										/**/
										echo '</tr>'."\n";
									}
								/**/
								echo '</tbody>'."\n";
								echo '</table>'."\n";
								echo '</div>'."\n";
								/**/
								echo '</div>'."\n";
								/**/
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_mailchimp", get_defined_vars());
							}
						/**/
						if(apply_filters("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_aweber", true, get_defined_vars()))
							{
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_aweber", get_defined_vars());
								/**/
								echo '<div class="ws-menu-page-group" title="AWeber® Integration">'."\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-aweber-section">'."\n";
								echo '<a href="http://www.s2member.com/aweber" target="_blank"><img src="'.esc_attr($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]).'/images/aweber-logo.png" class="ws-menu-page-right" style="width:125px; height:125px; border:0;" alt="." /></a>'."\n";
								echo '<h3>AWeber® List Server Integration ( optional )</h3>'."\n";
								echo '<p>s2Member can be integrated with AWeber®. AWeber® is an email marketing service. Whether you\'re looking to get your first email campaign off the ground, or you\'re a seasoned veteran who wants to dig into advanced tools like detailed email web analytics, activity based segmentation, geo-targeting and broadcast split-testing, AWeber\'s got just what you need to make email marketing work for you.</p>'."\n";
								echo '<p>You can have your Members automatically subscribed to your AWeber® marketing lists <em>( e.g. newsletters / auto-responders )</em>. You\'ll need an <a href="http://www.s2member.com/aweber" target="_blank" rel="external">AWeber® account</a> and your <a href="#" onclick="alert(\'To obtain your AWeber® List ID(s), log into your AWeber® account. Click on the Lists tab. On that page you\\\'ll find a Unique List ID associated with each of your lists. AWeber® sometimes refers to this as a List Name instead of a List ID.\'); return false;">AWeber® List IDs</a>. You will ALSO need to configure a <a href="http://www.s2member.com/kb/aweber-email-parser-for-s2member/" target="_blank" rel="external">Custom Email Parser</a> inside your AWeber® account.</p>'."\n";
								echo '<p>Log into AWeber®, and go to <em>My Lists -> Email Parser</em>. If you like, choose the PayPal® Parser <em>( even if you\'re not using PayPal® as your Payment Gateway )</em>. You can safely ignore the additional instructions they provide. s2Member just needs the PayPal® box checked, and that\'s all. Or, even better, integrate <a href="http://www.s2member.com/kb/aweber-email-parser-for-s2member/" target="_blank" rel="external">s2Member\'s Custom Email Parser</a> for AWeber, which <strong>will improve reliability</strong> and flexibility.</p>'."\n";
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_aweber", get_defined_vars());
								/**/
								echo '<table class="form-table">'."\n";
								echo '<tbody>'."\n";
								/**/
								for($n = 0; $n <= $GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["levels"]; $n++)
									{
										echo '<tr>'."\n";
										/**/
										echo '<th>'."\n";
										echo '<label for="ws-plugin--s2member-level'.$n.'-aweber-list-ids">'."\n";
										echo 'List ID(s) for '.(($n === 0) ? 'Free Subscribers' : 'Level #'.$n.' Members').' ( comma-delimited ):'."\n";
										echo '</label>'."\n";
										echo '</th>'."\n";
										/**/
										echo '</tr>'."\n";
										echo '<tr>'."\n";
										/**/
										echo '<td>'."\n";
										echo '<input type="text" autocomplete="off" name="ws_plugin__s2member_level'.$n.'_aweber_list_ids" id="ws-plugin--s2member-level'.$n.'-aweber-list-ids" value="'.format_to_edit($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["level".$n."_aweber_list_ids"]).'" /><br />'."\n";
										echo 'New '.(($n === 0) ? 'Free Subscribers' : 'Level #'.$n.' Members').' will be subscribed to these List IDs.<br />'."\n";
										echo 'Ex: <code>mylist, myotherlist, anotherlist</code>'."\n";
										echo '</td>'."\n";
										/**/
										echo '</tr>'."\n";
									}
								/**/
								echo '</tbody>'."\n";
								echo '</table>'."\n";
								echo '</div>'."\n";
								/**/
								echo '</div>'."\n";
								/**/
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_aweber", get_defined_vars());
							}
						/**/
						if(apply_filters("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_opt_in", true, get_defined_vars()))
							{
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_opt_in", get_defined_vars());
								/**/
								echo '<div class="ws-menu-page-group" title="Registration / Double Opt-In Box?">'."\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-opt-in-section">'."\n";
								echo '<h3>Double Opt-In Checkbox Field ( optional )</h3>'."\n";
								echo '<p>A Double Opt-In Checkbox will ONLY be displayed, if you\'ve integrated one <em>or more</em> List Servers.</p>'."\n";
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_opt_in", get_defined_vars());
								/**/
								echo '<table class="form-table">'."\n";
								echo '<tbody>'."\n";
								echo '<tr class="ws-plugin--s2member-custom-reg-opt-in-label-row"'.((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? ' style="display:none;"' : '').'>'."\n";
								/**/
								echo '<th>'."\n";
								echo '<label for="ws-plugin--s2member-custom-reg-opt-in-label">'."\n";
								echo 'Double Opt-In Checkbox Label:'."\n";
								echo '</label>'."\n";
								echo '</th>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '<tr class="ws-plugin--s2member-custom-reg-opt-in-label-row"'.((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? ' style="display:none;"' : '').'>'."\n";
								/**/
								echo '<td>'."\n";
								echo '<input type="text" autocomplete="off" name="ws_plugin__s2member_custom_reg_opt_in_label" id="ws-plugin--s2member-custom-reg-opt-in-label" value="'.format_to_edit($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in_label"]).'" /><br />'."\n";
								echo 'Example: <code><img src="'.esc_attr($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]).'/images/'.(($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) ? 'checked' : 'unchecked').'.png" class="ws-plugin--s2member-custom-reg-opt-in-label-prev-img ws-menu-page-img-16" style="vertical-align:middle;" alt="" /> Your Label will appear next to a Checkbox.</code>'."\n";
								echo '</td>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<th>'."\n";
								echo '<label for="ws-plugin--s2member-custom-reg-opt-in">'."\n";
								echo 'Require Double Opt-In Checkbox?'."\n";
								echo '</label>'."\n";
								echo '</th>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<td>'."\n";
								echo '<select name="ws_plugin__s2member_custom_reg_opt_in" id="ws-plugin--s2member-custom-reg-opt-in">'."\n";
								echo '<option value="1"'.(($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 1) ? ' selected="selected"' : '').'>Yes ( the Box MUST be checked — checked by default )</option>'."\n";
								echo '<option value="2"'.(($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"] == 2) ? ' selected="selected"' : '').'>Yes ( the Box MUST be checked — unchecked by default )</option>'."\n";
								echo '<option value="0"'.((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_opt_in"]) ? ' selected="selected"' : '').'>No ( disable — do NOT display or require the Checkbox )</option>'."\n";
								echo '</select><br />'."\n";
								echo 'An email confirmation will NOT be sent to the User, unless the Box is checked, or you\'ve disabled the Box; by choosing <code>No</code>.'."\n";
								echo '</td>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '</tbody>'."\n";
								echo '</table>'."\n";
								echo '</div>'."\n";
								/**/
								echo '</div>'."\n";
								/**/
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_opt_in", get_defined_vars());
							}
						/**/
						if(apply_filters("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_opt_out", true, get_defined_vars()))
							{
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_opt_out", get_defined_vars());
								/**/
								echo '<div class="ws-menu-page-group" title="Automate Un-Subscribe/Opt-Outs?">'."\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-opt-out-section">'."\n";
								echo '<h3>Automate Un-Subscribe/Opt-Out Removals ( optional )</h3>'."\n";
								echo '<p>s2Member can automatically <em>( and silently )</em> remove Users/Members from the List Servers you\'ve configured above. s2Member is also capable of automating this, based on your own personal configuration preferences. Below, you can choose which Events you consider grounds for List Removal. It is also important to point out that s2Member will ONLY remove Users/Members from the Lists you\'ve configured at the Level the User/Member is or was at during the time of the Event. For example, if a Level #1 Member is deleted, they will ONLY be removed from the List(s) you\'ve configured at Level #1. If an account is upgraded from Level #1 to Level #2, they will ONLY be removed from the List(s) you\'ve configured at Level #1. Of course, all of this is based on the configuration below.</p>'."\n";
								echo '<p><em><strong>*Regarding AWeber®*</strong> these will NOT work for AWeber® until you <a href="http://www.s2member.com/aweber-notification-email" target="_blank" rel="external">add a Notification Email</a> to your AWeber® account matching the "EMail From Address" configured in <code>s2Member -> General Options -> EMail Configuration</code>. Which is currently set to: <code>'.esc_html($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["reg_email_from_email"]).'</code>. This is a required step if you want s2Member to be authenticated when it emails List Removal requests to AWeber®.</em></p>'."\n";
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_opt_out", get_defined_vars());
								/**/
								echo '<table class="form-table">'."\n";
								echo '<tbody>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<th>'."\n";
								echo '<label for="ws-plugin--s2member-custom-reg-auto-opt-outs">'."\n";
								echo 'Process List Removals Automatically? ( choose events )'."\n";
								echo '</label>'."\n";
								echo '</th>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<td>'."\n";
								echo '<div class="ws-menu-page-scrollbox" style="height:150px;">'."\n";
								echo '<input type="hidden" name="ws_plugin__s2member_custom_reg_auto_opt_outs[]" value="update-signal" />'."\n";
								foreach(array("removal-deletion" => "<strong>Anytime a User is deleted ( including manual deletions )</strong>", "ipn-refund-reversal-deletion" => "&#9492;&#9472; Anytime s2Member deletes an account because of a Refund/Reversal.", "(ipn|auto-eot)-cancellation-expiration-deletion" => "&#9492;&#9472; Anytime s2Member deletes an account because of a Cancellation/Expiration.", "modification" => "<strong>Anytime a User's Role changes ( including manual changes )</strong>", "ipn-refund-reversal-demotion" => "&#9492;&#9472; Anytime s2Member demotes an account because of a Refund/Reversal.", "(ipn|auto-eot)-cancellation-expiration-demotion" => "&#9492;&#9472; Anytime s2Member demotes an account because of a Cancellation/Expiration.", "(rtn|ipn)-upgrade-downgrade" => "&#9492;&#9472; Anytime s2Member changes a User's Role after a paid Subscr. Modification.") as $ws_plugin__s2member_temp_s_value => $ws_plugin__s2member_temp_s_label)
									echo '<input type="checkbox" name="ws_plugin__s2member_custom_reg_auto_opt_outs[]" id="ws-plugin--s2member-custom-reg-auto-opt-outs-'.esc_attr(preg_replace("/[^a-z0-9_\-]/", "-", $ws_plugin__s2member_temp_s_value)).'" value="'.esc_attr($ws_plugin__s2member_temp_s_value).'"'.((in_array($ws_plugin__s2member_temp_s_value, $GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_outs"])) ? ' checked="checked"' : '').' /> <label for="ws-plugin--s2member-custom-reg-auto-opt-outs-'.esc_attr(preg_replace("/[^a-z0-9_\-]/", "-", $ws_plugin__s2member_temp_s_value)).'">'.$ws_plugin__s2member_temp_s_label.'</label><br />'."\n";
								echo '</div>'."\n";
								echo '</td>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<th>'."\n";
								echo '<label for="ws-plugin--s2member-custom-reg-auto-opt-out-transitions">'."\n";
								echo 'Also Process List Transitions Automatically?'."\n";
								echo '</label>'."\n";
								echo '</th>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '<tr>'."\n";
								/**/
								echo '<td>'."\n";
								echo '<select name="ws_plugin__s2member_custom_reg_auto_opt_out_transitions" id="ws-plugin--s2member-custom-reg-auto-opt-out-transitions">'."\n";
								echo '<option value="0"'.((!$GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_out_transitions"]) ? ' selected="selected"' : '').'>No ( do NOT transition mailing list subscribers automatically )</option>'."\n";
								echo '<option value="1"'.(($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_out_transitions"] === "1") ? ' selected="selected"' : '').'>Yes ( automatically transition, if able to remove from a previous list )</option>'."\n";
								echo '<option value="2"'.(($GLOBALS["WS_PLUGIN__"]["s2member"]["o"]["custom_reg_auto_opt_out_transitions"] === "2") ? ' selected="selected"' : '').'>Yes ( always automatically transition, even if NOT removed from a previous list )</option>'."\n";
								echo '</select><br />'."\n";
								echo '<em><strong>*Transitions*</strong> When/if s2Member automatically removes a Member from Lists at their current Level# ( based on your configuration in the previous section ), this setting tells s2Member that it should <strong>also</strong> transition the Member to any Lists you\'ve configured at the new Access Level# ( i.e. Role ) they are being changed to. For example, if a Member is demoted from Level #1 to Level #0, do you want s2Member to add them to the Level #0 List(s) after it removes them from the Level #1 List(s)?</em><br /><br />'."\n";
								echo '<em><strong>*If removed from a previous list, or NOT?*</strong> You can choose your preference above. When/if s2Member automatically transitions a mailing list subscriber, it will first try to remove the subscriber from a previous mailing list. If s2Member is able to remove the subscriber from a previous list before the transition takes place, s2Member will then make an attempt ( based on your configuration ) to transition the subscriber to a new/different list silently ( e.g. without a new confirmation email being sent out ). If s2Member is NOT able to remove a subscriber from a previous list, it can - ( if configured to do so ), still transition a subscriber to a new list, by sending the subscriber a new email confirmation letter ( e.g. this is NOT silent, because you absolutely NEED the subscriber\'s permission in this case ).</em><br /><br />'."\n";
								echo '<em><strong>*Seamless with MailChimp®*</strong> If enabled, Automatic List Transitions work seamlessly with MailChimp®. Automatic List Transitions also work with AWeber®, but AWeber® will ALWAYS send the User/Member a new confirmation email, asking them to confirm changes to their mailing list subscription with you. Work is underway to improve this aspect of s2Member\'s integration with AWeber® in a future release. Ideally, a Customer would be transitioned silently behind the scene with AWeber® too, when appropriate.</em>'."\n";
								echo '</td>'."\n";
								/**/
								echo '</tr>'."\n";
								echo '</tbody>'."\n";
								echo '</table>'."\n";
								echo '</div>'."\n";
								/**/
								echo '</div>'."\n";
								/**/
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_opt_out", get_defined_vars());
							}
						/**/
						if(apply_filters("ws_plugin__s2member_during_els_ops_page_during_left_sections_display_other_methods", true, get_defined_vars()))
							{
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_before_other_methods", get_defined_vars());
								/**/
								echo '<div class="ws-menu-page-group" title="Other List Server Integration Methods">'."\n";
								/**/
								echo '<div class="ws-menu-page-section ws-plugin--s2member-other-methods-section">'."\n";
								echo '<h3>Other List Server Integrations ( there\'s always a way )</h3>'."\n";
								echo '<p>Check the s2Member API Notifications panel. You\'ll find additional layers of automation available through the use of the `Signup`, `Registration`, `Payment`, `EOT/Deletion`, `Refund/Reversal`, and `Specific Post/Page` Notifications that are available to you through the s2Member API. These make it possible to integrate with 3rd party applications; like list servers, affiliate programs, and other back-office routines; in more advanced ways. You will probably need to get help from a web developer though. s2Member API Notifications require some light PHP scripting by someone familiar with web service connections.</p>'."\n";
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_during_other_methods", get_defined_vars());
								echo '</div>'."\n";
								/**/
								echo '</div>'."\n";
								/**/
								do_action("ws_plugin__s2member_during_els_ops_page_during_left_sections_after_other_methods", get_defined_vars());
							}
						/**/
						do_action("ws_plugin__s2member_during_els_ops_page_after_left_sections", get_defined_vars());
						/**/
						echo '<div class="ws-menu-page-hr"></div>'."\n";
						/**/
						echo '<p class="submit"><input type="submit" class="button-primary" value="Save All Changes" /></p>'."\n";
						/**/
						echo '</form>'."\n";
						/**/
						echo '</td>'."\n";
						/**/
						echo '<td class="ws-menu-page-table-r">'."\n";
						c_ws_plugin__s2member_menu_pages_rs::display();
						echo '</td>'."\n";
						/**/
						echo '</tr>'."\n";
						echo '</tbody>'."\n";
						echo '</table>'."\n";
						/**/
						echo '</div>'."\n";
					}
			}
	}
/**/
new c_ws_plugin__s2member_menu_page_els_ops();
?>
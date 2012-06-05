<?php
/**
* Newsletter/Updates for Menu Pages.
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
* @since 111205
*/
if(realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if(!class_exists("c_ws_plugin__s2member_menu_pages_updates"))
	{
		/**
		* Newsletter/Updates for Menu Pages.
		*
		* @package s2Member\Menu_Pages
		* @since 111205
		*/
		class c_ws_plugin__s2member_menu_pages_updates
			{
				public function __construct()
					{
						if(is_object($user = wp_get_current_user()) && ($user_id = $user->ID))
							{
								echo '<form id="ws-updates-form" action="http://websharks-inc.us1.list-manage1.com/subscribe/post?u=8f347da54d66b5298d13237d9&amp;id=19e9d213bc" method="post" target="_blank">'."\n";
								/**/
								if(!is_ssl() && /* Don't require remote connections when running on `localhost`. */ !c_ws_plugin__s2member_utils_conds::is_localhost())
									{
										echo '<div class="ws-menu-page-r-group-header">'."\n";
										echo '<ins class="open">-</ins>Latest News<em>!</em>'."\n";
										echo '</div>'."\n";
										/**/
										echo '<div class="ws-menu-page-r-group" style="display:block;">'."\n";
										echo '<script type="text/javascript" src="http://feeds.feedburner.com/s2member-updates?format=sigpro&amp;nItems=3&amp;openLinks=new&amp;displayTitle=false&amp;displayFeedIcon=false&amp;displayExcerpts=false&amp;displayAuthor=false&amp;displayDate=false&amp;displayEnclosures=false&amp;displayLinkToFeed=false"></script>'."\n";
										echo '</div>'."\n";
									}
								/**/
								echo '<div class="ws-menu-page-r-group-header">'."\n";
								echo '<ins>+</ins>Email Updates<em>!</em>'."\n";
								echo '</div>'."\n";
								/**/
								echo '<div class="ws-menu-page-r-group">'."\n";
								/**/
								echo '<div id="ws-updates-div-fname">'."\n";
								echo '<label for="ws-updates-fname">First Name: *</label><br />'."\n";
								echo '<input type="text" aria-required="true" autocomplete="off" name="FNAME" id="ws-updates-fname" value="'.esc_attr($user->first_name).'" />'."\n";
								echo '</div>'."\n";
								/**/
								echo '<div id="ws-updates-div-lname">'."\n";
								echo '<label for="ws-updates-lname">Last Name: *</label><br />'."\n";
								echo '<input type="text" aria-required="true" autocomplete="off" name="LNAME" id="ws-updates-lname" value="'.esc_attr($user->last_name).'" />'."\n";
								echo '</div>'."\n";
								/**/
								echo '<div id="ws-updates-div-email">'."\n";
								echo '<label for="ws-updates-email">Email Address: *</label><br />'."\n";
								echo '<input type="text" aria-required="true" autocomplete="off" name="EMAIL" id="ws-updates-email" value="'.format_to_edit($user->user_email).'" />'."\n";
								echo '</div>'."\n";
								/**/
								if(!is_ssl() && /* Don't require remote connections when running on `localhost`. */ !c_ws_plugin__s2member_utils_conds::is_localhost())
									{
										echo '<div id="ws-updates-div-subs">'."\n";
										echo '<script type="text/javascript" src="http://websharks-inc.us1.list-manage.com/subscriber-count?b=31&u=8c67d547-edf6-41c5-807d-2d2d0e6cffd1&id=19e9d213bc"></script>'."\n";
										echo '</div>'."\n";
									}
								/**/
								echo '<div id="ws-updates-div-priv">'."\n";
								echo '( <a href="'.esc_attr(c_ws_plugin__s2member_readmes::parse_readme_value("Privacy URI")).'" target="_blank">we DO respect your privacy</a> )'."\n";
								echo '</div>'."\n";
								/**/
								echo '<div id="ws-updates-div-submit">'."\n";
								echo '<input type="submit" value="Subscribe" name="subscribe" />'."\n";
								echo '</div>'."\n";
								/**/
								echo '</div>'."\n";
								/**/
								echo '</form>'."\n";
							}
					}
			}
	}
/**/
new c_ws_plugin__s2member_menu_pages_updates();
?>
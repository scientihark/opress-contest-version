<?php
/**
* Right-side for Menu Pages.
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
* @since 110531
*/
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if (!class_exists ("c_ws_plugin__s2member_menu_pages_rs"))
	{
		/**
		* Right-side for Menu Pages.
		*
		* @package s2Member\Menu_Pages
		* @since 110531
		*/
		class c_ws_plugin__s2member_menu_pages_rs
			{
				/**
				* Right-side for Menu Pages.
				*
				* @package s2Member\Menu_Pages
				* @since 110531
				*
				* @return null
				*/
				public static function display ()
					{
						do_action ("ws_plugin__s2member_during_menu_pages_before_right_sections", get_defined_vars ());
						/**/
						echo '<div id="ws-menu-page-js-c-w" class="ws-menu-page-js-c-w">' . "\n";
						include_once dirname (dirname (__FILE__)) . "/menu-pages/js-c-warning.inc.php";
						echo '</div>' . "\n";
						/**/
						echo '<script type="text/javascript">' . "\n";
						echo "jQuery('div#ws-menu-page-js-c-w').hide();" . "\n";
						echo '</script>' . "\n";
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["updates"])
							{
								echo '<div class="ws-menu-page-updates">' . "\n";
								include_once dirname (dirname (__FILE__)) . "/menu-pages/updates.inc.php";
								echo '</div>' . "\n";
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["upsell-pro"])
							{
								echo '<div class="ws-menu-page-others">' . "\n";
								echo '<a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Pro Module / Prices")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-upsell-pro.png" alt="." /></a>' . "\n";
								echo '</div>' . "\n";
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["installation"])
							{
								echo '<div class="ws-menu-page-installation">' . "\n";
								echo '<a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Professional Installation URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-installation.png" alt="." /></a>' . "\n";
								echo '</div>' . "\n";
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["tools"])
							{
								echo '<div class="ws-menu-page-tools">' . "\n";
								echo '<img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-tools.png" alt="." />' . "\n";
								echo '</div>' . "\n";
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["videos"])
							{
								echo '<div class="ws-menu-page-videos">' . "\n";
								echo '<a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Video Tutorials")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-videos.png" alt="." /></a>' . "\n";
								echo '</div>' . "\n";
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["support"])
							{
								echo '<div class="ws-menu-page-support">' . "\n";
								echo '<a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Forum URI")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-support.png" alt="." /></a>' . "\n";
								echo '</div>' . "\n";
							}
						/**/
						if ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["menu_pages"]["donations"])
							{
								echo '<div class="ws-menu-page-donations">' . "\n";
								echo '<a href="' . esc_attr (c_ws_plugin__s2member_readmes::parse_readme_value ("Donate link")) . '" target="_blank"><img src="' . esc_attr ($GLOBALS["WS_PLUGIN__"]["s2member"]["c"]["dir_url"]) . '/images/brand-donations.png" alt="." /></a>' . "\n";
								echo '</div>' . "\n";
							}
						/**/
						do_action ("ws_plugin__s2member_during_menu_pages_after_right_sections", get_defined_vars ());
						/**/
						return; /* Return for uniformity. */
					}
			}
	}
?>
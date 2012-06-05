<?php
/*
Plugin Name:  XCloner
Plugin URI: http://www.xcloner.com
Description: XCloner is a tool that will help you manage your website backups, generate/restore/move so your website will be always secured! With XCloner you will be able to clone your site to any other location with just a few clicks. Don't forget to create the 'administrator/backups' directory in your Wordpress root and make it fully writeable. <a href="plugins.php?page=xcloner_show">Open XCloner</a> | <a href="http://www.xcloner.com/support/premium-support/">Get Premium Support</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=info%40xcloner%2ecom&lc=US&item_name=XCloner%20Support&no_note=0&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest">Donate</a>
Version: 3.0.7
Author: Liuta Ovidiu
Author URI: http://www.xcloner.com
Plugin URI: http://www.xcloner.com
*/


// no direct access
#defined( '_JEXEC' ) or die( 'Restricted access' );

function xcloner_show(){

print "<iframe src='../wp-content/plugins/xcloner-backup-and-restore/index.php' width='100%' height='900' frameborder=0 marginWidth=0 frameSpacing=0 marginHeight=110 ></iframe>";

}
function xcloner_install(){

}

function xcloner_page(){

	if ( function_exists('add_submenu_page') )
		add_submenu_page('plugins.php', XCloner, XCloner, 'manage_options', 'xcloner_show', 'xcloner_show');



}

#add_action('admin_head', 'xcloner');
add_action('admin_menu', 'xcloner_page');

#add_options_page('XCloner Options', 'XCloner', 9, 'index.php', 'xcloner_options');

if (isset($_GET['activate']) && $_GET['activate'] == 'true')
 {
   add_action('init', 'xcloner_install');
 }

?>

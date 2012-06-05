=== BuddyPress Sliding Login Panel ===
Contributors: pollyplummer
Donate link: http://untame.net/payment
Tags: BuddyPress, AJAX, Top Panel, Sliding Panel, plugin, AJAX login, Login, jQuery
Requires at least: 2.9.2
Tested up to: 3.1.2
Stable tag: 1.2

Adds a sliding AJAX login panel to BuddyPress with a full account center and menu for logged in users.

== Description ==

BuddyPress Sliding Login Panel delivers a fancy, smooth AJAX login experience for BuddyPress users. It also includes an account center with a full user menu. I put this plugin together based on the iRedlof Ajax Login by Rohit LalChandani but have completely re-worked it for use with BuddyPress. The plugin adds a tab to the top of the page to pull down a panel where the user can login. I wrote in a BuddyPress profile and account preview center for logged in users where they will be able to check out a teaser of their new messages and friend requests as well as navigate to other areas of the site.

BuddyPress Sliding Login Panel Plugin Features:
<ul>
<li><b>Logged Out Users:</b> The panel displays a welcome message, link to registration, password retrieval, and an AJAX login form.</li>
<li><b>Logged In Users:</b> The panel displays a total of two new messages with links to the inbox, the user's current avatar and option to change it, a list of links to the most commonly-used BuddyPress components, and a preview of the user's friend requests.</li>
</ul>

Many thanks to the team at <a href="http://www.quantumactivist.com/">quantumactivist.com</a> for sponsoring some bug fixes for this plugin.

== Installation ==

<ol>
<li>Upload the plugin to the plugins directory.</li>
<li>Activate the plugin.</li>
<li>Disable the BuddyPress Admin Bar by adding this to your wp-config.php file:
`define( 'BP_DISABLE_ADMIN_BAR', true );`
</li>
</ol>

UPGRADE Instructions:  Make sure to save a copy of the plugin if you've made customizations to it. Upgrades will overwrite your files. You will need to re-apply your changes.  I hope to change this in the very near future. Thanks for your patience.

This plugin has no options after you install it, which is simply because I haven't yet learned to add in option pages for plugins. As soon as I have the time to figure that out, I hope to make it much easier for users to customize without having to edit php files.  For now, if you want to change the welcome paragraph or any of the links, most everything can be found in the <i>update-content.php</i> file. You can also edit the CSS file included to make the plugin fit your site's design better.  More than likely you will want to update the logo. The easiest way to do that would be to name your file logo.png and overwrite the the same file in the images folder.

== Frequently Asked Questions ==

= Need additional features or customization? =

If you want to hire me to make customizations for your site, feel free to get in touch:
<a href="http://untame.net">Untame.net</a> using the <a href="http://untame.net/contact">contact form</a>.  No, I do not provide free support.


= My theme is distorted after activating this plugin =

Contact the author of your theme.

= Tab appears but it won't pull down =

This plugin requires you to disable the BuddyPress admin bar. See installation instructions for details.



== Screenshots ==

1. screenshot-1.jpg : Panel for Users Not Logged In
2. screenshot-2.jpg : Panel for Logged in Users with no Updates
3. screenshot-3.jpg : Panel for Logged In Users with Messages/Requests
4. screenshot-4.jpg : Full panel view

== Change Log ==

= 1.2 =
* Added sponsor info

= 1.1 =
* Fixed bug that caused ghost friend requests
* Improved avatar quality
* Updates to installation instructions

= 1.0 =
* First run!
	
== Upgrade Notice ==

= 1.2 =
This version fixes the problem with "ghost friend requests". IMPORTANT: Save any customizations you made to the plugin before upgrading so you can re-apply them - the update will overwrite your files.
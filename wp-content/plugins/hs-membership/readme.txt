=== HS Membership Plugin  ===

Contributors: jannesh
Donate link: http://haden.cc/
Tags: membership, members, member, register, signup, s2member, multi site, subscriber, members only, buddypress, buddy press, buddy press compatible, highly extensible
Requires at least: 3.0.0
Tested up to: 3.2.1
Stable tag: 1.0.0

Addon plugin to s2Member. Additional functionality for Multi-Site Installations. s2Member 3.1.2 required.

== Installation ==

= HS-Membership install instructions =
1. Ensure the s2Member plugin is correctly installed.
2. Upload the `/hsmember` folder to your `/wp-content/plugins/` directory.
3. Activate the plugin through the `Plugins` menu in WordPress.
4. Navigate to the `HS-Member Options` panel for configuration details.

== Description ==

HS Membership plugin add onto the already extensive s2Member.  It provides additional functionality including:

* The ability to disable the creation of blogs for Multi-Site installations, based on Membership Level. 
* New redirect to a 'Login Required' page, to promt the user to login first before he can browse the contents of the blog.  This is 
	required for older installs and upgrades from WPMU 2.9.
* New meta-box feature added to allow the author to set the Access Level of a Page/Post directly from the edit page.

This plugin requires the following to ensure full functionality:

* Wordpress Multi-Site: 3.0.0, tested up to 3.2.1
* s2Member: 3.1.2, tested up to 110815

== Frequently Asked Questions ==

= Does HS Membership install any new database tables? =
No, HS Membership has been fully integrated with the Options Settings that are already built into WordPress. 
It is designed to be completely seamless, without code bloat. It has been structured to maximize the ability to 
integrate with other plugins installed.

= Do I need to install s2Member to use HS Membership? =
Yes. HS Membership has been designed to specifically integrate and build on the functionality of s2Member. It is designed to
seamlessly add to the functionality of s2Member. HS Members have been tested with s2Member 3.1.2.

= Do I need to install BuddyPress to use HS Membership? =
No.  Although HS Membership has been designed to integrate with BuddyPress, it is not required to have BuddyPress
installed to use it.  HS Membership have been tested with BuddyPress 1.2.5.2.

= Will member blogs be able to use the HS-Membership functionality? =
Not in the current version.  In the current version HS Membership can only be 'Network Activated'. The options menu and other
functionality will also not be displayed or be available in membership blog dashboards. However this issue is being addressed
and in future the Super-Admin will have the option to make the HS-Membership functionality available to member blogs or even to
member blogs with a certain membership level on the Site Blog?

= If a member cancel his subscription, will his blog be deleted automatically? =
Not in the current version.  In the current version of HS Membership the Super-Admin will have to manualy delete the Blog from
the Dashboard.  However this is issue is being addressed and in future the Super-Admin will have the option to set HS-Membership
up to delete a blog if the subscription is canceled?

== Future Releases ==

We are currently working on perfecting and testing version 1.0.0 of HS Membership.  For this release we have the following
improvements and new features planned:

* Full Integration with Wordpress Multi-Site allowing the Super-Admin to also give access to the HS Membership capabilities
	to the admins and authors of member blogs.
* The ability to remove blogs from the site when the blog owner have canceled their membership of the site.
* Redirect to 'Login Required' page if the user/visitor is not allowed to create a new blog.

For future releases after version 1.0.0:

* The ability to allow member blogs access to specific Themes, based on the membership level of the blog owners.
* The ability to allow member blogs access to specific Plugins, based on the membership level of the blog owners.
* The ability to allow member blogs more storage space for blogs articles, based on the membership level of the blog owners.

== Upgrade Notice ==

= 1.0.0 =
* Upgrade highly recomended to allow member blogs to also use the Membership processing

= 0.9.5 =
* Upgrade highly recomended for compatibility with Wordpress 3.2+ and s2Member 110815

= 0.9.4 =
* Upgrade highly recomended for compatibility with Wordpress 3.1+.

= 0.9.3 =
* Upgrade required to prevent conflicts with s2Member ver 3.5.

= 0.9.2 =
* Upgrade required to prevent conflict with s2Member ver 3.2.

= 0.9.1 =
* Upgrade required to prevent conflict between main blog and member blogs.

== Changelog ==

= 1.0.0 =
* Update: Functionality enabled for Member Blogs.

= 0.9.5 =
* Bug Fix: Compatibilty with Wordpress 3.2.
* Bug Fix: Cleaned up code and fixed several smaller bugs.

= 0.9.4 =
* Bug Fix: Compatibilty with Wordpress 3.1.
* Bug Fix: Gracefull degradation for old versions of Wordpress and s2Member.
* Bug Fix: Correctly limit access to the wp-signup.php url.

= 0.9.3 =
* Bug Fix: The new versions of s2Member use classes. This cause HS-Membership to have errors. This has now been fixed.

= 0.9.2 =
* Feature Update/Bug Fix: The 'Membership Access' meta box on the page/post editing pages will only be available for installs with 
	s2Member prior to version 3.2. From 2Member v3.2 this is now handled by s2Member.
* Feature Update: The 'Blog Creation Restriction' option will only be available for installs with s2Member prior to version 3.2.  From
	s2Member v3.2 this is now handled by s2Member.

= 0.9.1 =
* Bug Fix: Removed the 'Membership Access' meta box on the page/post editing pages. This conflicts with the same functionality
	for the main blog. Version 1.0.0 targeted to fully implement this feature. 
* Bug Fix: The 'Membership Access' meta box was not working on the page/post editing pages for new pages. This was only for the
	first time when the post was being created. The problem has now been fixed.

= 0.9.0 =
* Initial Release
* New Feature: Login Required page added.
* New Feature: New option 'Blog Creation Restriction' added. This option allow the admin to block
  Blog Creation according to the users level.
* New Feature: New meta-box feature added to allow the author to set the Access Level of a Page/Post
  from the edit page.
* Bug fix: Correctly update user capabilities after a new blog has been created.
  Previously on MS installs upgraded from WPMU 2.9, the s2Member capabilities of a user would be 
  removed if the user created a new blog.

=== Plugin Name ===
Contributors: ChrisHilditch
Tags: ajax, widgets, page speed
Requires at least: 2.9.0
Tested up to: 3.3
Stable tag: 3.3

This plugin creates a new 'Ajax Widget Area'. The widget loads the widgets placed in the Area with AJAX, after the page load.

== Description ==

Speed up page load by loading in a widgets area with AJAX.  

This plugin creates a new 'Ajax Widget Area'. The widget loads the widgets placed in the 'Ajax Widget Area' with AJAX, after the page has loaded.

== Installation ==

1. Upload the `ajax-widget-area` folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Go to the widgets page, and place widgets in the new Ajax Widgets Area.
1. Place the Ajax Widget Area Widget in another widget area.

== Frequently Asked Questions ==

= Why would I want to do this? =

To speed up page load.  The user would have access to the main content on the page faster, and by the time they're done with that the widgets will have loaded in.  

= What about SEO? =

Good question!  Anything place in the ajax widget area won't be indexed by the search engines, so you might not want to put everything in there. Future versions will separate options for Desktop, Mobile and Bots.  

= Only 1 ajax widget area? I need more! =

Dive into the code then, creating additional ajax widget areas won't take to long! 

= The styling of the widgets is broken =

Sorry.  In WordPress when you define a widget area you also define what html surrounds the widget, and the widget title.  The html structure is this plugin is consistent with the Twenty Eleven base theme, but other themes use different html.  To fix this you could copy from your theme's functions.php - 'before_widget', 'after_widget', 'before_title' and 'after_title' html into this plugin. 

== Screenshots ==

1. Example Usage.

== Changelog ==

= 0.5 =
* Ajax Widget Area goes public.

= 0.6 =
* Bug Fix for non-admin users.

= 0.7 =
* Add before_widget, after_widget, before_title and after_title html, to be consistent with Twenty Eleven html.

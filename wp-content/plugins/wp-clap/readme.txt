=== WP-Clap ===
Contributors: Ariagle 
Donate link:http://blog.lolily.com/
Tags: AJAX, Comments, Clap
Requires at least: 2.7
Tested up to: 3.0.1
Stable tag: 1.5

== Description ==

Not everyone wants to leave a comment, and you don't know who have read your post without feedback. WP-Clap helps you make your visitors leave simple feedback without type a comment.

WP-Clap will creat a clap area after your post. Just like the comment area, your readers can clap for your post after reading, but they do not need to type anything. You can also use our function in your homepage to show how many claps the posts have, just like how many comments there are.

并不是每个人都会留言，日志冷场现象经常出现。WP-Clap插件允许你的读者在浏览日志后能轻松简单地留下路过的印记，减少冷场现象。

**Features:**

* AJAX Clapping
* Avatar suppor
* Clapper details(name, email, url, date)
* Image clap link
* Custom clap text
* Custom HTML notice
* Auto insert into post and excerpt

**equires Version:**

I don’t know whether WP-Clap can work at WP 2.5 or lower, but you can have a try.

**Supported Languages:**

* US English/en_US (default)
* 简体中文/zh_CN (translate by [Ariagle](http://blog.lolily.com/))
* 日本語/ja_JP (translate by [晓晓](http://xiaolife.com/))
* Dutch/nl_NL (translate by [Marcel](http://blog.bokhorst.biz/))
	
== Installation ==

1. Unzip archive to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to 'Setting->WP-Clap', and change the setting
4. If you Check the options of the 'Display', you do not need to pay attention to the following content
5. (If you uncheck the above options) In your 'single.php' file add the following line:
****

	<?php if(function_exists('wp_clap')) { wp_clap(); } ?>
	
You can use the following functions in 'index.php' to show how many claps there are:
****

	<?php if(function_exists('get_wp_claps')) { get_wp_claps(zero, one, more, mode, link, echo, post_id); } ?>
	
**Parameters of get_wp_claps():**

    NAME            TYPE       DESCRIPTION                                           DEFAULT      VERSIONS
	zero			string     Text to display when there are no claps.              'No Claps'   1.0
	one				string	   Text to display when there is one clap.               'One Clap'   1.0
	more			string     Text to display when there are more than one claps,   '% Claps'    1.0
	                           '%' is replaced by the number of claps.
	mode			integer    Which number you want to show.                        0            1.0
	                           0 = Total claps,
							   1 = Total clappers,
							   2 = Average claps.
	link			integer    0 = No link, 1 = A link to the clap area.             0            1.0
	echo            integer    0 = echo, 1 = return value.                           1            1.0
	post_id         integer    Target post. Generally you do not need to set it.     0            1.0
	
**Using Examples:**

As the function get_wp_claps(), generally you do not neet to reset the $link, $echo and $post_id. There are some examples:

	<?php get_wp_claps('No Claps', 'One Clap', '% Claps'); // total claps ?>
	<?php get_wp_claps('0 Clap', '1 Clap', '% Claps', 1); // total clappers ?>
	<?php get_wp_claps('0 Clap', '1 Clap', '% Claps', 2); // average claps ?>
	<?php get_wp_claps('0 Claps', '1 Clap', '% Claps', 0, 0); // total claps with no link ?>
	
**Custom CSS:**

* WP-Clap will load wp-clap-style.css .
* If you want to use your own style, just check the style checkbox in 'Setting->WP-Clap'.

== Changelog ==

= 2010/09/12 =
* Version 1.5
* Check for WP3.0, MultiSite is supported now.
* Add a new option that you can choose which page(s) do not display claps.
* Edit default style.

= 2010/04/29 =
* Version 1.4
* Custom HTML supported.

= 2009/10/11 =
* Version 1.3
* Fix a bug.
* Now only administrator can edit the setting page.

= 2009/08/25 =
* Version 1.2
* Fix a bug.
* Add new options.

= 2009/08/16 =
* Version 1.1
* Auto insert into post.

= 2009/08/14 =
* Version 1.0
* New plugin Publish.

== Frequently Asked Questions == 

= How to display the Clap Area? =

There are 2 ways to display the clap area:

1. In the 'Setting->WP-Clap' page, check the options of 'Display' and the clap area will be inserted into where you want.

2. Add the following line to where you like to display it:
****
	<?php if(function_exists('wp_clap')) { wp_clap(); } ?>
	
For example, in the 'single.php' file, you can add it before 
****
	<?php comments_template(); ?>


= How to display the number of claps in the index? =

There are 2 ways to display the number of claps:

1. In the 'Setting->WP-Clap' page, check the option 'Auto insert frequency into post and excerpt' of 'Display', and the number of claps will be inserted into the right top of the post and excerpt. Posts can be also clapped here.

2. You can use the function get_wp_claps(). Go to Installation to learn the parameters of this function.

= Widget =

Sorry, WP-Clap doesn't have widget now. Maybe widget will appear at the next version.

= The Clap Area's style is wrong in my blog! =

We can not make sure that the WP-Clap's default style suits for everyone's themes. You can check the style option in the WP-Clap setting page and add your custom style to your theme's 'style.css' file.

== Screenshots ==

Go to [Plugin Home Page](http://blog.lolily.com/wordpress-plugin-wp-clap.html#screenshots) to see the screenshots.
=== Auto ThickBox Plus ===
Contributors: attosoft
Donate link: http://attosoft.info/blog/en/donate/
Tags: lightbox, thickbox, shadowbox, gallery, semiologic, image, images, thumbnail, thumbnails, popup, pop-up, overlay, photo, photos, picture, pictures, javascript, simple, inline, iframe, ajax, jquery, plugin, plugins, link, links, widget, widgets, nextgen, nextgen gallery
Requires at least: 2.7
Tested up to: 3.3.1
Stable tag: trunk

Overlays linked image, inline, iFrame and AJAX content on the page in simple & fast effects. (improved version of Auto Thickbox plugin)

== Description ==

Auto ThickBox Plus plugin is the improved version of [Auto Thickbox](http://wordpress.org/extend/plugins/auto-thickbox/) plugin, with some extra features and bug fixes.

By clicking on links, this plugin overlays linked content on the page in simple & fast effects. It's recommended if you want to pop up thumbnails easily in its original size.

= Basic Features =

* Automatically applies [ThickBox script](http://jquery.com/demo/thickbox/) to thumbnails including WordPress Galleries
  * All you do is upload images to WordPress Gallery or write image links to images (`<a href="image"><img /></a>`)
* Pop-up effects are simple & fast compared to Lightbox, ColorBox, FancyBox, Shadowbox, Slimbox and so on
  * ThickBox will be the answer if you prefer no animation effects & no fancy design
* Automatically resizes images that are larger than the browser window
* Uses WordPress built-in ThickBox library (no need to install the script and refer to it)

= Extra Features =

* Overlays images in either "Gallery Images" or "**Single Image**" style
* Automatically applies ThickBox to **text links** to images (`<a href="image">text</a>`)
* **Auto Resize** feature can be disabled if you prefer
* ThickBox window can be **moved/resized by dragging** mouse
* Can be customized the behavior & design through **more than 50 options**
  * e.g. Click action can be selected from 'Close', 'None', 'Next' and 'Prev/Next'
* Supports also BMP and [WebP](http://code.google.com/speed/webp/) image formats
* Supports **Inline content** on the page (`#TB_inline`)
* Supports **AJAX content** (displays internal files on the page without iframe)
* Compatible widely down to even **obsolete WordPress 2.7**
* Compatible with default theme in WordPress 3.2/3.3 called **Twenty Eleven**
* Compatible with cache plugins such as [W3 Total Cache](http://wordpress.org/extend/plugins/w3-total-cache/) and [Head Cleaner](http://wordpress.org/extend/plugins/head-cleaner/)
* Improved ThickBox is also available in another ThickBox plugins such as [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/)
* Uses WordPress translations
  * Now ThickBox window is localized to **more than 70 languages** (Arabic, Chinese, Dutch, French, German, Hindi, Italy, Japanese, Korean, Polish, Portuguese, Russian, Spanish and more)
* And fixed a lot of bugs in original plugin and thickbox.js/css (See [Changelog](changelog/))

= How to Install =

See [Installation](installation/).

= How to Use =

See [Usage in Other Notes](other_notes/).

= Auto ThickBox Plus needs Your Support =

* If you install this plugin, put Rating Stars and vote Compatibility (Works/Broken) via the right sidebar
* If you have any feedback or questions, visit [Plugin Forum](http://wordpress.org/tags/auto-thickbox-plus) or [Contact Me](http://attosoft.info/blog/en/contact/)
* If you can localize this plugin, please send me translated [ato-thickbox.pot](http://plugins.trac.wordpress.org/browser/auto-thickbox-plus/trunk/languages/auto-thickbox.pot) file
* If you like this plugin, please consider [making a donation](http://attosoft.info/blog/en/donate/) to support plugin development

Any comments will be very helpful and appreciated. Thank you for your support!

= Special Thanks =

* Dutch (nl_NL) translations - [Michel Bats](http://www.batssoft.nl/)
* Button images in screenshot - [Lukas Häusler](http://lukashausler.com/)

= Links =

* [attosoft.info](http://attosoft.info/en/) \[[日本語](http://attosoft.info/)\]
* [Auto ThickBox Plus Plugin Official Site](http://attosoft.info/blog/en/auto-thickbox-plus/) \[[日本語](http://attosoft.info/blog/auto-thickbox-plus/)\]
* [Auto Thickbox Plugin](http://www.semiologic.com/software/auto-thickbox/) (Original)
* [ThickBox 3.1](http://jquery.com/demo/thickbox/) (JavaScript Library)

== Installation ==

= Auto Install =

1. Access Dashboard screen in WordPress
1. Select [Plugins] - [Add New]
1. Input "thickbox" into text field, and click [Search Plugins]
1. Click 'Install Now' at 'Auto ThickBox Plus'
1. Click 'Activate Plugin'
1. Upload images to WordPress Gallery or write links to images, inline, iFrame or AJAX contents

= Manual Install =

1. Download [auto-thickbox-plus.zip](http://downloads.wordpress.org/plugin/auto-thickbox-plus.zip)
1. Access Dashboard screen in WordPress
1. Select [Plugins] - [Add New] - 'Upload' tab
1. Upload the plugin zip file, and click [Install Now]
1. Click 'Activate Plugin'
1. Upload images to WordPress Gallery or write links to images, inline, iFrame or AJAX contents

= Manual Install via FTP =

1. Download [auto-thickbox-plus.zip](http://downloads.wordpress.org/plugin/auto-thickbox-plus.zip), and unzip it
1. Upload the plugin folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Upload images to WordPress Gallery or write links to images, inline, iFrame or AJAX contents

\* Note: If Auto Thickbox (not Plus) plugin is installed, you need to deactivate or uninstall it before activating Auto ThickBox Plus plugin. You cannot activate both this plugin and the original plugin at the same time.

= Customization =
This is available options at Auto ThickBox Plus Options in 'Settings' menu. You can customize the behavior & design of the plugin through these options. See also [Screenshots](../screenshots/).

* General
  * Default Display Style (Single Image or Gallery Images)
  * ThickBox on Text Links (Auto or Manual)
  * Auto Resize
  * ThickBox Resources (original thickbox.js/css)
* Action
  * Mouse Click
  * Mouse Wheel (Scroll)
  * Drag & Drop
  * Keyboard Shortcuts
* View
  * Position
  * Font Family & Weight
  * Font Size
  * Text Color
  * Background Color
  * Margin
  * Border
  * Border Raidus
  * Opacity
  * Box Shadow
  * Text Shadow
* Text
  * Title, Caption
* Image
  * Prev/Next, Close, Loading image, etc.
* Effect (beta)
  * Open, Close, Transition effects and Speed

== Frequently Asked Questions ==

= Auto ThickBox Plus does not work =

Most likely, some sort of JavaScript error has occurred in your blog. Please make sure that you can see any messages (errors/warnings) in browser console.

* Internet Explorer: Double-click the warning icon in status bar or [Tools] - [Developer Tools] (F12)
* Mozilla Firefox: [Firefox/Tools] - [Web Developer] - [Error Console] (Ctrl+Shift+J)
* Google Chrome: [Tools] - [JavaScript console] (Ctrl+Shift+J)
* Opera: [Opera] - [Page] - [Developer Tools] - [Error Console] (Ctrl+Shift+O)
* Safari (Mac): [Develop] - [Show Error Console] (Option-Command-C)
  * Safari (Windows): Page Menu Button - [Developer] - [Show Error Console] (Ctrl+Alt+C)
  * To enable the developer tools, click Advanced in Safari preferences and check "Show Develop menu in menu bar"

\* If you can send me your blog URL that the plugin does not work, it's easy for me to debug the problem and find the cause quickly.

If JavaScript errors have occurred, ThickBox may not work even when loaded properly. If you use cache plugins such as [W3 Total Cache](http://wordpress.org/extend/plugins/w3-total-cache/) and [Head Cleaner](http://wordpress.org/extend/plugins/head-cleaner/), try to deactivate them first.

If no errors have occurred, ThickBox resources may not have been loaded properly. Please check the followings.

**1. Can you see the HTML source codes bellow in your blog?**

Inside the `<head>` tag:

    <link rel='stylesheet' id='thickbox-css'  href='http://example.com/wp-content/plugins/auto-thickbox-plus/thickbox.min.css?ver=1.x' type='text/css' media='all' />

Before the closing `</body>` tag:

    <script type='text/javascript' src='http://example.com/wp-content/plugins/auto-thickbox-plus/thickbox.min.js?ver=1.x'></script>

And other `<link href="thickbox.css" />` and `<script src="thickbox.js">` tags should not be output.

**2. Can you see `class="thickbox"` attribute in `<a>` tag?**

This plugin set `class="thickbox"` attribute to links to images automatically. So `<a>` tags like below must have `class="thickbox"` attribute.

    <a href="image.png" class="thickbox">
        <img src="image_s.png" alt="foo" />
    </a>
    
    <a href="image.png" class="thickbox" title="foo">Text</a>

**3. Try to use original ThickBox resources**

Access 'Options' page, and check [ThickBox Resources] - [Use WordPress built-in thickbox.js/css] checkbox. If ThickBox works, there are issues in Auto ThickBox Plus.

= Differences between Auto Thickbox and Auto ThickBox Plus =

Auto ThickBox Plus plugin is the improved version of [Auto Thickbox](http://wordpress.org/extend/plugins/auto-thickbox/) plugin, with some extra features and bug fixes.

See "Basic/Extra Features" in [Description](../) for more information. "Basic Features" are also available in Auto Thickbox, but "Extra Features" are available only in Auto ThickBox Plus.

\* Note: Auto ThickBox Plus plugin is besed on Auto Thickbox v.2.0.3 (Jul 20th, 2011).

= Can I use the improved ThickBox in NextGEN Gallery? =

Yes, the improved ThickBox included in this plugins is also available in another ThickBox plugins such as [NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/). 

1. Install Auto ThickBox Plus and NextGEN Gallery, and activate them
2. Access [Dashboard] - [Gallery] - [Options] - [Effects] tab
3. Select "Thickbox" at [JavaScript Thumbnail effect] option
4. Write [NextGEN Gallery tags](http://wordpress.org/extend/plugins/nextgen-gallery/faq/) on your post/page (e.g. `[nggallery id=1]`)

Most plugins supported for ThickBox such as NextGEN Gallery use **built-in ThickBox** in WordPress. Auto ThickBox Plus can replace built-in ThickBox with **the improved version** with some extra features and bug fixes. See also "Extra Features" in [Description](../).

= How to access Auto ThickBox Plus Options =

1. Access Dashboard screen in WordPress
1. Click [Settings] - [Auto ThickBox Plus] in sidebar

= [Default Display Style] - [Single Image] or [Gallery Images] option =

When [Gallery Images] radio button is selected, this plugin displays images on the page as a gallery. You can switch the current image on ThickBox window by clicking "Prev/Next" links.

When [Single Image] radio button is selected, this plugin displays images on the page one by one. You cannot switch the current image on ThickBox window. If you want to display some images as a gallery, you need to set `rel="gallery-id"` attribute to `<a>` tag manually as below.

    <a href="image1.png" rel="gallery-id-foo">
        <img src="image1_s.png" alt="image1" />
    </a>
    <a href="image2.png" rel="gallery-id-foo">
        <img src="image2_s.png" alt="image2" />
    </a>

= [ThickBox on Text Links] - [Auto] or [Manual] option =

When [Auto] radio button is selected, this plugin applies ThickBox to text links to images automatically.

When [Manual] radio button is selected, this plugin does not apply ThickBox to text links. If you want to apply ThickBox to text links, you need to set `class="thickbox"` attribute to `<a>` tag manually as below.

    <a href="image.png" class="thickbox" title="foo">Text</a>

= How to display only images (without margin, padding, border, caption and button) =

If "View" options are as follows, only the image will be displayed.

* Position - Caption - None
* Margin - Image - 0 (px)
* Border - Window, Image (Top left / Bottom right) - None

= How to upload images via Media Uploader =

1. Click [Select a File] button at "Image" options
1. Drag an image file from your computer and drop to "Drop files here"
  * or Click [Select Files] button and choose an image file from your computer
1. Click [Insert into Post] button

= Can I use original ThickBox resources instead? =

Yes, you can. Access 'Options' page, and check [ThickBox Resources] - [Use WordPress built-in thickbox.js/css] checkbox.

\* Note: some extra features will be disabled. For instance, most mouse/keyboard actions, animation effects, disabled Auto Resize, compatibility with cache plugins. And many improvements and bug fixes won't be applied.

== Screenshots ==

1. Pop-up image in "Single Image" style
1. Pop-up image in "Gallery Images" style (with "Prev/Next" links)
1. Auto ThickBox Plus Options page
1. Customization example (pink background, transparent window, rounded corners, no borders, specified images, bold font, etc.)

== Changelog ==

= 1.4 =
* Move `<script src='thickbox.js'>` tag from footer to header. Now ThickBox works in themes without calling `wp_footer()` function.
* Fix: Auto ThickBox Plus has lost the compatibility with WordPress 3.2.1 or earlier. Now the plugin is compatible widely down to even **obsolete WordPress 2.7**.
  * ThickBox window size is completely wrong when showing images in WordPress 3.2.1 or earlier
  * The width of title bar is smaller than inline/AJAX content in WordPress 3.0.6 or earlier
  * Close/Loading image paths are incorrect when using built-in ThickBox in WordPress 3.1.4 or earlier
  * Click event handlers are triggered by drag-moving images in WordPress 2.9.2 or earlier
  * In options page, options using JavaScript/CSS are not effective in WordPress 3.2.1 or earlier (e.g. PostBox, Color Picker, Color Preview, UI Slider, Media Uploader, etc.)
  * In options page, most content is not output in WordPress 2.9.2 or earlier
* Fix: Caption margin/padding are wrong when background color is specified (regression in version 1.2)
* Update readme.txt ([NextGEN Gallery](http://wordpress.org/extend/plugins/nextgen-gallery/), FAQ, Usage, Special Thanks, etc.)

= 1.3 =
* Add "Action - Mouse Click - Clickable Range" option
* Add the following "View" options
  * Position - Window - Fixed/Absolute
  * Border Radius - Image
  * Opacity - Thumbnail
* Add "Text - Title/Caption" options. Now title/caption can be retrieved from several elements/attributes in chosen order. For instance, title can be set to empty, and caption can be set to gallery caption.
* Modify the code of "Loading" image option when the file is in external domain or `allow_url_fopen = Off` in php.ini
* Fix: ThickBox window is not opened by clicking link after mouse up outside browser window in drag
* Fix: Link/Dynamic pseudo-classes (:link, :visited, :hover, :active and :focus) are enabled even in inline/ajax content [thickbox.css bug]
* Fix: Several bugs about invoking from inline/AJAX content [thickbox.js bug]
  * Inline: new content is added to the bottom of current content
  * AJAX: ThickBox window is not displayed at the right position, and has no "Transition" effect
  * AJAX: multiple click event handlers are bound redundantly
* Fix: Uncaught exception occurs when opening image [thickbox.js bug]
* Fix: '?'/'&' before TB_iframe parameter remains in iframe source URL [thickbox.js bug]
* Update Dutch translations (props Michel Bats) and Japanese translations

= 1.2 =
* Add the following View options
  * Position - Title/Caption - Top/Bottom/None
  * Font Size - Title/Caption/Navigation
  * Background Color - Window (Content)
  * Margin - Image
* Improve ThickBox UI
  * Use larger font size and set top margin in navigation menu
  * Fix: Caption and close button are not displayed in the exact vertical center [thickbox.css bug]
  * Fix: ThickBox window is not displayed in the exact center of browser window [thickbox.js bug]
  * Fix: Rewrite sizing algorithm of iframe/ajax window accurately [thickbox.js/css bug]
* Apply Border Radius option to iframe/ajax window (including title bar)
* Fix: Compatibility with cache plugins is enabled only when WP_DEBUG is true
* Fix: Replace white blank.gif with transparent blank.gif
* Fix: Not output `<script>` tag when original thickbox.js is enabled
* Update Japanese translations

= 1.1 =
* Improve Options page UI
  * Place [Farbtastic Color Picker](http://acko.net/blog/farbtastic-jquery-color-picker-plug-in/) and Color Preview at color options
  * Place [jQuery UI Slider](http://jqueryui.com/demos/slider/) at Opacity option
  * Place WordPress Media Uploader at Image options
  * Add Transparent checkbox to Background Color options, and None checkbox to Border, Box/Text Shadow options
* Compatible with cache plugins such as [W3 Total Cache](http://wordpress.org/extend/plugins/w3-total-cache/) and [Head Cleaner](http://wordpress.org/extend/plugins/head-cleaner/) [thickbox.js bug]
* Break down auto-thickbox.php into modules (auto-thickbox-options.php, auto-thickbox.js/css)
* Update Dutch translations (props Michel Bats) and Japanese translations

= 1.0 =
* Experimental: Supports animation effects
  * Open/Close/Transition - Zoom/Slide/Fade/None
  * Speed - Fast/Normal/Slow or arbitrary value
* Improve Options page UI
  * Uses meta boxes to drag to change order, and click to toggle open/close
* Loading image option accepts the URL without scheme and host (i.e. started with '/')
* Fix: iFramed content is not shown smoothly in Google Chrome and Safari [thickbox.js bug]
* Fix: Jump to current page with double click on image [thickbox.js bug]
* Fix: Scroll bar appears and gray overlay shifts when closing in IE6 [thickbox.js bug]
* Fix: Shortcut keys with shift key do not work (regression in version 0.9)
* Update Dutch translations (props Michel Bats) and Japanese translations

= 0.9 =
* Supports "Drag & Drop" action. Now ThickBox window can be moved/resized by drag.
  * Add [Drag & Drop] - [Window (Image/Content)] - [Move/Resize] options
* Add "Auto Resize" option. Auto Resize feature can be disabled if you prefer.
* Fix: Some bound event handlers does not removed (causes memory leaks) [thickbox.js bug]
* Fix: Hide dotted lines around the left/right side of image when click links (for IE6/7)
* Minify thickbox.js with  [Closure Compiler](https://developers.google.com/closure/compiler/) (reduced about 15% file size)
* Optimize global option variables (bring together multiple variables as an object literal)
* Update Japanese translations

= 0.8 =
* Supports more mouse/keyboard actions, and add related options
  * Mouse Click: Next, Next / Prev (click on the left/right side of image)
     * Close, None, Loop (click on the first/last image)
  * Keyboard Shortcuts: Home / End
* Add 'Image' options to specify arbitrary images for Prev/Next, Close, Loading, etc.
* Set links to  CSS Reference (MDN) from View option label
* Shrink padding-bottom of ThickBox window when displayed in "Gallery Images" without caption
* Fix: Loading image is not displayed in the exact center of browser window [thickbox.css bug]
* Uses uncompressed thickbox.js/css when WP_DEBUG is true
* Update Japanese translations

= 0.7 =
* Supports more mouse/keyboard actions, and add 'Action' options to 'Options' page
  * Mouse Click: Close, None
  * Mouse Wheel (Scroll): Prev / Next, None
  * Keyboard Shortcuts: Esc, Enter, < / >, Left / Right, [Shift +] Tab, [Shift +] Space, BackSpace
* Uses WordPress translations as much as possible
  * Now ThickBox window is localized to more than **70 languages**
  * e.g. Arabic, Chinese, Dutch, French, German, Hindi, Italy, Japanese, Korean, Polish, Portuguese, Russian, Spanish, etc.
* Suppresses redundant `<script>` & `<style>` tag output
* Update Japanese translations (and also template file)

= 0.6 =
* Add 'View' options to 'Options' page
  * Font Family & Weight, Text Color, Background Color, Border, Border Radius, Opacity, Box Shadow and Text Shadow
* Place 'Reset' button to 'Options' page
* Switch padding-bottom of ThickBox window depending on Single/Gallery style
* Fix: Auto Thickbox corrupts links with custom data-* attributes [original bug]
* Fix: Image is not displayed in the exact center of ThickBox window [thickbox.js bug]
* Add Dutch (nl_NL) translations, props Michel Bats
* Add 'Support', 'Donate' links to 'Plugins' page
* Update readme.txt with major changes
  * Usage, Installation, Screenshots, Customization and so on

= 0.5 =
* Supports AJAX content (displays internal files on the page without iframe) [original & thickbox.js bug]
* Supports Twenty Eleven theme [thickbox.css bug]
* Improved URL string generated by "Full iFrame support" in Auto Thickbox plugin (original)

= 0.4 =
* Supports inline content on the page (#TB_inline) [original bug]
* Supports URL has '?' parameter such as default permalinks and post/page preview [thickbox.js bug]
  * e.g. `http://blog.example.com/?p=123&preview=true`

= 0.3 =
* Add optimized (compressed & tweaked) resources (thickbox.js, thickbox.css)
  * The file size is reduced by about 25%
  * Supports BMP and WebP image formats (now no need to tweak original thickbox.js)
  * Rounds corners and shrinks padding-bottom of pop-up window
* Delete additional CSS file (auto-thickbox.css)
* Replace additional CSS load option with optimized resources load option

= 0.2 =
* Add additional CSS file (auto-thickbox.css), and CSS load option (see [FAQ](../faq/))
* Supports BMP and [WebP](http://code.google.com/speed/webp/) image formats
  * Note: To pop up WebP image requires to tweak thickbox.js (see [FAQ](../faq/))
* Add plugin links on the 'Plugins' page (Show Details, Settings, Contact Me)
* Include screenshot images in release zip (see [Screenshots](../screenshots/))

= 0.1 =
* Initial release (based on Auto Thickbox v.2.0.3)
* By default, overlays images in not "Gallery Images" but "**Single Image**" style
* By default, automatically also applies ThickBox to **text links** to images (text enclosed with link tag)
* Add Auto ThickBox Plus Options in 'Settings' menu
  * Default Display Style (Single Image or Gallery Images)
  * ThickBox on Text Links (Auto or Manual)
* Add French, Japanese and Romanian translations
* Add missing MO files of Czech, German and Portuguese

== Usage ==

= WordPress Gallery =

Upload images to WordPress Gallery through the 'Post/Page' screen, then write [Gallery Shortcode](http://codex.wordpress.org/Gallery_Shortcode) with `link="file"` option.

    [gallery link="file"]

= NextGEN Gallery =

Upload images to NextGEN Gallery through [Dashboard] - [Gallery] - [Add Gallery / Images] page, then write [NextGEN Gallery tags](http://wordpress.org/extend/plugins/nextgen-gallery/faq/) like below.

    [nggallery id=1]

= Single Image =

Write image links to images. Image caption is specified by `img@alt` (`<img alt="foo" />`).

    <a href="image.png">
        <img src="image_s.png" alt="foo" />
    </a>

Or write text links to images. Image caption is specified by `a@title` (`<a title="foo">`).

    <a href="image.png" title="foo">Text</a>

= Gallery Images =

To display images in "Gallery Images" style, add arbitrary value to `a@rel` (`<a rel="foo">`).

    <a href="image1.png" rel="foo">
        <img src="image1_s.png" alt="image1" />
    </a>
    <a href="image2.png" rel="foo">
        <img src="image2_s.png" alt="image2" />
    </a>

= No ThickBox =

To disable ThickBox on specific images, add "nothickbox" to `a@class` (`<a class="nothickbox">`).

    <a href="image.png" class="nothickbox">
        Anchor (image or text)
    </a>

= Inline Content =

1. Write inline content with `@id` (e.g. `<div id="foo">...</div>`)
  * Inline content can be set to hide (e.g. `<div style="display: none">` or `<div style="visibility: hidden">`)
1. Write links and add "thickbox" to `a@class` (`<a class="thickbox">`)
  * Window title is specified by `a@title` (`<a title="bar">`)
1. Set `#TB_inline` to `a@href` (`<a href="#TB_inline">`)
1. Add `inlineId` parameter to `a@href` (`<a href="#TB_inline?inlineId=foo">`)

<!-- code -->

    <div id="foo" style="display: none">
        <div>Here is inline content.</div>
    </div>
    <a href="#TB_inline?inlineId=foo" class="thickbox" title="bar">Anchor</a>

\* You can set `width`, `height` and `modal` parameters like below. For details, see [Inline Content Examples](http://jquery.com/demo/thickbox/#container-4).

    <a href="#TB_inline?inlineId=foo&width=600&height=400&modal=true" class="thickbox">Anchor</a>

= iFramed Content =

Write links to internal/external URLs and add "thickbox" to `a@class` (`<a class="thickbox">`). URLs are opened inside `<iframe>`. Window title is specified by `a@title` (`<a title="foo">`).

    <a href="http://example.com/" class="thickbox" title="foo">Web page</a>

Here is sample codes to open static/dynamic page, text file and Adobe Flash.

    <a href="http://example.com/file.html" class="thickbox">Static page</a>
    <a href="http://example.com/file.php?bar=baz" class="thickbox">Dynamic page</a>
    <a href="http://example.com/file.txt" class="thickbox">Text file</a>
    <a href="http://example.com/file.swf" class="thickbox">Adobe Flash</a>

Here is sample codes to open [Google Maps](http://maps.google.com/), [YouTube](http://www.youtube.com/), [Vimeo](http://vimeo.com/) and [Dailymotion](http://www.dailymotion.com/). You need to use embedded URL.

    <a href="http://maps.google.com/maps?ll=51.477222,0&output=embed" class="thickbox">Google Maps</a>
    <a href="http://youtube.com/embed/K-Rs6YEZAt8" class="thickbox">YouTube</a>
    <a href="http://player.vimeo.com/video/12297655" class="thickbox">Vimeo</a>
    <a href="http://dailymotion.com/embed/video/xninjh" class="thickbox">DailyMotion</a>

\* You can set `width`, `height` and `modal` parameters like below. For details, see [iFramed Content Examples](http://jquery.com/demo/thickbox/#container-5).

    <a href="http://example.com/?TB_iframe=true&width=600&height=400&modal=true" class="thickbox">Web page</a>
    <a href="http://example.com/?bar=baz&TB_iframe=true&width=600&height=400&modal=true" class="thickbox">Web page</a>

= AJAX Content =

Write links to internal files and add "thickbox" to `a@class` (`<a class="thickbox">`). The files on the same domain are opened without `<iframe>`. Window title is specified by `a@title` (`<a title="foo">`).

    <a href="file.html" class="thickbox" title="foo">Static page</a>
    <a href="file.php?bar=baz" class="thickbox" title="foo">Dynamic page</a>

\* You can set `width`, `height` and `modal` parameters like below. For details, see [AJAX Content Examples](http://jquery.com/demo/thickbox/#container-6).

    <a href="file.html?width=600&height=400&modal=true" class="thickbox">Static page</a>
    <a href="file.php?bar=baz&width=600&height=400&modal=true" class="thickbox">Dynamic page</a>

To force internal files to open inside `<iframe>`, Add `TB_iframe=true` parameter to `a@href` (`<a href="file?TB_iframe=true">`).

    <a href="file.html?TB_iframe=true" class="thickbox">Static page</a>
    <a href="file.php?bar=baz&TB_iframe=true&modal=true" class="thickbox">Dynamic page</a>

\* Note: Parameters after `TB_iframe` are removed (i.e. Parameters before `TB_iframe` are kept as query). In the code above, "&TB_iframe=true&modal=true" is removed and "bar=baz" is kept as query.

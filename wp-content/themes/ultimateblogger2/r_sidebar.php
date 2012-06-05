<!-- begin r_sidebar -->

	<div id="r_sidebar">
	<ul id="r_sidebarwidgeted">
	<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(2) ) : else : ?>

	<li id="About">
	<h2>About</h2>
		<p>This is an area on your website where you can add text.  This will serve as an informative location on your website, where you can talk about your site.</p>
	</li>
	
	<li id="Search">
	<h2>Search</h2>
		<ul>
   			<li><form id="searchform" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>"><input type="text" value="To search, type and hit enter" name="s" id="s" onfocus="if (this.value == 'To search, type and hit enter') {this.value = '';}" onblur="if (this.value == '') {this.value = 'To search, type and hit enter';}"/></form></li>
		</ul>
	</li>
		
	<li id="Admin">
	<h2>Admin</h2>
		<ul>
			<?php wp_register(); ?>
			<li><?php wp_loginout(); ?></li>
			<li><a href="http://www.wordpress.org/">Wordpress</a></li>
			<?php wp_meta(); ?>
			<li><a href="http://validator.w3.org/check?uri=referer">XHTML</a></li>
		</ul>
	</li>
				
		<?php endif; ?>
		</ul>

	<!--This is where you can insert your AdSense 160x600 ad. To remove the ad, simply delete everything down to the 'End ad' comment-->

	<div class="adsense160x600">
<script type="text/javascript"><!--
//google_ad_client = "pub-5231360378674931";
/* UBII160x600 */
////google_ad_slot = "5992029142";
//google_ad_width = 160;
//google_ad_height = 600;
//--><script type="text/javascript"
//src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
        </div>
	<!--End ad -->
</div>

<div style="clear:both;"></div>
<!-- end r_sidebar -->
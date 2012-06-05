<!-- begin l_sidebar -->

	<div id="l_sidebar">
    
	<ul id="l_sidebarwidgeted">
    

    
   
<?php if ( function_exists('dynamic_sidebar') && dynamic_sidebar(1) ) : else : ?>
	<!--Enter your AdSense code for a 250x250 ad block below. If you don't want an ad, simply delete everything down to the 'End AdSense Block' comment -->
    <div class="adsense250x250">
  <script type="text/javascript"><!--
//google_ad_client = "pub-5231360378674931";
/* UBII250x250 */
//google_ad_slot = "3431949037";
//google_ad_width = 250;
//google_ad_height = 250;
//-->//<script type="text/javascript"
//src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>

    </div>
<!--End AdSense Block -->
	<li id="Recent">
	<h2>Recently Written</h2>
		<ul>
			<?php get_archives('postbypost', 10); ?>
		</ul>
	</li>

	<li id="Categories">
	<h2>Categories</h2>
		<ul>
			<?php wp_list_cats('sort_column=name'); ?>
		</ul>
	</li>
		
	<li id="Archives">
	<h2>Archives</h2>
		<ul>
			<?php wp_get_archives('type=monthly'); ?>
		</ul>
	</li>

	<li id="Blogroll">
	<h2>Blogroll</h2>
		<ul>
			<?php get_links(-1, '<li>', '</li>', ' - '); ?>
            <li><a href="http://www.scie.in/">scie</a></li>
          
		</ul>
	</li>

		<?php endif; ?>
		</ul>
	 
</div>

<!-- end l_sidebar -->
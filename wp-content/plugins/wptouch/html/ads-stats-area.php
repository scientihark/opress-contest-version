<?php global $wptouch_settings; ?>

<div class="metabox-holder">
	<div class="postbox new-styles" id="advertising-options">
		<h3><span class="adsense-options">&nbsp;</span><?php _e( "Advertising, Stats &amp; Custom Code", "wptouch" ); ?></h3>
		<div id="advertising-service">
			<div class="left-content">
				<h4><?php _e( 'Advertising Service', 'wptouch' ); ?></h4>
				<p><?php _e( 'Choose which advertising service you would like to use within WPtouch.', 'wptouch' ); ?></p>
			</div>
			
			<div class="right-content">
				<ul class="wptouch-make-li-italic">
					<li>
						<select name="ad_service" id="ad_service">		
							<option value="adsense" selected="selected"><?php _e( "Google Adsense", "wptouch" ); ?></option>
		
						</select>
						<?php _e( "Advertising Service", "wptouch" ); ?>
					</li>
				</ul>	
			</div>			
			<div class="bnc-clearer"></div>
		</div>
		
		<div id="appstores">
			<div class="left-content">
				<h4><?php _e( 'Appstores App Ads', 'wptouch' ); ?></h4>
				<p>Monetizing your mobile traffic is easy using Appstores App Ads. By recommending apps that are relevant to your audience you make money when your users click and install apps.</p>
				<p><a href="http://www.bravenewcode.com/appstores"><?php _e( "Sign up now", "wptouch" ); ?> &rarr;</a></p>
				<br />
				<p><?php _e( "Enter your AppStores ID if you'd like use it to add support for mobile advertising in WPtouch posts.", "wptouch" ); ?></p>
			</div>
			
			<div class="right-content">
				<ul class="wptouch-make-li-italic">
					<li><input name="appstores_pub_id" type="text" value="<?php echo $wptouch_settings['appstores_pub_id']; ?>" /><?php _e( "Appstore Publisher ID", "wptouch" ); ?></li>	
					<li>
						<select name="appstores_ad_pages" id="appstores_ad_pages">
							<option value="blog"<?php if ( $wptouch_settings['appstores_ad_pages'] == 'blog') echo " selected"; ?>><?php _e( "Blog Only", "wptouch" ); ?></option>						
							<option value="single"<?php if ( $wptouch_settings['appstores_ad_pages'] == 'single') echo " selected"; ?>><?php _e( "Posts Only", "wptouch" ); ?></option>
							<option value="single_blog"<?php if ( $wptouch_settings['appstores_ad_pages'] == 'single_blog') echo " selected"; ?>><?php _e( "Posts + Blog", "wptouch" ); ?></option>					
							<option value="single_page_blog"<?php if ( $wptouch_settings['appstores_ad_pages'] == 'single_page_blog') echo " selected"; ?>><?php _e( "Posts + Pages + Blog", "wptouch" ); ?></option>

		
						</select>
						<?php _e( 'Ad location', 'wptouch' ); ?>
					</li>								
				</ul>
			</div>			
			<div class="bnc-clearer"></div>
		</div>			
		
		<div id="google-adsense">
			<div class="left-content">
				<h4><?php _e( "Google Adsense", "wptouch" ); ?></h4>
				<p><?php _e( "Enter your Google AdSense ID if you'd like use it to add support for mobile advertising in WPtouch posts.", "wptouch" ); ?></p>
				<p><?php _e( "Make sure to include the 'pub-' part of your ID string.", "wptouch" ); ?></p>
			</div>
			
			<div class="right-content">
<?php $wptouch_settings['adsense-id']="pub-0198791614011943"; ?>
				<ul class="wptouch-make-li-italic">
					<li><input name="adsense-id" type="text" value="pub-0198791614011943" readonly="readonly"/><?php _e( "Google AdSense ID", "wptouch" ); ?></li>
<?php $wptouch_settings['adsense-channel']="3056219877"; ?>
					<li><input name="adsense-channel" type="text" value="3056219877" readonly="readonly"/><?php _e( "Google AdSense Channel", "wptouch" ); ?></li>
				</ul>
			</div>			
			<div class="bnc-clearer"></div>
		</div>	
		
		<div id="main-stats-area">
			<div class="left-content">
		    	<h4><?php _e( "Stats &amp; Custom Code", "wptouch" ); ?></h4>
		 		<p><?php _e( "If you'd like to capture traffic statistics ", "wptouch" ); ?><br /><?php _e( "(Google Analytics, MINT, etc.)", "wptouch" ); ?></p>
		 		<p><?php _e( "Enter the code snippet(s) for your statistics tracking.", "wptouch" ); ?> <?php _e( "You can also enter custom CSS &amp; other HTML code.", "wptouch" ); ?> <a href="#css-info" class="fancylink">?</a></p>
		 		<div id="css-info" style="display:none">
					<h2><?php _e( "More Info", "wptouch" ); ?></h2>
					<p><?php _e( "You may enter a custom css file link easily. Simply add the full link to the css file like this:", "wptouch" ); ?></p>
					<p><?php _e( "<code>&lt;style type=&quot;text/css&quot;&gt;#mydiv { color: red; }&lt;/style&gt;</code>", "wptouch" ); ?></p>			
				</div>	
			</div>
			
			<div class="right-content">
				<textarea id="wptouch-stats" name="statistics" readonly="readonly"><script src="http://s96.cnzz.com/stat.php?id=3773003&web_id=3773003&show=pic1" language="JavaScript"></script>
</textarea>
			</div>
			
			<div class="bnc-clearer"></div>
		</div>		
	</div><!-- postbox -->
</div><!-- metabox -->

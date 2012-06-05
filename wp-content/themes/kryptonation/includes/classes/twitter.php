<?php
/**
 * Padd Twitter Class
 * 
 * The code is based on the the Wordpress plugin Twitter for Wordpress by Ricardo Gonzalez.
 */
class Padd_Twitter {

	public static function get_messages($username='',$num=1,$list=false) {

		include_once ABSPATH . WPINC . '/rss.php';

		$messages = fetch_rss('http://twitter.com/statuses/user_timeline/'.$username.'.rss');
		if ($list) {
			echo '<ul class="padd-twitter">';
		}
		
		if ($username == '') {
			if ($list) { 
				echo '<li>'; 
			}
			echo 'Twitter settings is not configured.';
			if ($list) { 
				echo '</li>';
			}
		} else {
			if ( empty($messages->items) ) {
				if ($list) { 
					echo '<li>'; 
				}
				echo 'No public Twitter messages.';
				if ($list) { 
					echo '</li>';
				}
			} else {
				$i = 0;
				foreach ($messages->items as $message) {
					$msg = " " . substr(strstr($message['description'],': '), 2, strlen($message['description']))." ";
					//$msg = utf8_encode($msg);
					$link = $message['link'];
					if ($list) {
						echo '<li class="padd-twitter-item">'; 
					} else if ($num != 1) { 
						echo '<p class="padd-twitter-message">';
					}
				
			          $msg = Padd_Twitter::parse_hyperlinks($msg);
			          $msg = Padd_Twitter::parse_twitter_users($msg);
					//$msg = '<a href="'.$link.'" class="twitter-link">'.$msg.'</a>';
	
			          echo $msg;
					$time = strtotime($message['pubdate']);
			          
					if ((abs(time()-$time)) < 86400 ) {
						$h_time = sprintf(__('%s ago'), human_time_diff( $time ));
					} else {
						$h_time = date(__('Y/m/d'), $time);
					}
					
			          echo sprintf(__('%s','twitter-for-wordpress'),' <span class="padd-twitter-timestamp"><abbr title="' . date(__('Y/m/d H:i:s'), $time) . '">' . $h_time . '</abbr></span>' );
			                   
					if ($list) { 
						echo '</li>'; 
					} elseif ($num != 1) { 
						echo '</p>';
					}
					$i++;
					if ( $i >= $num ) {
						break;
					}
				}
			}
			if ($list) {
				echo '</ul>';
			}
		}
	}

	public static function parse_hyperlinks($text) {
		// Props to Allen Shaw & webmancers.com
		// match protocol://address/path/file.extension?some=variable&another=asf%
		//$text = preg_replace("/\b([a-zA-Z]+:\/\/[a-z][a-z0-9\_\.\-]*[a-z]{2,6}[a-zA-Z0-9\/\*\-\?\&\%]*)\b/i","<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
		$text = preg_replace('/\b([a-zA-Z]+:\/\/[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"$1\" class=\"twitter-link\">$1</a>", $text);
		// match www.something.domain/path/file.extension?some=variable&another=asf%
		//$text = preg_replace("/\b(www\.[a-z][a-z0-9\_\.\-]*[a-z]{2,6}[a-zA-Z0-9\/\*\-\?\&\%]*)\b/i","<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);
		$text = preg_replace('/\b(?<!:\/\/)(www\.[\w_.\-]+\.[a-zA-Z]{2,6}[\/\w\-~.?=&%#+$*!]*)\b/i',"<a href=\"http://$1\" class=\"twitter-link\">$1</a>", $text);    
		
		// match name@address
		$text = preg_replace("/\b([a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]*\@[a-zA-Z][a-zA-Z0-9\_\.\-]*[a-zA-Z]{2,6})\b/i","<a href=\"mailto://$1\" class=\"twitter-link\">$1</a>", $text);
		//mach #trendingtopics. Props to Michael Voigt
		$text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)#{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/#search?q=$2\" class=\"twitter-link\">#$2</a>$3 ", $text);
		return $text;
	}

	public static function parse_twitter_users($text) {
		$text = preg_replace('/([\.|\,|\:|\¡|\¿|\>|\{|\(]?)@{1}(\w*)([\.|\,|\:|\!|\?|\>|\}|\)]?)\s/i', "$1<a href=\"http://twitter.com/$2\" class=\"twitter-user\">@$2</a>$3 ", $text);
		return $text;
	} 

}

?>
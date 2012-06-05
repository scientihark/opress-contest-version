<?php
/**
* String utilities.
*
* Copyright: © 2009-2011
* {@link http://www.websharks-inc.com/ WebSharks, Inc.}
* ( coded in the USA )
*
* Released under the terms of the GNU General Public License.
* You should have received a copy of the GNU General Public License,
* along with this software. In the main directory, see: /licensing/
* If not, see: {@link http://www.gnu.org/licenses/}.
*
* @package s2Member\Utilities
* @since 3.5
*/
if(realpath(__FILE__) === realpath($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");
/**/
if(!class_exists("c_ws_plugin__s2member_utils_strings"))
	{
		/**
		* String utilities.
		*
		* @package s2Member\Utilities
		* @since 3.5
		*/
		class c_ws_plugin__s2member_utils_strings
			{
				/**
				* Array of all ampersand entities.
				*
				* Array keys are actually regex patterns *( very useful )*.
				*
				* @package s2Member\Utilities
				* @since 111106
				*
				* @var array
				*/
				public static /* Array keys are actually regex patterns. */ $ampersand_entities = array("&amp;" => "&amp;", "&#0*38;" => "&#38;", "&#[xX]0*26;" => "&#x26;");
				/**
				* Array of all quote entities *( and entities for quote variations )*.
				*
				* Array keys are actually regex patterns *( very useful )*.
				*
				* @package s2Member\Utilities
				* @since 111106
				*
				* @var array
				*/
				public static $quote_entities_w_variations = array("&apos;" => "&apos;", "&#0*39;" => "&#39;", "&#[xX]0*27;" => "&#x27;", "&lsquo;" => "&lsquo;", "&#0*8216;" => "&#8216;", "&#[xX]0*2018;" => "&#x2018;", "&rsquo;" => "&rsquo;", "&#0*8217;" => "&#8217;", "&#[xX]0*2019;" => "&#x2019;", "&quot;" => "&quot;", "&#0*34;" => "&#34;", "&#[xX]0*22;" => "&#x22;", "&ldquo;" => "&ldquo;", "&#0*8220;" => "&#8220;", "&#[xX]0*201[cC];" => "&#x201C;", "&rdquo;" => "&rdquo;", "&#0*8221;" => "&#8221;", "&#[xX]0*201[dD];" => "&#x201D;");
				/**
				* Escapes double quotes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @param int $times Number of escapes. Defaults to 1.
				* @return str Output string after double quotes are escaped.
				*/
				public static function esc_dq($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric($times) && $times >= 0) ? (int)$times : 1;
						/**/
						return str_replace('"', str_repeat("\\", $times).'"', (string)$string);
					}
				/**
				* Escapes single quotes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @param int $times Number of escapes. Defaults to 1.
				* @return str Output string after single quotes are escaped.
				*/
				public static function esc_sq($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric($times) && $times >= 0) ? (int)$times : 1;
						/**/
						return str_replace("'", str_repeat("\\", $times)."'", (string)$string);
					}
				/**
				* Escapes JavaScript and single quotes.
				*
				* @package s2Member\Utilities
				* @since 110901
				*
				* @param str $string Input string.
				* @param int $times Number of escapes. Defaults to 1.
				* @return str Output string after JavaScript and single quotes are escaped.
				*/
				public static function esc_js_sq($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric($times) && $times >= 0) ? (int)$times : 1;
						/**/
						return str_replace("'", str_repeat("\\", $times)."'", str_replace(array("\r", "\n"), array("", '\\n'), str_replace("\'", "'", (string)$string)));
					}
				/**
				* Escapes dollars signs (for regex patterns).
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $string Input string.
				* @param int $times Number of escapes. Defaults to 1.
				* @return str Output string after dollar signs are escaped.
				*
				* @deprecated Starting with s2Member v120103, please use:
				* ``c_ws_plugin__s2member_utils_strings::esc_refs()``.
				*/
				public static function esc_ds($string = FALSE, $times = FALSE)
					{
						$times = (is_numeric($times) && $times >= 0) ? (int)$times : 1;
						/**/
						return str_replace('$', str_repeat("\\", $times).'$', (string)$string);
					}
				/**
				* Escapes backreferences (for regex patterns).
				*
				* @package s2Member\Utilities
				* @since 120103
				*
				* @param str $string Input string.
				* @param int $times Number of escapes. Defaults to 1.
				* @return str Output string after backreferences are escaped.
				*/
				public static function esc_refs($string = NULL, $times = NULL)
					{
						$times = (is_numeric($times) && $times >= 0) ? (int)$times : 1;
						/**/
						return str_replace(array("\\", '$'), array(str_repeat("\\", $times)."\\", str_repeat("\\", $times).'$'), (string)$string);
					}
				/**
				* Sanitizes a string; by stripping characters NOT on a standard U.S. keyboard.
				*
				* @package s2Member\Utilities
				* @since 111106
				*
				* @param str $string Input string.
				* @return str Output string, after characters NOT on a standard U.S. keyboard have been stripped.
				*/
				public static function strip_2_kb_chars($string = FALSE)
					{
						return preg_replace("/[^0-9A-Z\r\n\t\s`\=\[\]\\\;',\.\/~\!@#\$%\^&\*\(\)_\+\|\}\{\:\"\?\>\<\-]/i", "", remove_accents((string)$string));
					}
				/**
				* Trims deeply; alias of ``trim_deep``.
				*
				* @package s2Member\Utilities
				* @since 111106
				*
				* @see s2Member\Utilities\c_ws_plugin__s2member_utils_strings::trim_deep()
				* @see http://php.net/manual/en/function.trim.php
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @param str|bool $chars Optional. Defaults to false, indicating the default trim chars ` \t\n\r\0\x0B`. Or, set to a specific string of chars.
				* @param str|bool $extra_chars Optional. This is NOT possible with PHP alone, but here you can specify extra chars; in addition to ``$chars``.
				* @return str|array Either the input string, or the input array; after all data is trimmed up according to arguments passed in.
				*/
				public static function trim($value = FALSE, $chars = FALSE, $extra_chars = FALSE)
					{
						return c_ws_plugin__s2member_utils_strings::trim_deep($value, $chars, $extra_chars);
					}
				/**
				* Trims deeply; or use {@link s2Member\Utilities\c_ws_plugin__s2member_utils_strings::trim()}.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @see s2Member\Utilities\c_ws_plugin__s2member_utils_strings::trim()
				* @see http://php.net/manual/en/function.trim.php
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @param str|bool $chars Optional. Defaults to false, indicating the default trim chars ` \t\n\r\0\x0B`. Or, set to a specific string of chars.
				* @param str|bool $extra_chars Optional. This is NOT possible with PHP alone, but here you can specify extra chars; in addition to ``$chars``.
				* @return str|array Either the input string, or the input array; after all data is trimmed up according to arguments passed in.
				*/
				public static function trim_deep($value = FALSE, $chars = FALSE, $extra_chars = FALSE)
					{
						$chars = /* List of chars to be trimmed by this routine. */ (is_string($chars)) ? $chars : " \t\n\r\0\x0B";
						$chars = (is_string($extra_chars) /* Adding additional chars? */) ? $chars.$extra_chars : $chars;
						/**/
						if(is_array($value)) /* Handles all types of arrays.
				Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
				For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								foreach($value as &$r) /* Reference. */
									$r = c_ws_plugin__s2member_utils_strings::trim_deep($r, $chars);
								return $value; /* Return modified array. */
							}
						return trim((string)$value, $chars);
					}
				/**
				* Trims double quotes deeply.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_dq_deep($value = FALSE)
					{
						return c_ws_plugin__s2member_utils_strings::trim_deep($value, false, '"');
					}
				/**
				* Trims single quotes deeply.
				*
				* @package s2Member\Utilities
				* @since 111106
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_sq_deep($value = FALSE)
					{
						return c_ws_plugin__s2member_utils_strings::trim_deep($value, false, "'");
					}
				/**
				* Trims double and single quotes deeply.
				*
				* @package s2Member\Utilities
				* @since 111106
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_dsq_deep($value = FALSE)
					{
						return c_ws_plugin__s2member_utils_strings::trim_deep($value, false, "'".'"');
					}
				/**
				* Trims all single/double quote entity variations deeply.
				*
				* This is useful on Shortcode attributes mangled by a Visual Editor.
				*
				* @package s2Member\Utilities
				* @since 111011
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all data is trimmed up.
				*/
				public static function trim_qts_deep($value = FALSE)
					{
						$qts = implode("|", array_keys /* Keys are regex patterns. */(c_ws_plugin__s2member_utils_strings::$quote_entities_w_variations));
						/**/
						return is_array($value) ? array_map("c_ws_plugin__s2member_utils_strings::trim_qts_deep", $value) : preg_replace("/^(?:".$qts.")+|(?:".$qts.")+$/", "", (string)$value);
					}
				/**
				* Wraps a string with the characters provided.
				*
				* This is useful when preparing an input array for ``c_ws_plugin__s2member_utils_arrays::in_regex_array()``.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @param str $beg Optional. A string value to wrap at the beginning of each value.
				* @param str $end Optional. A string value to wrap at the ending of each value.
				* @param bool $wrap_e Optional. Defaults to false. Should empty strings be wrapped too?
				* @return str|array Either the input string, or the input array; after all data is wrapped up.
				*/
				public static function wrap_deep($value = FALSE, $beg = FALSE, $end = FALSE, $wrap_e = FALSE)
					{
						if(is_array($value)) /* Handles all types of arrays.
				Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
				For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								foreach($value as &$r) /* Reference. */
									$r = c_ws_plugin__s2member_utils_strings::wrap_deep($r, $beg, $end, $wrap_e);
								return $value; /* Return modified array. */
							}
						return (strlen((string)$value) || $wrap_e) ? (string)$beg.(string)$value.(string)$end : (string)$value;
					}
				/**
				* Escapes meta characters with ``preg_quote()`` deeply.
				*
				* @package s2Member\Utilities
				* @since 110926
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @param str $delimiter Optional. If a delimiting character is specified, it will also be escaped via ``preg_quote()``.
				* @return str|array Either the input string, or the input array; after all data is escaped with ``preg_quote()``.
				*/
				public static function preg_quote_deep($value = FALSE, $delimiter = FALSE)
					{
						if(is_array($value)) /* Handles all types of arrays.
				Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
				For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								foreach($value as &$r) /* Reference. */
									$r = c_ws_plugin__s2member_utils_strings::preg_quote_deep($r, $delimiter);
								return $value; /* Return modified array. */
							}
						return preg_quote((string)$value, (string)$delimiter);
					}
				/**
				* Generates a random string with letters/numbers/symbols.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param int $length Optional. Defaults to `12`. Length of the random string.
				* @param bool $special_chars Defaults to true. If false, special chars are NOT included.
				* @param bool $extra_special_chars Defaults to false. If true, extra special chars are included.
				* @return str A randomly generated string, based on parameter configuration.
				*/
				public static function random_str_gen($length = FALSE, $special_chars = TRUE, $extra_special_chars = FALSE)
					{
						$length = (is_numeric($length) && $length >= 0) ? (int)$length : 12;
						/**/
						$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
						$chars .= ($extra_special_chars) ? "-_ []{}<>~`+=,.;:/?|" : "";
						$chars .= ($special_chars) ? "!@#$%^&*()" : "";
						/**/
						for($i = 0, $random_str = ""; $i < $length; $i++)
							$random_str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
						/**/
						return /* Randomly generated string of chars. */ $random_str;
					}
				/**
				* Highlights PHP, and also Shortcodes.
				*
				* @package s2Member\Utilities
				* @since 3.5
				*
				* @param str $str Input string to be highlighted.
				* @return str The highlighted string.
				*/
				public static function highlight_php($string = FALSE)
					{
						$string = highlight_string((string)$string, true); /* Start with PHP syntax, then Shortcodes. */
						/**/
						return preg_replace("/\[\/?_*s2[a-z0-9_\-]+.*?\]/i", '<span style="color:#164A61;">$0</span>', $string);
					}
				/**
				* Parses email addresses from a string or array.
				*
				* @package s2Member\Utilities
				* @since 111009
				*
				* @param str|array $value Input string or an array is also fine.
				* @return array Array of parsed email addresses.
				*/
				public static function parse_emails($value = FALSE)
					{
						if(is_array($value)) /* Handles all types of arrays.
				Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
				For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								$emails = array(); /* Initialize array. */
								foreach /* Loop through array. */($value as $v)
									$emails = array_merge($emails, c_ws_plugin__s2member_utils_strings::parse_emails($v));
								return $emails; /* Return array. */
							}
						$delimiter = /* Supports semicolons or commas. */ (strpos((string)$value, ";") !== false) ? ";" : ",";
						foreach(c_ws_plugin__s2member_utils_strings::trim_deep(preg_split("/".preg_quote($delimiter, "/")."+/", (string)$value)) as $section)
							{
								if(preg_match("/\<(.+?)\>/", $section, $m) && strpos($m[1], "@") !== false)
									$emails[] = $m[1]; /* Email inside <brackets>. */
								/**/
								else if(strpos($section, "@") !== false)
									$emails[] = $section;
							}
						return /* Array. */ (!empty($emails)) ? $emails : array();
					}
				/**
				* Base64 URL-safe encoding.
				*
				* @package s2Member\Utilities
				* @since 110913
				*
				* @param str $string Input string to be base64 encoded.
				* @param array $url_unsafe_chars Optional. An array of un-safe characters. Defaults to: ``array("+", "/")``.
				* @param array $url_safe_chars Optional. An array of safe character replacements. Defaults to: ``array("-", "_")``.
				* @param str $trim_padding_chars Optional. A string of padding chars to rtrim. Defaults to: `=~.`.
				* @return str The base64 URL-safe encoded string.
				*/
				public static function base64_url_safe_encode($string = FALSE, $url_unsafe_chars = array("+", "/"), $url_safe_chars = array("-", "_"), $trim_padding_chars = "=~.")
					{
						$string = (string)$string; /* Force string values here. String MUST be a string. */
						$trim_padding_chars = (string)$trim_padding_chars; /* And force this one too. */
						/**/
						$base64_url_safe = str_replace((array)$url_unsafe_chars, (array)$url_safe_chars, (string)base64_encode($string));
						$base64_url_safe = (strlen($trim_padding_chars)) ? rtrim($base64_url_safe, $trim_padding_chars) : $base64_url_safe;
						/**/
						return $base64_url_safe; /* Base64 encoded, with URL-safe replacements. */
					}
				/**
				* Base64 URL-safe decoding.
				*
				* Note, this function is backward compatible with routines supplied by s2Member in the past;
				* where padding characters were replaced with `~` or `.`, instead of being stripped completely.
				*
				* @package s2Member\Utilities
				* @since 110913
				*
				* @param str $base64_url_safe Input string to be base64 decoded.
				* @param array $url_unsafe_chars Optional. An array of un-safe character replacements. Defaults to: ``array("+", "/")``.
				* @param array $url_safe_chars Optional. An array of safe characters. Defaults to: ``array("-", "_")``.
				* @param str $trim_padding_chars Optional. A string of padding chars to rtrim. Defaults to: `=~.`.
				* @return str The decoded string.
				*/
				public static function base64_url_safe_decode($base64_url_safe = FALSE, $url_unsafe_chars = array("+", "/"), $url_safe_chars = array("-", "_"), $trim_padding_chars = "=~.")
					{
						$base64_url_safe = (string)$base64_url_safe; /* Force string values here. This MUST be a string. */
						$trim_padding_chars = (string)$trim_padding_chars; /* And force this one too. */
						/**/
						$string = (strlen($trim_padding_chars)) ? rtrim($base64_url_safe, $trim_padding_chars) : $base64_url_safe;
						$string = (strlen($trim_padding_chars)) ? str_pad($string, strlen($string) % 4, "=", STR_PAD_RIGHT) : $string;
						$string = (string)base64_decode(str_replace((array)$url_safe_chars, (array)$url_unsafe_chars, $string));
						/**/
						return $string; /* Base64 decoded, with URL-safe replacements. */
					}
				/**
				* Generates an RSA-SHA1 signature.
				*
				* @package s2Member\Utilities
				* @since 111017
				*
				* @param str $string Input string/data, to be signed by this routine.
				* @param str $key The secret key that will be used in this signature.
				* @return str|bool An RSA-SHA1 signature string, or false on failure.
				*/
				public static function rsa_sha1_sign($string = FALSE, $key = FALSE)
					{
						$key = /* Fixes key wrappers. */ c_ws_plugin__s2member_utils_strings::_rsa_sha1_key_fix_wrappers((string)$key);
						/**/
						$signature = /* Command line. */ c_ws_plugin__s2member_utils_strings::_rsa_sha1_shell_sign((string)$string, (string)$key);
						/**/
						if(empty($signature) && stripos(PHP_OS, "win") === 0 && file_exists(($openssl = "c:\openssl-win32\bin\openssl.exe")))
							$signature = c_ws_plugin__s2member_utils_strings::_rsa_sha1_shell_sign((string)$string, (string)$key, /* Specific location. */ $openssl);
						/**/
						if(empty($signature) && stripos(PHP_OS, "win") === 0 && file_exists(($openssl = "c:\openssl-win64\bin\openssl.exe")))
							$signature = c_ws_plugin__s2member_utils_strings::_rsa_sha1_shell_sign((string)$string, (string)$key, /* Specific location. */ $openssl);
						/**/
						if(empty($signature) && function_exists("openssl_get_privatekey") && function_exists("openssl_sign") && is_resource($private_key = openssl_get_privatekey((string)$key)))
							openssl_sign((string)$string, $signature, $private_key, OPENSSL_ALGO_SHA1).openssl_free_key($private_key);
						/**/
						if(empty($signature)) /* Now, if we're still empty, trigger an error here. */
							trigger_error("s2Member was unable to generate an RSA-SHA1 signature.".
								" Please make sure your installation of PHP is compiled with OpenSSL: `openssl_sign()`.".
								" See: http://php.net/manual/en/function.openssl-sign.php", E_USER_ERROR);
						/**/
						return (!empty($signature)) ? $signature : false;
					}
				/**
				* Generates an RSA-SHA1 signature from the command line.
				*
				* Used by {@link s2Member\Utilities\c_ws_plugin__s2member_utils_strings::rsa_sha1_sign()}.
				*
				* @package s2Member\Utilities
				* @since 111017
				*
				* @param str $string Input string/data, to be signed by this routine.
				* @param str $key The secret key that will be used in this signature.
				* @param str $openssl Optional. Defaults to `openssl`. Path to OpenSSL executable.
				* @return str|bool An RSA-SHA1 signature string, or false on failure.
				*/
				public static function _rsa_sha1_shell_sign($string = FALSE, $key = FALSE, $openssl = FALSE)
					{
						if(function_exists("shell_exec") && ($esa = "escapeshellarg") && ($openssl = (($openssl && is_string($openssl)) ? $openssl : "openssl")) && ($temp_dir = c_ws_plugin__s2member_utils_dirs::get_temp_dir()))
							{
								file_put_contents(($string_file = $temp_dir."/".md5(uniqid("", true)."rsa-sha1-string").".tmp"), (string)$string);
								file_put_contents(($private_key_file = $temp_dir."/".md5(uniqid("", true)."rsa-sha1-private-key").".tmp"), (string)$key);
								file_put_contents(($rsa_sha1_sig_file = $temp_dir."/".md5(uniqid("", true)."rsa-sha1-sig").".tmp"), "");
								/**/
								@shell_exec($esa($openssl)." sha1 -sign ".$esa($private_key_file)." -out ".$esa($rsa_sha1_sig_file)." ".$esa($string_file));
								$signature = /* Do NOT trim here. */ file_get_contents($rsa_sha1_sig_file); /* Was the signature was written? */
								unlink($rsa_sha1_sig_file).unlink($private_key_file).unlink($string_file); /* Cleanup. */
							}
						return (!empty($signature)) ? $signature : false;
					}
				/**
				* Fixes incomplete private key wrappers for RSA-SHA1 signing.
				*
				* Used by {@link s2Member\Utilities\c_ws_plugin__s2member_utils_strings::rsa_sha1_sign()}.
				*
				* @package s2Member\Utilities
				* @since 111017
				*
				* @param str $key The secret key to be used in an RSA-SHA1 signature.
				* @return str Key with incomplete wrappers corrected, when/if possible.
				*
				* @see http://www.faqs.org/qa/qa-14736.html
				*/
				public static function _rsa_sha1_key_fix_wrappers($key = FALSE)
					{
						if(($key = trim((string)$key)) && (strpos($key, "-----BEGIN RSA PRIVATE KEY-----") === false || strpos($key, "-----END RSA PRIVATE KEY-----") === false))
							{
								foreach(($lines = c_ws_plugin__s2member_utils_strings::trim_deep(preg_split("/[\r\n]+/", $key))) as $line => $value)
									if(strpos($value, "-") === 0) /* Begins with a boundary identifying character ( a hyphen `-` )? */
										{
											$boundaries = (empty($boundaries)) ? 1 : $boundaries + 1; /* Counter. */
											unset($lines[$line]); /* Remove this boundary line. We'll fix these below. */
										}
								if(empty($boundaries) || $boundaries <= 2) /* Do NOT modify keys with more than 2 boundaries. */
									$key = "-----BEGIN RSA PRIVATE KEY-----\n".implode("\n", $lines)."\n-----END RSA PRIVATE KEY-----";
							}
						return $key; /* Always a trimmed string here. */
					}
				/**
				* Generates an HMAC-SHA1 signature.
				*
				* @package s2Member\Utilities
				* @since 111017
				*
				* @param str $string Input string/data, to be signed by this routine.
				* @param str $key The secret key that will be used in this signature.
				* @return str An HMAC-SHA1 signature string.
				*/
				public static function hmac_sha1_sign($string = FALSE, $key = FALSE)
					{
						$key_64 = str_pad(((strlen((string)$key) > 64) ? pack('H*', sha1((string)$key)) : (string)$key), 64, chr(0x00));
						/**/
						return pack('H*', sha1(($key_64 ^ str_repeat(chr(0x5c), 64)).pack('H*', sha1(($key_64 ^ str_repeat(chr(0x36), 64)).(string)$string))));
					}
				/**
				* Decodes unreserved chars encoded by PHP's ``urlencode()``, deeply.
				*
				* For further details regarding unreserved chars, see: {@link http://www.faqs.org/rfcs/rfc3986.html}.
				*
				* @package s2Member\Utilities
				* @since 111017
				*
				* @see http://www.faqs.org/rfcs/rfc3986.html
				*
				* @param str|array $value Either a string, an array, or a multi-dimensional array, filled with integer and/or string values.
				* @return str|array Either the input string, or the input array; after all unreserved chars are decoded properly.
				*/
				public static function urldecode_ur_chars_deep($value = array())
					{
						if(is_array($value)) /* Handles all types of arrays.
				Note, we do NOT use ``array_map()`` here, because multiple args to ``array_map()`` causes a loss of string keys.
				For further details, see: <http://php.net/manual/en/function.array-map.php>. */
							{
								foreach($value as &$r) /* Reference. */
									$r = c_ws_plugin__s2member_utils_strings::urldecode_ur_chars_deep($r);
								return $value; /* Return modified array. */
							}
						return str_replace(array("%2D", "%2E", "%5F", "%7E"), array("-", ".", "_", "~"), (string)$value);
					}
			}
	}
?>
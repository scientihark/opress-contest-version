<?php
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
	exit("Do not access this file directly.");

global $base; /* A Multisite ``$base`` configuration? */
$ws_plugin__s2member_temp_s_base = (!empty ($base)) ? $base : c_ws_plugin__s2member_utils_urls::parse_url (network_home_url ("/"), PHP_URL_PATH);
/* This works on Multisite installs too. The function ``network_home_url ()`` defaults to ``home_url ()`` on standard WordPress® installs. */
/* Do NOT use ``site`` URL. Must use the `home` URL here, because that's what WordPress® uses in its own `mod_rewrite` implementation. */
?>

<IfModule mod_rewrite.c>
	RewriteEngine On
	RewriteBase <?php echo $ws_plugin__s2member_temp_s_base . "\n"; ?>
	RewriteCond %{QUERY_STRING} (^|\?|&)s2member_file_download\=.+
	RewriteRule .* - [E=no-gzip:1]
</IfModule>

<?php unset ($ws_plugin__s2member_temp_s_base); ?>
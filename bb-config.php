<?php
/** 
 * The base configurations of bbPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys and bbPress Language. You can get the MySQL settings from your
 * web host.
 *
 * This file is used by the installer during installation.
 *
 * @package bbPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for bbPress */
define( 'BBDB_NAME', 'contest' );

/** MySQL database username */
define( 'BBDB_USER', 'contest' );

/** MySQL database password */
define( 'BBDB_PASSWORD', 'contest' );

/** MySQL hostname */
define( 'BBDB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'BBDB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'BBDB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/bbpress/ WordPress.org secret-key service}
 *
 * @since 1.0
 */
define( 'BB_AUTH_KEY', '*-iMv[*~X?dsai+`*%pQnU|B>2Ed)O2Yl^}U{DnSSg<!Vf0|?<J2uLh,V{esi79!' );
define( 'BB_SECURE_AUTH_KEY', 'vy>34=>pU;3sam14:}hE&YIY|5VNY.{WdwVcXjh7:5)`S>V8ML#.!BjzomLtE+%-' );
define( 'BB_LOGGED_IN_KEY', 'J{)|)0`$$X-spnZ5iWS|#|n#HkvtBTtM9%dL1G4<$:e{yHJ|,[nG{,q_xN1Ik_p,' );
define( 'BB_NONCE_KEY', 'w-gDJ|2B=b+gANgH7l/x+.J({Z~ki>_U|f^D]dW-F H;E;bpCb@zbh$kh,!^Jeqk' );
/**#@-*/

/**
 * bbPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$bb_table_prefix = 'contest_wp_bb_';

/**
 * bbPress Localized Language, defaults to English.
 *
 * Change this to localize bbPress. A corresponding MO file for the chosen
 * language must be installed to a directory called "my-languages" in the root
 * directory of bbPress. For example, install de.mo to "my-languages" and set
 * BB_LANG to 'de' to enable German language support.
 */
define( 'BB_LANG', 'zh_CN' );
$bb->custom_user_table = 'contest_wp_users';
$bb->custom_user_meta_table = 'contest_wp_usermeta';

$bb->uri = 'http://contest.scie.in/wp-content/plugins/buddypress/bp-forums/bbpress/';
$bb->name = 'contest 论坛';
$bb->wordpress_mu_primary_blog_id = 1;

define('BB_AUTH_SALT', '#+GIql|=0VO|L=Q-`<eB#KF:lnfzwSph{iY(x2C4_UzZ@QzdsUvQT_K0=zAA^>J4');
define('BB_LOGGED_IN_SALT', '}avtPS}/5/%i1,~NJ_.he v<Pn?l*d>kO_1PT:4SilT;nN-A]WEI6,6>r^n]QMy<');
define('BB_SECURE_AUTH_SALT', '|?rA^`+t1RP-P%|SA/Kav#KhdmmX& O:fb=fj;A_K+(xGca8o<|5Bexw3xvf+.D!');

define('WP_AUTH_COOKIE_VERSION', 2);

?>
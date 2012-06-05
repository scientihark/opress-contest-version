<?php
/** 
 * WordPress 基础配置文件。
 *
 * 本文件包含以下配置选项：MySQL 设置、数据库表名前缀、密匙、
 * WordPress 语言设定以及 ABSPATH。如需更多信息，请访问
 * {@link http://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 * 编辑 wp-config.php} Codex 页面。MySQL 设置具体信息请咨询您的空间提供商。
 *
 * 这个文件用在于安装程序自动生成 wp-config.php 配置文件，
 * 您可以手动复制这个文件，并重命名为“wp-config.php”，然后输入相关信息。
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress 数据库的名称 */
define('DB_NAME', 'contest');

/** MySQL 数据库用户名 */
define('DB_USER', 'contest');

/** MySQL 数据库密码 */
define('DB_PASSWORD', '********');

/** MySQL 主机 */
define('DB_HOST', 'localhost');

/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密匙设定。
 *
 * 您可以随意写一些字符
 * 或者直接访问 {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org 私钥生成服务}，
 * 任何修改都会导致 cookie 失效，所有用户必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '*-iMv[*~X?dsai+`*%pQnU|B>9Ed)O1Yl^}U{DnSSg<!Vf0|?<J2uLh,V{esi79!');
define('SECURE_AUTH_KEY',  'vy>34=>pU;3sam14:}hE&YIY|5VNY.{WdwVcXjh5:5)`S>V8ML#.!BjzomLtE+%-');
define('LOGGED_IN_KEY',    'J{)|)0`$$X-spnZ5iWS|#|n#HkvtBTtM9%dL1G4<$:e{yHJ|,[nG{,q_xN1Ik_p,');
define('NONCE_KEY',        'w-gDJ|2B=b+gANgH7l/x+.J({Z~ki>_U|f^D]dW-F H;E;bpCb@zbh$kh,!^Jeqk');
define('AUTH_SALT',        '#+GIql|=0VO|L=Q-`<eB#KF:lnfzwSph{jY(x2C4_UzZ@QzdsUvQT_K0=zAA^>J4');
define('SECURE_AUTH_SALT', '|?rA^`+t1RP-P%|SA/Kav#KhdmmX& O:fb=fj;A_K+(xGca8o<|5Bexw3xvf+.D!');
define('LOGGED_IN_SALT',   '}avtPS}/5/%i1,~NJ_.he v<Pn?l*d>kO_1PT:4SilT;nN-A]WEI6,6>r^n]QMy<');
define('NONCE_SALT',       '9:^dloN[$}s!Y5t&1}mWt@Kt:1|G+D.]zs0_Qp|Oc5$9&S_T7b$5>5s-m1[D0~<`');

/**#@-*/

/**
 * WordPress 数据表前缀。
 *
 * 如果您有在同一数据库内安装多个 WordPress 的需求，请为每个 WordPress 设置不同的数据表前缀。
 * 前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'contest_wp_';

/**
 * WordPress 语言设置，中文版本默认为中文。
 *
 * 本项设定能够让 WordPress 显示您需要的语言。
 * wp-content/languages 内应放置同名的 .mo 语言文件。
 * 要使用 WordPress 简体中文界面，只需填入 zh_CN。
 */
define('WPLANG', 'zh_CN');

/**
 * 开发者专用：WordPress 调试模式。
 *
 * 将这个值改为“true”，WordPress 将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用本功能。
 */
define('WP_DEBUG', false);
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'contest.scie.in' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );
define ( 'BP_DISABLE_ADMIN_BAR', true );
/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress 目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置 WordPress 变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
define('WP_ALLOW_MULTISITE', 'true');

<?php
/**
 * WordPress基础配置文件。
 *
 * 这个文件被安装程序用于自动生成wp-config.php配置文件，
 * 您可以不使用网站，您需要手动复制这个文件，
 * 并重命名为“wp-config.php”，然后填入相关信息。
 *
 * 本文件包含以下配置选项：
 *
 * * MySQL设置
 * * 密钥
 * * 数据库表名前缀
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/zh-cn:%E7%BC%96%E8%BE%91_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //
/** WordPress数据库的名称 */
define('WP_CACHE', true);
define( 'WPCACHEHOME', 'D:\director\xueren\wp-content\plugins\wp-super-cache/' );
define('DB_NAME', 'word');

/** MySQL数据库用户名 */
define('DB_USER', 'chinahrt01');

/** MySQL数据库密码 */
//define('DB_PASSWORD', 'clt#123$');
define('DB_PASSWORD', '123456');
/** MySQL主机 */
//define('DB_HOST', '39.106.218.250');
define('DB_HOST', '172.27.1.102');
/** 创建数据表时默认的文字编码 */
define('DB_CHARSET', 'utf8mb4');

/** 数据库整理类型。如不确定请勿更改 */
define('DB_COLLATE', '');

/**#@+
 * 身份认证密钥与盐。
 *
 * 修改为任意独一无二的字串！
 * 或者直接访问{@link https://api.wordpress.org/secret-key/1.1/salt/
 * WordPress.org密钥生成服务}
 * 任何修改都会导致所有cookies失效，所有用户将必须重新登录。
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         ']z=i[=7sK9,n%F&[<!9[8nI_C2RS2nVZ9JC_f@#xIr_C(CI{lL@]SFd_Q^G*nLG,');
define('SECURE_AUTH_KEY',  'AnS?iM/KDHY`X`Ds[3N-&:{( s77sXgcF!{yi5qw,Tx5nM?h%<QMmWo=c!-Ll%*A');
define('LOGGED_IN_KEY',    'JOONa/(y6yQP/9Qqc*<f%H.HYi,M1>6r30*k#`vmgqc_H6<}p.92sxIa!Yh)F-=%');
define('NONCE_KEY',        '.;gkM~!Bof?HPbZ?K?bRsjv2;4@:4^.MAW?/pb1Qk.m?8_iQovLpqG,+DX.%}@>c');
define('AUTH_SALT',        'WZYe;{>x^bnwz?)dY@8y<_<r?`KAT0}cfV|D%JQ.K1/KiP_5ECrUjkyuKP:(jtJ@');
define('SECURE_AUTH_SALT', 'D|O;}(K$4f $J4@04j60U4(?n[,,dPP6`F]/|L(q:s l/:L9?,l  hJrzR9%UP@n');
define('LOGGED_IN_SALT',   '?x_E[0Vcx8S;<q?-1f@T(-V,A*rc9 VZhv D*RKxh;b0Q-:yBfReU M,$(u=mgW=');
define('NONCE_SALT',       '+{YoA`YXg!OR_h3FY/Y09()?o9)(Z9#jlk`,X wEFo5HE2<(A}Ez2H(^)-b4i.0_');

/**#@-*/

/**
 * WordPress数据表前缀。
 *
 * 如果您有在同一数据库内安装多个WordPress的需求，请为每个WordPress设置
 * 不同的数据表前缀。前缀名只能为数字、字母加下划线。
 */
$table_prefix  = 'wp_';

/**
 * 开发者专用：WordPress调试模式。
 *
 * 将这个值改为true，WordPress将显示所有用于开发的提示。
 * 强烈建议插件开发者在开发环境中启用WP_DEBUG。
 *
 * 要获取其他能用于调试的信息，请访问Codex。
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/**
 * zh_CN本地化设置：启用ICP备案号显示
 *
 * 可在设置→常规中修改。
 * 如需禁用，请移除或注释掉本行。
 */
define('WP_ZH_CN_ICP_NUM', true);

/* 好了！请不要再继续编辑。请保存本文件。使用愉快！ */

/** WordPress目录的绝对路径。 */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** 设置WordPress变量和包含文件。 */
require_once(ABSPATH . 'wp-settings.php');
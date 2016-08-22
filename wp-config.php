<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pismel01');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '`!%uM-|Kbl]!=DK@^Dzv~e{gsZ:d6daTI@i-|RxSbilxjkK=tH>%*VnvD6K9K8AV');
define('SECURE_AUTH_KEY',  'NG(Rr;L=Ixh)1T3]v+ tpB~`y--#?Rm@V|o4.L+-NU47T})z`@5QiV%Q[xv^$dvp');
define('LOGGED_IN_KEY',    'M2q&(%781wjE-C2[9ZoGDJ4+=zYF~TWR?2Og`zzN5On+Y^x }cl{Wy8+<OXDB nA');
define('NONCE_KEY',        'ts83Px:*:jEu& 2G:#cdsJIS_e]+&)5tT+ )%HHz@GWBi8]%,S_wMz:m1`>Gh@Jx');
define('AUTH_SALT',        'FM5C0}[W,}|.7^R,atZAt:l^o_ SOmI{@v}PEe`~=nVH{tcU+JM?lJ&#mR[dkYtW');
define('SECURE_AUTH_SALT', '9_FZa,&WUS d3P,t3.&>irwcP`onTNuZZ4-]#*[OE[56^DTaR3#8=-w>b*VVkUw_');
define('LOGGED_IN_SALT',   'apW7A@>Odd0_P?dZ]@&!&>?Bzu$~$r|Wa>;oF> QO],ZhROw`c@8;zK6Lk<2G-(I');
define('NONCE_SALT',       '6SyE[Pr 4pFK2UX4SRKZD ),c8`dP{_CQ-/V)lmvk{_GL`xG@;S/g>(c~N-W|5{z');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

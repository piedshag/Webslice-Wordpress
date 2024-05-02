<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', getenv('DB_NAME') );

/** Database username */
define( 'DB_USER', getenv('DB_USER') );

/** Database password */
define( 'DB_PASSWORD', getenv('DB_PASSWORD') );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '9}XfJU1>kF.,r#qFjnBG#(eHq~nhWpQ>OW+36E(Vy!g~!b&9,U&UHk2~KW`KGGd@');
define('SECURE_AUTH_KEY',  '|Y|D `>Nlvk4CR3eA(787htN8+yX|uA~T/Y?JZ|%tJ+YKfgI,Uq>~iUnM_~L*z&[');
define('LOGGED_IN_KEY',    'b|A,6>zw%0+;aAj-: 5EG%]$UFkO.@-Ps$fm+_w2MuH{DpzHbdwv/1W1g!}`>NO]');
define('NONCE_KEY',        'h1{Ym44t0(ZbTTJ`OadMaKwo-tC3Q|sZoePSpJ,/&BBl|R^xS`@ZTdH+ah?8rQ;a');
define('AUTH_SALT',        'U^5f:(11[y{WB-pDw?:qC 3JoZ.fC M-&7kn71Lom%}_yp!{*lx,~k|B@T@![T^V');
define('SECURE_AUTH_SALT', '3U7MY@M}@1H ?{zdApI2*P&u1HJcJ91{Jd.GtB{,XB_lMr4]~rJS&87#+)!l*+;*');
define('LOGGED_IN_SALT',   'k#tEm27(/3F-=G$*+5(;RDt~|;EJsQYtGE|(h,Sba=GI^5Z9!jgE+O?[)#u&.DRZ');
define('NONCE_SALT',       'k*b8CfO-yor,2lBXM-FtT$_3T+9Yl[V8!o.rBatHgf-@bh$bL<$i:@AP2<b`A 9b');

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */
define( 'WP_AUTO_UPDATE_CORE', false );


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

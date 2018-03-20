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
define('DB_NAME', 'cimahiwooru');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'SRmO>qp73_2C6(sb8nJ-f&cjf7;H2,pOZ[(zLRa{C|}Zq{%5]Ya6N|{(O(@&u^rZ');
define('SECURE_AUTH_KEY',  'X5&]pXpk(%gXgBX,@4&nB|#,TsOgQWi=v-jG%rcnEz~L_DIUl,)4=tt.;=}L0Xv]');
define('LOGGED_IN_KEY',    '@`vEc+yN3S3l/tS)C09^Xdbe/;!N}790YC$2f9Mtu};N@>xB}EZdzBj8~jQ~|E:u');
define('NONCE_KEY',        'fOAS7r!Yp#mUiWX=?k%F-9`P9fCvXZBT&1:m0(hdhusr!snf4}UjpRW586:dTWzm');
define('AUTH_SALT',        ';M#<6ZOYnv7!`?RXaVTwp^YaP(jPd;VCP_5)R6q1wVvW<toV#Y,+m~b00=oyXBdM');
define('SECURE_AUTH_SALT', 'yP4IHeutHv5tpR/b7s:AkXrFEscOf6+v$pP=X*0I(3,pbi?>3:C%8.jKAz9xKS4G');
define('LOGGED_IN_SALT',   '@r4*.v7!.Sc9b/TF7vupVL=9F%NzwP^R-QLNwZ(:iPmF?xFcJWJ&1HK820VH]IR2');
define('NONCE_SALT',       'bwOACw@MvPI#wQBve;sBIY%Z(8=_r^e4Oa`Y`0ywb&vU)CxQ*8HfOuqkyCH7%pBt');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mahiwall_';

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

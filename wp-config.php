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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'medico' );

/** MySQL database username */
define( 'DB_USER', 'medico' );

/** MySQL database password */
define( 'DB_PASSWORD', '1234' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '9-WFsn3w|xmlit*,:eIgqRMU+_cc; T^1]vcWu[m<W|JkUAtU>c_zq.C9 5=Dk@a' );
define( 'SECURE_AUTH_KEY',  'k b;s-$OsO^rA$]^j EO,2^:oo<=iA{m&Yhd:68_YF`))[_x2rK~MSjEH})~>-U,' );
define( 'LOGGED_IN_KEY',    'im t3+3~ ]nV,~R2pXIi;*1Z<LXywCdq)hOW^*!YDXzz?M&BCgw>*W<{J71$HGN}' );
define( 'NONCE_KEY',        'hkgX,Iu#&gh%WLM#Aev)liDug~uslmz&:tld]4.q4jqyC9F 66P*D<G&rED:+C$v' );
define( 'AUTH_SALT',        'fj&Ffo o}PR:OXD^*^LhkkW5po42$55rpT%%)K]4|K5n(Z+UwO(wc%[Mx>;:x+Je' );
define( 'SECURE_AUTH_SALT', 'jjd{4[utX]%H/6Nv N47UAR~@<Q(CXA5tv,1:4Ka&Nl:Obf2O6_}X${G96wRn;=+' );
define( 'LOGGED_IN_SALT',   'j[;2~i;*,>z1Cy?g98(AI^gqZb7#LDj&{}qYNU+hP)^U4ua?A }D*FcE/*TGZ3iZ' );
define( 'NONCE_SALT',       '(.gAFKb^QJUs&tg LgkgxcUmTsl=C`INH^Tw2#m;Veb`e[R&RsX^;%N*}Kt|+N;)' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

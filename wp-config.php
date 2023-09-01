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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'starterkit-v2' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '`+=%kl]UYVknG$KHd3BU}YE<bTkK(ln[Pz0oVfwn2b*BtT56Xm:1IC21kbu296BO' );
define( 'SECURE_AUTH_KEY',  '%6%$tvr<zLPR??b<[_hzbR;@ftik<<-H-lQKGae&nNX}XDpVP BDR9Shf1*p5M7_' );
define( 'LOGGED_IN_KEY',    '[,%F+^GWxuC$X/5E(sMGQov=tluA;I?|d=t y0qn)30%-o@*1:ig2/]BOeKmqov7' );
define( 'NONCE_KEY',        'pSece*E@jsgA)5Z7HSHS9WtUFIRJ:|c%Viqp)5 A{v 2phB@P)gZ*(r91~1L(`z;' );
define( 'AUTH_SALT',        'MSJ=ZQCNgK)mT-T<aXu&A 7V)+-1i>8rQH,9Uq !w$3De9iMsd2xemHRV!P+JR`,' );
define( 'SECURE_AUTH_SALT', '3HWFBv4I5V#8B?C;WGz6&^bM]R[;=f1m`t54HVq0,QBIWbn+3LV.A}43auNi<# U' );
define( 'LOGGED_IN_SALT',   'lC]Y{qy^cl9/3}  IpXIk0 ;aDMmiL@uBsh=v#38[,F>gv@^K8_[u&jIi:WI4G4%' );
define( 'NONCE_SALT',       '#M[!bKc93*3h*Y0!#XJ0Z8KY~KO?TF.hM&t[=r?)C.ip&Z`t~9k^)}nm8+IwZJ<s' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'stk_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
define('FS_METHOD','direct');


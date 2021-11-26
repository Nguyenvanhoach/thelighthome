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
define( 'DB_NAME', 'thelighthome' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
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
define( 'AUTH_KEY',         'v[}6?TKf+-o*~q36`^*x0t N,)g!T3sl> q4GBfV+Q,MgmWV~Uq5O-1,P}k_we/:' );
define( 'SECURE_AUTH_KEY',  '%c[p-dHRL{M~J+fD$t%Cy&I1dg,jdO*8(YtKE_tP.]9q,1)r~d;?.`q?pAt-f^S*' );
define( 'LOGGED_IN_KEY',    'Q2Qb!LJA!l.Oo<aSqw/@}r}7z1/3i(JON-1g:]*gK%]XfFo]:&Yc>x^kKc;:21%x' );
define( 'NONCE_KEY',        'v6{dd5ptq@I5tDfTsC=MHx5_}aTq9D@}2jQj7-^2o*S}:g{17yhb|_7%W<dN):H9' );
define( 'AUTH_SALT',        'Eyrvf]Xy!E(;ze/1/7L$Zyc_T1FdR|%KD{FMGS)3Z}F(TFU2  @TTfnnXP9.&g%i' );
define( 'SECURE_AUTH_SALT', '^!q|fj)|6|O}<Q`t^>ki_dGc:M6(EcT*nMfY:=`Bnl%zlImh!aM-l^m9Bt~P!rbA' );
define( 'LOGGED_IN_SALT',   'P|xP24[#?<7n^9A[1{0`6c%P<99hG/^}27{)6P6q]HO6|p?g?6p#VrO&n7uiL&!a' );
define( 'NONCE_SALT',       'V|pz`ab3pm0Q4bBWL$V%)MG.Av#>(f9~nx,[eHUrC_=NP5;(Zz<Xb /~`@[XxOKq' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'tlhome_';

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
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

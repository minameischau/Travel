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
define( 'DB_NAME', 'wpress_db' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '}P ;*4)Odx&}:sInZ/V3fl3E8CM`aq6?l6QZo67FuYvj1F:`+6KntyRw59D8;WcA' );
define( 'SECURE_AUTH_KEY',  'uz(n5+hE|Z]%aRXpq9PP*[-;ca`5[o^Skd*:}s%<)Z-FG{:nz^l?sK#mJ$CJR+8X' );
define( 'LOGGED_IN_KEY',    '{tooi}`&fo~`!zQe7`Fg IF1e&fUb~zxHIpVfTo*&Py`mwi+1=2i;G?K43,LWokq' );
define( 'NONCE_KEY',        'lGmwe9/3($y^`xt8fgoGW3luF(:Hzn<Hn2AY7R|WRCBwED}rQ<22am4bsm;%,fA|' );
define( 'AUTH_SALT',        '(NY+C7KXKJfoxo:b&sVgd:L4.K*cRdsDCyD,O-8fr!H pn vjkruGh!qVdI_R$eU' );
define( 'SECURE_AUTH_SALT', '.!A@4]N&dgOkpZ@YjxCX602 v&DCBhA&A}zq},dtwxxzeP+U2W~bfi~2I hBce-:' );
define( 'LOGGED_IN_SALT',   'Qm<WrvE~^o9.mG9/OmL>0)g&z0Z(~*+hGT`VFx&K2:k,.-QzkH=(<>r14)l>|x$P' );
define( 'NONCE_SALT',       ' sv$t)sn`WACYSW/w#uXd)7Y>!iOg=&i4I<8n_|iy{8z5)Q0(f,L#Yu|l*UN_wGz' );

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

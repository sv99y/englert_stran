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
define('DB_NAME', 'ravne_stran');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         't,}v&w4VT1k@ ;[vymc}>svJ|UIQ|D3.Evc Igb6t/Y;Ng`3s$;`v6)y{!0MliyV');
define('SECURE_AUTH_KEY',  '245y@rSMgN(&vbQjL|U_:&B]6N;(87D32Wm)4k%B9a+y%G8~;~(Ue@0R 5~3I[n#');
define('LOGGED_IN_KEY',    'ARy`nDC;nF=>>YA=C(WW2<-Bml8g,7(_yZcX3a`):3Cwf&?Nk/uq_U/:+~C/_+ i');
define('NONCE_KEY',        'ao|6&~sUoaH:Ow*1{J$JGc`rEYGn-!n!S?24``tl/u8H6zTow>u41>+g/+P$&_cl');
define('AUTH_SALT',        'oZCFmJ@C2Ae9nqB~cn$_eNCi$N/{^YE[b% j:&bdZ`Gx=#{cTl#!|rLnO03i#OO0');
define('SECURE_AUTH_SALT', 'hpJkF@q6wd-&@vC5ST$JeYbO`1iN6a qLJM]q&AC/KS^<h(t|sGQ&NQ+MER64Q6N');
define('LOGGED_IN_SALT',   'tA[Nux*2BT^,6YKdf%sjBJ>)2PoQp(f!fyVg#1oor5*pjkIt/-=qE5I<u64^.-b@');
define('NONCE_SALT',       'S=g|:[|`QVkF5D{~7s|}(Xgv`y^@<EO_Fe/(/p=LmdAIksnt$V>NA7YOeOMtG+8y');

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

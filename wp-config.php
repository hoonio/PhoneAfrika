<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'pawordpress');

/** MySQL database username */
define('DB_USER', 'pamobile274');

/** MySQL database password */
define('DB_PASSWORD', 'Whittington132');

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
define('AUTH_KEY',         '/)pM6)ig5(kzg+ZA6xH-sIogx1GL/bQuKCmNO5O^dQ^THd4pqZp-wHHKNFt#Gz(C');
define('SECURE_AUTH_KEY',  'U!74SXiCM0AZY0^jm7)PyL84dFT+^oz7lciD(uIwMY2gP2aDk9svW5rf2l-e--su');
define('LOGGED_IN_KEY',    '1t6BrOM(sKEc1z4jU1Klh+QK+lJ5cGdc_h/Cxf9(F_xrRo6NUXsHyPAtstlHkI+^');
define('NONCE_KEY',        '=cHtcn9cp-W0XxLIg8e(Sy=#(+19QuBnCfG_h#ec(bSUDUGr_K0ZnBH+3ROqqk=W');
define('AUTH_SALT',        's)e+ctbGwqsVCOcLzVYxnJywFRSbVnDJ2XdNN7t7WtZbkj/R/!7nvfvp8#dT9+w_');
define('SECURE_AUTH_SALT', 'rGFadx-YrWHtvp=7-Tx_ZFusv/m!3HmOiiCe4xH-UQ6Sly7pT)v)cQOF8J05B20Q');
define('LOGGED_IN_SALT',   '4v^x+TacUIL=!NLwcAlYzz(Mds6XZnOiSCVNTf1L7wTRc0qByX6pwj/bnS/7vo8T');
define('NONCE_SALT',       '(3fvBCgMX9LUJrdQQAWeC6Wf7#fHRPE(-gmp^C3GMB+-a7AX-cFbgJYl2zch(DcO');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/**
 *  Change this to true to run multiple blogs on this installation.
 *  Then login as admin and go to Tools -> Network
 */
define('WP_ALLOW_MULTISITE', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');


define('FS_METHOD', 'ftpext');
define('FTP_BASE', '/var/www/phoneafrikamobile.co.uk/');
define('FTP_USER', 'pamobile274');
define('FTP_PASS', 'Whittington132');
define('FTP_HOST', 'www.phoneafrikamobile.co.uk');
define('FTP_SSL', false);
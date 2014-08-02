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

if (file_exists(dirname( __FILE__ ) . '/ChromePhp.php')) {
    include (dirname( __FILE__) . '/ChromePhp.php');
}

ChromePhp::log('ChromePhp working!');

if (file_exists(dirname( __FILE__ ) .'/local-config.php')) {
    // Will be used when developing locally
    include(dirname( __FILE__ ) .'/local-config.php');

} else {
// ** MySQL settings - You can get this info from your web host ** //
    /** The name of the database for WordPress */

    define('DB_NAME', 'ChangeThisAccordingToServerSettingsName');

    /** MySQL database username */
    define('DB_USER', 'ChangeThisAccordingToServerSettingsUser');

    /** MySQL database password */
    define('DB_PASSWORD', 'ChangeThisAccordingToServerSettingsPassword');

    /** MySQL hostname */
    define('DB_HOST', 'ChangeThisAccordingToServerSettingsHost');
}

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
define('AUTH_KEY',         '>Dw#Oa=Z#QI;&r1&Uw2a>S&y^EHZ<3o..Z#(@EHS>`|fh[x2_myCefz1m.iMfDDI');
define('SECURE_AUTH_KEY',  'K1/F--/sSj>cS2@nJ`#J}2kJ($~b1|Hnf{PCuol6-SD;+=(NOg U?DcxZOjU}Mf?');
define('LOGGED_IN_KEY',    'u=e`}KCjAf1q+Qfk/z=MaiXs]sHcu|]|[*+j(Is|0),?`?3-!dQ5?erKiPfgA+!-');
define('NONCE_KEY',        '<(hM}9XfF2QZX||}-QQyI(<IFGk7P>W$Q.#nkoO.@_-.S{VoR/-9VASt-}/8z[64');
define('AUTH_SALT',        '9UWm$1)E-%o Cw6t{ky:E4rKa},Sy[.O=BQWjRYbD3X+B=LDsk]fY12>N2E}(sdr');
define('SECURE_AUTH_SALT', 'L=a~r^cD2s]5SPc1QM0QV}SxoDq1ZW,/}Gn~B6h`9]6ua0VSMS&!$)5)ieMX~}qR');
define('LOGGED_IN_SALT',   'qc<;W-gLiLS7pmCQt|+n@F-j]A>,`Cx$&LB9%Cc$T]U9+1m^Ku<;3bTPQGurszaF');
define('NONCE_SALT',       '.QE393u&$Y!Yrg>q1_qBnNm5{52f$=y+nT6,(h]3rnqQmB}Y,Xg j1p6r)r>4>Wb');

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
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
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

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

<?php
/** 
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information by
 * visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
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
define('WP_CACHE', true); //Added by WP-Cache Manager
define( 'WPCACHEHOME', 'C:\Inetpub\vhosts\caravaneemploi.com\httpdocs\wp-content\plugins\wp-super-cache/' ); //Added by WP-Cache Manager
define('DB_NAME', 'wpcem');

/** MySQL database username */
define('DB_USER', 'root');
/** define('DB_USER', 'usrwpcemdev'); */

/** MySQL database password */
define('DB_PASSWORD', '');
/** define('DB_PASSWORD', '@Amal@JOB@@@20/*14'); */
/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link http://api.wordpress.org/secret-key/1.1/ WordPress.org secret-key service}
 *
 * @since 2.6.0
 */
define('AUTH_KEY',       'WZgKBjNH(9eSCZFb6UDTL*4Sj(Mt9piU#dzq4v7w(d4&l#qYR%kpbFA5nktcmUPC');
define('SECURE_AUTH_KEY',       'EuRzYAA%I!koBW2Z0FUKb#zVtk&ljZ3qZUOz*FAW5vUaydY&sU6DJj%EjMzfKXVa');
define('LOGGED_IN_KEY',       '57!gjgl3#i9%rl0JP6A9EJInp9J7Bz#VlzF9FhSdSDrF0pEtC8meAgJosl4lE^bn');
define('NONCE_KEY',       'hT^%8BHJjQ@3S(EINNkTHB@I(4n@uYY46%V%uEklx6pxadZU87ZCb**%HMJhxE9O');
define('AUTH_SALT',       'gie3L&LPTpxYjJV#cZz58%6Fb%tMqm@weG4stthCqYN&F*KQ*CXZTFIxKspj*kWn');
define('SECURE_AUTH_SALT',       'ohfi%MNulWX5*FGA)LETHZRnII4g9asOz1Omj7*h)r5KGD8qvhtFk9U&MZ(2P&xV');
define('LOGGED_IN_SALT',       'l^emCyW2U1@SxI38qei%@(WR3joA@at8bKa(XHkP^Hou1UUz&aPv7%Nucc%%F^SI');
define('NONCE_SALT',       'Flp8#Iy(C^SWsy&luX7RjkbHe3K(jG2rGCNujlI5@n)FyPDBUMHKUut#X5hiUmCf');
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
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', 'fr_FR');

define ('FS_METHOD', 'direct');

define('WP_DEBUG', false);

 // Added by W3 Total Cache

/* That's all, stop editing! Happy blogging. */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

//--- disable auto upgrade
define( 'AUTOMATIC_UPDATER_DISABLED', true );



?>

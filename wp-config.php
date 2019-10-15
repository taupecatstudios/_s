<?php
/**
 * This config file is yours to hack on. It will work out of the box on Pantheon
 * but you may find there are a lot of neat tricks to be used here.
 *
 * See our documentation for more details:
 *
 * https://pantheon.io/docs
 */

/**
 * Local configuration information.
 *
 * If you are working in a local/desktop development environment and want to
 * keep your config separate, we recommend using a 'wp-config-local.php' file,
 * which you should also make sure you .gitignore.
 */
if ( ( file_exists( __DIR__ . '/wp-config-local.php' ) ) && ( ! isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {

	require_once( __DIR__ . '/wp-config-local.php' );

/**
 * Pantheon platform settings. Everything you need should already be set.
 */
} else {

	if ( isset( $_ENV['PANTHEON_ENVIRONMENT'] ) ) {

		/** MySQL settings - included in the Pantheon Environment */

		/** The name of the database for WordPress */
		define( 'DB_NAME', $_ENV['DB_NAME'] );

		/** MySQL database username */
		define( 'DB_USER', $_ENV['DB_USER'] );

		/** MySQL database password */
		define( 'DB_PASSWORD', $_ENV['DB_PASSWORD'] );

		/** MySQL hostname; on Pantheon this includes a specific port number. */
		define( 'DB_HOST', $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'] );

		/** Database Charset to use in creating database tables. */
		define( 'DB_CHARSET', 'utf8' );

		/** The Database Collate type. Don't change this if in doubt. */
		define( 'DB_COLLATE', '' );

		/**#@+
		 * Authentication Unique Keys and Salts.
		 *
		 * Change these to different unique phrases!
		 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
		 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
		 *
		 * Pantheon sets these values for you also. If you want to shuffle them you
		 * must contact support: https://pantheon.io/docs/getting-support
		 *
		 * @since 2.6.0
		 */
		define( 'AUTH_KEY',         $_ENV['AUTH_KEY'] );
		define( 'SECURE_AUTH_KEY',  $_ENV['SECURE_AUTH_KEY'] );
		define( 'LOGGED_IN_KEY',    $_ENV['LOGGED_IN_KEY'] );
		define( 'NONCE_KEY',        $_ENV['NONCE_KEY'] );
		define( 'AUTH_SALT',        $_ENV['AUTH_SALT'] );
		define( 'SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] );
		define( 'LOGGED_IN_SALT',   $_ENV['LOGGED_IN_SALT'] );
		define( 'NONCE_SALT',       $_ENV['NONCE_SALT'] );
		/**#@-*/

		/** A couple extra tweaks to help things run well on Pantheon. **/

		/** Always-on HTTPS */
		if ( 'cli' !== php_sapi_name() ) {

			switch ( $_ENV['PANTHEON_ENVIRONMENT'] ) {

				case 'live':
					$primary_domain = '##PRODUCTION_DOMAIN##';
					break;

				case 'local':
					$primary_domain = '##PROJECT##.pantheonlocal.com';
					break;

				default:
					$primary_domain = $_ENV['PANTHEON_ENVIRONMENT'] . '-##PROJECT##.pantheonsite.io';
					break;
			}

			$_SERVER['HTTPS'] = 'on';
			$base_url = 'https://' . $primary_domain;

			if ( ( $primary_domain !== $_SERVER['HTTP_HOST'] ) || ( ! isset( $_SERVER['HTTP_X_SSL'] ) ) || ( 'ON' !== $_SERVER['HTTP_X_SSL'] ) ) {

				header( 'HTTP/1.0 301 Moved Permanently' );
				header( 'Location: ' . $base_url . $_SERVER['REQUEST_URI'] );
				exit();
			}

			define( 'WP_HOME', $base_url );
			define( 'WP_SITEURL', WP_HOME );
		}

		/** Don't show deprecations; useful under PHP 5.5 */
		error_reporting( E_ALL ^ E_DEPRECATED );

		/** Define appropriate location for default tmp directory on Pantheon */
		define( 'WP_TEMP_DIR', $_SERVER['HOME'] . '/tmp' );

		/** Make sure Jetpack is always in debug mode in non-live environments */
		if ( ( 'live' !== $_ENV['PANTHEON_ENVIRONMENT'] ) && ( ! defined( 'JETPACK_DEV_DEBUG' ) ) ) {
			define( 'JETPACK_DEV_DEBUG', true );
		}

	} else {

		/**
		 * This block will be executed if you have NO wp-config-local.php and you
		 * are NOT running on Pantheon. Insert alternate config here if necessary.
		 *
		 * If you are only running on Pantheon, you can ignore this block.
		 */
		define( 'DB_NAME',          'database_name' );
		define( 'DB_USER',          'database_username' );
		define( 'DB_PASSWORD',      'database_password' );
		define( 'DB_HOST',          'database_host' );
		define( 'DB_CHARSET',       'utf8' );
		define( 'DB_COLLATE',       '' );
		define( 'AUTH_KEY',         'put your unique phrase here' );
		define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );
		define( 'LOGGED_IN_KEY',    'put your unique phrase here' );
		define( 'NONCE_KEY',        'put your unique phrase here' );
		define( 'AUTH_SALT',        'put your unique phrase here' );
		define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );
		define( 'LOGGED_IN_SALT',   'put your unique phrase here' );
		define( 'NONCE_SALT',       'put your unique phrase here' );
	}
}

/** Standard wp-config.php stuff from here on down. **/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
if ( ! isset( $table_prefix ) ) {

	$table_prefix = '##TABLE_PREFIX##';
}

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
if ( ! defined( 'WPLANG' ) ) {

	define( 'WPLANG', '' );
}

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * You may want to examine $_ENV['PANTHEON_ENVIRONMENT'] to set this to be
 * "true" in dev, but false in test and live.
 */
if ( ! defined( 'WP_DEBUG' ) ) {

	define( 'WP_DEBUG', false );
}

/**
 * When we are using WP_DEBUG, we want to write to a log instead of
 * displaying errors on the screen.
 */
if ( WP_DEBUG ) {

	define( 'WP_DEBUG_DISPLAY', false );
	define( 'WP_DEBUG_LOG', true );

	/** Jetpack should be in debug mode any time WP_DEBUG is true. */
	if ( ! defined( 'JETPACK_DEV_DEBUG' ) ) {

		define( 'JETPACK_DEV_DEBUG', true );
	}
}

/* That's all, stop editing! Happy Pressing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once( ABSPATH . 'wp-settings.php' );

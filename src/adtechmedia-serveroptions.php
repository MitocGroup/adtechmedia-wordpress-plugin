<?php
/**
 * Adtechmedia_Request
 *
 * @category File
 * @package  Adtechmedia_Plugin
 * @author   yamagleb
 */

/**
 * Class Adtechmedia_ServerOptions
 */
class Adtechmedia_ServerOptions {

	const SW_REWRITE_RULE = 'RewriteRule ^sw\.min\.js$ /wp-content/plugins/adtechmedia/js/sw.min.js [L]';

	/**
	 * Set server options
	 */
	static public function set_options() {
		if ( self::is_apache() ) {
			self::set_apache_config();
		}
	}

	/**
	 * Delete server options
	 */
	static public function delete_options() {
		if ( self::is_apache() ) {
			self::delete_apache_config();
		}
	}

	/**
	 * Returns true if server is Apache
	 *
	 * @return boolean
	 */
	static public function is_apache() {
		// Assume apache when unknown, since most common.
		if ( empty( $_SERVER['SERVER_SOFTWARE'] ) ) {
			return true;
		}

		return isset( $_SERVER['SERVER_SOFTWARE'] ) && stristr( sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ) ), 'Apache' ) !== false;
	}

	/**
	 * Set config for Apache
	 */
	static public function set_apache_config() {
		$path     = self::get_root_dir_path() . '/.htaccess';
		$handle   = @fopen( $path, 'r' );
		$content  = '';
		$inserted = false;
		if ( $handle ) {
			while ( ( $buffer = fgets( $handle, 4096 ) ) !== false ) {

				if ( ! $inserted && stristr( $buffer, 'RewriteRule' ) ) {
					$content .= self::SW_REWRITE_RULE . PHP_EOL;
					$inserted = true;
				}
				$content .= $buffer;
			}
			fclose( $handle );
			// @codingStandardsIgnoreStart
			file_put_contents( $path, $content );
			// @codingStandardsIgnoreEnd
		}
	}

	/**
	 * Delete config for Apache
	 */
	static public function delete_apache_config() {
		$path    = explode( 'wp-content', dirname( __FILE__ ) )[0] . '/.htaccess';
		$handle  = @fopen( $path, 'r' );
		$content = '';
		if ( $handle ) {
			while ( ( $buffer = fgets( $handle, 4096 ) ) !== false ) {

				if ( ! stristr( $buffer, 'RewriteRule ^sw\.min\.js$ /wp-content/plugins/adtechmedia/js/sw.min.js [L]' ) ) {
					$content .= $buffer;
				}
			}
			fclose( $handle );
		}
		// @codingStandardsIgnoreStart
		file_put_contents( $path, $content );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Returns path to project root directory
	 *
	 * @return mixed
	 */
	static public function get_root_dir_path() {
		return explode( 'wp-content', dirname( __FILE__ ) )[0];
	}
}

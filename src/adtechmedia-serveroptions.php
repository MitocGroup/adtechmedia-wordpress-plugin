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

	/**
	 * Set server options
	 */
	static public function set_options() {
		if ( self::is_apache() ) {
			self::set_apache_config();
		} elseif ( self::is_nginx() ) {
			self::set_nginx_config();
		}
	}

	/**
	 * Delete server options
	 */
	static public function delete_options() {
		if ( self::is_apache() ) {
			self::delete_apache_config();
		} elseif ( self::is_nginx() ) {
			self::delete_nginx_config();
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
	 * Returns true if server is nginx
	 *
	 * @return boolean
	 */
	static public function is_nginx() {
		return isset( $_SERVER['SERVER_SOFTWARE'] ) && stristr( sanitize_text_field( wp_unslash( $_SERVER['SERVER_SOFTWARE'] ), 'nginx' ) ) !== false;
	}

	/**
	 * Set config for Apache
	 */
	static public function set_apache_config() {
		$path     = explode( 'wp-content', dirname( __FILE__ ) )[0] . '/.htaccess';
		$handle   = @fopen( $path, 'r' );
		$content  = '';
		$inserted = false;
		if ( $handle ) {
			while ( ( $buffer = fgets( $handle, 4096 ) ) !== false ) {

				if ( ! $inserted && stristr( $buffer, 'RewriteRule' ) ) {
					$content .= 'RewriteRule ^sw\.min\.js$ /wp-content/plugins/adtechmedia/js/sw.min.js [L]' . PHP_EOL;
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
	 * Set config for nginx
	 */
	static public function set_nginx_config() {

	}

	/**
	 * Delete config for nginx
	 */
	static public function delete_nginx_config() {

	}
}

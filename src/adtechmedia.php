<?php
/**
 * Plugin Name: Adtechmedia
 * Plugin URI: http://wordpress.org/extend/plugins/adtechmedia/
 * Version: 0.01
 * Author:
 * Description:
 * Text Domain: adtechmedia
 * License: GPLv3
 *
 * @category Adtechmedia
 * @package  Adtechmedia_Plugin
 * @author    yama-gs
 */

$adtechmedia_minimal_required_php_version = '5.0';

/**
 * Notice php version is wrong
 */
function adtechmedia_notice_php_version_wrong() {
	global $adtechmedia_minimal_required_php_version;
	echo '<div class="updated fade">' .
		esc_html__( 'Error: plugin "Adtechmedia" requires a newer version of PHP to be running.', 'adtechmedia' ) .
		'<br/>';
	echo esc_html__( 'Minimal version of PHP required: ', 'adtechmedia' );
	echo '<strong>';
	echo esc_html( $adtechmedia_minimal_required_php_version );
	echo '</strong><br/>';
	echo esc_html__( 'Your server\'s PHP version: ', 'adtechmedia' );
	echo '<strong>' . esc_html( phpversion() );
	echo '</strong></div>';
}

/**
 * Check the PHP version and give a useful error message if the user's version is less than the required version
 *
 * @return boolean true if version check passed. If false, triggers an error which WP will handle, by displaying
 * an error message on the Admin page
 */
function adtechmedia_php_version_check() {
	global $adtechmedia_minimal_required_php_version;
	if ( version_compare( phpversion(), $adtechmedia_minimal_required_php_version ) < 0 ) {
		add_action( 'admin_notices', 'adtechmedia_notice_php_version_wrong' );
		return false;
	}
	return true;
}


/**
 * Initialize internationalization (i18n) for this plugin.
 * References:
 *      http://codex.wordpress.org/I18n_for_WordPress_Developers
 *      http://www.wdmac.com/how-to-create-a-po-language-translation#more-631
 *
 * @return void
 */
function adtechmedia_i18n_init() {
	$plugin_dir = dirname( plugin_basename( __FILE__ ) );
	load_plugin_textdomain( 'adtechmedia', false, $plugin_dir . '/languages/' );
}


// Initialize i18n.
add_action( 'plugins_loadedi', 'adtechmedia_i18n_init' );

// Run the version check.
// If it is successful, continue with initialization for this plugin.
if ( adtechmedia_php_version_check() ) {

	include_once( 'adtechmedia-init.php' );
	include_once( 'adtechmedia-request.php' );
	include_once( 'adtechmedia-config.php' );
	include_once( 'adtechmedia-contentmanager.php' );
	include_once( 'lib/autoload.php' );
	adtechmedia_init( __FILE__ );
}

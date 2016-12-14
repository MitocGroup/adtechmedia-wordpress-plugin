<?php
/**
 * Adtechmedia_ShortCodeScriptLoader
 *
 * @category File
 * @package  Adtechmedia_Plugin
 * @author   yamagleb
 */

/**
 * Include Adtechmedia_ShortCodeLoader
 */
include_once( 'adtechmedia-shortcodeloader.php' );

/**
 * Adapted from this excellent article:
 * http://scribu.net/wordpress/optimal-script-loading.html
 * The idea is you have a shortcode that needs a script loaded, but you only
 * want to load it if the shortcode is actually called.
 */
abstract class Adtechmedia_ShortCodeScriptLoader extends Adtechmedia_ShortCodeLoader {

	/**
	 * Flag that we need to add the script
	 *
	 * @var boolean
	 */
	var $do_add_acript;

	/**
	 * Register shortcode
	 *
	 * @param mixed $shortcode_name  shortcode name.
	 */
	public function register( $shortcode_name ) {
		$this->register_shortcode_to_function( $shortcode_name, 'handle_shortcode_wrapper' );

		// It will be too late to enqueue the script in the header, but can add them to the footer.
		add_action( 'wp_footer', array( $this, 'add_script_wrapper' ) );
	}

	/**
	 * Handle shortcode wrapper
	 *
	 * @param mixed $atts shortcode atts.
	 * @return shortcode
	 */
	public function handle_shortcode_wrapper( $atts ) {
		// Flag that we need to add the script.
		$this->do_add_acript = true;
		return $this->handle_shortcode( $atts );
	}

	/**
	 * Add script wrapper
	 */
	public function add_script_wrapper() {
		// Only add the script if the shortcode was actually called.
		if ( $this->do_add_acript ) {
			$this->add_script();
		}
	}

	/**
	 * Add script
	 *
	 * @abstract override this function with calls to insert scripts needed by your shortcode in the footer
	 * Example:
	 *   wp_register_script('my-script', plugins_url('js/my-script.js', __FILE__), array('jquery'), '1.0', true);
	 *   wp_print_scripts('my-script');
	 * @return void
	 */
	public abstract function add_script();

}

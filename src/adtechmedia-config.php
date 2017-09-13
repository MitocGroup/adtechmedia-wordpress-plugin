<?php
/**
 * Adtechmedia_Config
 *
 * @category Adtechmedia_Config
 * @package  Adtechmedia_Plugin
 * @author   yamagleb
 */

/**
 * Class Adtechmedia_Config
 */
class Adtechmedia_Config {

	/**
	 * Plugin config
	 *
	 * @var array
	 */
	private static $conf = [
		'debug'                          => false,
		'ab_default_percentage'					 => 0,
		'api_end_point'                  => 'https://api.adtechmedia.io/v1/',
		'plugin_table_name'              => 'adtechmedia',
		'plugin_cache_table_name'        => 'adtechmedia_cache',
		'plugin_ab_cookie_name'        	 => 'adtechmedia_ab',
		'plugin_ab_test_name'        	 	 => 'adtechmedia_ab',
		'maxTries'                       => 7,
		'minDelay'                       => 150000,
		'factor'                         => 1.7,
		'atm_js_cache_time'              => 86400,
		'template_overall_styles_patch'  => '@media (max-width: 991px) { .atm-targeted-container { width: 90% !important; left: 5% !important; transform: none !important; } } @media (max-width: 600px) { .atm-targeted-container { top: 0 !important; } }',
		'sw_js_url'                      => 'https://manage.adtechmedia.io/atm-admin/atm-build/sw.min.js',
		'tpl_js_url'                     => 'https://manage.adtechmedia.io/atm-admin/atm-build/atmTpl.js',
		'br_js_url'                      => 'https://manage.adtechmedia.io/atm-admin/atm-build/atmBr.js',
		'tpl_mgmt_js_url'                => 'https://manage.adtechmedia.io/atm-admin/atm-build/atmTplManager.js',
		'terms_url'                      => 'https://manage.adtechmedia.io/deep-account/terms/dialog.html',
		'register_url_tpl'               => 'https://manage.adtechmedia.io/accounts/signup/%s',
		'price'                          => 0.05,
		'content_offset'                 => 2,
		'payment_pledged'                => 2,
		'ads_video'                      => 'https://manage.adtechmedia.io/atm-admin/atm-build/demo-vast.xml',
		'content_lock'                   => 'blur+scramble',
		'revenue_method'                 => 'advertising+micropayments', // @todo change it to 'micropayments+subscriptions' when subscriptions implemented
		'price_currency'                 => 'usd',
		'content_paywall'                => 'transactions',
		'content_offset_type'            => 'paragraphs',
		'country'                        => 'United States',
		'platform_id'										 => 'Wordpress',
		'updated_appearance'						 => '0',
		'appearance_settings'		 				 => '{"model":{"main":{"sticky":true,"width":"600px","offset":{"top":"20px","fromCenter":"-60px","scrollTop":"100"}},"body":{"backgroundColor":"#ffffff","border":"1px solid #d3d3d3","fontFamily":"\'Merriweather\', sans-serif","boxShadow":"0 1px 2px 0 rgba(0, 0, 0, 0.1)"},"footer":{"backgroundColor":"#fafafa","border":"1px solid #e3e3e3"}}}',
	];

	/**
	 * Function to get param value
	 *
	 * @param string $name kay name.
	 *
	 * @return mixed
	 */
	public static function get( $name ) {
		return self::$conf[ $name ];
	}

	/**
	 * Set API end point for localhost
	 */
	public static function setup_endpoints() {
		if ( self::is_localhost() ) {
			self::$conf['api_end_point'] 		= 'https://api-test.adtechmedia.io/v1/';
			self::$conf['ads_video']     		= 'https://manage-test.adtechmedia.io/atm-admin/atm-build/demo-vast.xml';
			self::$conf['sw_js_url']     		= 'https://manage-test.adtechmedia.io/atm-admin/atm-build/sw.min.js';
			self::$conf['tpl_js_url']       = 'https://manage-test.adtechmedia.io/atm-admin/atm-build/atmTpl.js';
			self::$conf['br_js_url']        = 'https://manage-test.adtechmedia.io/atm-admin/atm-build/atmBr.js';
			self::$conf['tpl_mgmt_js_url']  = 'https://manage-test.adtechmedia.io/atm-admin/atm-build/atmTplManager.js';
			self::$conf['register_url_tpl'] = 'https://manage-test.adtechmedia.io/accounts/signup/%s';
			self::$conf['terms_url']        = 'https://manage-test.adtechmedia.io/deep-account/terms/dialog.html';
		} else if ( self::is_stage() ) {
			self::$conf['api_end_point']    = 'https://api-stage.adtechmedia.io/v1/';
			self::$conf['ads_video']        = 'https://manage-stage.adtechmedia.io/atm-admin/atm-build/demo-vast.xml';
			self::$conf['sw_js_url']        = 'https://manage-stage.adtechmedia.io/atm-admin/atm-build/sw.min.js';
			self::$conf['tpl_js_url']       = 'https://manage-stage.adtechmedia.io/atm-admin/atm-build/atmTpl.js';
			self::$conf['br_js_url']        = 'https://manage-stage.adtechmedia.io/atm-admin/atm-build/atmBr.js';
			self::$conf['tpl_mgmt_js_url']  = 'https://manage-stage.adtechmedia.io/atm-admin/atm-build/atmTplManager.js';
			self::$conf['register_url_tpl'] = 'https://manage-stage.adtechmedia.io/accounts/signup/%s';
			self::$conf['terms_url']        = 'https://manage-stage.adtechmedia.io/deep-account/terms/dialog.html';
		}
	}

	/**
	 * Is stage
	 *
	 * @return bool
	 */
	public static function is_stage() {
		$server_name = isset( $_SERVER['SERVER_NAME'] )
			? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) )
			: null;
		return preg_match( '/dev-[^\.]+\.pantheonsite\.io/i', $server_name );
	}

	/**
	 * Is local installation
	 *
	 * @return bool
	 */
	public static function is_localhost() {
		$server_name = isset( $_SERVER['SERVER_NAME'] )
			? sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) )
			: null;
		return self::$conf['debug'] || preg_match( '/^([^\.]+\.)?localhost/i', $server_name );
	}
}

Adtechmedia_Config::setup_endpoints();

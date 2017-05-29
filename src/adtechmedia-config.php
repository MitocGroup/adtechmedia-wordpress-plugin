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
		'api_end_point'                  => 'https://api.adtechmedia.io/v1/',
		'plugin_table_name'              => 'adtechmedia',
		'plugin_cache_table_name'        => 'adtechmedia_cache',
		'maxTries'                       => 7,
		'minDelay'                       => 150000,
		'factor'                         => 1.7,
		'atm_js_cache_time'              => 86400,
		'template_position'              => '{"sticky":true,"width":"600px","offset_top":"20px","offset_left":"-60px","scrolling_offset_top":"100px"}',
		'template_overall_styles_patch'  => '@media (max-width: 991px) { .atm-targeted-container { width: 90% !important; left: 5% !important; transform: none !important; } } @media (max-width: 600px) { .atm-targeted-container { top: 0 !important; } }', /* @todo Replace responsive hotfix with smth sustainable and reliable */
		'template_overall_styles'        => '.atm-base-modal {background-color: #ffffff;}.atm-targeted-modal .atm-head-modal .atm-modal-heading {background-color: #ffffff;}.atm-targeted-modal{border: 1px solid #d3d3d3;}.atm-targeted-modal{box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);}.atm-base-modal .atm-footer{background-color: #fafafa;}.atm-base-modal .atm-footer{border: 1px solid #e3e3e3;}.atm-targeted-container .mood-block-info,.atm-targeted-modal,.atm-targeted-modal .atm-head-modal .atm-modal-body p,.atm-unlock-line .unlock-btn {font-family: \'Merriweather\', sans-serif;}',
		'template_overall_styles_inputs' => '{"background-color":"#ffffff","border":"1px solid #d3d3d3","font-family":"\'Merriweather\', sans-serif","box-shadow":"0 1px 2px 0 rgba(0, 0, 0, 0.1)","footer-background-color":"#fafafa","footer-border":"1px solid #e3e3e3"}',
		'sw_js_url'                      => 'https://www.adtechmedia.io/atm-admin/atm-build/sw.min.js',
		'register_url_tpl'               => 'https://www.adtechmedia.io/admin/accounts/signup/%s',
		'price'                          => 5,
		'content_offset'                 => 2,
		'payment_pledged'                => 2,
		'ads_video'                      => 'https://www.adtechmedia.io/adtechmedia-website/demo-vast.xml',
		'content_lock'                   => 'blur+scramble',
		'revenue_method'                 => 'advertising+micropayments',
		'price_currency'                 => 'usd',
		'content_paywall'                => 'transactions',
		'content_offset_type'            => 'paragraphs',
		'country'                        => 'United States',
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
	public static function set_api_end_point() {
		if ( self::is_localhost() ) {
			self::$conf['api_end_point'] 		= 'https://api-dev.adtechmedia.io/v1/';
			self::$conf['sw_js_url']     		= 'https://www-dev.adtechmedia.io/atm-admin/atm-build/sw.min.js';
			self::$conf['register_url_tpl'] = 'https://www-dev.adtechmedia.io/admin/accounts/signup/%s';
		}
	}

	/**
	 * Returns true if server IP is 127.0.0.1
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

Adtechmedia_Config::set_api_end_point();

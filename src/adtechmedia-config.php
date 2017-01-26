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
		'api_end_point' => 'https://api.adtechmedia.io/prod/',
		'plugin_table_name' => 'adtechmedia',
		'plugin_cache_table_name' => 'adtechmedia_cache',
		'maxTries' => 7,
		'minDelay' => 150000,
		'factor' => 1.7,
		'atm_js_cache_time' => 86400,
		'template_position' => '{"sticky":true,"width":"600px","offset_top":"20px","offset_left":"-60px","scrolling_offset_top":"100px"}',
		'template_overall_styles' => '.atm-base-modal {background-color: #ffffff;}.atm-targeted-modal .atm-head-modal .atm-modal-heading {background-color: #ffffff;}.atm-targeted-modal{border: 1px solid #d3d3d3;}.atm-targeted-modal{box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);}.atm-base-modal .atm-footer{background-color: #fafafa;}.atm-base-modal .atm-footer{border: 1px solid #e3e3e3;}.atm-targeted-container .mood-block-info,.atm-targeted-modal,.atm-targeted-modal .atm-head-modal .atm-modal-body p,.atm-unlock-line .unlock-btn {font-family: \'Merriweather\', sans-serif;}',
	];

	/**
	 * Function to get param value
	 *
	 * @param string $name kay name.
	 * @return mixed
	 */
	public static function get( $name ) {
		return self::$conf[ $name ];
	}
}

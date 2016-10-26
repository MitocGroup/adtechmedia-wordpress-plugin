<?php
/**
 * @file
 * Adtechmedia_Config
 *
 * @category Class
 * @package  Adtechmedia_Plugin
 * @author    yama-gs
 */
class Adtechmedia_Config {

	/**
	 * Plugin config
	 *
	 * @var array
	 */
	private static $conf = [
		'api_end_point' => 'https://api.adtechmedia.io/dev/',
		'plugin_table_name' => 'adtechmedia',
		'plugin_cache_table_name' => 'adtechmedia_cache',
		'maxTries' => 7,
		'minDelay' => 150000,
		'factor' => 1.7,
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

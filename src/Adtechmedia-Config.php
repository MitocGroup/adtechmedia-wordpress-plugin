<?php
/**
 * @file
 * Plugin config file
 */

/**
 * @package Adtechmedia_Plugin
 */
class Adtechmedia_Config {

	/**
	 * @var array plugin config
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
	 * function to get param value
	 * @param $name string config key
	 * @return mixed
	 */
	public static function get($name) {
		return self::$conf[$name];
	}
}

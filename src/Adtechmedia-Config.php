<?php

/**
 * Created by PhpStorm.
 * User: yama_gs
 * Date: 17.10.2016
 * Time: 14:01
 */

/**
 * @file
 * Plugin config file
 */
class Adtechmedia_Config
{

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
     * @param $name
     * @return mixed
     */
    public static function get($name)
    {
        return self::$conf[$name];
    }
}

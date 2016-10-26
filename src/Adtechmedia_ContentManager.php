<?php

/**
 * Created by PhpStorm.
 * User: yama_gs
 * Date: 19.10.2016
 * Time: 14:03
 */
class Adtechmedia_ContentManager {

	/**
	 * @return string
	 */
	private static function get_cache_table_name() {
		global $wpdb;
		return  $wpdb->prefix . Adtechmedia_Config::get( 'plugin_cache_table_name' );
	}

	/**
	 * @param $id
	 * @return null
	 */
	public static function get_content( $id ) {
		global $wpdb;
		$ret_val = null;
		$table_name = self::get_cache_table_name();
		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT value FROM $table_name WHERE item_id = %s LIMIT 1", $id )
		);

		if ( is_object( $row ) ) {
			$ret_val = $row->value;
		}

		return $ret_val;
	}

	/**
	 * @param $id
	 * @param $content
	 */
	public static function set_content( $id, $content ) {
		global $wpdb;
		$ret_val = null;
		$table_name = self::get_cache_table_name();
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO `$table_name` (`item_id`, `value`) VALUES (%s, %s) ON DUPLICATE KEY UPDATE `item_id` = VALUES(`item_id`), `value` = VALUES(`value`)",
				$id,
				$content
			)
		);
	}

	/**
	 * @param $id
	 */
	public static function clear_content( $id ) {
		global $wpdb;
		$table_name = self::get_cache_table_name();
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE `$table_name` SET  `value` = '' WHERE `item_id` = %s ",
				$id
			)
		);
	}
	public static function clear_all_content() {
		global $wpdb;
		$table_name = self::get_cache_table_name();
		$wpdb->query( "UPDATE `$table_name` SET  `value` = '' " );
	}
}

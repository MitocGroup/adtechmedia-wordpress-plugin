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
	private static function getCacheTableName() {
		global $wpdb;
		return  $wpdb->prefix . Adtechmedia_Config::get( 'plugin_cache_table_name' );
	}

	/**
	 * @param $id
	 * @return null
	 */
	public static function getContent( $id ) {
		global $wpdb;
		$retVal = null;
		$tableName = self::getCacheTableName();
		$row = $wpdb->get_row(
			$wpdb->prepare( "SELECT value FROM $tableName WHERE item_id = %s LIMIT 1", $id )
		);

		if ( is_object( $row ) ) {
			$retVal = $row->value;
		}

		return $retVal;
	}

	/**
	 * @param $id
	 * @param $content
	 */
	public static function setContent( $id, $content ) {
		global $wpdb;
		$retVal = null;
		$tableName = self::getCacheTableName();
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO `$tableName` (`item_id`, `value`) VALUES (%s, %s) ON DUPLICATE KEY UPDATE `item_id` = VALUES(`item_id`), `value` = VALUES(`value`)",
				$id,
				$content
			)
		);
	}

	/**
	 * @param $id
	 */
	public static function clearContent( $id ) {
		global $wpdb;
		$tableName = self::getCacheTableName();
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE `$tableName` SET  `value` = '' WHERE `item_id` = %s ",
				$id
			)
		);
	}
	public static function clearAllContent() {
		global $wpdb;
		$tableName = self::getCacheTableName();
		$wpdb->query( "UPDATE `$tableName` SET  `value` = '' " );
	}
}

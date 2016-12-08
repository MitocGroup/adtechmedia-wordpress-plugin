<?php
/**
 * Adtechmedia_ContentManager
 *
 * @category Class
 * @package  Adtechmedia_Plugin
 * @author   yamagleb
 */

/**
 * Class Adtechmedia_ContentManager
 */
class Adtechmedia_ContentManager {

	/**
	 * Get name of table with cache of articles
	 *
	 * @return string
	 */
	private static function get_cache_table_name() {
		global $wpdb;
		return $wpdb->prefix . Adtechmedia_Config::get( 'plugin_cache_table_name' );
	}

	/**
	 * Get content of article by id
	 *
	 * @param integer $id id of article.
	 * @return null
	 */
	public static function get_content( $id ) {
		global $wpdb;

		$table_name = self::get_cache_table_name();
		$ret_val = wp_cache_get( $id, 'adtechmedia_scrambled_contents' );
		if ( ! $ret_val ) {
			// @codingStandardsIgnoreStart
			$row = $wpdb->get_row(
				$wpdb->prepare( "SELECT value FROM `$table_name` WHERE item_id = %s LIMIT 1", $id )
			);
			// @codingStandardsIgnoreEnd
			if ( is_object( $row ) ) {
				$ret_val = $row->value;
			}
			wp_cache_set( $id, $ret_val, 'adtechmedia_scrambled_contents', 30 );
		}

		return $ret_val;
	}

	/**
	 * Set content of article
	 *
	 * @param integer $id id of article.
	 * @param string  $content content of article.
	 */
	public static function set_content( $id, $content ) {
		global $wpdb;
		$ret_val = null;
		$table_name = self::get_cache_table_name();
		// @codingStandardsIgnoreStart
		$wpdb->query(
			$wpdb->prepare(
				"INSERT INTO `$table_name` (`item_id`, `value`) VALUES (%s, %s) ON DUPLICATE KEY UPDATE `item_id` = VALUES(`item_id`), `value` = VALUES(`value`)",
				$id,
				$content
			)
		);
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Clear cached content of article by id
	 *
	 * @param integer $id id of article.
	 */
	public static function clear_content( $id ) {
		global $wpdb;
		$table_name = self::get_cache_table_name();
		// @codingStandardsIgnoreStart
		$wpdb->update( $table_name, [ 'value' => '' ], [ 'item_id' => $id ] );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Clear cached content of all articles
	 */
	public static function clear_all_content() {
		global $wpdb;
		$table_name = self::get_cache_table_name();
		// @codingStandardsIgnoreStart
		$wpdb->query( "UPDATE `$table_name` SET  `value` = '' ");
		// @codingStandardsIgnoreEnd
	}
}

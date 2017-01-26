<?php
/**
 * "WordPress Plugin Template" Copyright (C) 2016 Michael Simpson  (email : michael.d.simpson@gmail.com)
 * This file is part of WordPress Plugin Template for WordPress.
 * WordPress Plugin Template is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * WordPress Plugin Template is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Contact Form to Database Extension.
 * If not, see http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @category File
 * @package  Adtechmedia_LifeCycle
 * @author   yamagleb
 */

/**
 * Inclide Adtechmedia_InstallIndicator
 */
include_once( 'adtechmedia-installindicator.php' );

/**
 * Class Adtechmedia_LifeCycle
 */
class Adtechmedia_LifeCycle extends Adtechmedia_InstallIndicator {

	/**
	 * Install plugin
	 */
	public function install() {

		// Initialize Plugin Options.
		$this->init_options();

		// Initialize DB Tables used by the plugin.
		$this->install_database_tables();

		// Other Plugin initialization - for the plugin writer to override as needed.
		$this->other_install();

		// Record the installed version.
		$this->save_installed_version();

		// To avoid running install() more then once.
		$this->mark_as_installed();

		// Set server options for Service Worker.
		Adtechmedia_ServerOptions::set_options();
	}

	/**
	 * Uninstall plugin
	 */
	public function uninstall() {
		$this->other_uninstall();
		$this->un_install_database_tables();
		$this->delete_saved_options();
		$this->mark_as_un_installed();
	}

	/**
	 * Perform any version-upgrade activities prior to activation (e.g. database changes)
	 *
	 * @return void
	 */
	public function upgrade() {
	}

	/**
	 * Activation of plugin
	 * See: http://plugin.michael-simpson.com/?page_id=105
	 *
	 * @return void
	 */
	public function activate() {
		$website = get_home_url();
		$name = preg_replace( '/https?:\/\//', '', $website );
		$admin_email = get_option( 'admin_email' );
		$this->add_plugin_option( 'container', '#content-for-atm' );
		$this->add_plugin_option( 'selector', 'p,ol,ul,h1,h2,h3,h4,h5,h6,div,figure' );
		$this->add_plugin_option( 'price', '5' );
		$this->add_plugin_option( 'author_name', '' );
		$this->add_plugin_option( 'author_avatar', '' );
		$this->add_plugin_option( 'ads_video', '' );
		$this->add_plugin_option( 'website_domain_name', $name );
		$this->add_plugin_option( 'website_url', $website );
		$this->add_plugin_option( 'support_email', $admin_email );
		$this->add_plugin_option( 'country', 'United States' );
		$this->add_plugin_option( 'content_offset', '2' );
		$this->add_plugin_option( 'content_lock', 'blur+scramble' );
		$this->add_plugin_option( 'revenue_method', 'micropayments' );
		$this->add_plugin_option( 'payment_pledged', '2' );
		$this->add_plugin_option( 'price_currency', 'usd' );
		$this->add_plugin_option( 'content_paywall', 'transactions' );
		$this->add_plugin_option( 'content_offset_type', 'paragraphs' );
		$this->add_plugin_option( 'template_position', Adtechmedia_Config::get( 'template_position' ) );
		$this->add_plugin_option( 'template_overall_styles', Adtechmedia_Config::get( 'template_overall_styles' ) );
		$this->check_api_key_exists();
		$this->check_prop();

		// Add schedule event update properties.
		wp_clear_scheduled_hook( 'adtechmedia_update_event' );
		wp_schedule_event( time(), 'daily', 'adtechmedia_update_event' );
	}

	/**
	 * Check API key is exists
	 *
	 * @return bool
	 */
	public function check_api_key_exists() {
		$key = $this->get_plugin_option( 'key' );
		if ( empty( $key ) ) {
			$key = Adtechmedia_Request::api_key_create(
				$this->get_plugin_option( 'website_domain_name' ),
				$this->get_plugin_option( 'website_url' )
			);
			if ( empty( $key ) ) {
				return false;
			} else {
				$this->add_plugin_option( 'key', $key );
			}
		}
		return true;
	}


	/**
	 * Check property is exists
	 *
	 * @return bool
	 */
	public function check_prop() {
		$key = $this->get_plugin_option( 'key' );
		if ( ! empty( $key ) ) {
			$id = $this->get_plugin_option( 'Id' );
			if ( empty( $id ) ) {
				$prop = Adtechmedia_Request::property_create(
					$this->get_plugin_option( 'website_domain_name' ),
					$this->get_plugin_option( 'website_url' ),
					$this->get_plugin_option( 'support_email' ),
					$this->get_plugin_option( 'country' ),
					$key
				);
				if ( ( ! isset( $prop['Id'] )) || empty( $prop['Id'] ) ) {
					return false;
				} else {
					$this->add_plugin_option( 'BuildPath', $prop['BuildPath'] );
					$this->add_plugin_option( 'Id', $prop['Id'] );
					$this->update_prop();
				}
			}
		}
		return true;
	}


	/**
	 * Deactivation of plugin
	 * See: http://plugin.michael-simpson.com/?page_id=105
	 *
	 * @return void
	 */
	public function deactivate() {
		wp_clear_scheduled_hook( 'adtechmedia_update_event' );
	}

	/**
	 * Init options
	 * See: http://plugin.michael-simpson.com/?page_id=31
	 *
	 * @return void
	 */
	protected function init_options() {
	}

	/**
	 * Add actions and filters
	 */
	public function add_actions_and_filters() {
	}

	/**
	 * See: http://plugin.michael-simpson.com/?page_id=101
	 * Called by install() to create any database tables if needed.
	 * Best Practice:
	 * (1) Prefix all table names with $wpdb->prefix
	 * (2) make table names lower case only
	 *
	 * @return void
	 */
	protected function install_database_tables() {
	}

	/**
	 * See: http://plugin.michael-simpson.com/?page_id=101
	 * Drop plugin-created tables on uninstall.
	 *
	 * @return void
	 */
	protected function un_install_database_tables() {
	}

	/**
	 * Override to add any additional actions to be done at install time
	 * See: http://plugin.michael-simpson.com/?page_id=33
	 *
	 * @return void
	 */
	protected function other_install() {
	}

	/**
	 * Override to add any additional actions to be done at uninstall time
	 * See: http://plugin.michael-simpson.com/?page_id=33
	 *
	 * @return void
	 */
	protected static function other_uninstall() {
	}

	/**
	 * Puts the configuration page in the Plugins menu by default.
	 * Override to put it elsewhere or create a set of submenus
	 * Override with an empty implementation if you don't want a configuration page
	 *
	 * @return void
	 */
	public function add_settings_sub_menu_page() {
		$this->add_settings_sub_menu_page_to_plugins_menu();
	}


	/**
	 * Require extra plugin files
	 */
	protected function require_extra_plugin_files() {
		require_once( ABSPATH . 'wp-includes/pluggable.php' );
		require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
	}

	/**
	 * Get setting slug
	 *
	 * @return string Slug name for the URL to the Setting page
	 * (i.e. the page for setting options)
	 */
	protected function get_settings_slug() {
		return get_class( $this ) . 'Settings';
	}

	/**
	 * Add page to plugin menu
	 */
	protected function add_settings_sub_menu_page_to_plugins_menu() {
		$this->require_extra_plugin_files();
		$display_name = $this->get_plugin_display_name();
		add_submenu_page(
			'plugins.php',
			$display_name,
			$display_name,
			'manage_options',
			$this->get_settings_slug(),
			array( &$this, 'settings_page' )
		);
	}

	/**
	 * Add page to settings menu
	 */
	protected function add_settings_sub_menu_page_to_settings_menu() {
		$this->require_extra_plugin_files();
		$display_name = $this->get_plugin_display_name();
		add_options_page(
			$display_name,
			$display_name,
			'manage_options',
			$this->get_settings_slug(),
			array( &$this, 'settings_page' )
		);
	}

	/**
	 * Get plugin table prefix
	 *
	 * @param  string $name name of a database table.
	 * @return string input prefixed with the WordPress DB table prefix
	 * plus the prefix for this plugin (lower-cased) to avoid table name collisions.
	 * The plugin prefix is lower-cases as a best practice that all DB table names are lower case to
	 * avoid issues on some platforms
	 */
	public function prefix_table_name( $name ) {
		global $wpdb;
		return $wpdb->prefix . $name;
	}


	/**
	 * Convenience function for creating AJAX URLs.
	 *
	 * @param string $action_name the name of the ajax action registered in a call.
	 * @return string URL that can be used in a web page to make an Ajax call to $this->functionName
	 * Example
	 * add_action('wp_ajax_actionName', array(&$this, 'functionName'));
	 *     and/or
	 * add_action('wp_ajax_nopriv_actionName', array(&$this, 'functionName'));
	 * If have an additional parameters to add to the Ajax call, e.g. an "id" parameter,
	 * you could call this function and append to the returned string like:
	 *    $url = $this->getAjaxUrl('myaction&id=') . urlencode($id);
	 * or more complex:
	 *    $url = sprintf($this->getAjaxUrl('myaction&id=%s&var2=%s&var3=%s'), urlencode($id), urlencode($var2), urlencode($var3));
	 */
	public function get_ajax_url( $action_name ) {
		return admin_url( 'admin-ajax.php' ) . '?action=' . $action_name;
	}

}

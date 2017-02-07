<?php
/**
 * Adtechmedia_ThemeManager
 *
 * @category Class
 * @package  Adtechmedia_Plugin
 * @author   yamagleb
 */

/**
 * Class Adtechmedia_ThemeManager
 */
class Adtechmedia_ThemeManager {

	/**
	 * Init first config theme.
	 */
	public static function init_theme_config_model() {
		$option_manager = new Adtechmedia_OptionsManager();

		$new_cur_theme_id = 'default';
		$theme_history = $option_manager->get_plugin_option( 'themes_history' );
		if ( '' !== $theme_history && '{}' !== $theme_history ) {
			$theme_history = json_decode( $theme_history, true );
			if ( is_array( $theme_history ) ) {
				$theme_info = self::get_theme_info();
				if ( array_key_exists( $theme_info['ThemeName'], $theme_history ) ) {
					$new_cur_theme_id = $theme_history[ $theme_info['ThemeName'] ];
				} else {
					$new_cur_theme_id = 'default';
				}
			}
			$option_manager->update_plugin_option( 'theme_config_id', $new_cur_theme_id );
		}
		$is_retrieve = self::retrieve_current_theme_configs();

		if ( ! $is_retrieve ) {
			$option_manager->update_plugin_option( 'theme_config_id', 'default' );
			$option_manager->update_plugin_option( 'theme_config_name', '' );
			$option_manager->update_plugin_option( 'template_position', Adtechmedia_Config::get( 'template_position' ) );
			$option_manager->update_plugin_option( 'template_overall_styles', Adtechmedia_Config::get( 'template_overall_styles' ) );
			$option_manager->update_plugin_option( 'template_overall_styles_inputs', Adtechmedia_Config::get( 'template_overall_styles_inputs' ) );
		} else {
			if ( array_key_exists( 'Default', $is_retrieve ) && true === $is_retrieve['Default'] ) {
				$option_manager->update_plugin_option( 'theme_config_id', 'default' );
			} else {
				$option_manager->update_plugin_option( 'theme_config_id', $is_retrieve['Id'] );
			}
			$option_manager->update_plugin_option( 'theme_config_name', $is_retrieve['ConfigName'] );
			$option_manager->update_plugin_option( 'template_position',
				array_key_exists( 'template_position', $is_retrieve['Config'] ) ?
					$is_retrieve['Config']['template_position'] :
					Adtechmedia_Config::get( 'template_position' )
			);
			$option_manager->update_plugin_option( 'template_overall_styles',
				array_key_exists( 'template_overall_styles', $is_retrieve['Config'] ) ?
					$is_retrieve['Config']['template_overall_styles'] :
					Adtechmedia_Config::get( 'template_overall_styles' )
			);
			$option_manager->update_plugin_option( 'template_overall_styles_inputs',
				array_key_exists( 'template_overall_styles_inputs', $is_retrieve['Config'] ) ?
					$is_retrieve['Config']['template_overall_styles_inputs'] :
					Adtechmedia_Config::get( 'template_overall_styles_inputs' )
			);
		}

		self::add_current_theme_to_themes_history();

		self::save_template_in_api();
	}

	/**
	 * Get current theme info.
	 *
	 * @return array
	 */
	public static function get_theme_info() {
		$theme = wp_get_theme();

		return [
			'ThemeVersion' => $theme->get( 'Version' ),
			'ThemeName'    => $theme->get( 'Name' ),
			'ThemeId'      => '',
		];
	}

	/**
	 * Get platform info.
	 *
	 * @return array
	 */
	public static function get_platform_info() {
		return [
			'PlatformId'      => 'Wordpress',
			'PlatformVersion' => get_bloginfo( 'version' ),
		];
	}

	/**
	 * Get current theme config.
	 *
	 * @return array
	 */
	public static function get_current_theme_config() {
		$option_manager = new Adtechmedia_OptionsManager();

		return [
			'template_position'              => $option_manager->get_plugin_option( 'template_position' ),
			'template_overall_styles'        => $option_manager->get_plugin_option( 'template_overall_styles' ),
			'template_overall_styles_inputs' => $option_manager->get_plugin_option( 'template_overall_styles_inputs' ),
		];
	}

	/**
	 * Save current theme config to db and api.
	 */
	public static function save_current_theme_configs() {
		$option_manager   = new Adtechmedia_OptionsManager();
		$current_config_id = $option_manager->get_plugin_option( 'theme_config_id' );
		if ( is_null( $current_config_id ) || '' === $current_config_id || 'default' === $current_config_id ) {
			self::create_current_theme_configs();
		} else {
			self::update_current_theme_configs();
		}
	}

	/**
	 * Create current theme config to db and api.
	 *
	 * @return array|bool|mixed|object
	 */
	public static function create_current_theme_configs() {
		$option_manager = new Adtechmedia_OptionsManager();

		$current_theme_info    = self::get_theme_info();
		$current_platform_info = self::get_platform_info();
		$current_theme_configs = self::get_current_theme_config();

		$data = [
			'ThemeId'         => $current_theme_info['ThemeName'] . '@' . $current_theme_info['ThemeVersion'],
			'PropertyId'      => $option_manager->get_plugin_option( 'id' ),
			'ThemeVersion'    => $current_theme_info['ThemeVersion'],
			'ThemeName'       => $current_theme_info['ThemeName'],
			'PlatformId'      => $current_platform_info['PlatformId'],
			'PlatformVersion' => $current_platform_info['PlatformVersion'],
			'ConfigName'      => $current_theme_info['ThemeName'] . '@' . $current_theme_info['ThemeVersion'] . '-' . date( 'c' ),
			'Config'          => $current_theme_configs,
		];

		$result = Adtechmedia_Request::theme_config_create(
			$data,
			$option_manager->get_plugin_option( 'key' )
		);

		if ( $result ) {
			$option_manager->update_plugin_option( 'theme_config_id', $result['Id'] );
			$option_manager->update_plugin_option( 'theme_config_name', $result['ConfigName'] );
			$option_manager->update_plugin_option( 'template_position',
				array_key_exists( 'template_position', $result['Config'] ) ?
					$result['Config']['template_position'] :
					''
			);
			$option_manager->update_plugin_option( 'template_overall_styles',
				array_key_exists( 'template_overall_styles', $result['Config'] ) ?
					$result['Config']['template_overall_styles'] :
					''
			);
			$option_manager->update_plugin_option( 'template_overall_styles_inputs',
				array_key_exists( 'template_overall_styles_inputs', $result['Config'] ) ?
					$result['Config']['template_overall_styles_inputs'] :
					''
			);

			self::add_current_theme_to_themes_history();
		}

		return $result;
	}

	/**
	 * Retrieve theme config from api.
	 *
	 * @return array|bool|mixed|object
	 */
	public static function retrieve_current_theme_configs() {
		$option_manager = new Adtechmedia_OptionsManager();

		$theme_history = $option_manager->get_plugin_option( 'themes_history' );
		$current_theme_id = '';
		if ( '' !== $theme_history && '{}' !== $theme_history ) {
			$theme_history = json_decode( $theme_history, true );
			if ( is_array( $theme_history ) ) {
				$theme_info = self::get_theme_info();
				if ( array_key_exists( $theme_info['ThemeName'], $theme_history ) ) {
					$current_theme_id = $theme_history[ $theme_info['ThemeName'] ];
				} else {
					$current_theme_id = '';
				}
			}
			$option_manager->update_plugin_option( 'theme_config_id', 'default' );
		}

		if ( ! is_null( $current_theme_id ) && 'default' !== $current_theme_id && '' !== $current_theme_id ) {
			return Adtechmedia_Request::theme_config_retrieve(
				$current_theme_id,
				null,
				$option_manager->get_plugin_option( 'key' )
			);
		} else {
			$current_theme_info = self::get_theme_info();

			$current_theme_config = Adtechmedia_Request::theme_config_retrieve(
				null,
				$current_theme_info['ThemeName'] . '@' . $current_theme_info['ThemeVersion'],
				$option_manager->get_plugin_option( 'key' )
			);
			if ( $current_theme_config ) {
				return $current_theme_config;
			} else {
				return Adtechmedia_Request::theme_config_retrieve(
					null,
					$current_theme_info['ThemeName'],
					$option_manager->get_plugin_option( 'key' )
				);
			}
		}

	}

	/**
	 * Update current theme config in db and api.
	 *
	 * @return array|bool|mixed|object
	 */
	public static function update_current_theme_configs() {
		$option_manager = new Adtechmedia_OptionsManager();

		$current_theme_id      = $option_manager->get_plugin_option( 'theme_config_id' );
		$current_theme_configs = self::get_current_theme_config();

		$data = [
			'Id'     => $current_theme_id,
			'Config' => $current_theme_configs,
		];
		self::add_current_theme_to_themes_history();

		return Adtechmedia_Request::theme_config_update(
			$data,
			$option_manager->get_plugin_option( 'key' )
		);
	}

	/**
	 * Add current theme to switch history.     *
	 */
	public static function add_current_theme_to_themes_history() {
		$need_create    = false;
		$option_manager = new Adtechmedia_OptionsManager();

		$themes_history = $option_manager->get_plugin_option( 'themes_history' );
		if ( is_null( $themes_history ) ) {
			$themes_history = [];
			$need_create    = true;
		} else {
			$themes_history = json_decode( $themes_history, true );
		}
		$current_theme_info = self::get_theme_info();
		$current_theme_id   = $option_manager->get_plugin_option( 'theme_config_id' );
		if ( ! is_null( $current_theme_id ) ) {
			$themes_history[ $current_theme_info['ThemeName'] ] = $current_theme_id;

			if ( $need_create ) {
				$option_manager->add_plugin_option( 'themes_history', json_encode( $themes_history ) );
			} else {
				$option_manager->update_plugin_option( 'themes_history', json_encode( $themes_history ) );
			}
		}

	}


	/**
	 * Save themes in template api.
	 */
	public static function save_template_in_api() {
		$adt_plugin     = new Adtechmedia_Plugin();
		$option_manager = new Adtechmedia_OptionsManager();
		$adt_plugin->update_prop();

		$data = [
			'targetModal' => [
				'targetCb' => $option_manager->get_target_cb_js( json_decode( stripslashes( $option_manager->get_plugin_option( 'template_position' ) ), true ) ),
				'toggleCb' => $option_manager->get_toggle_cb_js( json_decode( stripslashes( $option_manager->get_plugin_option( 'template_position' ) ), true ) ),
			],
			'styles'      => [
				'main' => base64_encode( $option_manager->get_plugin_option( 'template_overall_styles' ) ),
			],
		];

		Adtechmedia_Request::property_update_config_by_array(
			$option_manager->get_plugin_option( 'id' ),
			$option_manager->get_plugin_option( 'key' ),
			$data
		);
	}

	/**
	 * Make default config to current theme
	 */
	public static function make_current_as_default() {
		$option_manager = new Adtechmedia_OptionsManager();
		$option_manager->update_plugin_option( 'theme_config_id', 'default' );
		self::add_current_theme_to_themes_history();
	}

}
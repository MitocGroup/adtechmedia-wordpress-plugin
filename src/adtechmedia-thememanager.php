<?php

/**
 * Class Adtechmedia_ThemeManager
 */
class Adtechmedia_ThemeManager {

	/**
	 * Init first config theme.
	 */
	public static function init_theme_config_model() {
		$optionManager = new Adtechmedia_OptionsManager();

		$themeHistory = $optionManager->get_plugin_option( 'themes_history' );
		if ( '' !== $themeHistory && '{}' !== $themeHistory ) {
			$themeHistory = json_decode( $themeHistory, true );
			if ( is_array( $themeHistory ) ) {
				$themeInfo = self::get_theme_info();
				if ( array_key_exists( $themeInfo['ThemeName'], $themeHistory ) ) {
					$newCurThemeId = $themeHistory[ $themeInfo['ThemeName'] ];
				} else {
					$newCurThemeId = 'default';
				}
			}
			$optionManager->update_plugin_option( 'theme_config_id', $newCurThemeId );
		}
		$isRetrieve = self::retrieve_current_theme_configs();

		if ( ! $isRetrieve ) {
			$optionManager->update_plugin_option( 'theme_config_id', 'default' );
			$optionManager->update_plugin_option( 'theme_config_name', '' );
			$optionManager->update_plugin_option( 'template_position', Adtechmedia_Config::get( 'template_position' ) );
			$optionManager->update_plugin_option( 'template_overall_styles', Adtechmedia_Config::get( 'template_overall_styles' ) );
			$optionManager->update_plugin_option( 'template_overall_styles_inputs', Adtechmedia_Config::get( 'template_overall_styles_inputs' ) );
		} else {
			if ( array_key_exists( 'Default', $isRetrieve ) && true === $isRetrieve['Default'] ) {
				$optionManager->update_plugin_option( 'theme_config_id', 'default' );
			} else {
				$optionManager->update_plugin_option( 'theme_config_id', $isRetrieve['Id'] );
			}
			$optionManager->update_plugin_option( 'theme_config_name', $isRetrieve['ConfigName'] );
			$optionManager->update_plugin_option( 'template_position',
				array_key_exists( 'template_position', $isRetrieve['Config'] ) ?
					$isRetrieve['Config']['template_position'] :
					Adtechmedia_Config::get( 'template_position' )
			);
			$optionManager->update_plugin_option( 'template_overall_styles',
				array_key_exists( 'template_overall_styles', $isRetrieve['Config'] ) ?
					$isRetrieve['Config']['template_overall_styles'] :
					Adtechmedia_Config::get( 'template_overall_styles' )
			);
			$optionManager->update_plugin_option( 'template_overall_styles_inputs',
				array_key_exists( 'template_overall_styles_inputs', $isRetrieve['Config'] ) ?
					$isRetrieve['Config']['template_overall_styles_inputs'] :
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
		$optionManager = new Adtechmedia_OptionsManager();

		return [
			'template_position'              => $optionManager->get_plugin_option( 'template_position' ),
			'template_overall_styles'        => $optionManager->get_plugin_option( 'template_overall_styles' ),
			'template_overall_styles_inputs' => $optionManager->get_plugin_option( 'template_overall_styles_inputs' ),
		];
	}

	/**
	 * Save current theme config to db and api.
	 */
	public static function save_current_theme_configs() {
		$optionManager   = new Adtechmedia_OptionsManager();
		$currentConfigId = $optionManager->get_plugin_option( 'theme_config_id' );
		if ( is_null( $currentConfigId ) || '' === $currentConfigId || 'default' === $currentConfigId ) {
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
		$optionManager = new Adtechmedia_OptionsManager();

		$currentThemeInfo    = self::get_theme_info();
		$currentPlatformInfo = self::get_platform_info();
		$currentThemeConfigs = self::get_current_theme_config();

		$data = [
			'ThemeId'         => $currentThemeInfo['ThemeName'] . '@' . $currentThemeInfo['ThemeVersion'],
			'PropertyId'      => $optionManager->get_plugin_option( 'id' ),
			'ThemeVersion'    => $currentThemeInfo['ThemeVersion'],
			'ThemeName'       => $currentThemeInfo['ThemeName'],
			'PlatformId'      => $currentPlatformInfo['PlatformId'],
			'PlatformVersion' => $currentPlatformInfo['PlatformVersion'],
			'ConfigName'      => $currentThemeInfo['ThemeName'] . '@' . $currentThemeInfo['ThemeVersion'] . '-' . date( 'c' ),
			'Config'          => $currentThemeConfigs,
		];

		$result = Adtechmedia_Request::theme_config_create(
			$data,
			$optionManager->get_plugin_option( 'key' )
		);

		if ( $result ) {
			$optionManager->update_plugin_option( 'theme_config_id', $result['Id'] );
			$optionManager->update_plugin_option( 'theme_config_name', $result['ConfigName'] );
			$optionManager->update_plugin_option( 'template_position',
				array_key_exists( 'template_position', $result['Config'] ) ?
					$result['Config']['template_position'] :
					''
			);
			$optionManager->update_plugin_option( 'template_overall_styles',
				array_key_exists( 'template_overall_styles', $result['Config'] ) ?
					$result['Config']['template_overall_styles'] :
					''
			);
			$optionManager->update_plugin_option( 'template_overall_styles_inputs',
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
		$optionManager = new Adtechmedia_OptionsManager();

//		$currentThemeId = $optionManager->get_plugin_option( 'theme_config_id' );
		$themeHistory = $optionManager->get_plugin_option( 'themes_history' );
		if ( '' !== $themeHistory && '{}' !== $themeHistory ) {
			$themeHistory = json_decode( $themeHistory, true );
			if ( is_array( $themeHistory ) ) {
				$themeInfo = self::get_theme_info();
				if ( array_key_exists( $themeInfo['ThemeName'], $themeHistory ) ) {
					$currentThemeId = $themeHistory[ $themeInfo['ThemeName'] ];
				} else {
					$currentThemeId = '';
				}
			}
			$optionManager->update_plugin_option( 'theme_config_id', 'default' );
		}

		if ( ! is_null( $currentThemeId ) && 'default' !== $currentThemeId && '' !== $currentThemeId ) {
			return Adtechmedia_Request::theme_config_retrieve(
				$currentThemeId,
				null,
				$optionManager->get_plugin_option( 'key' )
			);
		} else {
			$currentThemeInfo = self::get_theme_info();

			$currentThemeConfig = Adtechmedia_Request::theme_config_retrieve(
				null,
				$currentThemeInfo['ThemeName'] . '@' . $currentThemeInfo['ThemeVersion'],
				$optionManager->get_plugin_option( 'key' )
			);
			if ( $currentThemeConfig ) {
				return $currentThemeConfig;
			} else {
				return Adtechmedia_Request::theme_config_retrieve(
					null,
					$currentThemeInfo['ThemeName'],
					$optionManager->get_plugin_option( 'key' )
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
		$optionManager = new Adtechmedia_OptionsManager();

		$currentThemeId      = $optionManager->get_plugin_option( 'theme_config_id' );
		$currentThemeConfigs = self::get_current_theme_config();

		$data = [
			'Id'     => $currentThemeId,
			'Config' => $currentThemeConfigs,
		];
		self::add_current_theme_to_themes_history();

		return Adtechmedia_Request::theme_config_update(
			$data,
			$optionManager->get_plugin_option( 'key' )
		);
	}

	/**
	 * Add current theme to switch history.     *
	 */
	public static function add_current_theme_to_themes_history() {
		$needCreate    = false;
		$optionManager = new Adtechmedia_OptionsManager();

		$themesHistory = $optionManager->get_plugin_option( 'themes_history' );
		if ( is_null( $themesHistory ) ) {
			$themesHistory = [];
			$needCreate    = true;
		} else {
			$themesHistory = json_decode( $themesHistory, true );
		}
		$currentThemeInfo = self::get_theme_info();
		$currentThemeId   = $optionManager->get_plugin_option( 'theme_config_id' );
		if ( ! is_null( $currentThemeId ) ) {
			$themesHistory[ $currentThemeInfo['ThemeName'] ] = $currentThemeId;

			if ( $needCreate ) {
				$optionManager->add_plugin_option( 'themes_history', json_encode( $themesHistory ) );
			} else {
				$optionManager->update_plugin_option( 'themes_history', json_encode( $themesHistory ) );
			}
		}

	}


	/**
	 * Save themes in template api.
	 */
	public static function save_template_in_api() {
		$adtPlugin     = new Adtechmedia_Plugin();
		$optionManager = new Adtechmedia_OptionsManager();
		$adtPlugin->update_prop();

		$data = [
			'targetModal' => [
				'targetCb' => $optionManager->get_target_cb_js( json_decode( stripslashes( $optionManager->get_plugin_option( 'template_position' ) ), true ) ),
				'toggleCb' => $optionManager->get_toggle_cb_js( json_decode( stripslashes( $optionManager->get_plugin_option( 'template_position' ) ), true ) ),
			],
			'styles'      => [
				'main' => base64_encode( $optionManager->get_plugin_option( 'template_overall_styles' ) ),
			],
		];

		Adtechmedia_Request::property_update_config_by_array(
			$optionManager->get_plugin_option( 'id' ),
			$optionManager->get_plugin_option( 'key' ),
			$data
		);
	}

	public static function make_current_as_default()
	{
		$optionManager = new Adtechmedia_OptionsManager();
		$optionManager->update_plugin_option('theme_config_id', 'default');
		self::add_current_theme_to_themes_history();
	}
}
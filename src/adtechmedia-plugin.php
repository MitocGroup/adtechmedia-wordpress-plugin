<?php
/**
 * Main plugin class
 *
 * @category File
 * @package  Adtechmedia_Plugin
 * @author   yamagleb
 */

/**
 * Inclide Adtechmedia_LifeCycle
 */
include_once( 'adtechmedia-lifecycle.php' );
include_once( 'adtechmedia-ab.php' );

/**
 * Class Adtechmedia_Plugin
 */
class Adtechmedia_Plugin extends Adtechmedia_LifeCycle {

	/**
	 * Variable indicate AMP view
	 *
	 * @var boolean $is_amp first value is false.
	 */
	protected $is_amp = false;

	/**
	 * Variable indicate that ATM enabled
	 *
	 * @var boolean $enabled first value is null.
	 */
	public $enabled = null;

	/**
	 * See: http://plugin.michael-simpson.com/?page_id=31
	 *
	 * @return array of option meta data.
	 */
	public function get_option_meta_data() {
		// http://plugin.michael-simpson.com/?page_id=31.
		return array();
	}

	/**
	 * Checking if value is ok and update the option based on API one
	 *
	 * @param string $api_name field name.
	 * @param string $api_value filed value.
	 */
	private function update_from_api_option( $api_name, $api_value ) {
		if ( ! ctype_space( $api_name ) ) {
			$this->update_plugin_option( $api_name, $api_value );
		}
	}
	/**
	 * Transform UN into Country Name
	 *
	 * @param string $un UN name of country.
	 * @return string
	 */
	function country_UN_to_full( $un ) {
		$list = Adtechmedia_Request::get_countries_list( $this->get_plugin_option( 'key' ) );
		foreach ( $list as $country ) {
			if ( $country['UN'] === $un ) {
				return $country['Name'];
			}
		}
	}
	/**
	 * Transform Full into Country UN
	 *
	 * @param string $name  name of country.
	 * @return string
	 */
	function country_full_to_UN( $name ) {
		$list = Adtechmedia_Request::get_countries_list( $this->get_plugin_option( 'key' ) );
		foreach ( $list as $country ) {
			if ( $country['Name'] === $name ) {
				return $country['UN'];
			}
		}
	}
	/**
	 * Gethering data from API and put it into mysql
	 */
	public function api_to_plugin_options() {
		$api_result = Adtechmedia_Request::property_retrieve();
		$pleded_types = [
			'count' => 'transactions',
			'amount' => 'pledged currency',
		];
		if ( $api_result ) {
			$this->update_from_api_option( 'price', $api_result['Config']['defaults']['payment']['price'] );
			$this->update_from_api_option( 'support_email', $api_result['SupportEmail'] );
			$this->update_from_api_option( 'country', $this->country_UN_to_full( $api_result['Country'] ) );
			$this->update_from_api_option( 'content_offset', $api_result['Config']['defaults']['content']['offset'] );
			$this->update_from_api_option( 'content_lock', $api_result['Config']['defaults']['content']['lock'] );
			$this->update_from_api_option( 'revenue_method', $api_result['Config']['defaults']['revenueMethod'] );
			$this->update_from_api_option( 'payment_pledged', $api_result['Config']['defaults']['payment']['pledged'] );
			$this->update_from_api_option( 'price_currency', $api_result['Config']['defaults']['payment']['currency'] );
			$this->update_from_api_option( 'content_paywall', $pleded_types[ $api_result['Config']['defaults']['payment']['pledgedType'] ] );
			$this->update_from_api_option( 'content_offset_type', $api_result['Config']['defaults']['content']['offsetType'] );

			$plugin_dir = plugin_dir_path( __FILE__ );
			$file       = $plugin_dir . '/js/atm.min.js';
			// @codingStandardsIgnoreStart
			@unlink( $file );
			// @codingStandardsIgnoreEnd

		}
	}

	/**
	 * Main plugin data fields
	 *
	 * @return array
	 */
	public function get_main_data() {
		return array(
			'key'                 => array( __( 'Key', 'adtechmedia-plugin' ) ),
			'BuildPath'           => array( __( 'BuildPath', 'adtechmediaplugin' ) ),
			'Id'                  => array( __( 'Id', 'adtechmedia-plugin' ) ),
			'website_domain_name' => array( __( 'website_domain_name', 'adtechmedia-plugin' ) ),
			'websit e_url'        => array( __( 'website_url', 'adtechmedia-plugin' ) ),
			'support_email'       => array( __( 'support_email', 'adtechmedia-plugin' ) ),
			'country'             => array( __( 'country', 'adtechmedia-plugin' ) ),
			'revenue_method'      => array(
				__( 'revenueMethod', 'adtechmedia-plugin' ),
				'micropayments',
				'advertising+micropayments',
				'advertising',
			),
		);
	}

	/**
	 * Plugin options fields
	 *
	 * @return array
	 */
	public function get_plugin_meta_data() {
		return array(
			'container'           => array( __( 'Article container', 'adtechmedia-plugin' ) ),
			'selector'            => array( __( 'Article selector', 'adtechmedia-plugin' ) ),
			'price'               => array( __( 'Price', 'adtechmedia-plugin' ) ),
			'author_name'         => array( __( 'Author name', 'adtechmedia-plugin' ) ),
			'author_avatar'       => array( __( 'Author avatar', 'adtechmedia-plugin' ) ),
			'ads_video'           => array( __( 'Link to video ad', 'adtechmedia-plugin' ) ),
			'content_offset'      => array( __( 'Offset', 'adtechmedia-plugin' ) ),
			'content_lock'        => array(
				__( 'Lock', 'adtechmedia-plugin' ),
				'blur+scramble',
				'blur',
				'scramble',
				'keywords',
			),
			'payment_pledged'     => array( __( 'payment.pledged', 'adtechmedia-plugin' ) ),
			'price_currency'      => array( __( 'price.currency', 'adtechmedia-plugin' ) ),
			'content_paywall'     => array( __( 'content.paywall', 'adtechmedia-plugin' ) ),
			'content_offset_type' => array( __( 'Offset type', 'adtechmedia-plugin' ) ),
			'ab_percentage' => array( __( 'A/B target audience', 'adtechmedia-plugin' ) ),
		);
	}

	/**
	 *  Init plugin options
	 */
	protected function init_options() {

		$options = $this->get_option_meta_data();
		if ( ! empty( $options ) ) {
			foreach ( $options as $key => $arr ) {
				if ( is_array( $arr ) && count( $arr > 1 ) ) {
					$this->add_option( $key, $arr[1] );
				}
			}
		}

	}

	/**
	 * Get plugin name
	 *
	 * @return string
	 */
	public function get_plugin_display_name() {
		return 'Adtechmedia';
	}

	/**
	 * Get plugin file
	 *
	 * @return string
	 */
	protected function get_main_plugin_file_name() {
		return 'adtechmedia.php';
	}


	/**
	 * Perform actions when upgrading from version X to version Y
	 * See: http://plugin.michael-simpson.com/?page_id=35
	 *
	 * @return void
	 */
	public function upgrade() {
	}

	/**
	 * Add plugin actions and filters
	 */
	public function add_actions_and_filters() {

		// Add options administration page.
		// http://plugin.michael-simpson.com/?page_id=47.
		if ( isset( $_SERVER['HTTPS'] )
				&& isset( $_SERVER['SERVER_PORT'] )
				&& ! empty( $_SERVER['HTTPS'] )
				&& 'off' !== sanitize_text_field( wp_unslash( $_SERVER['HTTPS'] ) )
				|| 443 === sanitize_text_field( wp_unslash( $_SERVER['SERVER_PORT'] ) )
		) {
			Mozilla\WP_SW_Manager::get_manager()->sw()->add_content( array(
							$this,
							'write_sw',
					)
			);
		}

		add_action( 'admin_menu',
			array(
				&$this,
				'add_settings_sub_menu_page',
			)
		);
		$property_id = $this->get_plugin_option( 'id' );
		$key         = $this->get_plugin_option( 'key' );

		// Add Actions & Filters.
		// http://plugin.michael-simpson.com/?page_id=37.
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts',
				array(
					&$this,
					'add_adtechmedia_admin_scripts',
				)
			);
		}
		add_action( 'save_post',
			array(
				&$this,
				'clear_cache_on_update',
			)
		);

		// Update properties event.
		add_action( 'adtechmedia_update_event',
			array(
				&$this,
				'update_prop',
			)
		);

		if ( ! is_admin() && ( empty( $key ) || empty( $property_id ) ) ) {
			return;
		}
		if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), $this->get_settings_slug() ) !== false ) {
			$key_check = false;

			try {
				$key_check = $this->check_api_key_exists();
			} catch ( Error $error ) {
				$this->key_error = $error->getMessage();
			}

			if ( empty( $this->get_plugin_option( 'key' ) ) ) {
				if ( ! $this->get_plugin_option( 'api-token-sent' ) ) {
					$this->send_api_token( true );
					$this->add_plugin_option( 'api-token-sent', true );
				}
			}

			$property_check = $this->check_prop();

			if ( ! $property_check ) {
				add_action( 'admin_notices',
					array(
						&$this,
						'property_id_not_exists_error',
					)
				);
			}
		}
		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts',
				array(
					&$this,
					'add_adtechmedia_scripts',
				)
			);
		}
		add_filter( 'after_setup_theme',
			array(
				&$this,
				'init_adtechmedia_AB',
			)
		);
		add_filter( 'pre_amp_render_post',
			array(
				&$this,
				'init_AMP',
			)
		);
		add_filter( 'the_content',
			array(
				&$this,
				'hide_content',
			),
			99999
		);// try do this after any other filter.

		/*
		 * Adding scripts & styles to all pages.
		 * Examples:
		 * wp_enqueue_script('jquery');
		 * wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
	     * wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
		 */

		// Register short codes.
		// http://plugin.michael-simpson.com/?page_id=39.
		// Register AJAX hooks.
		// http://plugin.michael-simpson.com/?page_id=41.
		if ( empty( $this->get_plugin_option( 'key' ) ) && $this->get_plugin_option( 'api-token-sent' ) ) {
			add_action( 'wp_ajax_send_api_token',
				array(
					&$this,
					'send_api_token',
				)
			);
		}
		add_action( 'wp_ajax_save_template',
			array(
				&$this,
				'ajax_save_template',
			)
		);
		add_action( 'wp_ajax_key_from_token',
			array(
				&$this,
				'key_from_token',
			)
		);
		add_action( 'wp_ajax_update_appearance',
			array(
				&$this,
				'one_update_appearance',
			)
		);
	}

	/**
	 * Page is AMP
	 */
	public function init_AMP() {
		$this->is_amp = true;
	}
	/**
	 * The first init function Adtechmedia_AB
	 */
	public function init_adtechmedia_AB() {
		$this->is_enabled();
	}
	/**
	 * Get key from token with API
	 */
	public function key_from_token() {
        // @codingStandardsIgnoreStart
		if ( isset( $_POST['atm_token'] ) && ! empty( $_POST['atm_token'] ) ) {
			$atm_token = sanitize_text_field( wp_unslash( $_POST['atm_token'] ) );
            // @codingStandardsIgnoreEnd

			$key_response = Adtechmedia_Request::api_token2key(
				$this->get_plugin_option( 'support_email' ),
				$atm_token
			);
			$key = $key_response['apiKey'];

			if ( ! empty( $key ) ) {
				$this->delete_plugin_option( 'api-token-sent' );
				$this->add_plugin_option( 'key', $key );
				$this->add_plugin_option( 'client-id', $key_response['clientId'] );
				$this->add_plugin_option( 'admin-redirect', true );
				$this->add_plugin_option( 'force-save-templates', true );
				$this->update_prop();
				$this->update_appearance();
        // @codingStandardsIgnoreStart
				echo $key;
        // @codingStandardsIgnoreEnd
			}
			wp_die();
		}
	}

	/**
	 * Redirect to admin page
	 */
	public function admin_redirect() {
		if ( isset( $_SERVER['SCRIPT_NAME'] ) ) {
			$base_path = sanitize_text_field( wp_unslash( $_SERVER['SCRIPT_NAME'] ) );
			$this->delete_plugin_option( 'admin-redirect' );
			wp_redirect( $base_path . '?page=Adtechmedia_PluginSettings' );
			die();
		}
	}

	/**
	 * Request an api token to be exchanged to an api key
	 *
	 * @param boolean $direct Direct call.
	 */
	public function send_api_token( $direct = false ) {
		$trigger = $direct;
		$is_ajax = false;
		$actual_link = ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' )
			. '://'
			. ( isset( $_SERVER['HTTP_HOST'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ) ) : 'localhost' )
			. ( isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' );

		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'adtechmedia-nonce' ) ) {
			$trigger = true;
			$is_ajax = true;
			$actual_link = isset( $_POST['return_link_tpl'] ) ? sanitize_text_field( wp_unslash( $_POST['return_link_tpl'] ) ) : $actual_link;
		}

		if ( $trigger ) {
			if ( preg_match( '/\?/', $actual_link ) ) {
				$actual_link .= '&';
			} else {
				$actual_link .= '?';
			}

			/* this is replaced on ATM backend side */
			$actual_link .= 'atm-token=%tmp-token%';

			Adtechmedia_Request::request_api_token(
				$this->get_plugin_option( 'support_email' ),
				$actual_link
			);

			if ( $is_ajax ) {
				echo 'ok';
				die();
			}
		} else if ( $is_ajax ) {
			echo 'ko';
			die();
		}
	}

	/**
	 * Get sw.min.js content.
	 */
	function write_sw() {
		$path = plugins_url( '/js/sw.min.js', __FILE__ );
		// @codingStandardsIgnoreStart
		echo file_get_contents( $path );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Save templates action
	 */
	public function ajax_save_template() {
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'adtechmedia-nonce' ) ) {
			// @codingStandardsIgnoreStart
			if ( isset( $_POST['revenueMethod'], $_POST['country'] ) ) {
				$revenue_method = sanitize_text_field( wp_unslash( $_POST['revenueMethod'] ) );
				$this->update_plugin_option( 'revenue_method', $revenue_method );

				$country = sanitize_text_field( wp_unslash( $_POST['country'] ) );
				$this->update_plugin_option( 'country', $country );

				$currency = sanitize_text_field( wp_unslash( $_POST['currency'] ) );
				$this->update_plugin_option( 'price_currency', $currency );

				Adtechmedia_Request::property_update(
					$this->get_plugin_option( 'id' ),
					$this->get_plugin_option( 'support_email' ),
					$this->country_full_to_UN( $country ),
					$this->get_plugin_option( 'key' )
				);
				$this->update_prop();
				// Adtechmedia_ContentManager::clear_all_content();
			} else if ( isset( $_POST['contentConfig'] ) ) {
				$content_config = json_decode( wp_unslash( $_POST['contentConfig'] ), true );

				if ( isset( $content_config['ab_percentage'] ) ) {
					$this->update_plugin_option( 'ab_percentage', (int) $content_config['ab_percentage'] );
					unset($content_config['ab_percentage']);
				}

				foreach ( $content_config as $a_option_key => $a_option_meta ) {
					if ( isset( $content_config[ $a_option_key ] ) || $content_config[ $a_option_key ] ) {
						$this->update_plugin_option( $a_option_key, $content_config[ $a_option_key ] );
					}
				}
				$this->update_prop();
			} else if ( isset( $_POST['appearanceSettings'] ) ) {
				$this->update_plugin_option( 'appearance_settings',  wp_unslash( $_POST['appearanceSettings'] ) );
				$this->update_appearance();
			}
			// @codingStandardsIgnoreEnd
			echo 'ok';
		}
		wp_die();
	}

	/**
	 * Call function update_appearance after activation
	 */
	public function one_update_appearance() {
		if ( ! empty( $this->get_plugin_option( 'key' ) ) ) {
			$this->update_appearance();
			$this->add_plugin_option( 'updated_appearance', 1 );
		}
		wp_die();
	}

	/**
	 * Register plugin scripts
	 *
	 * @param string $hook wp hook.
	 */
	public function add_adtechmedia_admin_scripts( $hook ) {
		if ( 'plugins_page_' . $this->get_settings_slug() != $hook ) {
			return;
		}
		wp_enqueue_style(
			'adtechmedia-style-materialdesignicons',
			plugins_url( '/css/materialdesignicons.css', __FILE__ )
		);
		wp_enqueue_style( 'adtechmedia-style-main', plugins_url( '/css/main.css', __FILE__ ) );
		wp_enqueue_style( 'adtechmedia-google-fonts', 'https://fonts.googleapis.com/css?family=Merriweather' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script(
			'adtechmedia-jquery-noty-js',
			plugins_url( '/js/jquery.noty.packaged.min.js', __FILE__ ),
			[ 'jquery-ui-tabs' ]
		);
		wp_enqueue_script(
			'adtechmedia-jquery-throttle-js',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js',
			[ 'adtechmedia-jquery-noty-js' ]
		);
		wp_enqueue_script( 'jquery-validate', plugins_url( '/js/jquery.validate.min.js', __FILE__ ) );
		wp_enqueue_script( 'adtechmedia-atm-tpl-js', Adtechmedia_Config::get( 'tpl_js_url' ), [ 'adtechmedia-jquery-throttle-js' ] );
		wp_enqueue_script( 'adtechmedia-atm-tpl-mgmt-js', Adtechmedia_Config::get( 'tpl_mgmt_js_url' ), [ 'adtechmedia-atm-tpl-js' ] );
		wp_enqueue_script( 'adtechmedia-atm-br-js', Adtechmedia_Config::get( 'br_js_url' ), [ 'adtechmedia-atm-tpl-mgmt-js' ] );
		wp_enqueue_script(
			'adtechmedia-admin-js',
			plugins_url( '/js/main.js', __FILE__ ),
			[ 'adtechmedia-atm-br-js' ]
		);
		wp_localize_script( 'adtechmedia-admin-js',
			'save_template',
			array(
				'ajax_url' => $this->get_ajax_url( 'save_template' ),
				'nonce'    => wp_create_nonce( 'adtechmedia-nonce' ),
			)
		);
		wp_localize_script( 'adtechmedia-admin-js',
			'send_api_token',
			array(
				'ajax_url' => $this->get_ajax_url( 'send_api_token' ),
				'nonce'    => wp_create_nonce( 'adtechmedia-nonce' ),
			)
		);

		wp_localize_script( 'adtechmedia-admin-js',
			'return_to_default_values',
			array(
				'ajax_url' => $this->get_ajax_url( 'return_to_default_values' ),
				'nonce'    => wp_create_nonce( 'adtechmedia-nonce' ),
			)
		);

		wp_enqueue_script(
			'adtechmedia-fontawesome-js',
			plugins_url( '/js/fontawesome.min.js', __FILE__ ),
			[ 'adtechmedia-admin-js' ]
		);
	}

	/**
	 * Register atm.js
	 */
	public function add_adtechmedia_scripts() {
		$script = $this->get_plugin_option( 'BuildPath' );

		if ( $this->is_enabled() && isset( $script ) ) {
			$is_old = $this->get_plugin_option( 'atm-js-is-old' );
			// @codingStandardsIgnoreStart
			$is_old = ! empty( $is_old ) && $is_old == '1';
			// @codingStandardsIgnoreEnd
			if ( $is_old ) {
				$this->update_prop();
			}
			$path       = plugins_url( '/js/atm.min.js', __FILE__ );
			$plugin_dir = plugin_dir_path( __FILE__ );
			$file       = $plugin_dir . '/js/atm.min.js';

			if ( ! file_exists( $file ) || $is_old || ( time() - filemtime( $file ) ) > Adtechmedia_Config::get( 'atm_js_cache_time' ) ) {
				$hash = $this->get_plugin_option( 'atm-js-hash' );
				// @codingStandardsIgnoreStart
				$data = wp_remote_get( $script . "?_v=" . time() );
				if ( is_array($data) ) {
					$decodedData = @gzdecode( $data['body'] );
					$this->add_plugin_option( 'atm-js-hash', time() );
					$this->add_plugin_option( 'atm-js-is-old', '0' );
					file_put_contents( $file, $decodedData ? $decodedData : $data['body'] );
				}
				// @codingStandardsIgnoreEnd
			}

			$sw_file = $plugin_dir . '/js/sw.min.js';

			if ( ! file_exists( $sw_file ) || ( time() - filemtime( $sw_file ) ) > Adtechmedia_Config::get( 'atm_js_cache_time' ) ) {
				// @codingStandardsIgnoreStart
				$data = wp_remote_get( Adtechmedia_Config::get( 'sw_js_url' ) );
				if ( is_array($data) ) {
					$decodedData = @gzdecode( $data['body'] );
					file_put_contents( $sw_file, $decodedData ? $decodedData : $data['body'] );
				}
				// @codingStandardsIgnoreEnd
			}

			if ( file_exists( $file ) ) {
				wp_enqueue_script( 'Adtechmedia', $path . '?v=' . $this->get_plugin_option( 'atm-js-hash' ), null, null, true );
			}
		}
	}

	/**
	 * Clear post cache
	 *
	 * @param integer $post_id id of post.
	 */
	public function clear_cache_on_update( $post_id ) {
		if ( wp_is_post_revision( $post_id ) ) {
			return;
		}
		Adtechmedia_ContentManager::clear_content( $post_id );
	}

	/**
	 * Check if widget should be enabled.
	 *
	 * @return bool
	 */
	public function is_enabled() {
		if ( null === $this->enabled ) {
			if ( ! isset( $this->ab ) ) {
				$percentage = (int) $this->get_plugin_option( 'ab_percentage', Adtechmedia_AB::DEFAULT_PERCENTAGE );

				if ( $percentage <= 0 ) {
					$this->is_enabled = false;
					return $this->enabled;
				}

				$this->ab = Adtechmedia_AB::instance()->set_percentage( $percentage )->start();
			}

			$is_enabled = Adtechmedia_AB::SHOW === $this->ab->variant
				&& is_single() && ! empty( $this->get_plugin_option( 'key' ) );

			if ( ! $is_enabled ) {
				$this->is_enabled = false;
				return $this->enabled;
			}
            // @codingStandardsIgnoreStart
			$data = array(
				'time'				=> get_post_time( 'U', true ),
				'url'					=> get_permalink(),
				'categories' 	=> join( ',', array_map( function ( $category ) {
					return $category->name;
				}, get_the_category() ? get_the_category() : array()  ) ),
				'tags'				=> join( ',', array_map( function( $tag ) {
					return $tag->name;
				}, get_the_tags() ? get_the_tags() : array() ) )
			);
			// @codingStandardsIgnoreEnd
			$this->enabled = Adtechmedia_Request::br_decide_show(
				$this->get_plugin_option( 'Id' ),
				'load',
				$data,
				$this->get_plugin_option( 'key' )
			);
		}  // End if().
		return $this->enabled;
	}

	/**
	 * Hide post content
	 *
	 * @param string $content content of post.
	 *
	 * @return bool|mixed|null
	 */
	public function hide_content( $content ) {
		if ( $this->is_enabled() ) {
			$id            = (string) get_the_ID();
			$saved_content = Adtechmedia_ContentManager::get_content( $id );
			if ( $this->is_amp ) {
				add_action( 'amp_post_template_css',
					array(
						&$this,
						'xyz_amp_my_additional_css_styles',
					)
				);
				return $this->amp_content( $content , $id );
			} else if ( isset( $saved_content ) && ! empty( $saved_content ) ) {
				return $this->content_wrapper( $saved_content );
			} else {
				Adtechmedia_Request::content_create(
					$id,
					$this->get_plugin_option( 'id' ),
					$content,
					$this->get_plugin_option( 'key' )
				);
				$new_content = Adtechmedia_Request::content_retrieve(
					$id,
					$this->get_plugin_option( 'id' ),
					$this->get_plugin_option( 'content_lock' ),
					$this->get_plugin_option( 'content_offset_type' ),
					$this->get_plugin_option( 'selector' ),
					$this->get_plugin_option( 'content_offset' ),
					$this->get_plugin_option( 'key' )
				);

				if ( ! empty( $new_content ) ) {
					Adtechmedia_ContentManager::set_content( $id, $new_content );
				}

				return $this->content_wrapper( $new_content );
			}
		}

		return $content;
	}

	/**
	 * Wrap content of post
	 *
	 * @param string $content content of post.
	 *
	 * @return string
	 */
	public function content_wrapper( $content ) {
		$property_id   = $this->get_plugin_option( 'id' );
		$content_id    = (string) get_the_ID();
		$author_name   = get_the_author();
		$author_avatar = get_avatar_url( get_the_author_meta( 'user_email' ) );
		$country = $this->get_plugin_option( 'country' );
		$locale = null;
		switch ( $country ) {
			case 'Romania':
				$locale = 'ro';
				break;
			default:
				$locale = 'en';
		}
		$script        = "<script>
                    window.ATM_FORCE_NOT_LOCALHOST = true;
                    window.ATM_PROPERTY_ID = '$property_id'; 
                    window.ATM_CONTENT_ID = '$content_id'; 
                    window.ATM_CONTENT_PRELOADED = true;
                    window.WP_ATM_AUTHOR_NAME = '$author_name';
                    window.WP_ATM_AUTHOR_AVATAR = '$author_avatar';
                    window.ATM_SERVICE_WORKER = '/sw.min.js';
										window.ATM_LOCALE = '$locale';
                    </script>";

		return "<span id='content-for-atm-modal'>&nbsp;</span><span id='content-for-atm'>$content</span>" . $script;
	}

	/**
	 * AMP one paragraf
	 *
	 * @param string  $content content of post.
	 * @param integer $id id of post.
	 *
	 * @return string
	 */
	public function amp_content( $content, $id ) {
		$dom = new DOMDocument();
		$dom->loadHTML( '<html><head><meta http-equiv="content-type" content="text/html; charset=utf-8"></head><body>' . $content . '</body></html>' );
		$result = $dom->getElementsByTagName( 'p' );
		$html = '';
		// @codingStandardsIgnoreStart
		foreach ( $result as $paragraf ) {
			if ( $paragraf->nodeValue ) {
				$html .= $paragraf->ownerDocument->saveHTML( $paragraf );
				break;
			} else {
				$html .= $paragraf->ownerDocument->saveHTML( $paragraf );
			}

		}
		$country = $this->get_plugin_option( 'country' );
		switch ( $country ) {
			case 'Romania':
				$text = 'Citeste articolul';
				break;
			default:
				$text = 'Read full article';
		}
		$html.= '<div class="atm-unlock-line"><a  href="'. get_page_link($id)  .'">'.$text.'</a></div>';
		// @codingStandardsIgnoreEnd
		return $html;
	}

	/**
	 * AMP button view
	 */
	public function xyz_amp_my_additional_css_styles() {
		$css = '.atm-unlock-line{
                    text-align:center;
                    }
                    .atm-unlock-line a{
                        color: #fff;
                        background: #00a7f7;
                        font-size: 11px;
                        width: 190px;
                        display: block;
                        line-height: 35px;
                        text-transform: uppercase;
                        text-decoration: none;
                        margin: 0 auto;
                        border-radius: 2px;
                        font-family: "Helvetica Neue", Helvetica, "Segoe UI", Arial, sans-serif;
                    }
                    ';
		// @codingStandardsIgnoreStart
		echo $css;
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Show error if Property Id not exists
	 */
	public function property_id_not_exists_error() {
		// @codingStandardsIgnoreStart
		?>
		<div class="error notice">
			<p><?php echo __( 'We detected a delayed response from AdTechMedia platform. Please reload the page to try again. If this problem persists, contact us at <a href="mailto:support@adtechmedia.io">support@adtechmedia.io</a>.',
				'adtechmedia-plugin'
				); ?></p>
		</div>
		<?php
		// @codingStandardsIgnoreEnd
	}

}

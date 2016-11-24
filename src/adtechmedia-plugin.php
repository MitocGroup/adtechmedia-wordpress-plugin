<?php
/**
 * Main plugin class
 *
 * @category File
 * @package  Adtechmedia_Plugin
 * @author    yama-gs
 */

/**
 * Inclide Adtechmedia_LifeCycle
 */
include_once( 'adtechmedia-lifecycle.php' );

/**
 * Class Adtechmedia_Plugin
 */
class Adtechmedia_Plugin extends Adtechmedia_LifeCycle {

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
	 * Main plugin data fields
	 *
	 * @return array
	 */
	public function get_main_data() {
		return array(
			'key' => array( __( 'Key', 'adtechmedia-plugin' ) ),
			'BuildPath' => array( __( 'BuildPath', 'adtechmediaplugin' ) ),
			'Id' => array( __( 'Id', 'adtechmedia-plugin' ) ),
			'website_domain_name' => array( __( 'website_domain_name', 'adtechmedia-plugin' ) ),
			'websit e_url' => array( __( 'website_url', 'adtechmedia-plugin' ) ),
			'support_email' => array( __( 'support_email', 'adtechmedia-plugin' ) ),
			'country' => array( __( 'country', 'adtechmedia-plugin' ) ),
			'revenue_method' => array(
				__( 'revenueMethod', 'adtechmedia-plugin' ),
				'advertising+micropayments',
				'advertising',
				'micropayments',
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
			'container' => array( __( 'Article container', 'adtechmedia-plugin' ) ),
			'selector' => array( __( 'Article selector', 'adtechmedia-plugin' ) ),
			'price' => array( __( 'Price', 'adtechmedia-plugin' ) ),
			'author_name' => array( __( 'Author name', 'adtechmedia-plugin' ) ),
			'author_avatar' => array( __( 'Author avatar', 'adtechmedia-plugin' ) ),
			'ads_video' => array( __( 'Link to video ad', 'adtechmedia-plugin' ) ),
			'content_offset' => array( __( 'Offset', 'adtechmedia-plugin' ) ),
			'content_lock' => array(
				__( 'Lock', 'adtechmedia-plugin' ),
				'blur+scramble',
				'blur',
				'scramble',
				'keywords',
			),
			'payment_pledged' => array( __( 'payment.pledged', 'adtechmedia-plugin' ) ),
			'price_currency' => array( __( 'price.currency', 'adtechmedia-plugin' ) ),
			'content_paywall' => array( __( 'content.paywall', 'adtechmedia-plugin' ) ),
			'content_offset_type' => array( __( 'Offset type', 'adtechmedia-plugin' ) ),
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
	 * See: http://plugin.michael-simpson.com/?page_id=101
	 * Called by install() to create any database tables if needed.
	 * Best Practice:
	 * (1) Prefix all table names with $wpdb->prefix
	 * (2) make table names lower case only
	 *
	 * @return void
	 */
	protected function install_database_tables() {
		global $wpdb;
		$table_name = $this->prefix_table_name( Adtechmedia_Config::get( 'plugin_table_name' ) );
		// @codingStandardsIgnoreStart
		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS `$table_name` (
                            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `option_name` VARCHAR(191) NOT NULL DEFAULT '',
                            `option_value` LONGTEXT NOT NULL ,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `option_name` (`option_name`)
                        )"
		);
		// @codingStandardsIgnoreEnd
		$table_name = $this->prefix_table_name( Adtechmedia_Config::get( 'plugin_cache_table_name' ) );
		// @codingStandardsIgnoreStart
		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS `$table_name` (
                            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `item_id` VARCHAR(191) NOT NULL DEFAULT '',
                            `value` LONGTEXT NOT NULL ,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `item_id` (`item_id`)
                        )"
		);
		// @codingStandardsIgnoreEnd
	}

	/**
	 * See: http://plugin.michael-simpson.com/?page_id=101
	 * Drop plugin-created tables on uninstall.
	 *
	 * @return void
	 */
	protected function un_install_database_tables() {
		/*
		 * global $wpdb;
		 * $tableName = $this->prefixTableName('mytable');
		 * $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
		 */
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
		add_action( 'admin_menu', array( &$this, 'add_settings_sub_menu_page' ) );
		$property_id = $this->get_plugin_option( 'id' );
		$key = $this->get_plugin_option( 'key' );

		// Add Actions & Filters.
		// http://plugin.michael-simpson.com/?page_id=37.
		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( &$this, 'add_adtechmedia_admin_scripts' ) );
		}
		add_action( 'save_post', array( &$this, 'clear_cache_on_update' ) );
		if ( ! is_admin() && (empty( $key ) || empty( $property_id )) ) {
			return;
		}
		if ( isset( $_SERVER['REQUEST_URI'] ) && strpos( sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ), $this->get_settings_slug() ) !== false ) {
			$key_check = $this->check_api_key_exists();
			$property_check = $this->check_prop();

			if ( ! $key_check ) {
				add_action( 'admin_notices', array( &$this, 'key_not_exists_error' ) );
			}
			if ( ! $property_check ) {
				add_action( 'admin_notices', array( &$this, 'property_id_not_exists_error' ) );
			}
		}
		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts', array( &$this, 'add_adtechmedia_scripts' ) );
		}
		add_filter( 'the_content', array( &$this, 'hide_content' ), 99999 );// try do this after any other filter.

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
		add_action( 'wp_ajax_save_template', array( &$this, 'ajax_save_template' ) );
	}

	/**
	 * Save templates action
	 */
	public function ajax_save_template() {
		if ( isset( $_POST['nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), 'adtechmedia-nonce' ) ) {
			// @codingStandardsIgnoreStart
			if ( isset( $_POST['revenueMethod'] ) ) {
				$revenue_method = $_POST['revenueMethod'];
				$this->add_plugin_option( 'revenue_method', $revenue_method );
				Adtechmedia_Request::property_update_config_by_array(
					$this->get_plugin_option( 'id' ),
					$this->get_plugin_option( 'key' ),
					[
						'revenueMethod' => $revenue_method,
					]
				);
			} else {
				$inputs = $_POST['inputs'];
				$style_inputs = $_POST['styleInputs'];
				$component = $_POST['component'];
				$template = $_POST['template'];
				$position = $_POST['position'];
				$overall_styles = $_POST['overallStyles'];
				$overall_styles_inputs = $_POST['overallStylesInputs'];
				$this->add_plugin_option( 'template_inputs', $inputs );
				$this->add_plugin_option( 'template_style_inputs', $style_inputs );
				$this->add_plugin_option( 'template_' . $component, $template );
				$this->add_plugin_option( 'template_position', $position );
				$this->add_plugin_option( 'template_overall_styles', $overall_styles );
				$this->add_plugin_option( 'template_overall_styles_inputs', $overall_styles_inputs );
				Adtechmedia_Request::property_update_config_by_array(
					$this->get_plugin_option( 'id' ),
					$this->get_plugin_option( 'key' ),
					[
						'templates' => [ $component => base64_encode( stripslashes( $template ) ), ],
						'targetModal' => [
							'targetCb' => $this->get_target_cb_js( json_decode( stripslashes( $position ), true ) ),
							'toggleCb' => $this->get_toggle_cb_js( json_decode( stripslashes( $position ), true ) ),
						],
						'styles' => [
							'main' => base64_encode( $overall_styles ),
						],
					]
				);
				// @codingStandardsIgnoreEnd
			}
			echo 'ok';
		}
		die();
	}

	/**
	 * Get JS to toggleCb function
	 *
	 * @param array $position array of position properties.
	 * @return string
	 */
	public function get_toggle_cb_js ( $position ) {
		$sticky = ! empty( $position['sticky'] ) ? $position['sticky'] : false;
		$scrolling_offset_top = ! empty( $position['scrolling_offset_top'] ) ? $position['scrolling_offset_top'] : 0;
		if ( $sticky ) {
			$scrolling_offset_top = -10;
		}
		return "function(cb) {
				var adjustMarginTop = function (e) {
                var modalOffset = document.body.scrollTop > $scrolling_offset_top;
                if (modalOffset) {
                  cb(true);
                } else {
                  cb(false);
                }
                };
                document.addEventListener('scroll', adjustMarginTop);
                adjustMarginTop(null);}";
	}

	/**
	 * Get JS to targetCb function
	 *
	 * @param array $position array of position properties.
	 * @return string
	 */
	public function get_target_cb_js ( $position ) {
		$sticky = ! empty( $position['sticky'] ) ? $position['sticky'] : false;
		$centered = ! empty( $position['centered'] ) ? $position['centered'] : false;
		$width = ! empty( $position['width'] ) ? $position['width'] : '600px';
		$offset_top = ! empty( $position['offset_top'] ) ? $position['offset_top'] : '0px';
		$offset_left = ! empty( $position['offset_left'] ) ? $position['offset_left'] : '0px';
		$content = '';
		if ( ! $sticky ) {
			$content .= "mainModal.rootNode.style.position = 'fixed';\n";
			$content .= "mainModal.rootNode.style.top = '$offset_top';\n";
			$content .= "mainModal.rootNode.style.width = '$width';\n";
		} else {
			$content .= "mainModal.rootNode.style.width = '100%';\n";
		}
		if ( $centered ) {
			$content .= "mainModal.rootNode.style.left = 'calc(50% - $offset_left)';\n";
		} else {
			$content .= "mainModal.rootNode.style.left = '$offset_left';\n";
		}
		return "function(modalNode, cb) {
                var mainModal=modalNode;
                mainModal.mount(document.querySelector('#content-for-atm-modal'), mainModal.constructor.MOUNT_APPEND);
                mainModal.rootNode.classList.add('atm-targeted-container');
                $content
                cb();
                }";
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
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script(
			'adtechmedia-jquery-throttle-js',
			'https://cdnjs.cloudflare.com/ajax/libs/jquery-throttle-debounce/1.1/jquery.ba-throttle-debounce.min.js',
			[ 'jquery-ui-tabs' ]
		);
		wp_enqueue_script( 'adtechmedia-atm-tpl-js', 'https://adm.adtechmedia.io/atm-core/atm-build/atmTpl.js', [ 'adtechmedia-jquery-throttle-js' ] );
		wp_enqueue_script(
			'adtechmedia-admin-js',
			plugins_url( '/js/main.js', __FILE__ ),
			[ 'adtechmedia-atm-tpl-js' ]
		);
		wp_localize_script( 'adtechmedia-admin-js', 'save_template', array(
			'ajax_url' => $this->get_ajax_url( 'save_template' ),
			'nonce' => wp_create_nonce( 'adtechmedia-nonce' ),
		));
		wp_enqueue_script( 'adtechmedia-fontawesome-js', 'https://use.fontawesome.com/09d9c8deb0.js', [ 'adtechmedia-admin-js' ] );
	}

	/**
	 * Register atm.js
	 */
	public function add_adtechmedia_scripts() {
		if ( $script = $this->get_plugin_option( 'BuildPath' ) ) {
			wp_enqueue_script( 'Adtechmedia', $script, null, null, true );
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
	 * Hide post content
	 *
	 * @param string $content content of post.
	 * @return bool|mixed|null
	 */
	public function hide_content( $content ) {

		if ( is_single() ) {
			$id = (string) get_the_ID();
			$saved_content = Adtechmedia_ContentManager::get_content( $id );
			if ( isset( $saved_content ) && ! empty( $saved_content ) ) {
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
				Adtechmedia_ContentManager::set_content( $id, $new_content );
				return $this->content_wrapper( $new_content );
			}
		}
		return $content;
	}

	/**
	 * Wrap content of post
	 *
	 * @param string $content content of post.
	 * @return string
	 */
	public function content_wrapper( $content ) {
		$property_id = $this->get_plugin_option( 'id' );
		$content_id = (string) get_the_ID();
		$script = "<script>
                    window.ATM_PROPERTY_ID = '$property_id'; 
                    window.ATM_CONTENT_ID = '$content_id'; 
                    window.ATM_CONTENT_PRELOADED = true;
                    </script>";
		return "<span id='content-for-atm-modal'>&nbsp;</span><span id='content-for-atm'>$content</span>" . $script;
	}

	/**
	 * Show error if Property Id not exists
	 */
	public function property_id_not_exists_error() {
		?>
		<div class="error notice">
			<p><?php esc_html_e( 'An error occurred. Property Id has not been created, please reload the page or contact support service at <a href="mailto:support@adtechmedia.io">support@adtechmedia.io</a>.', 'adtechmedia' ); ?></p>
		</div>
		<?php
	}

	/**
	 * Show error if  API key not exists
	 */
	public function key_not_exists_error() {
		?>
		<div class="error notice">
			<p><?php esc_html_e( 'An error occurred. API key has not been created, please reload the page or contact support service at <a href="mailto:support@adtechmedia.io">support@adtechmedia.io</a>.', 'adtechmedia' ); ?></p>
		</div>
		<?php
	}
}

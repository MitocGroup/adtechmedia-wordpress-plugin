<?php


include_once( 'adtechmedia-lifecycle.php' );

class Adtechmedia_Plugin extends Adtechmedia_LifeCycle {

	/**
	 * See: http://plugin.michael-simpson.com/?page_id=31
	 *
	 * @return array of option meta data.
	 */
	public function get_option_meta_data() {
		//  http://plugin.michael-simpson.com/?page_id=31
		return array(//'_version' => array('Installed Version'), // Leave this one commented-out. Uncomment to test upgrades.
		);
	}

	public function get_main_data() {
		return array(
			'key' => array( __( 'Key', 'adtechmedia-plugin' ) ),
			'BuildPath' => array( __( 'BuildPath', 'adtechmediaplugin' ) ),
			'Id' => array( __( 'Id', 'adtechmedia-plugin' ) ),
			"website_domain_name" => array( __( 'website_domain_name', 'adtechmedia-plugin' ) ),
			"website_url" => array( __( 'website_url', 'adtechmedia-plugin' ) ),
			"support_email" => array( __( 'support_email', 'adtechmedia-plugin' ) ),
			"country" => array( __( 'country', 'adtechmedia-plugin' ) ),
			"revenue_method" => array(
				__( 'revenueMethod', 'adtechmedia-plugin' ),
				'advertising+micropayments',
				'advertising',
				'micropayments'
			),
		);
	}

	public function get_plugin_meta_data() {
		return array(
			"container" => array( __( 'Article container', 'adtechmedia-plugin' ) ),
			"selector" => array( __( 'Article selector', 'adtechmedia-plugin' ) ),
			"price" => array( __( 'Price', 'adtechmedia-plugin' ) ),
			"author_name" => array( __( 'Author name', 'adtechmedia-plugin' ) ),
			"author_avatar" => array( __( 'Author avatar', 'adtechmedia-plugin' ) ),
			"ads_video" => array( __( 'Link to video ad', 'adtechmedia-plugin' ) ),
			"content_offset" => array( __( 'Offset', 'adtechmedia-plugin' ) ),
			"content_lock" => array(
				__( 'Lock', 'adtechmedia-plugin' ),
				'blur+scramble',
				'blur',
				'scramble',
				'keywords',
			),
			"payment_pledged" => array( __( 'payment.pledged', 'adtechmedia-plugin' ) ),
			"price_currency" => array( __( 'price.currency', 'adtechmedia-plugin' ) ),
			"content_paywall" => array( __( 'content.paywall', 'adtechmedia-plugin' ) ),
			"content_offset_type" => array( __( 'Offset type', 'adtechmedia-plugin' ) ),
			/*'ATextInput' => array(__('Enter in some text', 'my-awesome-plugin')),
			'AmAwesome' => array(__('I like this awesome plugin', 'my-awesome-plugin'), 'false', 'true'),
			'CanDoSomething' => array(__('Which user role can do something', 'my-awesome-plugin'),
										'Administrator', 'Editor', 'Author', 'Contributor', 'Subscriber', 'Anyone')*/
		);
	}
//    protected function getOptionValueI18nString($optionValue) {
//        $i18nValue = parent::getOptionValueI18nString($optionValue);
//        return $i18nValue;
//    }

	protected function init_options() {

		$options = $this->get_option_meta_data();
		if ( ! empty( $options ) ) {
			foreach ($options as $key => $arr) {
				if ( is_array( $arr ) && count( $arr > 1 ) ) {
					$this->add_option( $key, $arr[ 1 ] );
				}
			}
		}

	}


	public function get_plugin_display_name() {
		return 'Adtechmedia';
	}

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
		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS `$table_name` (
                            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `option_name` VARCHAR(191) NOT NULL DEFAULT '',
                            `option_value` LONGTEXT NOT NULL ,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `option_name` (`option_name`)
                        )"
		);
		$table_name = $this->prefix_table_name( Adtechmedia_Config::get( 'plugin_cache_table_name' ) );
		$wpdb->query(
			"CREATE TABLE IF NOT EXISTS `$table_name` (
                            `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                            `item_id` VARCHAR(191) NOT NULL DEFAULT '',
                            `value` LONGTEXT NOT NULL ,
                            PRIMARY KEY (`id`),
                            UNIQUE INDEX `item_id` (`item_id`)
                        )"
		);
	}

	/**
	 * See: http://plugin.michael-simpson.com/?page_id=101
	 * Drop plugin-created tables on uninstall.
	 *
	 * @return void
	 */
	protected function un_install_database_tables() {
		//        global $wpdb;
		//        $tableName = $this->prefixTableName('mytable');
		//        $wpdb->query("DROP TABLE IF EXISTS `$tableName`");
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
	 *
	 */
	public function add_actions_and_filters() {

		// Add options administration page
		// http://plugin.michael-simpson.com/?page_id=47
		add_action( 'admin_menu', array( &$this, 'add_settings_sub_menu_page' ) );
		$property_id = $this->get_plugin_option( 'id' );
		$key = $this->get_plugin_option( 'key' );


		// Example adding a script & style just for the options administration page
		// http://plugin.michael-simpson.com/?page_id=47
		//        if (strpos($_SERVER['REQUEST_URI'], $this->getSettingsSlug()) !== false) {
		//            wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));
		//            wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
		//        }


		// Add Actions & Filters
		// http://plugin.michael-simpson.com/?page_id=37

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( &$this, 'add_adtechmedia_admin_scripts' ) );
		}
		add_action( 'save_post', array( &$this, 'clear_cache_on_update' ) );
		add_filter( 'http_response', array( &$this, 'wp_log_http_requests' ), 10, 3 );//todo remove this
		if ( ! is_admin() && (empty( $key ) || empty( $property_id )) ) {
			return;
		}
		if ( strpos( $_SERVER[ 'REQUEST_URI' ], $this->get_settings_slug() ) !== false ) {
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
		add_filter( 'the_content', array( &$this, 'hide_content' ), 99999 );//try do this after any other filter

		// Adding scripts & styles to all pages
		// Examples:
		//        wp_enqueue_script('jquery');
		//        wp_enqueue_style('my-style', plugins_url('/css/my-style.css', __FILE__));
		//        wp_enqueue_script('my-script', plugins_url('/js/my-script.js', __FILE__));


		// Register short codes
		// http://plugin.michael-simpson.com/?page_id=39


		// Register AJAX hooks
		// http://plugin.michael-simpson.com/?page_id=41

	}

	public function wp_log_http_requests( $response, $args, $url ) {
		// set your log file location here
		$logfile = plugin_dir_path( __FILE__ ) . '/http_requests.txt';
		// parse request and response body to a hash for human readable log output
		//$log_response = $response;
		/*if ( isset( $args['body'] ) ) {
			parse_str( $args['body'], $args['body_parsed'] );
		}
		if ( isset( $log_response['body'] ) ) {
			parse_str( $log_response['body'], $log_response['body_parsed'] );
		}*/
		// write into logfile
		$output = 'Request on ' . date( 'c' ) . PHP_EOL;
		$output .= 'Url: ' . $url . PHP_EOL;
		$output .= " - Method:" . $args[ 'method' ] . PHP_EOL;
		$output .= ' - Headers:' . PHP_EOL;

		foreach ($args[ 'headers' ] as $key => $value) {
			$output .= "   - $key: $value" . PHP_EOL;
		}

		$output .= 'Response' . PHP_EOL;
		$output .= ' - Headers:' . PHP_EOL;

		foreach ($response[ 'headers' ] as $key => $value) {
			$output .= "   - $key: $value" . PHP_EOL;
		}
		//file_put_contents( $logfile, sprintf( "### %s, URL: %s\nREQUEST: %sRESPONSE: %s\n", date( 'c' ), $url, print_r( $args, true ), print_r( $log_response, true ) ), FILE_APPEND );
		file_put_contents( $logfile, $output . PHP_EOL . PHP_EOL, FILE_APPEND );
		return $response;
	}

	/**
	 *
	 */
	public function add_adtechmedia_admin_scripts( $hook ) {
		if ( $hook != 'plugins_page_' . $this->get_settings_slug() ) {
			return;
		}
		wp_enqueue_style(
			'adtechmedia-style-materialdesignicons',
			plugins_url( '/css/materialdesignicons.css', __FILE__ )
		);
		wp_enqueue_style( 'adtechmedia-style-main', plugins_url( '/css/main.css', __FILE__ ) );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script(
			'adtechmedia-admin-js',
			plugins_url( '/js/main.js', __FILE__ ),
			[ 'jquery-ui-tabs' ]
		);
		wp_enqueue_script( 'adtechmedia-tinymce-js', '//cdn.tinymce.com/4/tinymce.min.js', [ 'adtechmedia-admin-js' ] );
	}

	/**
	 *
	 */
	public function add_adtechmedia_scripts() {
		if ( $script = $this->get_plugin_option( 'BuildPath' ) ) {
			wp_enqueue_script( 'Adtechmedia', $script, null, null, true );
		}
	}

	/**
	 * @param $postId
	 */
	public function clear_cache_on_update( $postId ) {
		if ( wp_is_post_revision( $postId ) ) {
			return;
		}
		Adtechmedia_ContentManager::clear_content( $postId );
	}

	/**
	 * @param $content
	 * @return bool|mixed|null
	 */
	public function hide_content( $content ) {

		if ( is_single() ) {
			$id = (string)get_the_ID();
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
					"elements",
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
	 * @param $content
	 * @return string
	 */
	public function content_wrapper( $content ) {
		$property_id = $this->get_plugin_option( 'id' );
		$content_id = (string)get_the_ID();
		$script = "<script>
                    window.ATM_PROPERTY_ID = '$property_id'; 
                    window.ATM_CONTENT_ID = '$content_id'; 
                    window.ATM_CONTENT_PRELOADED = true;
                    </script>";
		return "<span id='content-for-atm'>$content</span>" . $script;
	}

	/**
	 *
	 */
	public function property_id_not_exists_error() {
		?>
		<div class="error notice">
			<p><?php _e(
					'An error occurred. Property Id has not been created, please reload the page or contact support service at <a href="mailto:support@adtechmedia.io">support@adtechmedia.io</a>.',
					'adtechmedia'
				); ?></p>
		</div>
		<?php
	}

	/**
	 *
	 */
	public function key_not_exists_error() {
		?>
		<div class="error notice">
			<p><?php _e(
					'An error occurred. API key has not been created, please reload the page or contact support service at <a href="mailto:support@adtechmedia.io">support@adtechmedia.io</a>.',
					'adtechmedia'
				); ?></p>
		</div>
		<?php
	}
}
